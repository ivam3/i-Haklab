
# scrcpy

## ¿Qué es scrcpy?

Scrcpy (pronunciado "screen copy") es una herramienta gratuita y de código abierto que permite visualizar y controlar la pantalla de un dispositivo Android desde un ordenador de escritorio (Windows, macOS, Linux). Destaca por su ligereza, baja latencia, alta calidad de imagen y por no requerir la instalación de ninguna aplicación en el dispositivo Android ni acceso root.

Funciona conectando el dispositivo Android al ordenador, ya sea mediante un cable USB o de forma inalámbrica (a través de ADB sobre TCP/IP), y transmitiendo la pantalla del dispositivo a una ventana en el ordenador, mientras reenvía las entradas de teclado y ratón al dispositivo.

## ¿Para qué es útil la herramienta?

Scrcpy es una herramienta extremadamente útil para desarrolladores, testers, gamers, presentadores y usuarios generales de Android que desean una experiencia de escritorio con su dispositivo móvil:

-   **Desarrollo de Aplicaciones Android:** Probar aplicaciones directamente en el PC, interactuando con ellas usando un teclado y ratón.
-   **Presentaciones y Demostraciones:** Mostrar la pantalla de un dispositivo Android en una pantalla más grande sin necesidad de un proyector o cables HDMI específicos del móvil.
-   **Juegos:** Jugar a juegos Android en el ordenador utilizando el ratón y el teclado, o mapeando controles.
-   **Soporte Técnico Remoto:** Ayudar a otros a solucionar problemas en sus dispositivos Android viendo y controlando su pantalla.
-   **Gestión del Dispositivo:** Realizar tareas cotidianas, como escribir mensajes, navegar por aplicaciones o configurar ajustes, de forma más cómoda desde el ordenador.
-   **Grabación de Pantalla:** Grabar fácilmente la actividad de la pantalla del Android en el PC.

## ¿Cómo se usa?

Scrcpy es una herramienta de línea de comandos, pero se abre en una ventana gráfica.

### 1. Requisitos Previos

-   **Dispositivo Android:** Necesitas un dispositivo Android con Android 5.0 (Lollipop) o superior.
-   **Depuración USB:** Debes tener habilitadas las "Opciones para desarrolladores" en tu dispositivo Android y, dentro de ellas, activar la "Depuración USB".
-   **ADB:** Scrcpy utiliza ADB (Android Debug Bridge) para comunicarse con el dispositivo. ADB suele venir incluido con la instalación de Scrcpy o se instala por separado con las herramientas de la plataforma SDK de Android.

### 2. Instalación

-   **Windows:**
    1.  Descarga el paquete `scrcpy-win64-...zip` (o win32 si es necesario) desde la página de lanzamientos de GitHub de scrcpy.
    2.  Descomprime el archivo en una carpeta de tu elección.
    3.  Asegúrate de que la depuración USB esté activada en tu Android y conéctalo al PC con un cable USB.
    4.  Ejecuta `scrcpy.exe` desde la carpeta descomprimida.

-   **macOS:**
    Instala con Homebrew:
    ```bash
    brew install scrcpy
    ```
    Luego conecta el Android y ejecuta `scrcpy` en la terminal.

-   **Linux (Debian/Ubuntu):**
    Instala con `apt`:
    ```bash
    sudo apt install scrcpy
    ```
    Luego conecta el Android y ejecuta `scrcpy` en la terminal.

### 3. Conexión y Control

-   **Conexión USB (recomendado):**
    1.  Activa la depuración USB en tu Android.
    2.  Conecta tu Android al PC con un cable USB.
    3.  Si es la primera vez, el móvil te pedirá que autorices la depuración USB desde tu PC; acepta.
    4.  Ejecuta `scrcpy` en la terminal. Se abrirá una ventana con la pantalla de tu Android.

-   **Conexión Inalámbrica (ADB sobre TCP/IP):**
    1.  Conecta tu Android al PC por USB y asegúrate de que ADB lo detecte (`adb devices`).
    2.  Habilita ADB sobre TCP/IP en el móvil (sin desconectar el USB): `adb tcpip 5555`.
    3.  Desconecta el cable USB del Android.
    4.  Conecta tu PC al Android de forma inalámbrica (ambos deben estar en la misma red Wi-Fi): `adb connect <IP_del_dispositivo>:5555`.
    5.  Ejecuta `scrcpy`.

### 4. Opciones de Línea de Comandos Útiles

Scrcpy tiene muchas opciones para personalizar la experiencia.

-   `scrcpy -w`: Inicia en modo "Wireless" (para conexiones ADB inalámbricas).
-   `scrcpy --no-display`: Solo envía las entradas del teclado/ratón sin mostrar la pantalla.
-   `scrcpy --record file.mp4`: Graba la pantalla del dispositivo en un archivo de video.
-   `scrcpy -m 1024`: Limita el tamaño de la pantalla a 1024 píxeles (útil para baja resolución).
-   `scrcpy -b 2M`: Limita el bitrate del video a 2 Mbps.
-   `scrcpy --always-on-top`: Mantiene la ventana de scrcpy siempre visible.
-   `scrcpy --turn-screen-off`: Apaga la pantalla del dispositivo físico mientras se está duplicando (ahorra batería).
-   `scrcpy --show-touches`: Muestra los toques en la pantalla.

## Otras Consideraciones

-   **Rendimiento:** Scrcpy es conocido por su bajo consumo de recursos y baja latencia, lo que lo hace muy fluido.
-   **Seguridad:** La comunicación entre Scrcpy y el dispositivo Android se realiza a través de ADB, que es un protocolo seguro.
-   **No Requiere Root:** Una de las grandes ventajas es que no necesita acceso root en el dispositivo para funcionar.
-   **No Instala Apps:** Scrcpy no instala ningún software en el dispositivo Android; simplemente utiliza las funcionalidades nativas de Android.
