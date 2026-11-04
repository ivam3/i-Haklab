# OBS Studio

## ¿Qué es?

Integración de i-Haklab para usar una cámara UVC por USB y las cámaras
frontal/trasera del teléfono como fuentes locales de **OBS Studio**, sin
depender de la app *USB Camera* y sin hardware adicional.

La captura se publica como MJPEG en `127.0.0.1`:

| Fuente | URL | Puerto |
| --- | --- | --- |
| Cámara USB (UVC) | `http://127.0.0.1:9000/video` | 9000 |
| Cámara del teléfono | `http://127.0.0.1:9001/video` | 9001 |

## Qué configura i-Haklab

Al ejecutar `apt install obs-studio` (o `apt reinstall obs-studio`), el wrapper
de apt ejecuta `preconf obs-studio` **antes** de instalar el paquete:

1. Instala las dependencias que faltan: `ffmpeg`, `scrcpy`, `android-tools`,
   `termux-api`, `mpv`, `clang`, `cmake`, `make`, `pkg-config`, `libusb`,
   `libjpeg-turbo`, `git`, `python`, `procps` y `coreutils`.
2. Clona `libuvc` (tag `v0.0.9`) y compila los helpers locales:
   `uvc-stream`, `usbdesc` y `mjpeg-pipe-server`.

Después de instalar OBS, `pkg2conf obs-studio` fusiona en la colección activa
las escenas y fuentes de cámara. Nunca borra escenas existentes: si una escena
o fuente ya existe, la deja intacta. Antes de escribir crea una copia
`Untitled.json.bak.ih-<fecha>`.

Escenas creadas:

* **Cámara USB** — cámara UVC a pantalla completa.
* **Cámara Trasera** — cámara trasera del teléfono a pantalla completa.
* **Cámara Frontal** — cámara frontal del teléfono a pantalla completa.
* **USB + Teléfono** — USB a pantalla completa y teléfono en ventana PiP.

## Cámara USB

La app *USB Camera* (`com.shenyaocn.android.usbcamera`) debe estar cerrada o
deshabilitada para que no reclame el dispositivo UVC.

```bash
cam-usb --list       # lista dispositivos USB visibles
cam-usb --probe      # pide permiso y guarda VID:PID
cam-usb              # inicia el stream en el puerto 9000
cam-usb --stop       # detiene el stream
```

Verificación:

```bash
curl -fsS http://127.0.0.1:9000/snapshot -o /tmp/usb.jpg
```

La primera vez Android muestra un diálogo de permiso USB. Acepta el acceso y
repite `cam-usb --probe` si es necesario. El VID:PID se guarda en
`~/.config/cam-usb.vidpid`.

## Cámara del teléfono

Requiere depuración inalámbrica activa y un dispositivo ADB conectado:

```bash
adb devices
phone-cam --list       # cámaras disponibles
phone-cam back         # cámara trasera (id 0) en el puerto 9001
phone-cam front        # cámara frontal (id 1) en el puerto 9001
phone-cam --stop       # detiene scrcpy, ffmpeg y el servidor MJPEG
```

Verificación:

```bash
curl -fsS http://127.0.0.1:9001/snapshot -o /tmp/phone.jpg
```

La mayoría de los HAL de cámara no permiten abrir la frontal y la trasera a la
vez. `phone-cam front` y `phone-cam back` se alternan; la cámara USB sí puede
convivir con una cámara del teléfono.

## Ventanas flotantes

```bash
cam-float                 # ventana flotante para la cámara USB
phone-float               # ventana flotante para la cámara del teléfono
cam-float --stop
phone-float --stop
```

Ambas ventanas usan `mpv` sin bordes, siempre encima, y se pueden mover con
`cam-float 480x360+20+20`.

## Recompilar los helpers

Si cambias el código o una actualización de libuvc falla:

```bash
~/.local/libexec/i-Haklab/build-uvc-cam
```

Los binarios quedan en `~/.local/src/uvc-cam/`.

## Desinstalación

`apt remove obs-studio` ejecuta el caso `obs-studio` de `cleanup`:

* elimina solo las escenas y fuentes creadas por i-Haklab;
* conserva las escenas, fuentes y grupos del usuario;
* conserva una fuente de cámara si otra escena del usuario todavía la usa;
* elimina `libuvc` y los binarios generados por `preconf` en
  `~/.local/src/uvc-cam/`, pero mantiene el código fuente y los scripts;
* deja una copia `Untitled.json.bak.cleanup-<fecha>` antes de modificar OBS.

## Solución de problemas

* **`No USB devices are visible`**: conecta la cámara, revisa el diálogo de
  permiso USB y confirma con `termux-usb -l`.
* **La cámara USB está ocupada**: cierra o deshabilita la app *USB Camera*.
* **ADB en `offline`**: reconecta la depuración inalámbrica y vuelve a probar
  `adb devices`; `phone-cam` prefiere un serial `IP:puerto` cuando hay varios.
* **OBS está abierto al ejecutar `pkg2conf`**: ciérralo y ejecuta
  `pkg2conf obs-studio`; OBS guarda la colección al salir y podría sobrescribir
  los cambios.
* **`curl` no responde**: comprueba el puerto (`9000` USB, `9001` teléfono) y
  el log `~/.cache/phone-cam/phone-cam.log`.
