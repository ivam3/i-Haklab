
# Gobuster

## ¿Qué es Gobuster?

Gobuster es una herramienta de línea de comandos de código abierto, escrita en el lenguaje de programación Go, diseñada para la enumeración por fuerza bruta en diversos contextos de seguridad ofensiva. Su principal función es descubrir recursos ocultos o difíciles de encontrar en sistemas objetivo, como directorios y archivos en servidores web, subdominios de un dominio principal, o hosts virtuales.

Gracias a su implementación en Go, Gobuster es extremadamente rápido y eficiente, permitiendo realizar grandes cantidades de peticiones en poco tiempo.

## ¿Para qué es útil la herramienta?

Gobuster es una herramienta esencial para profesionales de ciberseguridad, pentesters y auditores web. Sus principales usos son:

-   **Descubrimiento de Contenido Web:** Identificar directorios y archivos no listados que pueden contener información sensible, configuraciones erróneas o puntos de entrada para ataques.
-   **Enumeración de Subdominios:** Encontrar subdominios de un dominio objetivo, lo que puede revelar aplicaciones o servicios adicionales no evidentes a primera vista.
-   **Identificación de Hosts Virtuales:** Descubrir otros sitios web alojados en el mismo servidor, lo que a menudo expone más vectores de ataque.
-   **Seguridad de Buckets S3/GCS:** Verificar la existencia y accesibilidad de buckets de almacenamiento en la nube de Amazon S3 y Google Cloud Storage.
-   **Fuzzing:** Utilizar listas de palabras para probar rutas, parámetros o valores en busca de vulnerabilidades o información adicional.

## ¿Cómo se usa?

Gobuster funciona basándose en "modos" de operación, donde cada modo está diseñado para un tipo específico de enumeración (directorios, DNS, vhosts, etc.). La herramienta requiere una lista de palabras (wordlist) para realizar la fuerza bruta.

### 1. Instalación

En sistemas basados en Debian/Ubuntu (como Kali Linux), la instalación es sencilla:

```bash
sudo apt update
sudo apt install gobuster
```

Si tienes el entorno de desarrollo de Go configurado, también puedes instalarlo directamente:

```bash
go install github.com/OJ/gobuster/v3@latest
```

### 2. Modos y Ejemplos de Uso

Todos los comandos se ejecutan desde la terminal.

-   **Modo `dir` (Directorios y Archivos):**
    Para buscar directorios y archivos en una URL específica utilizando una lista de palabras.
    ```bash
    gobuster dir -u http://ejemplo.com -w /usr/share/wordlists/dirb/common.txt
    ```
    Puedes añadir extensiones de archivo con la opción `-x`:
    ```bash
    gobuster dir -u http://ejemplo.com -w /usr/share/wordlists/dirb/common.txt -x php,html,txt,bak
    ```

-   **Modo `dns` (Subdominios):**
    Para enumerar subdominios de un dominio dado.
    ```bash
    gobuster dns -d ejemplo.com -w /usr/share/wordlists/subdomains/subdomains-top1million-5000.txt
    ```

-   **Modo `vhost` (Hosts Virtuales):**
    Para descubrir hosts virtuales en una dirección IP o dominio.
    ```bash
    gobuster vhost -u http://ejemplo.com -w /usr/share/wordlists/subdomains/top5000subdomains.txt
    ```

### Opciones Comunes

-   `-u <url>`: URL objetivo (para `dir`, `vhost`).
-   `-d <dominio>`: Dominio objetivo (para `dns`).
-   `-w <wordlist>`: Ruta al archivo de la lista de palabras.
-   `-x <extensiones>`: Listado de extensiones a buscar (ej. `php,html`).
-   `-t <threads>`: Número de hilos concurrentes (por defecto 10).
-   `-k`: Ignorar errores de certificado SSL/TLS.
-   `-s <códigos_estado>`: Códigos de estado HTTP a mostrar (ej. `200,204,301,302,307,401,403`).
-   `-b <códigos_estado>`: Códigos de estado HTTP a ocultar.

## Otras consideraciones

-   **Listas de Palabras:** La efectividad de Gobuster depende críticamente de la calidad y exhaustividad de la lista de palabras utilizada. Colecciones como Seclists son una excelente fuente.
-   **Uso Ético:** Gobuster realiza fuerza bruta. Utiliza esta herramienta solo en sistemas para los que tengas autorización explícita para probar su seguridad.
-   **Monitoreo:** Debido a la gran cantidad de peticiones que puede generar, es posible que los sistemas de detección de intrusiones (IDS/IPS) o WAF detecten la actividad de Gobuster.
