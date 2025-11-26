
# Hakku Framework

## ¿Qué es Hakku Framework?

Hakku Framework es una plataforma de código abierto para pruebas de penetración, escrita en Python 3. Está diseñada para facilitar la realización de pruebas de seguridad tanto a nivel web como de red. Ofrece una estructura modular, lo que permite a los usuarios desarrollar y ejecutar herramientas específicas para la recopilación de información, la evaluación de vulnerabilidades y la explotación.

El framework proporciona una interfaz de línea de comandos (CLI) sencilla e interactiva, similar a otros frameworks de pentesting como Metasploit, lo que lo hace accesible para quienes están familiarizados con este tipo de herramientas.

## ¿Para qué es útil la herramienta?

Hakku Framework es una herramienta versátil para profesionales de ciberseguridad, pentesters y entusiastas. Sus principales utilidades incluyen:

-   **Recopilación de Información (Reconnaissance):** Contiene módulos para recopilar datos sobre objetivos, como escáneres de puertos o herramientas de rastreo de DNS.
-   **Evaluación de Vulnerabilidades:** Ayuda a identificar debilidades en aplicaciones web y redes, como el escaneo de puertos abiertos o la búsqueda de configuraciones inseguras.
-   **Desarrollo Rápido de Herramientas:** Su estructura modular y API de Python facilitan la creación rápida de nuevas herramientas o la adaptación de las existentes para necesidades específicas de pentesting.
-   **Enseñanza y Aprendizaje:** Es una plataforma útil para aprender sobre diferentes técnicas de pruebas de penetración y cómo se estructuran las herramientas de seguridad.

## ¿Cómo se usa?

Hakku Framework se opera a través de su interfaz de línea de comandos.

### 1. Instalación

1.  **Clonar el repositorio:** Obtén el código fuente de Hakku desde GitHub.
    ```bash
    git clone https://github.com/4shadoww/hakkuframework
    ```

2.  **Navegar al directorio:** Accede al directorio recién clonado.
    ```bash
    cd hakkuframework
    ```

3.  **Instalar dependencias (opcional):** Aunque es portátil, algunos módulos pueden requerir dependencias de Python.
    ```bash
    # Si existe un archivo requirements.txt
    pip install -r requirements.txt
    ```
    También puedes ejecutar el script de instalación si lo proporciona el repositorio:
    ```bash
    chmod +x install
    ./install
    ```
    Asegúrate de que los scripts de los módulos sean ejecutables:
    ```bash
    chmod +x modules/*
    ```

### 2. Ejecutar y Utilizar

1.  **Iniciar el Framework:**
    ```bash
    python3 hakku
    ```
    Esto abrirá la consola interactiva de Hakku.

2.  **Comandos Básicos:**
    -   `help`: Muestra la lista de comandos disponibles en la consola.
    -   `show modules`: Lista todos los módulos de pentesting disponibles dentro del framework, organizados por categoría (Web, Network, Wireless, etc.).

3.  **Usar un Módulo:**
    -   Para seleccionar un módulo específico, usa el comando `use <nombre_del_modulo>`.
        Por ejemplo, para usar un escáner de puertos:
        ```bash
        use port_scanner
        ```
    -   Una vez que has seleccionado un módulo, puedes ver sus opciones y parámetros requeridos con:
        ```bash
        show options
        ```
    -   Configura los parámetros necesarios usando `set <parámetro> <valor>`.
        Por ejemplo:
        ```bash
        set target 192.168.1.1
        set ports 1-1024
        ```
    -   Ejecuta el módulo con el comando `run`.

### Ejemplo de flujo de trabajo

```
hakku > show modules
# (Se muestra una lista de módulos, por ejemplo, en la categoría Network)

hakku > use port_scanner
hakku (port_scanner) > show options
# (Se muestran las opciones del módulo port_scanner, como target, ports, etc.)

hakku (port_scanner) > set target example.com
hakku (port_scanner) > set ports 80,443,22
hakku (port_scanner) > run
# (El módulo port_scanner se ejecuta y muestra los resultados)
```

## Otras consideraciones

-   **Entorno:** Hakku Framework está optimizado para sistemas operativos basados en Linux, como Kali Linux.
-   **Actualizaciones:** Al ser un proyecto de código abierto, es recomendable mantenerlo actualizado (`git pull`) para obtener las últimas funciones y correcciones.
-   **Uso Ético:** Al igual que con todas las herramientas de pentesting, Hakku Framework debe usarse de manera ética y legal, solo en sistemas y redes para los que se tenga autorización explícita para realizar pruebas de seguridad.
