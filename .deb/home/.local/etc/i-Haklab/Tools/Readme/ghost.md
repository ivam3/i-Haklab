
# Ghost Framework

## ¿Qué es Ghost Framework?

Ghost Framework es una herramienta de post-explotación para Android, de código abierto y escrita en Python. Utiliza el **Android Debug Bridge (ADB)** para establecer una conexión remota con un dispositivo Android y proporcionar un control casi total sobre él. Está diseñado como un framework interactivo, similar a Metasploit, con diferentes módulos para realizar tareas específicas.

## ¿Para qué es útil la herramienta?

Ghost Framework es utilizado por profesionales de la seguridad y pentesters para evaluar la seguridad de un dispositivo Android una vez que se ha obtenido acceso a él (por ejemplo, si se ha logrado habilitar ADB en un dispositivo comprometido). Sus principales usos son:

-   **Post-explotación:** Es su función principal. Permite a un analista interactuar con un dispositivo comprometido para extraer información, instalar/desinstalar aplicaciones, y moverse lateralmente.
-   **Análisis Forense Remoto:** Permite la extracción de datos sensibles, registros (logs), y otra información del dispositivo para una investigación.
-   **Gestión Remota:** Aunque no es su propósito principal, puede usarse para administrar un dispositivo Android desde la línea de comandos, realizar capturas de pantalla, grabar la pantalla, etc.
-   **Pruebas de seguridad de aplicaciones:** Se puede usar para manipular el entorno de una aplicación, ver sus datos privados, y evaluar su comportamiento.

## ¿Cómo se usa?

Ghost Framework se opera a través de una consola interactiva. Primero, se debe establecer una conexión con el dispositivo Android a través de ADB.

### Requisitos

-   Python 3.
-   Tener `adb` instalado en tu sistema.
-   El dispositivo Android debe tener la **depuración USB habilitada** y debe estar conectado a la misma red (si se usa ADB por WiFi) o al mismo PC (vía USB).

### Pasos básicos

1.  **Instalación del Framework:**
    ```bash
    git clone https://github.com/entynetproject/ghost.git
    cd ghost
    pip3 install -r requirements.txt
    ```

2.  **Conectar al dispositivo Android:**
    Asegúrate de que `adb` puede ver tu dispositivo.
    ```bash
    # Conectar vía USB
    adb devices

    # O conectar vía WiFi (el dispositivo debe tener ADB sobre TCP/IP habilitado)
    adb connect <IP_del_dispositivo>:5555
    ```

3.  **Iniciar Ghost Framework:**
    ```bash
    python3 ghost.py
    ```
    Esto abrirá la consola interactiva de Ghost (`ghost >`).

4.  **Seleccionar el dispositivo y usar módulos:**
    -   Dentro de la consola de Ghost, usa `show` para ver los dispositivos conectados.
    -   Usa `use <ID>` para seleccionar el dispositivo que quieres controlar.
    -   Una vez seleccionado el dispositivo, puedes usar comandos como `help` para ver la lista de módulos disponibles.

### Comandos y Módulos Comunes

-   `shell`: Abre una shell interactiva en el dispositivo Android.
-   `screenshot`: Toma una captura de pantalla del dispositivo.
-   `screenrecord`: Graba un video de la pantalla.
-   `download`: Descarga un archivo desde el dispositivo Android a tu máquina.
-   `upload`: Sube un archivo desde tu máquina al dispositivo.
-   `app_install`: Instala un archivo APK en el dispositivo.
-   `app_uninstall`: Desinstala una aplicación.
-   `wifi_info`: Muestra información sobre la conexión WiFi.

## Otras consideraciones

-   **Legalidad y Ética:** Esta es una herramienta potente. Su uso debe limitarse a entornos de prueba autorizados y hacking ético.
-   **Dependencia de ADB:** El framework es completamente dependiente de ADB. Si la conexión ADB se pierde o es revocada en el dispositivo, el control se pierde.
