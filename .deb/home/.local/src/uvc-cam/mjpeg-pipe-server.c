/*
 * mjpeg-pipe-server: read a sequence of JPEG images from stdin (for example
 * `ffmpeg ... -f mjpeg -`) and serve them as a local MJPEG HTTP stream.
 *
 * Usage: ffmpeg ... -f mjpeg - | mjpeg-pipe-server [port]
 *
 * Endpoints:
 *   http://127.0.0.1:9001/video
 *   http://127.0.0.1:9001/snapshot
 */
#define _GNU_SOURCE
#include <arpa/inet.h>
#include <errno.h>
#include <netinet/in.h>
#include <netinet/tcp.h>
#include <pthread.h>
#include <signal.h>
#include <stdint.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <sys/types.h>
#include <time.h>
#include <unistd.h>

#define MAX_CLIENTS 16

static volatile sig_atomic_t g_running = 1;
static int g_listen = -1;

static pthread_mutex_t g_lock = PTHREAD_MUTEX_INITIALIZER;
static pthread_cond_t g_cond = PTHREAD_COND_INITIALIZER;
static unsigned char *g_frame = NULL;
static size_t g_frame_len = 0;
static unsigned long g_frame_seq = 0;
static char g_boundary[] = "frame";

static void on_signal(int sig) {
  (void)sig;
  g_running = 0;
  if (g_listen >= 0) {
    shutdown(g_listen, SHUT_RDWR);
    close(g_listen);
    g_listen = -1;
  }
  pthread_mutex_lock(&g_lock);
  pthread_cond_broadcast(&g_cond);
  pthread_mutex_unlock(&g_lock);
}

static void publish_frame(const unsigned char *data, size_t len) {
  if (len == 0) return;
  pthread_mutex_lock(&g_lock);
  if (g_frame_len < len) {
    unsigned char *p = realloc(g_frame, len);
    if (!p) {
      pthread_mutex_unlock(&g_lock);
      return;
    }
    g_frame = p;
  }
  memcpy(g_frame, data, len);
  g_frame_len = len;
  g_frame_seq++;
  pthread_cond_broadcast(&g_cond);
  pthread_mutex_unlock(&g_lock);
}

static int send_all(int fd, const void *buf, size_t len) {
  const unsigned char *p = buf;
  while (len) {
    ssize_t n = send(fd, p, len, MSG_NOSIGNAL);
    if (n < 0) {
      if (errno == EINTR) continue;
      return -1;
    }
    if (n == 0) return -1;
    p += n;
    len -= (size_t)n;
  }
  return 0;
}

static void send_headers(int fd, const char *ctype, size_t clen) {
  char hdr[512];
  int n = snprintf(hdr, sizeof(hdr),
                   "HTTP/1.1 200 OK\r\n"
                   "Content-Type: %s\r\n"
                   "Content-Length: %zu\r\n"
                   "Cache-Control: no-cache, no-store, must-revalidate\r\n"
                   "Pragma: no-cache\r\n"
                   "Connection: close\r\n"
                   "\r\n",
                   ctype, clen);
  if (n > 0) send_all(fd, hdr, (size_t)n);
}

static int read_request(int fd, char *path, size_t path_len) {
  char buf[2048];
  size_t used = 0;
  while (used + 1 < sizeof(buf)) {
    ssize_t n = recv(fd, buf + used, sizeof(buf) - 1 - used, 0);
    if (n <= 0) return -1;
    used += (size_t)n;
    buf[used] = 0;
    char *end = strstr(buf, "\r\n\r\n");
    if (!end) end = strstr(buf, "\n\n");
    if (!end) continue;
    char method[16], target[1024];
    if (sscanf(buf, "%15s %1023s", method, target) != 2) return -1;
    (void)method;
    strncpy(path, target, path_len - 1);
    path[path_len - 1] = 0;
    return 0;
  }
  return -1;
}

