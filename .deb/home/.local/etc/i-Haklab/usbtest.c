#include <stdio.h>
#include <assert.h>
#include <libusb-1.0/libusb.h>

int main(int argc, char **argv) {
    libusb_context *context;
    libusb_device_handle *handle;
    libusb_device *device;
    struct libusb_device_descriptor desc;
    unsigned char buffer[256];
    int fd;
    assert((argc > 1) && (sscanf(argv[1], "%d", &fd) == 1));
    libusb_set_option(NULL, LIBUSB_OPTION_WEAK_AUTHORITY);
    assert(!libusb_init(&context));
    assert(!libusb_wrap_sys_device(context, (intptr_t) fd, &handle));
    device = libusb_get_device(handle);
    assert(!libusb_get_device_descriptor(device, &desc));
    printf("Vendor ID: %04x\n", desc.idVendor);
    printf("Product ID: %04x\n", desc.idProduct);
    assert(libusb_get_string_descriptor_ascii(handle, desc.iManufacturer, buffer, 256) >= 0);
    printf("Manufacturer: %s\n", buffer);
    assert(libusb_get_string_descriptor_ascii(handle, desc.iProduct, buffer, 256) >= 0);
    printf("Product: %s\n", buffer);
    if (libusb_get_string_descriptor_ascii(handle, desc.iSerialNumber, buffer, 256) >= 0)
        printf("Serial No: %s\n", buffer);
    libusb_exit(context);
}