
# Hunner-framework

## ¿Qué es Hunner-framework?

Hunner-framework es un framework de hacking y pruebas de penetración de código abierto, escrito en Python. Está diseñado para automatizar y facilitar diversas tareas relacionadas con la ciberseguridad, enfocándose principalmente en la identificación de vulnerabilidades y la ejecución de ataques en sitios web y sistemas de red.

Ofrece una interfaz de línea de comandos sencilla e interactiva, que permite a los usuarios seleccionar y configurar diferentes módulos para realizar tareas específicas.

## ¿Para qué es útil la herramienta?

Hunner-framework es una herramienta versátil para pentesters, hackers éticos y analistas de seguridad, útil para:

-   **Escaneo de Vulnerabilidades Web:** Contiene módulos para detectar vulnerabilidades comunes en aplicaciones web, como inyección SQL y Cross-Site Scripting (XSS).
-   **Ataques de Fuerza Bruta:** Puede realizar ataques de fuerza bruta contra diversos servicios, incluyendo FTP, SSH y cuentas de correo electrónico, para descubrir credenciales débiles.
-   **Ataques de Denegación de Servicio (DoS):** Incluye funcionalidades para simular ataques DoS, lo que permite evaluar la resiliencia de un sistema ante este tipo de amenazas.
-   **Automatización de Tareas:** Su diseño modular y basado en scripts Python facilita la automatización de tareas repetitivas en pruebas de seguridad.
-   **Educación y Aprendizaje:** Es una plataforma útil para aprender sobre diferentes tipos de ataques y vulnerabilidades en un entorno controlado.

## ¿Cómo se usa?

Hunner-framework se opera a través de su interfaz de línea de comandos.

### 1. Instalación

1.  **Actualizar el sistema (Recomendado en Linux/Termux):**
    ```bash
    sudo apt update && sudo apt upgrade -y
    ```

2.  **Instalar Python y Git:**
    Asegúrate de tener Python 3 y Git instalados en tu sistema.
    ```bash
    sudo apt install python3 git -y
    ```

3.  **Clonar el repositorio:**
    Obtén el código fuente de Hunner-framework desde GitHub.
    ```bash
    git clone https://github.com/b3-v3r/Hunner.git
    ```
    (Nota: Si la herramienta se obtiene de otra fuente, la URL del repositorio puede variar).

4.  **Navegar al directorio:**
    ```bash
    cd Hunner
    ```

5.  **Dar permisos de ejecución:**
    Asegúrate de que el script principal tenga permisos de ejecución.
    ```bash
    chmod +x hunner.py
    ```

### 2. Ejecutar y Utilizar

1.  **Iniciar el Framework:**
    ```bash
    python3 hunner.py
    ```
    Esto abrirá la consola interactiva de Hunner-framework.

2.  **Explorar Opciones:**
    Una vez dentro de la consola, el framework te presentará un menú con diferentes categorías de ataques o escaneos. Simplemente selecciona la opción deseada (generalmente introduciendo un número).

### Ejemplos de Funcionalidades (dependiendo de la versión)

Aunque el menú puede variar, algunas de las funcionalidades típicas incluyen:

-   **SQL Vulnerability Scan:** Para escanear sitios web en busca de inyecciones SQL.
    -   Selecciona esta opción y proporciona la URL del objetivo.
-   **XSS Vulnerability Scan:** Para detectar vulnerabilidades de Cross-Site Scripting.
    -   Selecciona esta opción y proporciona la URL del objetivo.
-   **DoS Attack:** Para realizar un ataque de denegación de servicio.
    -   Selecciona esta opción, proporciona la IP o URL del objetivo y posiblemente el puerto.
-   **Brute Force Attacks:**
    -   **FTP Brute Force:** Requiere el objetivo, el nombre de usuario y una lista de contraseñas.
    -   **SSH Brute Force:** Requiere el objetivo, el nombre de usuario y una lista de contraseñas.
    -   **Email Brute Force:** Requiere el objetivo (servidor de correo), el nombre de usuario y una lista de contraseñas.

## Otras consideraciones

-   **Ética y Legalidad:** Es crucial utilizar Hunner-framework de manera ética y legal. **Solo debe emplearse en sistemas y redes para los que se tenga autorización explícita para realizar pruebas de seguridad.** El uso no autorizado es ilegal y puede tener graves consecuencias.
-   **Ambiente:** El framework está optimizado para entornos Linux, incluyendo distribuciones como Kali Linux o Termux en Android.
-   **Dependencias:** Asegúrate de que todas las dependencias de Python (si las hay, a menudo listadas en un `requirements.txt`) estén instaladas.
