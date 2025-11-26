# FuzzDB

## ¿Qué es FuzzDB?

FuzzDB no es una herramienta ejecutable, sino un **repositorio o base de datos de listas de payloads (cargas útiles) para ataques de "fuzzing" y descubrimiento de recursos**. Es un proyecto de código abierto que recopila una enorme cantidad de patrones de ataque, listas de palabras y diccionarios utilizados en las pruebas de seguridad de aplicaciones web.

El "fuzzing" es una técnica de prueba de software que consiste en proporcionar datos inválidos, inesperados o aleatorios a las entradas de un programa. El objetivo es provocar fallos, errores o comportamientos no deseados que puedan revelar una vulnerabilidad de seguridad. FuzzDB proporciona los "datos inválidos" que se necesitan para realizar estas pruebas de forma eficaz.

## ¿Para qué es útil?

FuzzDB es el arsenal de municiones para muchas herramientas de pentesting. Su contenido se utiliza para:

*   **Descubrimiento de Vulnerabilidades:** Proporciona listas de payloads para probar una amplia gama of vulnerabilidades, como:
    *   Inyección SQL (SQLi)
    *   Cross-Site Scripting (XSS)
    *   Inyección de Comandos del Sistema Operativo (OS Command Injection)
    *   Path Traversal (atravesamiento de directorios)
    *   Inyección de plantillas del lado del servidor (SSTI)
    *   Y muchas más.
*   **Descubrimiento de Recursos Ocultos:** Contiene listas de nombres de archivos y directorios comunes que se utilizan con herramientas como [Dirb](dirb.md), Gobuster o ffuf para encontrar paneles de administración, archivos de backup, y otras páginas no enlazadas.
*   **Análisis de Respuestas:** Incluye patrones (expresiones regulares) para buscar en las respuestas del servidor web, ayudando a identificar mensajes de error detallados, direcciones de correo electrónico, números de tarjetas de crédito o cualquier información sensible que se haya filtrado.
*   **Pruebas de Fuerza Bruta:** Contiene listas de nombres de usuario y contraseñas comunes.

## Contenido Principal de FuzzDB

FuzzDB está organizado en una estructura de carpetas, cada una con un propósito específico:

*   **`attack-payloads/`:** Esta es la sección principal. Contiene subcarpetas para cada tipo de vulnerabilidad (SQLi, XSS, etc.), y dentro de ellas, archivos de texto con cientos de payloads diferentes para probar esa vulnerabilidad específica.
*   **`discovery/`:** Aquí se encuentran las listas de palabras para el descubrimiento de recursos.
    *   `predictable-filepaths/`: Listas de nombres de directorios y archivos comunes (`/admin`, `/backup`, `/.git/`, etc.).
    *   `dns/`: Listas de subdominios comunes para usar con herramientas como `dnsenum`.
*   **`regex/`:** Contiene expresiones regulares para buscar patrones interesantes en las respuestas del servidor.
*   **`webshells/`:** Una colección de "webshells" (scripts que proporcionan un shell de comandos en un servidor web) en varios lenguajes (PHP, ASP, JSP), útiles en la fase de post-explotación.

## ¿Cómo se usa?

FuzzDB no se "ejecuta". En su lugar, se **utiliza junto con otras herramientas** que realizan las peticiones web.

### Ejemplo 1: Fuzzing de XSS con Burp Suite Intruder

1.  Interceptas una solicitud en [Burp Suite](burpsuite.md) que tiene un parámetro de búsqueda, por ejemplo: `GET /search?query=test`.
2.  Envías esta solicitud al módulo **Intruder**.
3.  Seleccionas el valor del parámetro `query` (`test`) como el punto de inyección.
4.  En la pestaña de Payloads del Intruder, en lugar de escribir tus propios payloads, cargas un archivo de FuzzDB, como `attack-payloads/xss/xss-rsnake.txt`.
5.  Inicias el ataque. Intruder enviará una solicitud por cada línea del archivo de FuzzDB, permitiéndote ver si alguna de ellas tiene éxito.

### Ejemplo 2: Descubrimiento de directorios con `ffuf`

`ffuf` es una herramienta moderna de fuzzing. Puedes decirle que use una lista de FuzzDB para buscar directorios.

```bash
ffuf -w /ruta/a/fuzzdb/discovery/predictable-filepaths/raft-medium-directories.txt -u http://example.com/FUZZ
```
*   `-w`: Especifica la lista de palabras (la de FuzzDB).
*   `-u http://example.com/FUZZ`: `FUZZ` es un marcador de posición que `ffuf` reemplazará con cada palabra de la lista.

## Consideraciones Adicionales

*   **Falsos Positivos de Antivirus:** Dado que FuzzDB contiene patrones de ataque, algunos programas antivirus pueden marcar los archivos como maliciosos. Esto es un falso positivo; los archivos en sí son solo texto plano e inofensivos.
*   **Recurso Fundamental:** Es uno de los recursos más fundamentales para cualquier persona que realice pruebas de seguridad de aplicaciones web. Herramientas como OWASP ZAP a menudo vienen con las listas de FuzzDB ya integradas.
*   **Actualizaciones:** El repositorio de FuzzDB en GitHub es la fuente principal para obtener la versión más actualizada y completa de las listas.

---
*Nota: FuzzDB es una colección de datos para ser utilizada en pruebas de seguridad éticas y autorizadas.*
