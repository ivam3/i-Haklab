
# Routersploit

## ¿Qué es Routersploit?

Routersploit es un framework de explotación de código abierto similar a Metasploit, pero especializado en dispositivos embebidos. Está diseñado para ayudar a los profesionales de la ciberseguridad a identificar y explotar vulnerabilidades en routers, puntos de acceso, cámaras IP, módems y otros dispositivos IoT (Internet de las Cosas).

El framework, escrito en Python, proporciona una interfaz modular que permite a los usuarios buscar, escanear, explotar y auditar la seguridad de estos dispositivos, que a menudo son pasados por alto y tienen configuraciones de seguridad débiles o vulnerabilidades conocidas.

## ¿Para qué es útil la herramienta?

Routersploit es una herramienta esencial para pentesters y equipos de Red Team que realizan evaluaciones de seguridad en redes e infraestructuras que incluyen dispositivos embebidos:

-   **Pruebas de Penetración de Dispositivos Embebidos:** Su objetivo principal es identificar y explotar vulnerabilidades en routers, switches, puntos de acceso, cámaras IP y otros dispositivos IoT.
-   **Auditoría de Seguridad de Red:** Permite a los profesionales evaluar la postura de seguridad de la red al enfocarse en los dispositivos que son a menudo los puntos más débiles de una infraestructura.
-   **Identificación de Vulnerabilidades:** Contiene una base de datos de exploits conocidos para una amplia variedad de fabricantes y modelos de dispositivos.
-   **Ataques de Fuerza Bruta y Diccionario:** Incluye módulos para probar credenciales predeterminadas o débiles contra servicios de autenticación de dispositivos (Telnet, SSH, HTTP).
-   **Escaneo de Redes:** Permite escanear rangos de IP para identificar dispositivos vulnerables.

## ¿Cómo se usa?

Routersploit se opera a través de una interfaz de línea de comandos interactiva, similar a Metasploit.

### 1. Instalación

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/threat9/routersploit.git
    cd routersploit
    ```

2.  **Instalar dependencias:**
    ```bash
    pip install -r requirements.txt
    ```
    (Asegúrate de usar `pip` o `pip3` según tu configuración de Python).

### 2. Uso Básico

1.  **Iniciar Routersploit:**
    ```bash
    python3 rsf.py
    ```
    Esto iniciará la consola interactiva de Routersploit.

2.  **Navegación y Módulos:**
    La interfaz de Routersploit se organiza en diferentes tipos de módulos:
    -   `exploits`: Módulos para explotar vulnerabilidades específicas.
    -   `scanners`: Módulos para escanear en busca de vulnerabilidades.
    -   `creds`: Módulos para ataques de fuerza bruta de credenciales.
    -   `payloads`: Módulos para generar payloads.

    -   `show modules`: Muestra todos los módulos disponibles.
    -   `use <tipo_de_modulo>/<nombre_del_modulo>`: Selecciona un módulo.
        Por ejemplo: `use scanners/cisco/asa_ftp_bruteforce`

3.  **Configurar Opciones del Módulo:**
    Una vez seleccionado un módulo, puedes ver y configurar sus opciones.

    -   `show options`: Muestra los parámetros configurables del módulo (ej. `target`, `port`, `username`, `password`).
    -   `set target <IP_objetivo>`: Establece la dirección IP del dispositivo a atacar.
    -   `set port <número_de_puerto>`: Establece el puerto del servicio (ej. 23 para Telnet).
    -   `set username <nombre_usuario>`: Establece el nombre de usuario para ataques de credenciales.
    -   `set password <contraseña>`: Establece la contraseña para ataques de credenciales.
    -   `set users <ruta_a_lista_usuarios>`: Establece un archivo de lista de usuarios.
    -   `set passwords <ruta_a_lista_contraseñas>`: Establece un archivo de lista de contraseñas.

4.  **Ejecutar el Módulo:**
    -   `check`: Algunos módulos tienen una opción `check` para verificar si el objetivo es vulnerable antes de intentar la explotación.
    -   `run`: Ejecuta el módulo.

### Ejemplo de Flujo de Trabajo

```
# Iniciar Routersploit
python3 rsf.py

# Buscar un escáner de Cisco
rsf > search cisco

# Usar el escáner de Telnet para Cisco
rsf > use scanners/cisco/cisco_telnet_bruteforce

# Mostrar opciones del escáner
rsf (Cisco Telnet Bruteforce) > show options

# Configurar el objetivo y el diccionario de contraseñas
rsf (Cisco Telnet Bruteforce) > set target 192.168.1.1
rsf (Cisco Telnet Bruteforce) > set passwords /usr/share/wordlists/rockyou.txt
rsf (Cisco Telnet Bruteforce) > set username cisco

# Ejecutar el escáner
rsf (Cisco Telnet Bruteforce) > run
```

## Otras Consideraciones

-   **Ética y Legalidad:** Routersploit es una herramienta ofensiva. Su uso para atacar a individuos o sistemas sin consentimiento mutuo y por escrito es **ILEGAL y puede tener graves consecuencias legales**. Utilízala únicamente para fines educativos, de penetración ética en tus propios sistemas o con autorización explícita.
-   **Base de Datos de Dispositivos:** La efectividad de Routersploit se basa en su base de datos de vulnerabilidades conocidas. Es crucial mantener la herramienta actualizada.
-   **Firmware:** Los dispositivos embebidos pueden tener numerosas versiones de firmware, y una vulnerabilidad puede no aplicarse a todas ellas.
