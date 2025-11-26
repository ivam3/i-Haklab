
# HCDecryptor

## ¿Qué es HCDecryptor?

HCDecryptor es una herramienta diseñada para descifrar archivos de configuración, comúnmente con extensión `.hc`, que son utilizados por varias aplicaciones VPN populares como HTTP Custom, HTTP Injector, APK Custom, eProxy, NapsternetV y otras basadas en SocksHTTP. Estas aplicaciones a menudo cifran sus archivos de configuración para proteger la información sensible, como detalles del servidor, cargas útiles (payloads) y credenciales SSH, impidiendo su fácil lectura o modificación.

Existen implementaciones de HCDecryptor en JavaScript y Python, así como servicios web y bots que utilizan esta funcionalidad.

## ¿Para qué es útil la herramienta?

HCDecryptor es útil para varios propósitos, principalmente para aquellos que trabajan con estas aplicaciones VPN y necesitan acceder a la configuración subyacente:

-   **Análisis de Configuraciones:** Permite a los usuarios y desarrolladores inspeccionar los detalles exactos de cómo están configuradas las conexiones VPN dentro de estos archivos `.hc` cifrados.
-   **Solución de Problemas:** Al descifrar la configuración, se pueden identificar y corregir errores o discrepancias en la configuración de la VPN.
-   **Seguridad:** Un investigador de seguridad podría usarla para entender la información que estas configuraciones exponen y verificar si hay credenciales hardcodeadas o datos sensibles.
-   **Educación:** Ayuda a comprender cómo funcionan estas aplicaciones VPN a un nivel más técnico, revelando los payloads y detalles de conexión.

## ¿Cómo se usa?

La forma de usar HCDecryptor varía ligeramente dependiendo de la implementación (JavaScript o Python). A continuación, se describen los pasos generales para las versiones de línea de comandos.

### 1. Requisitos

-   **Para la versión de JavaScript:** Necesitarás tener Node.js instalado en tu sistema.
-   **Para la versión de Python:** Necesitarás Python 3 y las librerías `pycryptodome`.

### 2. Instalación (ejemplo para Python)

Si estás utilizando una versión de Python, los pasos típicos de instalación serían:

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/some_user/hcdecryptor_python.git
    ```
    (Nota: Reemplaza `some_user/hcdecryptor_python.git` con la URL real del repositorio si lo obtienes de GitHub).

2.  **Navegar al directorio:**
    ```bash
    cd hcdecryptor_python
    ```

3.  **Instalar dependencias:**
    ```bash
    pip3 install -r requirements.txt
    ```

### 3. Ejemplos de Uso en Línea de Comandos

Una vez instalado, el uso general es pasar el archivo `.hc` cifrado a la herramienta.

-   **Para la versión de Python:**
    Coloca tu archivo `.hc` cifrado (ej. `config.hc`) en el mismo directorio que el script principal de descifrado (ej. `decrypt.py`).
    ```bash
    python3 decrypt.py config.hc
    ```
    La salida descifrada (que contiene la configuración en texto plano, JSON u otro formato legible) se mostrará en la terminal.

-   **Para la versión de JavaScript:**
    Si tienes un script `index.js` o `HCDecryptor.js`, y tu archivo `config.hc` en el mismo directorio:
    ```bash
    node index.js -f config.hc -k keys.dat
    ```
    (La opción `-k keys.dat` puede ser necesaria si el descifrador requiere claves externas, que a veces se actualizan).
    O, de forma más simple:
    ```bash
    node HCDecryptor.js /ruta/al/config.hc
    ```

### 4. Alternativas Web y Bots

Existen servicios web (como HCDrill) y bots de Telegram que ofrecen la funcionalidad de descifrado. Estos permiten subir el archivo `.hc` directamente en una interfaz web o a través de un bot, y el servicio devuelve el contenido descifrado. Esta es una opción conveniente si no deseas instalar el software localmente.

## Otras consideraciones

-   **Claves de Descifrado:** Las aplicaciones VPN a veces cambian las claves o algoritmos de cifrado. Esto significa que una versión antigua de HCDecryptor podría no ser capaz de descifrar los archivos `.hc` generados por versiones más recientes de las aplicaciones, o viceversa. Es posible que necesites la versión correcta de la herramienta o un conjunto de claves actualizado.
-   **Contenido Sensible:** Ten en cuenta que los archivos `.hc` descifrados pueden contener información sensible. Maneja esta información con cuidado.
