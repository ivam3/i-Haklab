# Build the local camera helpers used by the OBS integration.
# libuvc is built separately by ~/.local/libexec/i-Haklab/build-uvc-cam.

CC ?= cc
PREFIX ?= /data/data/com.termux/files/usr
LIBUVC_DIR ?= $(HOME)/.local/src/uvc-cam/libuvc
CFLAGS ?= -O2 -Wall -Wextra
CPPFLAGS += -I$(LIBUVC_DIR)/include -I$(LIBUVC_DIR)/build/include -I$(PREFIX)/include -I$(PREFIX)/include/libusb-1.0
LDFLAGS += -L$(LIBUVC_DIR)/build -Wl,-rpath,$(PREFIX)/lib -Wl,-rpath,'$$ORIGIN/libuvc/build'
UVC_LIBS = -luvc -lusb-1.0 -ljpeg -lpthread

.PHONY: all clean

all: mjpeg-pipe-server usbdesc uvc-stream

mjpeg-pipe-server: mjpeg-pipe-server.c
	$(CC) $(CFLAGS) -pthread -o $@ $<

usbdesc: usbdesc.c
	$(CC) $(CFLAGS) $(CPPFLAGS) -o $@ $< -lusb-1.0

uvc-stream: uvc-stream.c
	$(CC) $(CFLAGS) $(CPPFLAGS) -o $@ $< $(LDFLAGS) $(UVC_LIBS)

clean:
	rm -f mjpeg-pipe-server usbdesc uvc-stream
