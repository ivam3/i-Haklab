
# Nmap (Network Mapper)

## ¿Qué es Nmap?

Nmap, acrónimo de "Network Mapper", es una herramienta de código abierto ampliamente utilizada para la exploración de redes y auditorías de seguridad. Creada por Gordon Lyon (conocido como Fyodor), Nmap permite a los administradores de red y a los profesionales de la ciberseguridad descubrir hosts y servicios en una red de ordenadores, así como obtener información detallada sobre ellos.

Nmap opera enviando paquetes IP especialmente diseñados a los hosts objetivo y analizando las respuestas, lo que le permite construir un "mapa" de la red.

## ¿Para qué es útil la herramienta?

Nmap es una herramienta fundamental en el arsenal de cualquier profesional de la seguridad o administrador de red. Sus principales funcionalidades incluyen:

-   **Descubrimiento de Hosts:** Identificar qué dispositivos están activos y en línea en una red.
-   **Escaneo de Puertos:** Determinar qué puertos están abiertos, cerrados o filtrados en un host objetivo, revelando qué servicios están escuchando.
-   **Detección de Servicios y Versiones:** Identificar qué aplicaciones y servicios están ejecutándose en los puertos abiertos, incluyendo sus versiones. Esto es crucial para descubrir vulnerabilidades conocidas asociadas a versiones específicas de software.
-   **Detección de Sistemas Operativos (OS):** Estimar el sistema operativo del host objetivo (Windows, Linux, macOS, etc.) analizando las características de las respuestas de red.
-   **Evaluación de Vulnerabilidades:** Ayuda a identificar posibles debilidades de seguridad en sistemas y servicios.
-   **Mapeo y Auditoría de Red:** Crear un inventario detallado de la red, facilitando la gestión y la seguridad de la infraestructura.

## ¿Cómo se usa?

Nmap es una herramienta de línea de comandos, aunque también existe una interfaz gráfica llamada Zenmap.

### 1. Instalación

Nmap está disponible para Linux, Windows y macOS. En muchas distribuciones de Linux (como Kali Linux, Ubuntu), se puede instalar fácilmente:

```bash
sudo apt install nmap # En sistemas basados en Debian/Ubuntu
```

### 2. Ejemplos de Uso Básico

1.  **Escaneo Básico de un Objetivo:**
    Nmap escaneará los 1000 puertos TCP más comunes.

    ```bash
    nmap example.com
    # o
    nmap 192.168.1.1
    ```

2.  **Escaneo de un Rango de IPs o una Subred:**
    ```bash
    nmap 192.168.1.1-100   # Escanea IPs del 1 al 100
    nmap 192.168.1.0/24    # Escanea toda la subred
    ```

3.  **Escaneo de Puertos Específicos:**
    ```bash
    nmap -p 22,80,443 example.com   # Escanea puertos SSH, HTTP y HTTPS
    nmap -p 1-1024 example.com      # Escanea los primeros 1024 puertos
    nmap -p- example.com            # Escanea todos los 65535 puertos
    ```

4.  **Detección de Servicios y Versiones:**
    ```bash
    nmap -sV example.com
    ```

5.  **Detección de Sistema Operativo:**
    ```bash
    nmap -O example.com
    ```

6.  **Escaneo Agresivo (Incluye detección de OS, versiones, scripts y traceroute):**
    ```bash
    nmap -A example.com
    ```

7.  **Escaneo Rápido (Top 100 puertos):**
    ```bash
    nmap -F example.com
    ```

8.  **Ping Scan (Solo descubre hosts activos, sin escanear puertos):**
    ```bash
    nmap -sn 192.168.1.0/24
    ```

9.  **Guardar los Resultados en un Archivo:**
    ```bash
    nmap -oN resultados.txt example.com   # Salida normal
    nmap -oX resultados.xml example.com   # Salida XML
    nmap -oA todos_los_formatos example.com # Guarda en normal, XML y greppable
    ```

### 3. Nmap Scripting Engine (NSE)

Nmap incluye un potente motor de scripting (NSE) que permite a los usuarios escribir o utilizar scripts preexistentes para automatizar una amplia gama de tareas avanzadas, como:

-   Detección de vulnerabilidades.
-   Explotación de vulnerabilidades simples.
-   Detección de configuraciones erróneas.
-   Fuerza bruta de credenciales.

Para ejecutar scripts NSE:
```bash
nmap -sC example.com   # Ejecuta scripts por defecto
nmap --script http-enum example.com # Ejecuta un script específico
```

## Otras Consideraciones

-   **Ética y Legalidad:** Nmap es una herramienta muy potente. **Siempre debes tener autorización expresa y por escrito** antes de escanear cualquier red o sistema. El escaneo no autorizado puede ser ilegal y poco ético, y puede generar alertas en los sistemas de seguridad del objetivo.
-   **Ruido:** Dependiendo del tipo de escaneo, Nmap puede generar un considerable tráfico de red, lo que podría ser detectado por firewalls, IDS/IPS.
-   **Firewalls:** Los firewalls pueden afectar los resultados del escaneo, bloqueando puertos o haciendo que parezcan filtrados.
