# DIRB

## ¿Qué es DIRB?

DIRB es una herramienta clásica de línea de comandos para el **descubrimiento de contenido web**. Su función es lanzar un ataque de diccionario contra un servidor web para encontrar directorios y archivos que no están enlazados o que se pretende que estén ocultos.

El nombre "DIRB" es un acrónimo que resume su función: **DIR**ectory **B**uster (Destructor de Directorios). Funciona tomando una lista de palabras (wordlist) y probando cada palabra como una posible ruta en el servidor web, analizando la respuesta para ver si el recurso existe.

## ¿Para qué es útil la herramienta?

DIRB es una herramienta fundamental en la fase de reconocimiento de cualquier prueba de penetración web. Descubrir contenido oculto puede revelar vectores de ataque críticos:

*   **Encontrar Paneles de Administración:** Descubre páginas de inicio de sesión de administradores (como `/admin`, `/login.php`, `/dashboard`) que no están enlazadas desde la página principal.
*   **Descubrir Archivos de Backup:** Encuentra archivos de copia de seguridad olvidados (como `backup.zip`, `sitio.tar.gz`, `config.php.bak`) que pueden contener código fuente, credenciales, o información sensible.
*   **Localizar Archivos de Configuración:** Descubre archivos de configuración expuestos (como `.htaccess`, `web.config`) que pueden revelar información sobre la tecnología y la configuración del servidor.
*   **Identificar Endpoints de API Ocultos:** Ayuda a encontrar endpoints de una API que no están documentados públicamente.
*   **Mapear la Estructura del Sitio:** Proporciona una mejor comprensión de la estructura del sitio web, más allá de lo que se puede ver simplemente navegando por él.

## ¿Cómo funciona?

1.  **Entrada:** Se le proporciona a DIRB una URL base (el sitio a escanear) y, opcionalmente, una lista de palabras. Si no se proporciona una lista, DIRB utiliza sus propias listas de palabras incorporadas, que son bastante efectivas.
2.  **Peticiones HTTP:** DIRB itera sobre cada palabra de la lista y realiza una petición HTTP a `http://<URL_base>/<palabra>`.
3.  **Análisis de Respuesta:** Analiza el código de estado de la respuesta HTTP del servidor:
    *   **`200 OK`:** Significa que el archivo o directorio existe y es accesible. ¡Un hallazgo!
    *   **`301/302 Redirect`:** Indica que el recurso se ha movido. DIRB lo seguirá. A menudo, un `301` para un nombre sin `/` al final (ej. `/admin`) significa que es un directorio.
    *   **`403 Forbidden`:** Significa que el recurso existe pero no tenemos permiso para verlo. Sigue siendo un hallazgo útil, ya que confirma la existencia del recurso.
    *   **`404 Not Found`:** Significa que el recurso no existe. DIRB ignora estos resultados.
4.  **Informe:** DIRB muestra en tiempo real todos los recursos que encuentra (aquellos que no devuelven un 404).

## ¿Cómo se usa? (Ejemplo básico)

DIRB es una herramienta de línea de comandos muy sencilla de utilizar.

**Sintaxis básica:**
```bash
dirb <URL_base> [ruta/a/la/wordlist]
```

### Ejemplo 1: Escaneo simple

Este comando escaneará `http://example.com` utilizando la lista de palabras por defecto de DIRB.

```bash
dirb http://example.com
```

**Salida de ejemplo:**
```
-----------------
DIRB v2.22
By The Dark Raver
-----------------

START_TIME: Thu Oct 27 12:00:00 2023
URL_BASE: http://example.com/
WORDLIST_FILES: /usr/share/dirb/wordlists/common.txt

-----------------
GENERATED WORDS: 4612

---- Scanning URL: http://example.com/ ----
+ http://example.com/index.html (CODE:200|SIZE:1234)
+ http://example.com/admin/ (CODE:301|SIZE:0) --> http://example.com/admin/
+ http://example.com/robots.txt (CODE:200|SIZE:56)
==> DIRECTORY: http://example.com/css/
==> DIRECTORY: http://example.com/js/
...
```

### Ejemplo 2: Usar una lista de palabras personalizada

Si tienes tu propia lista de palabras, puedes especificársela a DIRB.

```bash
dirb http://example.com /ruta/a/mi/wordlist.txt
```

### Ejemplo 3: Escaneo recursivo y búsqueda de extensiones

```bash
dirb http://example.com -r -X .php,.html,.bak
```
*   `-r`: Realiza el escaneo de forma recursiva. Si encuentra un directorio, también escaneará dentro de ese directorio.
*   `-X .php,.html,.bak`: Le dice a DIRB que, además de buscar `palabra`, también busque `palabra.php`, `palabra.html` y `palabra.bak` por cada palabra en la lista.

## Consideraciones Adicionales

*   **Ruido en la Red:** Un escaneo con DIRB puede generar miles de peticiones HTTP, lo que crea mucho "ruido" en los logs del servidor web. Esto puede alertar a los sistemas de detección de intrusos (IDS).
*   **Herramientas Modernas:** Aunque DIRB es un clásico y sigue siendo efectivo, han surgido herramientas más modernas y rápidas que realizan la misma función, como **Gobuster**, **Dirsearch** y **ffuf**. Estas herramientas están escritas en lenguajes compilados como Go, lo que les permite ser mucho más rápidas al manejar miles de hilos concurrentes.
*   **Legalidad:** El uso de DIRB en un sitio web sin permiso explícito es una actividad hostil y puede ser ilegal.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. Utiliza esta herramienta de forma responsable.*
