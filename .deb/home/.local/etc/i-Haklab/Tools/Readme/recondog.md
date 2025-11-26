
# ReconDog

## ¿Qué es ReconDog?

ReconDog es una herramienta de código abierto desarrollada en Python, diseñada para la recopilación de información (reconocimiento) en el ámbito de la ciberseguridad, el hacking ético y la búsqueda de recompensas por errores (bug bounties). Es una suite "todo en uno" que automatiza una variedad de técnicas de OSINT (Inteligencia de Fuentes Abiertas) para obtener datos sobre un objetivo, como dominios, direcciones IP, subdominios y tecnologías web.

La herramienta está diseñada para ser sigilosa, utilizando APIs para recopilar datos sin establecer contacto directo con el objetivo, lo que ayuda a proteger la identidad del usuario durante la fase de reconocimiento pasivo.

## ¿Para qué es útil la herramienta?

ReconDog es una herramienta versátil para pentesters, hackers éticos y analistas de seguridad, útil para:

-   **Reconocimiento de Dominios:** Obtener información WHOIS, registros DNS, y buscar subdominios.
-   **Análisis de Direcciones IP:** Determinar la geolocalización de una IP (GeoIP) y realizar búsquedas inversas de IP.
-   **Detección de Tecnologías Web:** Identificar el CMS (WordPress, Drupal, etc.) y otras tecnologías utilizadas por un sitio web.
-   **Escaneo de Puertos:** Identificar puertos TCP abiertos en un objetivo.
-   **Detección de Honeypots:** Utilizar servicios como Shodan para verificar si un objetivo es un honeypot.
-   **Extracción de Enlaces:** Recopilar enlaces de una página web para un análisis posterior.
-   **Escaneo de Vulnerabilidades (Básico):** Puede tener funcionalidades para detectar vulnerabilidades simples como XSS.

## ¿Cómo se usa?

ReconDog se opera desde la línea de comandos, ofreciendo una interfaz de menú interactiva para seleccionar diferentes opciones de reconocimiento.

### 1. Instalación

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/s0md3v/ReconDog.git
    cd ReconDog
    ```
2.  **Instalar dependencias:**
    ```bash
    pip install -r requirements.txt
    ```
    (Asegúrate de usar `pip` o `pip3` según tu configuración de Python).

### 2. Ejemplos de Uso

1.  **Iniciar la herramienta:**
    ```bash
    python3 dog.py
    ```
    Esto presentará un menú interactivo con varias opciones.

2.  **Ejemplo de Recopilación de Información (Menú Interactivo):**
    Una vez iniciado, podrías ver un menú similar a este (las opciones pueden variar según la versión):

    ```
    ReconDog:
    1. Whois lookup
    2. GeoIP lookup
    3. DNS lookup
    4. Port Scan
    5. ...
    ```

    -   Selecciona una opción (ej. `2` para GeoIP lookup).
    -   Introduce la dirección IP cuando se te solicite.
    -   La herramienta realizará la consulta y mostrará los resultados.

## Otras Consideraciones

-   **Ética y Legalidad:** ReconDog es una herramienta de OSINT. Solo accede a información públicamente disponible. Su uso debe ser **ético y legal**. Utilízala únicamente para fines de seguridad autorizados, investigación legítima o en tus propios proyectos.
-   **APIs:** La efectividad de ReconDog se basa en la integración con diversas APIs.
-   **Recursos:** Es una herramienta potente que puede requerir una cantidad considerable de tiempo y recursos para un análisis exhaustivo.
