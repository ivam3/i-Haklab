
# PhoneSploit

## ¿Qué es PhoneSploit?

PhoneSploit es una herramienta de código abierto escrita en Python, diseñada para la explotación remota y el control de dispositivos Android. Utiliza una combinación de **Android Debug Bridge (ADB)** y el **Metasploit Framework** para interactuar con dispositivos Android objetivo, simplificando las pruebas de penetración y la evaluación de vulnerabilidades en este tipo de dispositivos.

La herramienta proporciona una interfaz interactiva que permite a los usuarios realizar una amplia gama de acciones en el dispositivo Android comprometido, desde el acceso a la shell hasta el control de la pantalla y la gestión de archivos.

## ¿Para qué es útil la herramienta?

PhoneSploit es una herramienta valiosa para pentesters, hackers éticos y profesionales de la seguridad que necesitan evaluar la postura de seguridad de dispositivos Android. Sus principales utilidades incluyen:

-   **Acceso y Control Remoto:** Obtener acceso a la shell del dispositivo, ejecutar comandos arbitrarios y controlarlo a distancia.
-   **Duplicación y Control de Pantalla:** Reflejar la pantalla del dispositivo Android en la máquina del atacante y permitir la interacción (teclado/ratón).
-   **Recopilación de Información:** Extraer datos sensibles como contactos, registros de llamadas, mensajes SMS, información del dispositivo (modelo, versión de Android) y lista de aplicaciones instaladas.
-   **Gestión de Archivos:** Subir y descargar archivos o carpetas completas desde y hacia el dispositivo objetivo.
-   **Captura de Medios:** Tomar capturas de pantalla, grabar la pantalla y capturar audio del micrófono o del propio dispositivo.
-   **Gestión de Aplicaciones:** Instalar, desinstalar y ejecutar aplicaciones, así como extraer sus archivos APK.
-   **Explotación con Metasploit:** Automatizar la creación, instalación y ejecución de payloads de Metasploit para obtener una sesión Meterpreter, lo que permite un control más profundo del dispositivo.
-   **Control del Dispositivo:** Reiniciar, apagar, bloquear o desbloquear la pantalla del dispositivo.

## ¿Cómo se usa?

PhoneSploit se ejecuta desde la línea de comandos y requiere ciertos requisitos previos para funcionar.

### 1. Requisitos Previos

-   **Sistema Operativo:** Recomendado Kali Linux o cualquier distribución Linux con Python 3 y Metasploit Framework instalados.
-   **ADB (Android Debug Bridge):** Las herramientas de la plataforma SDK de Android deben estar instaladas y configuradas.
-   **`scrcpy`:** Para la funcionalidad de duplicación y control de pantalla.
-   **`nmap`:** Para escanear la red.

### 2. Preparación del Dispositivo Android Objetivo

Para que PhoneSploit pueda conectarse y controlar un dispositivo Android, este debe estar configurado:

1.  **Habilitar Opciones de Desarrollador:** Generalmente, yendo a "Ajustes" > "Acerca del teléfono" y tocando el "Número de compilación" varias veces.
2.  **Habilitar Depuración USB:** Dentro de las "Opciones de Desarrollador", activa la "Depuración USB".
3.  **Conexión Remota (ADB por TCP/IP):** Para explotar de forma remota, el dispositivo debe tener el puerto ADB TCP 5555 abierto y accesible desde la red.

### 3. Instalación de PhoneSploit

1.  **Clonar el Repositorio:**
    ```bash
    git clone https://github.com/aerosol-waf/PhoneSploit.git
    cd PhoneSploit
    ```

2.  **Instalar Dependencias de Python:**
    ```bash
    pip install -r requirements.txt
    ```

### 4. Ejecución y Conexión

1.  **Ejecutar PhoneSploit:**
    ```bash
    python3 phonesploit.py
    ```
    Esto iniciará la interfaz interactiva de PhoneSploit.

2.  **Conectar el Dispositivo:**
    -   **Vía USB:** Si el dispositivo está conectado por USB y la depuración USB está habilitada, PhoneSploit debería detectarlo.
    -   **Vía Inalámbrica:** Si el dispositivo está en la misma red y tiene ADB por TCP/IP habilitado, selecciona la opción para conectar por IP y proporciona la dirección IP del dispositivo.

### 5. Uso de las Funcionalidades

Una vez conectado, PhoneSploit te presentará un menú con varias opciones. Algunos comandos comunes son:

-   `shell`: Obtener una shell interactiva en el dispositivo Android.
-   `screencap`: Tomar una captura de pantalla.
-   `screenrecord`: Grabar la pantalla del dispositivo.
-   `pull <ruta_remota> <ruta_local>`: Descargar un archivo/carpeta del dispositivo.
-   `push <ruta_local> <ruta_remota>`: Subir un archivo/carpeta al dispositivo.
-   `dump contacts`: Extraer contactos.
-   `dump call_logs`: Extraer registros de llamadas.
-   `dump sms`: Extraer mensajes SMS.
-   `install <ruta_apk>`: Instalar una aplicación.
-   `uninstall <nombre_paquete>`: Desinstalar una aplicación.
-   `metasploit`: Integración para generar y ejecutar payloads de Metasploit.
-   `reboot`: Reiniciar el dispositivo.
-   `poweroff`: Apagar el dispositivo.
-   `help`: Muestra la lista completa de comandos.

## Otras Consideraciones

-   **Ética y Legalidad:** PhoneSploit es una herramienta ofensiva muy potente. **Su uso para atacar dispositivos que no te pertenecen o para los cuales no tienes autorización explícita y por escrito es ILEGAL y puede tener graves consecuencias legales.** Utilízala únicamente para fines educativos, de investigación y de pruebas de penetración éticas en entornos controlados.
-   **Dependencia de ADB:** La funcionalidad de PhoneSploit depende completamente de la conexión ADB. Si ADB no está habilitado o configurado correctamente en el objetivo, la herramienta no podrá operar.
-   **Detección:** El tráfico ADB y las acciones realizadas por PhoneSploit pueden ser detectados por soluciones de seguridad en el dispositivo Android.
