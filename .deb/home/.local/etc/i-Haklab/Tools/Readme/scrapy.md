
# Scrapy

## ¿Qué es Scrapy?

Scrapy es un framework de código abierto, rápido y extensible, escrito en Python, diseñado para rastrear sitios web y extraer datos estructurados. Es una herramienta potente para el web scraping y la minería de datos, permitiendo a los desarrolladores construir "arañas" (spiders) que navegan por las páginas web, recolectan información específica y la procesan.

A diferencia de las soluciones de web scraping más simples, Scrapy ofrece una arquitectura completa con componentes para manejar solicitudes HTTP, respuestas, procesamiento de datos, gestión de sesiones y exportación a varios formatos.

## ¿Para qué es útil la herramienta?

Scrapy es ampliamente utilizado por científicos de datos, desarrolladores y analistas para una variedad de tareas:

-   **Web Scraping y Minería de Datos:** Extraer grandes volúmenes de datos de sitios web para análisis, investigación de mercado, o construcción de datasets.
-   **Procesamiento de Información:** Automatizar la recopilación de noticias, precios de productos, listados de empleo, o cualquier otro tipo de información web.
-   **Archivado de Contenido Web:** Crear copias locales o bases de datos de sitios web para futuras referencias o análisis.
-   **Monitorización de Sitios Web:** Rastrear cambios en precios, disponibilidad de productos o actualizaciones de contenido en línea.
-   **OSINT (Inteligencia de Fuentes Abiertas):** En algunos contextos, puede utilizarse para la recopilación automatizada de información pública de sitios web específicos.

## ¿Cómo se usa?

El uso de Scrapy sigue un flujo de trabajo estructurado que implica la creación de un proyecto Scrapy, la definición de "Items" y la escritura de "Spiders".

### 1. Instalación

1.  **Instalar Python:** Asegúrate de tener Python y `pip` instalados en tu sistema.

2.  **Instalar Scrapy:**
    ```bash
    pip install scrapy
    ```

### 2. Creación de un Proyecto Scrapy

El primer paso es crear un nuevo proyecto Scrapy, lo que generará una estructura de directorios básica.

```bash
scrapy startproject mi_proyecto_scraping
cd mi_proyecto_scraping
```

### 3. Definición de un "Item"

Un "Item" es un contenedor simple para los datos raspados, similar a un diccionario, que define la estructura de los datos que quieres extraer. Se define en `mi_proyecto_scraping/items.py`.

`mi_proyecto_scraping/items.py`:
```python
import scrapy

class MiProyectoScrapingItem(scrapy.Item):
    titulo = scrapy.Field()
    autor = scrapy.Field()
    url = scrapy.Field()
```

### 4. Creación de una "Spider"

Una "Spider" es una clase de Python que defines para indicarle a Scrapy cómo rastrear un sitio web y cómo extraer los datos. Se guarda en `mi_proyecto_scraping/spiders/`.

`mi_proyecto_scraping/spiders/mi_primera_spider.py`:
```python
import scrapy

class MiPrimeraSpider(scrapy.Spider):
    name = "ejemplo_web"  # Nombre único para la spider
    start_urls = [
        'http://quotes.toscrape.com/page/1/', # URLs de inicio
        'http://quotes.toscrape.com/page/2/',
    ]

    def parse(self, response):
        # Este método se llama para cada URL en start_urls
        # y para cualquier URL que se siga a continuación.

        # Extraer citas
        for quote in response.css('div.quote'):
            yield {
                'texto': quote.css('span.text::text').get(),
                'autor': quote.css('small.author::text').get(),
                'tags': quote.css('div.tags a.tag::text').getall(),
            }

        # Seguir al siguiente botón de "next page"
        next_page = response.css('li.next a::attr(href)').get()
        if next_page is not None:
            yield response.follow(next_page, callback=self.parse)
```

### 5. Ejecutar la "Spider"

Desde la línea de comandos, en la raíz de tu proyecto Scrapy, ejecuta la spider.

```bash
scrapy crawl ejemplo_web
```

### 6. Exportar los Datos (Opcional)

Puedes exportar los datos extraídos directamente a un archivo mientras se ejecuta la spider.

-   **Exportar a JSON:**
    ```bash
    scrapy crawl ejemplo_web -o quotes.json
    ```
-   **Exportar a CSV:**
    ```bash
    scrapy crawl ejemplo_web -o quotes.csv
    ```
-   **Exportar a JSON Lines (útil para grandes volúmenes):**
    ```bash
    scrapy crawl ejemplo_web -o quotes.jl
    ```

### 7. Scrapy Shell (para depuración)

Scrapy incluye una shell interactiva que te permite probar selectores XPath y CSS en tiempo real, lo que es muy útil para depurar tus spiders.

```bash
scrapy shell "http://quotes.toscrape.com"
```
Dentro de la shell, puedes usar `response.css(...)` o `response.xpath(...)` para probar tus selectores.

## Otras Consideraciones

-   **Ética y Legalidad:** El web scraping debe hacerse de forma ética y legal. Respeta el archivo `robots.txt` del sitio web, los términos de servicio, evita sobrecargar el servidor y no extraigas datos personales sin consentimiento.
-   **Middleware:** Scrapy es altamente extensible. Puedes añadir middlewares para gestionar proxies, user-agents, cookies, o para procesar solicitudes y respuestas.
-   **Item Pipelines:** Para un procesamiento más avanzado de los datos (validación, limpieza, almacenamiento en una base de datos), se utilizan los Item Pipelines.
-   **`settings.py`:** El archivo `settings.py` de tu proyecto permite configurar el comportamiento de Scrapy, como el retraso entre solicitudes (`DOWNLOAD_DELAY`), el `User-Agent`, o si se debe seguir `robots.txt`.
