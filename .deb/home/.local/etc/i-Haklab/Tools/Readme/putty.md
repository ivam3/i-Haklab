# PuTTY

## ¿Qué es PuTTY?

PuTTY es una herramienta de código abierto y gratuita que funciona como un emulador de terminal, consola serie y aplicación de transferencia de archivos de red. Fue desarrollada principalmente para la plataforma Windows, pero también está disponible para plataformas Unix (incluyendo Linux y macOS). Es ampliamente utilizada para conectarse de forma segura a servidores remotos.

PuTTY soporta varios protocolos de red para la conexión y transferencia de datos, siendo SSH (Secure Shell) el más popular por su seguridad.

## ¿Para qué es útil la herramienta?

PuTTY es una herramienta esencial para administradores de sistemas, desarrolladores, profesionales de la ciberseguridad y cualquier persona que necesite acceder y gestionar sistemas remotos. Sus principales utilidades son:

-   **Acceso Seguro a Servidores Remotos (SSH):** Permite a los usuarios conectarse de forma segura a servidores Linux/Unix remotos, ejecutando comandos como si estuvieran sentados frente a la máquina. SSH cifra todo el tráfico, protegiendo las credenciales y los datos.
-   **Conexiones Serie:** Puede utilizarse para conectar a dispositivos a través de un puerto serie (como routers, switches de red, o hardware embebido) para su configuración y diagnóstico.
-   **Transferencia de Archivos Segura (SCP/SFTP):** Incluye herramientas como `pscp` (para SCP) y `psftp` (para SFTP) que permiten transferir archivos de forma segura entre la máquina local y el servidor remoto.
-   **Túneles SSH (Port Forwarding):** Permite crear túneles seguros para reenviar tráfico de red, lo que puede ser útil para acceder a servicios internos de una red remota de forma segura o para cifrar el tráfico a través de una conexión no segura.
-   **Protocolos Antiguos:** Aunque menos seguro, también soporta protocolos más antiguos como Telnet y rlogin para compatibilidad con sistemas heredados.

## ¿Cómo se usa?

El uso de PuTTY se centra en su interfaz gráfica (en Windows) o a través de sus herramientas de línea de comandos asociadas (en Unix/Linux y Windows).

### 1. Instalación

-   **En Windows:** Descarga el instalador MSI o el ejecutable independiente desde el sitio web oficial de PuTTY ([www.putty.org](https://www.putty.org/)).
-   **En Linux/macOS:** PuTTY (el cliente gráfico) es menos común, ya que los sistemas ya tienen SSH integrado. Sin embargo, las herramientas de línea de comandos como `pscp` y `psftp` se pueden instalar a través de gestores de paquetes si se desea (ej. `sudo apt install putty-tools`).

### 2. Conexión Básica (Usando el Cliente PuTTY en Windows)

1.  **Abrir PuTTY:** Ejecuta la aplicación PuTTY.
2.  **Configurar la Conexión:**
    -   En el campo "Host Name (or IP address)", introduce el nombre de dominio o la dirección IP del servidor remoto.
    -   En el campo "Port", el puerto por defecto para SSH es 22. Si tu servidor usa otro puerto, cámbialo.
    -   Asegúrate de que el "Connection type" esté seleccionado en "SSH".
3.  **Abrir la Conexión:** Haz clic en el botón "Open".
4.  **Advertencia de Seguridad (Host Key):** La primera vez que te conectes a un servidor, PuTTY te preguntará si confías en la clave de host del servidor. Si es una conexión legítima, haz clic en "Accept" o "Yes".
5.  **Autenticación:**
    -   La ventana de la terminal te pedirá "login as:". Introduce tu nombre de usuario para el servidor y presiona Enter.
    -   Luego te pedirá la "password:". Escribe tu contraseña y presiona Enter. Por razones de seguridad, la contraseña no se mostrará mientras la escribes.
6.  **Acceso:** Una vez autenticado, tendrás acceso a la línea de comandos del servidor remoto.
7.  **Cerrar Sesión:** Escribe `exit` y presiona Enter para cerrar la sesión.

### 3. Guardar Sesiones (en PuTTY)

Puedes guardar la configuración de tus conexiones para no tener que introducirlas cada vez:
1.  Introduce los detalles de `Host Name`, `Port` y `Connection type`.
2.  En la sección "Saved Sessions", escribe un nombre para tu sesión (ej. `MiServidorAWS`).
3.  Haz clic en "Save". Para futuras conexiones, solo selecciona la sesión guardada y haz clic en "Load" y luego "Open".

### 4. Autenticación con Clave Pública (Más Segura)

PuTTY soporta la autenticación con pares de claves SSH (pública/privada), que es más segura que las contraseñas.
1.  **Generar Claves:** Utiliza la herramienta `PuTTYgen` (incluida con PuTTY) para generar un par de claves.
2.  **Copiar Clave Pública:** Copia la clave pública al archivo `~/.ssh/authorized_keys` en el servidor remoto.
3.  **Guardar Clave Privada:** Guarda la clave privada en formato `.ppk` (PuTTY Private Key).
4.  **Configurar PuTTY:** En la configuración de una sesión guardada, ve a `Connection > SSH > Auth` y especifica la ruta a tu archivo `.ppk`.

### 5. Transferencia de Archivos con `pscp` (CLI)

`pscp` es una herramienta de línea de comandos similar a `scp` en Linux/Unix, para copiar archivos de forma segura.

-   **Copiar un archivo local al servidor:**
    ```bash
    pscp C:\ruta\a\mi_archivo.txt usuario@servidor.com:/ruta/remota/
    ```

-   **Copiar un archivo del servidor a local:**
    ```bash
    pscp usuario@servidor.com:/ruta/remota/archivo_servidor.log C:\ruta\local\
    ```

### 6. Transferencia de Archivos con `psftp` (CLI)

`psftp` es un cliente SFTP de línea de comandos para PuTTY.

```bash
psftp usuario@servidor.com
```
Una vez conectado, puedes usar comandos como `get`, `put`, `ls`, `cd`, etc.

## Otras Consideraciones

-   **Seguridad:** SSH proporciona una conexión cifrada, lo que hace que PuTTY sea una opción segura para la administración remota. Siempre usa SSH en lugar de Telnet cuando sea posible.
-   **PuTTYgen:** Una herramienta auxiliar para generar pares de claves SSH para la autenticación sin contraseña.
-   **Pageant:** Un agente de autenticación que almacena tus claves privadas de forma segura en memoria para evitar tener que introducirlas repetidamente.
