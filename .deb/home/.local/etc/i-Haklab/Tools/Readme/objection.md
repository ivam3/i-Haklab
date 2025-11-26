
# Objection (Mobile Security Toolkit)

## ¿Qué es Objection?

Objection es un kit de herramientas de exploración móvil en tiempo de ejecución, de código abierto y desarrollado en Python, diseñado para ayudar a los pentesters y analistas de seguridad a evaluar la seguridad de las aplicaciones móviles (tanto Android como iOS). Está construido sobre **Frida**, una potente herramienta de instrumentación dinámica, lo que permite a Objection interactuar con aplicaciones en ejecución, modificar su comportamiento, inspeccionar la memoria y el sistema de archivos, y eludir controles de seguridad, todo ello en tiempo real.

Su objetivo es simplificar tareas complejas de seguridad móvil, reduciendo la necesidad de un jailbreak en iOS o un rooteo en Android para muchas operaciones.

## ¿Para qué es útil la herramienta?

Objection es una herramienta indispensable en el arsenal de cualquier profesional que realice pruebas de penetración en aplicaciones móviles. Sus principales utilidades incluyen:

-   **Bypass de SSL Pinning:** Permite eludir las restricciones de SSL Pinning, facilitando la intercepción y análisis del tráfico HTTPS de una aplicación.
-   **Acceso al Sistema de Archivos de la Aplicación:** Permite explorar, descargar y cargar archivos desde el directorio de datos de la aplicación, revelando información sensible almacenada localmente.
-   **Manipulación de la Memoria en Tiempo de Ejecución:** Permite explorar y modificar objetos en la memoria de la aplicación (heap), parchear código o volcar secciones de memoria.
-   **Extracción de Secretos:** Volcar keychains (iOS), preferencias compartidas (Android), bases de datos SQLite y otros almacenes de datos que puedan contener información confidencial.
-   **Análisis de Clases y Métodos:** Enumerar clases y métodos de la aplicación, y llamar a métodos arbitrarios en tiempo de ejecución para comprender su lógica interna.
-   **Ejecución de Scripts de Frida:** Proporciona un entorno para cargar y ejecutar scripts personalizados de Frida.

## ¿Cómo se usa?

Objection se ejecuta desde la línea de comandos y se conecta a una aplicación móvil que está siendo instrumentada por Frida.

### 1. Instalación de Prerrequisitos

1.  **Instalar Python 3 y `pip`:** Asegúrate de tener Python 3 y su gestor de paquetes `pip` instalados en tu sistema.

2.  **Instalar Objection:**
    ```bash
    pip3 install objection
    ```

3.  **Configurar Frida:**
    -   **Servidor Frida en el dispositivo móvil:** Necesitas tener el servidor de Frida ejecutándose en el dispositivo móvil o emulador. Para Android, esto a menudo implica un dispositivo rooteado o parchar el APK con `frida-gadget`. Para iOS, un dispositivo con jailbreak facilita el proceso.
    -   **Cliente Frida en la máquina local:** `pip3 install frida-tools`

### 2. Uso Básico

1.  **Asegúrate de que Frida-server esté en ejecución en el dispositivo:**
    -   Inicia el servidor Frida en tu dispositivo móvil (si es Android rooteado, por ejemplo, `frida-server` en el dispositivo).
    -   Asegúrate de que tu máquina local pueda comunicarse con el dispositivo (por ejemplo, `adb forward tcp:27042 tcp:27042`).

2.  **Lanzar Objection y adjuntarlo a una Aplicación:**
    Identifica el nombre del paquete de la aplicación que deseas probar (ej. `com.example.app`).

    ```bash
    objection -g "com.example.app" explore
    ```
    Esto lanzará un shell interactivo donde podrás ejecutar comandos de Objection.

### 3. Comandos Comunes en el Shell Interactivo de Objection

Una vez en el shell interactivo de Objection (`com.example.app (PID: 12345) #`), puedes ejecutar comandos como:

-   `env`: Muestra información sobre el entorno de la aplicación, como directorios de almacenamiento de datos.
-   `android hooking list classes`: Lista todas las clases cargadas en la aplicación Android.
-   `ios hooking list classes`: Lista todas las clases cargadas en la aplicación iOS.
-   `android hooking search classes <palabra_clave>`: Busca clases que contengan una palabra clave.
-   `ios hooking search methods <palabra_clave>`: Busca métodos que contengan una palabra clave.
-   `android sslpinning disable`: Deshabilita el SSL Pinning en Android.
-   `ios sslpinning disable`: Deshabilita el SSL Pinning en iOS.
-   `android data_directory ls`: Lista el contenido del directorio de datos de la aplicación.
-   `android data_directory download <ruta_archivo>`: Descarga un archivo desde el directorio de datos.
-   `ios keychain dump`: Volca las entradas del keychain de iOS.
-   `memory list modules`: Lista los módulos cargados en la memoria de la aplicación.
-   `exit`: Sale del shell de Objection.

## Otras Consideraciones

-   **Entorno Controlado:** Objection es una herramienta de seguridad ofensiva. Su uso debe realizarse en **entornos controlados y con la autorización explícita** del propietario de la aplicación y el dispositivo móvil.
-   **Frida como Base:** Familiarizarse con Frida (`frida-tools`) mejorará tu capacidad para usar Objection y entender sus funcionalidades.
-   **Actualizaciones Constantes:** Las aplicaciones móviles y los sistemas operativos cambian constantemente. Es importante mantener Objection y Frida actualizados para asegurar su compatibilidad y efectividad.
