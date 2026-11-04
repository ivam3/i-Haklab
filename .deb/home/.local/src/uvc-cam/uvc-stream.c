/*
 * uvc-stream: capture a UVC camera through a termux-usb file descriptor
 * and expose it as a local MJPEG HTTP stream.
 *
 * Usage:
 *   TERMUX_USB_FD=<fd> ./uvc-stream [port] [width] [height] [fps]
 *
 * Endpoints:
 *   http://127.0.0.1:9000/video     multipart/x-mixed-replace MJPEG
 *   http://127.0.0.1:9000/snapshot  single JPEG
 */
#define _GNU_SOURCE
#include <arpa/inet.h>
#include <errno.h>
#include <netinet/in.h>
#include <netinet/tcp.h>
#include <pthread.h>
#include <signal.h>
#include <stdarg.h>
#include <stdint.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <sys/types.h>
#include <unistd.h>

#include <libusb-1.0/libusb.h>
#include <libuvc/libuvc.h>

#define MAX_CLIENTS 16
#define FRAME_MAGIC 0x4a504547u

static volatile sig_atomic_t g_running = 1;
static int g_listen_fd = -1;

static pthread_mutex_t g_lock = PTHREAD_MUTEX_INITIALIZER;
static pthread_cond_t g_cond = PTHREAD_COND_INITIALIZER;
static unsigned char *g_frame = NULL;
static size_t g_frame_len = 0;
static unsigned long g_frame_seq = 0;
static char g_boundary[] = "frame";

static void logmsg(const char *fmt, ...) {
  va_list ap;
  va_start(ap, fmt);
  vfprintf(stderr, fmt, ap);
  va_end(ap);
  fputc('\n', stderr);
}

static void on_signal(int sig) {
  (void)sig;
  g_running = 0;
  if (g_listen_fd >= 0) {
    shutdown(g_listen_fd, SHUT_RDWR);
    close(g_listen_fd);
    g_listen_fd = -1;
  }
  pthread_mutex_lock(&g_lock);
  pthread_cond_broadcast(&g_cond);
  pthread_mutex_unlock(&g_lock);
}

