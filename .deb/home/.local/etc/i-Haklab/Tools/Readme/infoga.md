
# Infoga

## ¿Qué es Infoga?

Infoga es una herramienta de código abierto basada en Python diseñada para la recopilación de información (OSINT - Open Source Intelligence) sobre direcciones de correo electrónico. Su objetivo es ayudar a los profesionales de la seguridad a recabar datos públicos sobre un correo electrónico específico, utilizando diversas fuentes de información disponibles en internet.

La herramienta automatiza el proceso de buscar información en motores de búsqueda, servidores de claves PGP, servicios de verificación de filtraciones de datos como `haveibeenpwned.com`, y otras fuentes para construir un perfil de la dirección de correo electrónico objetivo.

## ¿Para qué es útil la herramienta?

Infoga es una herramienta valiosa en la fase de reconocimiento de cualquier prueba de penetración o auditoría de seguridad. Sus principales utilidades son:

-   **Reconocimiento de Correos Electrónicos:** Permite a los pentesters obtener una visión general de la presencia en línea de una dirección de correo electrónico, incluyendo nombres, dominios asociados y posibles vulnerabilidades.
-   **Identificación de Filtraciones de Datos:** Verifica si una dirección de correo electrónico ha sido expuesta en brechas de seguridad conocidas, lo que puede indicar un riesgo de credenciales comprometidas.
-   **Análisis de Exposición:** Ayuda a las organizaciones a evaluar cuánta información sobre sus direcciones de correo electrónico está públicamente disponible, lo que podría ser utilizado en ataques de ingeniería social o spear-phishing.
-   **Análisis de IPs y Dominios:** Puede ayudar a relacionar direcciones de correo electrónico con direcciones IP, nombres de host y países de origen.

## ¿Cómo se usa?

Infoga es una herramienta de línea de comandos.

### 1. Instalación

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/m4ll0k/Infoga.git
    ```
    (Nota: La URL del repositorio puede variar, ya que hay varios forks de Infoga. Se recomienda usar el original o uno bien mantenido).

2.  **Navegar al directorio:**
    ```bash
    cd Infoga
    ```

3.  **Instalar dependencias:**
    ```bash
    pip3 install -r requires.txt
    ```
    Si no hay un archivo `requires.txt`, puedes intentar instalar `requests` y otras librerías comunes de Python para web scraping.

### 2. Ejemplos de Uso

1.  **Escanear un dominio utilizando todas las fuentes disponibles:**
    ```bash
    python3 infoga.py --domain example.com --source all
    ```
    Esto intentará recopilar información utilizando todas las fuentes configuradas en la herramienta.

2.  **Escanear un dominio utilizando una fuente específica (ej. Google):**
    ```bash
    python3 infoga.py --domain example.com --source google
    ```

3.  **Ajustar la verbosidad de la salida:**
    Puedes especificar el nivel de detalle de la salida con la opción `--verbose`. Los niveles suelen ir del 1 al 3, siendo 3 el más detallado.
    ```bash
    python3 infoga.py --domain example.com --source all --verbose 3
    ```

4.  **Especificar una API Key (si es necesario):**
    Algunas fuentes o servicios (como `haveibeenpwned.com`) pueden requerir una API Key. Infoga podría tener una opción para configurarla, como `--api-key`. Consulta la ayuda de la herramienta (`python3 infoga.py --help`) para ver las opciones exactas.

## Otras consideraciones

-   **Precisión de Datos:** La información obtenida depende de la disponibilidad de datos públicos en las fuentes consultadas. La precisión puede variar.
-   **API Keys:** Para maximizar la cantidad y calidad de la información, es a menudo necesario obtener y configurar API Keys para servicios de terceros.
-   **Uso Ético y Legal:** Infoga debe usarse de manera ética y legal. Solo debe emplearse para investigar direcciones de correo electrónico para las que se tenga autorización explícita o que sean de dominio público para fines legítimos (ej. investigación de seguridad).
-   **Actualizaciones:** Debido a que los sitios web y APIs cambian con frecuencia, es importante mantener la herramienta actualizada para asegurar su correcto funcionamiento y la obtención de datos relevantes.
