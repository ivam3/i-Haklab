
# PhoneIntel

## ¿Qué es PhoneIntel?

PhoneIntel es una herramienta de código abierto basada en Python, diseñada para la Inteligencia de Fuentes Abiertas (OSINT) en números de teléfono. Su propósito es recopilar y analizar información detallada sobre un número de teléfono a partir de diversas fuentes públicas y servicios en línea.

La herramienta puede proporcionar detalles geográficos (país, área), información del operador, y buscar si el número está asociado con actividades de spam, redes sociales, foros, o cualquier otra presencia en línea.

## ¿Para qué es útil la herramienta?

PhoneIntel es una herramienta valiosa para investigadores de OSINT, profesionales de la ciberseguridad y cualquier persona que necesite obtener información sobre números de teléfono con fines de investigación o seguridad:

-   **Reconocimiento OSINT:** Permite a los investigadores construir un perfil sobre un número de teléfono, identificando su origen y su presencia en línea.
-   **Análisis de Fraude y Spam:** Ayuda a identificar números de teléfono asociados con actividades fraudulentas, spam o telemarketing indeseado mediante la integración con bases de datos como Tellows y SpamCalls.net.
-   **Verificación de Información:** Puede usarse para validar la información de contacto y su reputación.
-   **Generación de Google Dorks:** Automatiza la creación de Google dorks específicos para buscar números de teléfono en diferentes categorías de sitios web.
-   **Mapeo de Ubicación:** En algunos casos, puede ayudar a visualizar la ubicación geográfica aproximada de un número de teléfono.

## ¿Cómo se usa?

PhoneIntel es una herramienta de línea de comandos.

### 1. Instalación

1.  **Instalar Python:** Asegúrate de tener Python 3 y `pip` instalados en tu sistema.

2.  **Instalar PhoneIntel:**
    ```bash
    pip install phoneintel
    ```

### 2. Uso Básico

El formato general del comando es `phoneintel <opción> <número_de_teléfono>`. Asegúrate de incluir el código de país en el número de teléfono (ej. `+34...`).

### 3. Ejemplos de Uso

1.  **Obtener Información General de un Número (`--info`):**
    Este es el comando principal para recopilar todos los datos disponibles sobre un número de teléfono.

    ```bash
    phoneintel --info +34613814500
    ```
    La salida incluirá detalles como el país, el prefijo, el tipo de línea (móvil, fijo) y el operador.

2.  **Generar Google Dorks (`--dorks`):**
    Crea consultas de Google especializadas para buscar el número en diferentes tipos de sitios web.

    ```bash
    phoneintel +34613814500 --dorks --type social_networks
    ```
    -   `--type`: Puedes especificar categorías como `social_networks`, `forums`, `classifieds`, `ecommerce`, `news`, `blogs`, `job_sites`, `pastes`, `reputation`, `phone_directories`, `people_search` o `all`.

3.  **Visualizar Ubicación en OpenStreetMap (`--map`):**
    Algunas integraciones pueden permitir la visualización de la ubicación aproximada en OpenStreetMap (requiere una API key de MapQuest, que se puede configurar).

    ```bash
    phoneintel --info +34613814500 --map
    ```

4.  **Integración con APIs Externas (ej. Neutrino):**
    PhoneIntel puede integrarse con APIs de terceros para una validación y análisis más profundo. Primero, debes iniciar sesión con tus credenciales de API si el servicio lo requiere.

    ```bash
    # Login para NeutrinoAPI
    phoneintel --neutrino --login --id TU_API_ID --key TU_API_KEY

    # Luego, usar la funcionalidad de Neutrino
    phoneintel --neutrino +34613814500
    ```

5.  **Procesar Múltiples Números desde un Archivo (`--search --input`):**
    Si tienes un archivo (`numbers.txt`) con un número de teléfono por línea, puedes procesarlos por lotes.

    ```bash
    phoneintel --search --input numbers.txt
    ```

## Otras Consideraciones

-   **Ética y Legalidad:** PhoneIntel es una herramienta de OSINT que solo accede a información públicamente disponible. **Su uso debe ser estrictamente ético y legal.** No debe utilizarse para acosar, espiar o acceder a información privada. Utilízala únicamente para fines de seguridad autorizados, investigación legítima o en tus propios datos.
-   **Precisión y Limitaciones:** La cantidad y precisión de la información obtenida dependen de la disponibilidad de los datos en las fuentes públicas y las APIs consultadas. La geolocalización de números móviles puede ser limitada.
-   **API Keys:** Para acceder a funcionalidades avanzadas o para un uso intensivo, es posible que necesites registrarte en servicios de terceros (como NeutrinoAPI o Tellows) y configurar sus respectivas claves API.
-   **Actualizaciones:** Las fuentes de datos y APIs pueden cambiar con el tiempo. Es importante mantener PhoneIntel actualizado (`pip install --upgrade phoneintel`) para asegurar su funcionalidad.