static void *client_thread(void *arg) {
  int fd = (int)(intptr_t)arg;
  int one = 1;
  setsockopt(fd, IPPROTO_TCP, TCP_NODELAY, &one, sizeof(one));
  struct timeval tv = {.tv_sec = 10, .tv_usec = 0};
  setsockopt(fd, SOL_SOCKET, SO_SNDTIMEO, &tv, sizeof(tv));

  char path[1024] = {0};
  if (read_request(fd, path, sizeof(path)) != 0) {
    close(fd);
    return NULL;
  }

  if (strncmp(path, "/snapshot", 9) == 0) {
    pthread_mutex_lock(&g_lock);
    size_t len = g_frame_len;
    unsigned char *tmp = len ? malloc(len) : NULL;
    if (tmp && len) memcpy(tmp, g_frame, len);
    pthread_mutex_unlock(&g_lock);
    if (tmp && len) {
      send_headers(fd, "image/jpeg", len);
      send_all(fd, tmp, len);
    } else {
      const char *msg = "No frame yet\n";
      send_headers(fd, "text/plain", strlen(msg));
      send_all(fd, msg, strlen(msg));
    }
    free(tmp);
    close(fd);
    return NULL;
  }

  if (strncmp(path, "/video", 6) != 0) {
    const char *msg = "Use /video or /snapshot\n";
    send_headers(fd, "text/plain", strlen(msg));
    send_all(fd, msg, strlen(msg));
    close(fd);
    return NULL;
  }

  char hdr[512];
  int n = snprintf(hdr, sizeof(hdr),
                   "HTTP/1.1 200 OK\r\n"
                   "Content-Type: multipart/x-mixed-replace; boundary=%s\r\n"
                   "Cache-Control: no-cache, no-store, must-revalidate\r\n"
                   "Pragma: no-cache\r\n"
                   "Connection: close\r\n"
                   "\r\n",
                   g_boundary);
  if (n <= 0 || send_all(fd, hdr, (size_t)n) != 0) {
    close(fd);
    return NULL;
  }

  unsigned long last_seq = 0;
  while (g_running) {
    pthread_mutex_lock(&g_lock);
    while (g_running && (g_frame_seq == last_seq || g_frame_len == 0)) {
      struct timespec ts;
      clock_gettime(CLOCK_REALTIME, &ts);
      ts.tv_sec += 2;
      pthread_cond_timedwait(&g_cond, &g_lock, &ts);
    }
    if (!g_running) {
      pthread_mutex_unlock(&g_lock);
      break;
    }
    last_seq = g_frame_seq;
    size_t len = g_frame_len;
    unsigned char *tmp = malloc(len);
    if (tmp) memcpy(tmp, g_frame, len);
    pthread_mutex_unlock(&g_lock);
    if (!tmp) break;

    char part[256];
    int pn = snprintf(part, sizeof(part),
                      "--%s\r\nContent-Type: image/jpeg\r\nContent-Length: %zu\r\n\r\n",
                      g_boundary, len);
    if (pn <= 0 || send_all(fd, part, (size_t)pn) != 0 ||
        send_all(fd, tmp, len) != 0 || send_all(fd, "\r\n", 2) != 0) {
      free(tmp);
      break;
    }
    free(tmp);
  }
  close(fd);
  return NULL;
}

static void *accept_thread(void *arg) {
  (void)arg;
  while (g_running) {
    struct sockaddr_in peer;
    socklen_t plen = sizeof(peer);
    int cfd = accept(g_listen, (struct sockaddr *)&peer, &plen);
    if (cfd < 0) {
      if (errno == EINTR) continue;
      if (!g_running) break;
      continue;
    }
    pthread_t th;
    if (pthread_create(&th, NULL, client_thread, (void *)(intptr_t)cfd) == 0) {
      pthread_detach(th);
    } else {
      close(cfd);
    }
  }
  return NULL;
}

static void *stdin_thread(void *arg) {
  (void)arg;
  unsigned char buf[65536];
  unsigned char *acc = NULL;
  size_t acc_len = 0, acc_cap = 0;
  int in_frame = 0;
  size_t start = 0;

  while (g_running) {
    ssize_t n = read(0, buf, sizeof(buf));
    if (n <= 0) break;
    if (acc_len + (size_t)n > acc_cap) {
      size_t cap = acc_cap ? acc_cap * 2 : 131072;
      while (cap < acc_len + (size_t)n) cap *= 2;
      unsigned char *p = realloc(acc, cap);
      if (!p) break;
      acc = p;
      acc_cap = cap;
    }
    memcpy(acc + acc_len, buf, (size_t)n);
    acc_len += (size_t)n;

    size_t i = 0;
    while (i + 1 < acc_len) {
      if (!in_frame) {
        if (acc[i] == 0xff && acc[i + 1] == 0xd8) {
          in_frame = 1;
          start = i;
          i += 2;
          continue;
        }
        i++;
      } else {
        if (acc[i] == 0xff && acc[i + 1] == 0xd9) {
          size_t end = i + 2;
          publish_frame(acc + start, end - start);
          /* keep from end */
          size_t remain = acc_len - end;
          if (remain) memmove(acc, acc + end, remain);
          acc_len = remain;
          in_frame = 0;
          i = 0;
          start = 0;
        } else {
          i++;
        }
      }
    }
    if (!in_frame && acc_len > 0) {
      acc_len = 0;
    } else if (in_frame && start > 0) {
      size_t remain = acc_len - start;
      if (remain) memmove(acc, acc + start, remain);
      acc_len = remain;
      start = 0;
      i = 0;
    }
  }
  free(acc);
  return NULL;
}

int main(int argc, char **argv) {
  int port = 9001;
  if (argc > 1) port = atoi(argv[1]);

  signal(SIGINT, on_signal);
  signal(SIGTERM, on_signal);
  signal(SIGPIPE, SIG_IGN);

  g_listen = socket(AF_INET, SOCK_STREAM, 0);
  if (g_listen < 0) {
    perror("socket");
    return 1;
  }
  int one = 1;
  setsockopt(g_listen, SOL_SOCKET, SO_REUSEADDR, &one, sizeof(one));
  struct sockaddr_in addr = {0};
  addr.sin_family = AF_INET;
  addr.sin_addr.s_addr = htonl(INADDR_LOOPBACK);
  addr.sin_port = htons((uint16_t)port);
  if (bind(g_listen, (struct sockaddr *)&addr, sizeof(addr)) < 0) {
    perror("bind");
    close(g_listen);
    return 1;
  }
  if (listen(g_listen, 16) < 0) {
    perror("listen");
    close(g_listen);
    return 1;
  }

  fprintf(stderr, "MJPEG at http://127.0.0.1:%d/video\n", port);
  pthread_t ath, sth;
  pthread_create(&ath, NULL, accept_thread, NULL);
  pthread_create(&sth, NULL, stdin_thread, NULL);
  while (g_running) pause();

  if (g_listen >= 0) close(g_listen);
  pthread_join(sth, NULL);
  return 0;
}