static void frame_callback(uvc_frame_t *frame, void *user_ptr) {
  (void)user_ptr;
  if (!frame || !frame->data || frame->data_bytes == 0) return;
  if (frame->frame_format != UVC_FRAME_FORMAT_MJPEG) {
    /* We only serve MJPEG. Inform once in a while and ignore. */
    static unsigned long other = 0;
    if ((other++ % 120) == 0) {
      logmsg("ignored frame: format %d (%zu bytes)", frame->frame_format,
             frame->data_bytes);
    }
    return;
  }
  pthread_mutex_lock(&g_lock);
  if (g_frame_len < frame->data_bytes) {
    unsigned char *p = realloc(g_frame, frame->data_bytes);
    if (!p) {
      pthread_mutex_unlock(&g_lock);
      return;
    }
    g_frame = p;
  }
  memcpy(g_frame, frame->data, frame->data_bytes);
  g_frame_len = frame->data_bytes;
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
    int cfd = accept(g_listen_fd, (struct sockaddr *)&peer, &plen);
    if (cfd < 0) {
      if (errno == EINTR) continue;
      if (!g_running) break;
      logmsg("accept: %s", strerror(errno));
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

static void print_formats(uvc_device_handle_t *devh) {
  const uvc_format_desc_t *fmt = uvc_get_format_descs(devh);
  while (fmt) {
    char name[5] = {0};
    memcpy(name, fmt->fourccFormat, 4);
    logmsg("formato: %s (bFormatIndex=%u)", name, fmt->bFormatIndex);
    for (const uvc_frame_desc_t *fr = fmt->frame_descs; fr; fr = fr->next) {
      logmsg("  %ux%u  min=%u max=%u default=%u (100ns)", fr->wWidth,
             fr->wHeight, fr->dwMinFrameInterval, fr->dwMaxFrameInterval,
             fr->dwDefaultFrameInterval);
    }
    fmt = fmt->next;
  }
}

int main(int argc, char **argv) {
  const char *fd_s = getenv("TERMUX_USB_FD");
  if (!fd_s && argc > 1 && argv[1][0] >= '0' && argv[1][0] <= '9') {
    fd_s = argv[1];
  }
  if (!fd_s) {
    fprintf(stderr,
            "Missing TERMUX_USB_FD. Run with:\n"
            "  termux-usb -r -E -e %s /dev/bus/usb/BBB/DDD\n",
            argv[0]);
    return 2;
  }
  int fd = atoi(fd_s);

  int port = 9000;
  int width = 1280, height = 720, fps = 30;
  if (getenv("CAM_PORT")) port = atoi(getenv("CAM_PORT"));
  if (getenv("CAM_WIDTH")) width = atoi(getenv("CAM_WIDTH"));
  if (getenv("CAM_HEIGHT")) height = atoi(getenv("CAM_HEIGHT"));
  if (getenv("CAM_FPS")) fps = atoi(getenv("CAM_FPS"));
  int argi = 1;
  if (argc > 1 && argv[1][0] >= '0' && argv[1][0] <= '9') argi = 2;
  if (argi < argc) port = atoi(argv[argi++]);
  if (argi < argc) width = atoi(argv[argi++]);
  if (argi < argc) height = atoi(argv[argi++]);
  if (argi < argc) fps = atoi(argv[argi++]);

  signal(SIGINT, on_signal);
  signal(SIGTERM, on_signal);
  signal(SIGPIPE, SIG_IGN);

  uvc_context_t *ctx = NULL;
  uvc_device_handle_t *devh = NULL;
  uvc_error_t res = uvc_init(&ctx, NULL);
  if (res != UVC_SUCCESS) {
    logmsg("uvc_init: %s", uvc_strerror(res));
    return 1;
  }

  res = uvc_wrap(fd, ctx, &devh);
  if (res != UVC_SUCCESS) {
    logmsg("uvc_wrap: %s", uvc_strerror(res));
    uvc_exit(ctx);
    return 1;
  }

  uvc_device_t *dev = uvc_get_device(devh);
  uvc_device_descriptor_t *desc = NULL;
  if (uvc_get_device_descriptor(dev, &desc) == UVC_SUCCESS) {
    logmsg("camera: %04x:%04x %s %s", desc->idVendor, desc->idProduct,
           desc->manufacturer ? desc->manufacturer : "",
           desc->product ? desc->product : "");
    uvc_free_device_descriptor(desc);
  }
  print_formats(devh);

  uvc_stream_ctrl_t ctrl;
  int chosen_w = 0, chosen_h = 0, chosen_fps = 0;
  const int widths[] = {width, 1920, 1280, 1024, 800, 640, 352};
  const int heights[] = {height, 1080, 720, 768, 600, 480, 288};
  const int fpss[] = {fps, 30, 15, 10, 5};
  for (size_t i = 0; i < sizeof(widths) / sizeof(widths[0]) && !chosen_w; i++) {
    for (size_t j = 0; j < sizeof(heights) / sizeof(heights[0]) && !chosen_w; j++) {
      for (size_t k = 0; k < sizeof(fpss) / sizeof(fpss[0]) && !chosen_w; k++) {
        if (widths[i] <= 0 || heights[j] <= 0 || fpss[k] <= 0) continue;
        res = uvc_get_stream_ctrl_format_size(devh, &ctrl, UVC_FRAME_FORMAT_MJPEG,
                                              widths[i], heights[j], fpss[k]);
        if (res == UVC_SUCCESS) {
          chosen_w = widths[i];
          chosen_h = heights[j];
          chosen_fps = fpss[k];
        }
      }
    }
  }
  if (!chosen_w) {
    logmsg("no compatible MJPEG mode found");
    uvc_close(devh);
    uvc_exit(ctx);
    return 1;
  }
  logmsg("selected mode: %dx%d @ %d fps", chosen_w, chosen_h, chosen_fps);

  res = uvc_start_streaming(devh, &ctrl, frame_callback, NULL, 0);
  if (res != UVC_SUCCESS) {
    logmsg("uvc_start_streaming: %s", uvc_strerror(res));
    uvc_close(devh);
    uvc_exit(ctx);
    return 1;
  }

  g_listen_fd = socket(AF_INET, SOCK_STREAM, 0);
  if (g_listen_fd < 0) {
    logmsg("socket: %s", strerror(errno));
    uvc_stop_streaming(devh);
    uvc_close(devh);
    uvc_exit(ctx);
    return 1;
  }
  int one = 1;
  setsockopt(g_listen_fd, SOL_SOCKET, SO_REUSEADDR, &one, sizeof(one));
  struct sockaddr_in addr = {0};
  addr.sin_family = AF_INET;
  addr.sin_addr.s_addr = htonl(INADDR_LOOPBACK);
  addr.sin_port = htons((uint16_t)port);
  if (bind(g_listen_fd, (struct sockaddr *)&addr, sizeof(addr)) < 0) {
    logmsg("bind: %s", strerror(errno));
    close(g_listen_fd);
    g_listen_fd = -1;
    uvc_stop_streaming(devh);
    uvc_close(devh);
    uvc_exit(ctx);
    return 1;
  }
  if (listen(g_listen_fd, 16) < 0) {
    logmsg("listen: %s", strerror(errno));
    close(g_listen_fd);
    g_listen_fd = -1;
    uvc_stop_streaming(devh);
    uvc_close(devh);
    uvc_exit(ctx);
    return 1;
  }

  logmsg("MJPEG at http://127.0.0.1:%d/video", port);
  pthread_t ath;
  pthread_create(&ath, NULL, accept_thread, NULL);
  while (g_running) pause();

  if (g_listen_fd >= 0) {
    close(g_listen_fd);
    g_listen_fd = -1;
  }
  uvc_stop_streaming(devh);
  uvc_close(devh);
  uvc_exit(ctx);
  logmsg("stopped");
  return 0;
}
