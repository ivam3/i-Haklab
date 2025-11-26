# Wfuzz

## ¿Qué es Wfuzz?

Wfuzz es un **"fuzzer" para aplicaciones web**, escrito en Python. Un "fuzzer" es una herramienta que envía una gran cantidad de datos semi-aleatorios o predefinidos (un "diccionario" o "payload") a una aplicación para provocar fallos, encontrar contenido oculto o descubrir vulnerabilidades.

La principal característica de Wfuzz es su flexibilidad. Funciona reemplazando una palabra clave especial, `FUZZ`, en una petición HTTP con los valores de un diccionario. Esto permite "fuzzear" (atacar con fuerza bruta) prácticamente cualquier parte de una petición web: parámetros GET/POST, cabeceras, cookies, rutas de directorios, subdominios, etc.

## ¿Para qué es útil?

Wfuzz es una de las herramientas más versátiles en el arsenal de un pentester de aplicaciones web.

*   **Descubrimiento de Contenido (Fuerza Bruta de Directorios y Archivos):** Es su uso más común. Permite encontrar directorios y archivos ocultos que no están enlazados en el sitio, como `/admin`, `/backup`, `/config.php.bak`.
*   **Fuzzing de Parámetros:** Puedes usarlo para probar qué valores acepta un parámetro, lo que puede revelar vulnerabilidades como Inyección SQL (SQLi), Cross-Site Scripting (XSS), o Inyección de Comandos.
*   **Ataques de Fuerza Bruta a Formularios:** Automatiza el proceso de probar miles de combinaciones de usuario/contraseña en un formulario de inicio de sesión.
*   **Descubrimiento de Subdominios (Virtual Hosts):** Puede ser utilizado para descubrir subdominios que no son públicamente conocidos, modificando la cabecera `Host` de la petición.
*   **Identificación de Vulnerabilidades:** Al analizar las respuestas del servidor (códigos de estado, tamaño de la respuesta, tiempo), Wfuzz ayuda a identificar comportamientos anómalos que sugieren una vulnerabilidad.

## ¿Cómo se usa? (Ejemplos básicos)

Wfuzz se basa en el uso de la palabra clave `FUZZ` y la especificación de un diccionario (`-w`).

**Ejemplo 1: Descubrimiento de directorios y archivos**

Este comando buscará directorios y archivos en `http://example.com/` utilizando una lista de palabras común.

```bash
wfuzz -c -w /usr/share/seclists/Discovery/Web-Content/common.txt http://example.com/FUZZ
```
*   `-c`: Muestra la salida en colores.
*   `-w`: Especifica el diccionario (wordlist) a utilizar.
*   `FUZZ`: Wfuzz reemplazará esta palabra clave con cada línea del diccionario.

**Ejemplo 2: Fuzzing de un parámetro GET**

Este comando prueba diferentes valores para el parámetro `id` en la URL.

```bash
wfuzz -c -w /usr/share/seclists/Fuzzing/SQLi/Generic-SQLi.txt "http://testphp.vulnweb.com/listproducts.php?cat=FUZZ"
```
Aquí, estamos usando una lista de payloads de inyección SQL para ver si la aplicación es vulnerable.

**Ejemplo 3: Filtrar resultados**

La salida de Wfuzz puede ser muy grande. Puedes filtrarla para enfocarte en lo interesante. Por ejemplo, para ocultar las respuestas con código 404 (Not Found):

```bash
wfuzz -c -w /usr/share/seclists/Discovery/Web-Content/common.txt --hc 404 http://example.com/FUZZ
```
*   `--hc 404`: Oculta (`hide`) las respuestas con código (`code`) 404.

## Consideraciones Adicionales

*   **Flexibilidad Extrema:** La capacidad de poner `FUZZ` en cualquier lugar de una petición (incluso en múltiples lugares con `FUZZ1`, `FUZZ2`, etc.) hace que Wfuzz sea mucho más flexible que otras herramientas como `dirb` o `gobuster`.
*   **Dependencia de Diccionarios:** La efectividad de Wfuzz depende directamente de la calidad y relevancia del diccionario que utilices para el ataque.
*   **Ruido y Detección:** Como cualquier herramienta de fuerza bruta, Wfuzz genera una gran cantidad de tráfico y es fácilmente detectable por WAFs e IDS.
*   **Legalidad:** Su uso contra cualquier sistema sin autorización es ilegal.

---
*Nota: Wfuzz es una herramienta esencial y avanzada para el pentesting de aplicaciones web. Su dominio requiere práctica, especialmente en el arte de filtrar los resultados para encontrar las verdaderas vulnerabilidades.*
