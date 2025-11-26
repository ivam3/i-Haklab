
# OrbitalDump

## ¿Qué es OrbitalDump?

OrbitalDump es una herramienta de código abierto escrita en Python, diseñada para realizar ataques de fuerza bruta distribuidos contra servicios SSH. Su función principal es intentar adivinar nombres de usuario y contraseñas válidas para conexiones SSH mediante el uso de listas de palabras (diccionarios).

Una característica distintiva de OrbitalDump es su capacidad para utilizar proxies SOCKS4. Al canalizar los ataques a través de múltiples proxies, la herramienta puede evadir las medidas de limitación de velocidad (rate limiting) y los bloqueos de IP que los servidores SSH implementan para defenderse de los ataques de fuerza bruta. Si no se configuran proxies, OrbitalDump funciona como un script de fuerza bruta SSH multiproceso estándar.

## ¿Para qué es útil la herramienta?

OrbitalDump es una herramienta útil para profesionales de la ciberseguridad y pentesters en la fase de ataque, especialmente en el contexto de la evaluación de la seguridad de credenciales SSH:

-   **Auditoría de Credenciales SSH:** Permite probar la fortaleza de las contraseñas utilizadas para el acceso SSH en sistemas, identificando credenciales débiles o por defecto.
-   **Pruebas de Penetración:** En un entorno autorizado, se utiliza para demostrar cómo un atacante podría obtener acceso a sistemas a través de SSH mediante el uso de ataques de fuerza bruta.
-   **Evasión de Controles:** Su capacidad para usar proxies distribuidos ayuda a evadir las defensas de seguridad que intentan bloquear ataques de fuerza bruta desde una única dirección IP.
-   **Recuperación de Acceso:** En algunos casos, si se tienen indicios de nombres de usuario y posibles contraseñas, puede ayudar a recuperar el acceso a sistemas SSH propios.

## ¿Cómo se usa?

OrbitalDump es una herramienta de línea de comandos basada en Python.

### 1. Instalación

1.  **Instalar Python:** Asegúrate de tener Python 3 y `pip` instalados en tu sistema.

2.  **Instalar OrbitalDump:**
    Puedes instalarlo a través de `pip` (se recomienda usar `--user` para evitar problemas de permisos):

    ```bash
    pip install -U --user orbitaldump
    ```
    O, puedes clonar el repositorio de GitHub y ejecutarlo directamente:
    ```bash
    git clone https://github.com/k4yt3x/orbitaldump.git
    cd orbitaldump
    ```

### 2. Preparar Listas de Palabras

Necesitarás archivos de texto para los nombres de usuario y las contraseñas, con una entrada por línea.

-   `usernames.txt` (ej. `root`, `admin`, `john`, `maria`)
-   `passwords.txt` (ej. `password`, `123456`, `qwerty`, `secret`)

### 3. Ejemplos de Uso

1.  **Ataque Básico de Fuerza Bruta SSH (sin proxies):**
    Este comando intentará iniciar sesión en `example.com` utilizando los nombres de usuario de `usernames.txt` y las contraseñas de `passwords.txt`, con 10 hilos concurrentes.

    ```bash
    python -m orbitaldump -t 10 -u usernames.txt -p passwords.txt -h example.com
    ```
    -   `-t <número>`: Número de hilos concurrentes.
    -   `-u <archivo_usuarios>`: Ruta al archivo de nombres de usuario.
    -   `-p <archivo_contraseñas>`: Ruta al archivo de contraseñas.
    -   `-h <host_objetivo>`: Dirección IP o nombre de host del servidor SSH.

2.  **Ataque de Fuerza Bruta SSH con Proxies (SOCKS4):**
    Si deseas usar proxies para distribuir el ataque, añade la opción `--proxies`. OrbitalDump obtendrá proxies automáticamente de fuentes públicas como ProxyScrape.

    ```bash
    python -m orbitaldump -t 20 -u usernames.txt -p passwords.txt -h example.com --proxies
    ```

3.  **Especificar un Puerto SSH Diferente:**
    Si el servidor SSH se ejecuta en un puerto no estándar (ej. 2222).

    ```bash
    python -m orbitaldump -t 10 -u usernames.txt -p passwords.txt -h example.com -P 2222
    ```

4.  **Ver la Ayuda de la Herramienta:**
    Para ver todas las opciones y comandos disponibles.

    ```bash
    python -m orbitaldump --help
    ```

## Otras Consideraciones

-   **Ética y Legalidad:** OrbitalDump es una herramienta ofensiva. Su uso para atacar a individuos o sistemas sin consentimiento mutuo y por escrito es **ILEGAL y puede tener graves consecuencias legales**. Está destinado exclusivamente para fines educativos, de investigación y de pruebas de penetración éticas con autorización explícita.
-   **Bloqueo de Cuentas:** Los ataques de fuerza bruta pueden llevar al bloqueo de cuentas si el servidor SSH tiene configuradas políticas de bloqueo de intentos fallidos. Utiliza la herramienta con precaución.
-   **Calidad de las Listas de Palabras:** La efectividad del ataque depende en gran medida de la calidad y el tamaño de las listas de nombres de usuario y contraseñas.
-   **Proxies:** La fiabilidad de los proxies públicos puede variar. Algunos pueden ser lentos o inactivos.
