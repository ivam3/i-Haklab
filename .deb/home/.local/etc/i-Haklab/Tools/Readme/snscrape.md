# snscrape

## ¿Qué es snscrape?

`snscrape` es una herramienta de línea de comandos y una librería de Python para hacer "scraping" (extracción de datos) de redes sociales. Su característica más destacada es que permite recopilar información de plataformas como Twitter, Facebook, Instagram, Reddit, y otras **sin necesidad de una clave de API**.

Esto la convierte en una herramienta extremadamente útil para la recopilación de datos de fuentes abiertas (OSINT) a gran escala, ya que no está sujeta a las estrictas limitaciones que las APIs oficiales suelen imponer.

## ¿Para qué es útil?

`snscrape` es ampliamente utilizado por investigadores, periodistas, analistas de datos y profesionales de la seguridad para:

*   **Recopilación de Inteligencia (OSINT):** Permite a un investigador descargar todos los tweets de un usuario, buscar publicaciones por hashtag o palabra clave, o extraer los miembros de un grupo de Facebook para análisis posteriores.
*   **Análisis de Datos y Ciencia de Datos:** Es ideal para recopilar grandes conjuntos de datos de redes sociales para análisis de sentimientos, estudios de tendencias, investigación académica, etc.
*   **Archivado:** Se puede usar para archivar el historial de publicaciones de una cuenta o el contenido relacionado con un evento específico.
*   **Pruebas de Penetración:** En la fase de reconocimiento, `snscrape` puede ser más potente que `Sherlock` para no solo encontrar un perfil, sino también para descargar todo su contenido y analizarlo en busca de información útil para un ataque.

## ¿Cómo se usa? (Ejemplos básicos)

`snscrape` se utiliza desde la línea de comandos. Su sintaxis se basa en especificar el "scraper" a utilizar (por ejemplo, `twitter-search`) y los parámetros de la búsqueda.

**Ejemplo 1: Extraer los últimos 100 tweets de un usuario**

Este comando extrae los 100 tweets más recientes del usuario `elonmusk` y los imprime en la consola.

```bash
snscrape --max-results 100 twitter-user elonmusk
```

**Ejemplo 2: Buscar tweets con un hashtag y guardarlos en JSON**

Este comando busca los últimos 500 tweets que contienen el hashtag `#ciberseguridad` y guarda los resultados (con todos los detalles) en un archivo JSON.

```bash
snscrape --jsonl --max-results 500 twitter-search "#ciberseguridad" > tweets.json
```
*   `--jsonl`: Especifica que la salida debe ser en formato JSON-Lines, que es mucho más detallado que la salida por defecto (que solo muestra las URLs).

**Ejemplo 3: Extraer información de un subreddit**

Este comando extrae las últimas 1000 publicaciones del subreddit `r/netsec`.

```bash
snscrape --max-results 1000 reddit-subreddit netsec
```

## Consideraciones Adicionales

*   **Sin API:** La principal ventaja de `snscrape` es que no usa una API oficial. Esto significa que no necesitas registrarte como desarrollador ni obtener credenciales. Sin embargo, también significa que si la plataforma cambia el diseño de su sitio web, la herramienta puede dejar de funcionar hasta que sea actualizada por los desarrolladores.
*   **Límites y Bloqueos:** Aunque no hay límites de API, realizar demasiadas peticiones en un corto período de tiempo puede hacer que la plataforma te bloquee temporalmente tu dirección IP. La herramienta tiene algunas protecciones, pero es algo a tener en cuenta.
*   **Legalidad y Ética:** `snscrape` solo recopila datos que son públicamente visibles. Sin embargo, el uso que le des a esos datos está sujeto a los términos de servicio de la plataforma y a las leyes de privacidad de tu jurisdicción. Úsala de forma ética y responsable.

---
*Nota: `snscrape` es una herramienta muy potente para la recopilación masiva de datos. Su uso debe ser cuidadoso para no infringir la privacidad ni los términos de servicio de las plataformas sociales.*
