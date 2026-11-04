#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <libusb.h>

static void print_string(libusb_device_handle *h, uint8_t idx, const char *label) {
    unsigned char buf[256];
    if (!idx) return;
    int r = libusb_get_string_descriptor_ascii(h, idx, buf, sizeof(buf));
    if (r > 0) printf("%s: %.*s\n", label, r, buf);
}

int main(int argc, char **argv) {
    const char *fds = getenv("TERMUX_USB_FD");
    if (!fds && argc > 1) fds = argv[1];
    if (!fds) { fprintf(stderr, "Missing TERMUX_USB_FD\n"); return 2; }
    int fd = atoi(fds);

    libusb_context *ctx = NULL;
    libusb_device_handle *h = NULL;
    if (libusb_init(&ctx) < 0) { fprintf(stderr, "libusb_init failed\n"); return 1; }
    int r = libusb_wrap_sys_device(ctx, fd, &h);
    if (r < 0) {
        fprintf(stderr, "libusb_wrap_sys_device failed: %s\n", libusb_error_name(r));
        libusb_exit(ctx);
        return 1;
    }

    libusb_device *dev = libusb_get_device(h);
    struct libusb_device_descriptor dd;
    if (libusb_get_device_descriptor(dev, &dd) == 0) {
        printf("VID:PID = %04x:%04x\n", dd.idVendor, dd.idProduct);
        printf("bcdUSB = %04x  class=%02x subclass=%02x protocol=%02x\n",
               dd.bcdUSB, dd.bDeviceClass, dd.bDeviceSubClass, dd.bDeviceProtocol);
        print_string(h, dd.iManufacturer, "Manufacturer");
        print_string(h, dd.iProduct, "Product");
        print_string(h, dd.iSerialNumber, "Serial");
    }

    struct libusb_config_descriptor *cfg = NULL;
    if (libusb_get_active_config_descriptor(dev, &cfg) == 0 && cfg) {
        printf("Interfaces:\n");
        for (int i = 0; i < cfg->bNumInterfaces; i++) {
            const struct libusb_interface *itf = &cfg->interface[i];
            for (int a = 0; a < itf->num_altsetting; a++) {
                const struct libusb_interface_descriptor *id = &itf->altsetting[a];
                printf("  if=%d alt=%d class=%02x subclass=%02x protocol=%02x endpoints=%d\n",
                       id->bInterfaceNumber, id->bAlternateSetting,
                       id->bInterfaceClass, id->bInterfaceSubClass,
                       id->bInterfaceProtocol, id->bNumEndpoints);
            }
        }
        libusb_free_config_descriptor(cfg);
    }

    libusb_close(h);
    libusb_exit(ctx);
    return 0;
}
