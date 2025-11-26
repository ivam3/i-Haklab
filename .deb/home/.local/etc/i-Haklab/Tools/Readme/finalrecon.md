# FinalRecon

## ¿Qué es FinalRecon?

FinalRecon es una herramienta de **reconocimiento web todo en uno** escrita en Python. Su objetivo es consolidar la funcionalidad de múltiples herramientas de reconocimiento en un único lugar, permitiendo a un pentester o analista de seguridad obtener una visión general rápida y completa de un sitio web objetivo.

Es una herramienta de OSINT (Inteligencia de Fuentes Abiertas) que automatiza la recopilación de información pública sobre un dominio.

## ¿Para qué es útil la herramienta?

FinalRecon es una de las primeras herramientas que se utilizan en la fase de reconocimiento de una prueba de penetración web. Ayuda a responder preguntas fundamentales sobre el objetivo:

*   ¿Qué tecnologías utiliza este sitio web?
*   ¿Qué otros subdominios tiene esta organización?
*   ¿Qué información pública existe sobre el dominio?
*   ¿Hay directorios o archivos interesantes expuestos?
*   ¿Qué puertos tiene abiertos el servidor?

Al automatizar la recopilación de esta información, FinalRecon ahorra una cantidad significativa de tiempo al analista y le proporciona una base sólida para comenzar a buscar vulnerabilidades.

## Funcionalidades Clave

FinalRecon integra una amplia gama de comprobaciones, que incluyen:

*   **Análisis de Encabezados (Headers):** Inspecciona los encabezados de respuesta HTTP para obtener información sobre el servidor web, las tecnologías utilizadas y las configuraciones de seguridad.
*   **Whois:** Realiza una búsqueda Whois para obtener información sobre el propietario del dominio, las fechas de registro y los servidores de nombres.
*   **Inspección de Certificados SSL:** Extrae detalles del certificado SSL/TLS del sitio.
*   **Rastreador (Crawler):** Navega por el sitio web para encontrar y listar enlaces internos y externos, scripts, y otros recursos.
*   **Enumeración de DNS:** Consulta docenas de tipos de registros DNS para obtener un mapa detallado de la configuración DNS del dominio.
*   **Enumeración de Subdominios:** Utiliza múltiples fuentes de datos de terceros para descubrir subdominios asociados al objetivo.
*   **Wayback Machine:** Busca en el archivo de internet (Wayback Machine) para encontrar URLs y contenido histórico del sitio, lo que puede revelar endpoints o información que ya no es visible públicamente.
*   **Enumeración de Directorios:** Realiza un ataque de diccionario, similar a [Dirb](dirb.md), para encontrar directorios y archivos ocultos.
*   **Escaneo de Puertos:** Realiza un escaneo rápido de los 1000 puertos TCP más comunes para ver qué servicios están expuestos además del servicio web.
*   **Detección de WAF:** Intenta identificar si el sitio está protegido por un Firewall de Aplicaciones Web (WAF) conocido.

## ¿Cómo se usa? (Ejemplo básico)

FinalRecon es una herramienta de línea de comandos. Su uso más común es simplemente proporcionarle una URL objetivo y, opcionalmente, especificar qué comprobaciones realizar.

**Sintaxis básica:**
```bash
python finalrecon.py --url [URL_objetivo]
```

### Ejemplo 1: Escaneo completo

La forma más fácil y completa de usar la herramienta es con la opción `--full`. Esto ejecutará todos los módulos de reconocimiento contra el objetivo.

```bash
python finalrecon.py --full http://example.com
```
La herramienta comenzará a ejecutar cada una de sus comprobaciones en secuencia y mostrará los resultados en la consola, a menudo guardándolos también en archivos de salida para un análisis más detallado.

### Ejemplo 2: Ejecutar un módulo específico

Si solo estás interesado en una tarea específica, como la enumeración de subdominios, puedes ejecutar solo ese módulo.

```bash
python finalrecon.py --url http://example.com --sub
```

## Consideraciones Adicionales

*   **Entorno:** FinalRecon está diseñado para sistemas operativos basados en Linux. Según la documentación oficial, no es compatible con Windows ni con Termux (un emulador de terminal para Android).
*   **Herramienta de OSINT:** Es importante recordar que FinalRecon es una herramienta de inteligencia de fuentes abiertas. Recopila información que está disponible públicamente. Sin embargo, algunas de sus funciones (como el escaneo de puertos o la enumeración de directorios) son actividades "activas" que pueden ser detectadas por los sistemas de seguridad del objetivo.
*   **Legalidad:** Al igual que con otras herramientas de reconocimiento, solo debes usar FinalRecon contra objetivos para los que tengas permiso explícito de realizar pruebas.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética.*
