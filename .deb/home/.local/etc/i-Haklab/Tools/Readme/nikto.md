
# Nikto

## ¿Qué es Nikto?

Nikto es una herramienta de escaneo de vulnerabilidades en servidores web de código abierto. Está diseñada para realizar pruebas exhaustivas contra servidores web para identificar configuraciones inseguras, archivos y programas predeterminados o potencialmente peligrosos, versiones de software obsoletas, errores de configuración del servidor y otros problemas comunes que podrían ser explotados por atacantes.

Nikto es un escáner de red pasivo y activo, lo que significa que no solo busca la presencia de servicios, sino que también intenta interactuar con ellos para identificar vulnerabilidades.

## ¿Para qué es útil la herramienta?

Nikto es una herramienta esencial para profesionales de la ciberseguridad, pentesters, auditores de seguridad y administradores de sistemas en la fase de reconocimiento y análisis de vulnerabilidades:

-   **Auditorías de Seguridad Web:** Permite a los profesionales evaluar rápidamente la postura de seguridad de un servidor web y sus aplicaciones.
-   **Identificación de Configuraciones Inseguras:** Detecta errores comunes como directorios indexables, archivos de copia de seguridad expuestos, información sensible en encabezados HTTP.
-   **Detección de Software Obsoleto:** Identifica versiones de software de servidor web y componentes (ej. Apache, Nginx, PHP) que son antiguos y pueden tener vulnerabilidades conocidas.
-   **Búsqueda de Archivos y Scripts Maliciosos o por Defecto:** Escanea en busca de programas CGI vulnerables, scripts por defecto, archivos de ejemplo o de prueba que a menudo se dejan en servidores de producción.
-   **Evaluación Continua:** Puede integrarse en flujos de trabajo de seguridad para realizar escaneos regulares y asegurar que no se introduzcan nuevas vulnerabilidades.

## ¿Cómo se usa?

Nikto se ejecuta desde la línea de comandos y es compatible con sistemas operativos como Linux, macOS y Windows (a través de entornos como Cygwin o WSL). Es una herramienta que a menudo viene preinstalada en distribuciones de seguridad como Kali Linux.

### 1. Instalación

En la mayoría de las distribuciones basadas en Debian/Ubuntu (como Kali Linux), puedes instalar Nikto con:

```bash
sudo apt update
sudo apt install nikto
```

### 2. Ejemplos de Uso Básico

1.  **Escaneo Básico de un Servidor Web:**
    Para realizar un escaneo completo de un sitio web, simplemente especifica el host o la dirección IP.

    ```bash
    nikto -h example.com
    # o
    nikto -h 192.168.1.100
    ```

2.  **Escaneo de un Puerto Específico:**
    Si el servidor web no se ejecuta en el puerto 80 (HTTP) o 443 (HTTPS), puedes especificar el puerto con `-p` o `--port`.

    ```bash
    nikto -h example.com -p 8080
    ```

3.  **Guardar la Salida en un Archivo:**
    Es buena práctica guardar los resultados de un escaneo para su posterior análisis. Puedes especificar el formato con `-F` (ej. `html`, `xml`, `csv`).

    ```bash
    nikto -h example.com -o resultados_nikto.html -F html
    ```

4.  **Escaneo a través de un Proxy:**
    Si necesitas escanear a través de un proxy (por ejemplo, para anonimizar el tráfico o en una red corporativa), puedes configurarlo.

    ```bash
    nikto -h example.com -useproxy http://127.0.0.1:8080
    ```
    (Reemplaza `http://127.0.0.1:8080` con la dirección de tu proxy).

5.  **Actualizar la Base de Datos de Plugins:**
    Nikto utiliza una base de datos de plugins para detectar vulnerabilidades. Es importante mantenerla actualizada.

    ```bash
    nikto -update
    ```

### 3. Opciones Comunes Adicionales

-   `-Cgidirs all`: Prueba todos los directorios CGI conocidos.
-   `-evasion 1,2,3`: Intenta técnicas de evasión de IDS/IPS (numeradas del 1 al 9).
-   `-ssl`: Fuerza el uso de SSL para el escaneo.
-   `-Tuning 1,2,3`: Especifica qué categorías de pruebas realizar.

## Otras Consideraciones

-   **Ruido:** Nikto es un escáner activo y generará un considerable tráfico de red, lo que puede ser detectado por sistemas de monitoreo de seguridad (IDS/IPS/WAF).
-   **Falsos Positivos:** Aunque es potente, Nikto puede generar falsos positivos. Los resultados deben ser verificados manualmente por un analista.
-   **Legalidad y Ética:** Nikto es una herramienta ofensiva. **Su uso debe ser estrictamente ético y legal, siempre con el permiso explícito y por escrito del propietario del sistema objetivo.** El uso no autorizado es ilegal y puede tener graves consecuencias.
-   **No es un Exploit:** Nikto es un escáner de vulnerabilidades; no explota las vulnerabilidades que encuentra. Solo las reporta.
