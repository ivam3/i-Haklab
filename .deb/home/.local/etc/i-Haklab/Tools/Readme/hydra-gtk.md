
# hydra-gtk (THC Hydra GUI)

## ¿Qué es hydra-gtk?

`hydra-gtk` es la interfaz gráfica de usuario (GUI) de **THC Hydra**, una de las herramientas de cracking de contraseñas de red más rápidas y potentes que existen. Mientras que THC Hydra es una herramienta de línea de comandos, `hydra-gtk` proporciona una experiencia más visual y sencilla para configurar y ejecutar ataques de fuerza bruta y diccionario contra diversos servicios de red.

Está diseñada para ayudar a los investigadores y consultores de seguridad a demostrar lo fácil que puede ser obtener acceso no autorizado a sistemas de forma remota mediante el descifrado de credenciales.

## ¿Para qué es útil la herramienta?

`hydra-gtk` y su herramienta subyacente (THC Hydra) son herramientas esenciales en las fases de auditoría de seguridad y pruebas de penetración, utilizadas para:

-   **Auditoría de Contraseñas:** Permite a los administradores de red y a los consultores de seguridad verificar la fortaleza de las contraseñas utilizadas por los usuarios en diversos servicios.
-   **Pruebas de Penetración:** En un entorno autorizado, se utiliza para descubrir credenciales válidas en servicios expuestos en la red, lo que podría conducir a la obtención de acceso no autorizado.
-   **Soporte Multiprocolos:** Soporta un gran número de protocolos de red, incluyendo (pero no limitado a):
    -   SSH (Secure Shell)
    -   FTP (File Transfer Protocol)
    -   HTTP/HTTPS (servidores web y formularios de login)
    -   MySQL, PostgreSQL
    -   SMB (Server Message Block)
    -   POP3, IMAP (servicios de correo)
    -   Telnet, VNC, RDP
    -   SNMP (Simple Network Management Protocol)
-   **Ataques de Fuerza Bruta y Diccionario:** Combina listas de usuarios y contraseñas para intentar iniciar sesión en servicios, o prueba combinaciones de caracteres.

## ¿Cómo se usa?

`hydra-gtk` se utiliza a través de su interfaz gráfica.

### 1. Instalación

`hydra-gtk` a menudo viene preinstalado en distribuciones de seguridad como Kali Linux. Si no lo está, puedes instalarlo en sistemas basados en Debian/Ubuntu con:

```bash
sudo apt-get install hydra-gtk
```

### 2. Inicio

Puedes iniciar la aplicación desde el menú de aplicaciones de tu sistema o ejecutando el comando `xhydra` en una terminal:

```bash
xhydra
```

### 3. Configuración del Ataque (desde la GUI)

La interfaz de `hydra-gtk` está dividida en varias pestañas:

-   **Target (Objetivo):**
    -   `Single Target`: La dirección IP o nombre de host del objetivo.
    -   `Port`: El puerto del servicio a atacar (ej. 22 para SSH, 21 para FTP).
    -   `Protocol`: Selecciona el protocolo de la lista desplegable (ej. `ssh`, `ftp`, `http-get`, `mysql`).

-   **Passwords (Contraseñas):**
    -   `Username List`: Ruta a un archivo de texto con nombres de usuario (uno por línea).
    -   `Password List`: Ruta a un archivo de texto con contraseñas (uno por línea).
    -   `Username`: Un único nombre de usuario a probar.
    -   `Password`: Una única contraseña a probar.
    -   También se pueden configurar ataques basados en fuerza bruta (`Brute Force`).

-   **Specific (Opciones Específicas):**
    -   Aquí se configuran opciones específicas para el protocolo seleccionado (ej. URL para un formulario HTTP POST).

-   **Tuning (Ajuste):**
    -   `Number of Tasks`: Número de conexiones simultáneas (threads).
    -   `Timeout`: Tiempo de espera por conexión.
    -   `Verbose Mode`: Nivel de detalle de la salida.
    -   `Stop after first pair`: Detiene el ataque al encontrar el primer par de credenciales.

-   **Start (Inicio):**
    -   Haz clic en `Start` para iniciar el ataque. Los resultados se mostrarán en la parte inferior de la ventana, indicando las credenciales válidas encontradas.

### 4. Equivalente en Línea de Comandos (THC Hydra)

Es útil entender que `hydra-gtk` simplemente construye un comando para la herramienta `hydra` subyacente. Un ejemplo de cómo se vería un ataque SSH por línea de comandos sería:

```bash
hydra -l usuario_conocido -P /ruta/a/diccionario.txt -t 10 ssh://192.168.1.10
```

## Otras Consideraciones

-   **Ética y Legalidad:** THC Hydra y `hydra-gtk` son herramientas potentes para pruebas de seguridad. **Su uso debe ser estrictamente ético y legal, siempre con el permiso explícito y por escrito del propietario del sistema objetivo.** El uso no autorizado es ilegal y puede tener graves consecuencias.
-   **Recursos del Sistema:** Los ataques de fuerza bruta pueden consumir muchos recursos de CPU, memoria y red, tanto en la máquina atacante como en el objetivo.
-   **Bloqueos:** Los sistemas de detección de intrusiones (IDS/IPS) y los sistemas de prevención de ataques pueden detectar y bloquear los intentos de fuerza bruta, bloqueando la IP del atacante.
