
# OSRFramework (Open Sources Research Framework)

## ¿Qué es OSRFramework?

OSRFramework es un conjunto de herramientas de código abierto basadas en Python, diseñadas para realizar tareas de Inteligencia de Fuentes Abiertas (OSINT). Su objetivo principal es ayudar a los investigadores, analistas de seguridad y profesionales de OSINT a recopilar información sobre objetivos (como dominios, nombres de usuario, correos electrónicos, números de teléfono) a partir de datos disponibles públicamente en diversas plataformas en línea.

El framework agrupa varias utilidades que automatizan búsquedas en redes sociales, foros, blogs, registros de dominios y otras fuentes públicas, facilitando el proceso de reconocimiento y la construcción de un perfil digital.

## ¿Para qué es útil la herramienta?

OSRFramework es una herramienta invaluable en la fase de reconocimiento de cualquier investigación de OSINT o prueba de penetración. Sus principales utilidades son:

-   **Recopilación de Información Detallada:** Permite obtener una imagen completa de la huella digital de una persona o entidad en Internet.
-   **Verificación de Nombres de Usuario:** Comprobar la existencia de perfiles de usuario en cientos de plataformas para un nombre de usuario dado.
-   **Análisis de Dominio:** Recopilar información sobre dominios, incluyendo su existencia, TLDs relacionados y direcciones IP.
-   **Investigación de Correos Electrónicos y Teléfonos:** Determinar si correos electrónicos o números de teléfono están asociados con actividades de spam o registrados en bases de datos públicas.
-   **Correlación de Datos:** Enlazar diferentes piezas de información para descubrir conexiones y patrones ocultos.
-   **Investigaciones de Seguridad:** Ayudar a los profesionales a entender la exposición en línea de una organización o individuo, identificando posibles vectores de ataque o fugas de información.

## ¿Cómo se usa?

OSRFramework se opera principalmente a través de una interfaz de línea de comandos (CLI).

### 1. Instalación

1.  **Instalar Python:** Asegúrate de tener Python 3 y `pip` instalados en tu sistema.

2.  **Instalar OSRFramework:**
    ```bash
    pip install osrframework
    ```
    También puedes clonar el repositorio de GitHub ([https://github.com/i3visio/OSRFramework](https://github.com/i3visio/OSRFramework)) e instalar las dependencias manualmente.

### 2. Uso Básico (Comando `osrf`)

La herramienta principal es `osrf`, que actúa como un "runner" para las diferentes utilidades del framework.

-   **Mostrar la ayuda general:**
    ```bash
    osrf --help
    ```
    Esto listará todos los subcomandos disponibles (como `domainfy`, `usufy`, `mailfy`, etc.).

### 3. Ejemplos de Subcomandos

1.  **`usufy` (Búsqueda de Nombres de Usuario):**
    Comprueba si un nombre de usuario existe en varias plataformas.

    ```bash
    osrf usufy -n "nombredeusuario"
    ```
    Puedes especificar plataformas concretas con `-p`:
    ```bash
    osrf usufy -n "nombredeusuario" -p twitter,instagram
    ```

2.  **`domainfy` (Búsqueda de Dominios):**
    Verifica la existencia de dominios para una palabra clave o apodo.

    ```bash
    osrf domainfy -n "nombre_empresa"
    ```
    Para buscar dominios con TLDs específicos:
    ```bash
    osrf domainfy -n "nombre_empresa" -t com,org,net
    ```

3.  **`mailfy` (Búsqueda de Correos Electrónicos):**
    Recopila información relacionada con una dirección de correo electrónico.

    ```bash
    osrf mailfy -n "ejemplo@dominio.com"
    ```

4.  **`phonefy` (Búsqueda de Números de Teléfono):**
    Investiga si un número de teléfono está asociado con actividades en línea.

    ```bash
    osrf phonefy -n "+34600123456"
    ```

5.  **`searchfy` (Búsqueda General):**
    Realiza búsquedas en múltiples plataformas para una consulta general.

    ```bash
    osrf searchfy -n "Juan Pérez"
    ```

### 4. Opciones Comunes

-   `--output-file <archivo>`: Guarda los resultados en un archivo.
-   `--verbose`: Aumenta el nivel de detalle de la salida.
-   `--json`: Muestra la salida en formato JSON.

## Otras Consideraciones

-   **Ética y Legalidad:** OSRFramework es una herramienta de OSINT que solo accede a información públicamente disponible. **Su uso debe ser estrictamente ético y legal.** No debe utilizarse para acosar, espiar o acceder a información privada. Utilízala únicamente para fines de seguridad autorizados, investigación legítima o en tus propios proyectos.
-   **Dependencia de APIs:** La efectividad de OSRFramework depende de la disponibilidad y el funcionamiento de las APIs de las diferentes plataformas que consulta. Los cambios en estas APIs pueden afectar la funcionalidad.
-   **Actualizaciones:** Es importante mantener OSRFramework actualizado (`pip install --upgrade osrframework`) para asegurar que funciona correctamente con los cambios en las plataformas en línea y para obtener las últimas características.
