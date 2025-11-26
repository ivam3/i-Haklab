# fbi (Framebuffer Imageviewer)

## ¿Qué es fbi?

En el contexto de las herramientas de línea de comandos de Linux, `fbi` no tiene nada que ver con la agencia de investigación estadounidense. `fbi` es el acrónimo de **F**rame**b**uffer **I**mageviewer (Visor de Imágenes para Framebuffer).

Es una utilidad clásica de Linux que permite ver imágenes directamente desde la consola, sin necesidad de tener un entorno gráfico (como el sistema X11 o Wayland) en ejecución. Utiliza el **framebuffer** del kernel de Linux, que es una capa de bajo nivel que permite a los programas escribir píxeles directamente en la pantalla.

## ¿Para qué es útil la herramienta?

Aunque hoy en día la mayoría de los usuarios de escritorio utilizan visores de imágenes gráficos, `fbi` sigue siendo muy útil en varios escenarios:

*   **Sistemas Mínimos y Servidores:** En servidores o sistemas embebidos que no tienen un entorno de escritorio instalado (solo una consola de texto), `fbi` permite visualizar imágenes rápidamente sin la sobrecarga de instalar un sistema gráfico completo.
*   **Scripts de Sistema:** Se puede utilizar en scripts para mostrar imágenes. Por ejemplo, un script de diagnóstico podría mostrar un código QR en la pantalla para ser escaneado con un teléfono.
*   **Arranque del Sistema (Splash Screens):** Se usa a menudo durante el proceso de arranque de sistemas Linux embebidos para mostrar un logo o una pantalla de bienvenida (splash screen) antes de que se inicie la aplicación principal.
*   **Presentaciones de Diapositivas Simples:** Puede tomar una lista de imágenes y mostrarlas como una presentación de diapositivas a pantalla completa, directamente desde la consola.

## ¿Cómo funciona?

`fbi` lee un formato de archivo de imagen (soporta muchos, como JPEG, PNG, GIF, etc.) y lo renderiza directamente en el dispositivo de framebuffer (`/dev/fb0`). Para que funcione, el usuario que ejecuta el comando necesita permisos de lectura y escritura para el dispositivo de framebuffer. Por esta razón, a menudo se ejecuta con `sudo` o como usuario `root`.

## ¿Cómo se usa?

`fbi` es una herramienta de línea de comandos.

### Ejemplo 1: Ver una sola imagen

Para ver una imagen a pantalla completa:

```bash
sudo fbi mi_imagen.jpg
```

La imagen se mostrará en la pantalla. Puedes usar las teclas de flecha para desplazarte si la imagen es más grande que la pantalla. Presiona `q` para salir.

### Ejemplo 2: Ver múltiples imágenes (Modo Presentación)

Puedes pasarle varias imágenes o usar un comodín para crear una presentación de diapositivas.

```bash
sudo fbi *.png
```

En este modo, puedes usar las teclas `Page Up` y `Page Down` para navegar entre las imágenes.

### Ejemplo 3: Establecer un tiempo para la presentación

Puedes hacer que las imágenes cambien automáticamente después de un número determinado de segundos.

```bash
# Cambiar de imagen cada 5 segundos
sudo fbi -a -t 5 *.jpg
```
*   `-a`: Activa el modo de auto-zoom (ajusta la imagen a la pantalla).
*   `-t 5`: Establece un tiempo de 5 segundos por imagen.

### Ejemplo 4: Ver imágenes en una terminal virtual diferente

Puedes ejecutar `fbi` en una TTY (terminal virtual) específica.

```bash
# Mostrar la imagen en la TTY 2
sudo fbi -d /dev/fb0 -T 2 mi_logo.png
```
*   `-d /dev/fb0`: Especifica el dispositivo de framebuffer.
*   `-T 2`: Especifica el número de la terminal virtual.

## Consideraciones Adicionales

*   **Requiere Framebuffer:** `fbi` solo funciona en sistemas donde el framebuffer de Linux está habilitado y es accesible, lo que es cierto en la mayoría de las distribuciones de Linux cuando no se está en una sesión gráfica. No funcionará dentro de un emulador de terminal *dentro* de un entorno de escritorio (como `gnome-terminal` o `konsole`), ya que estos no tienen acceso directo al framebuffer. Funciona en las consolas de texto plano (TTYs), a las que normalmente se accede con `Ctrl+Alt+F1` a `F6`.
*   **Herramienta Sencilla y Directa:** Es una herramienta que hace una cosa y la hace bien. No tiene funciones de edición ni una interfaz compleja; es simplemente un visor.

---
*Nota: La información proporcionada aquí se refiere al visor de imágenes para Linux. Cualquier otra herramienta con el mismo nombre tendría un propósito completamente diferente.*
