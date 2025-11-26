# WhatWeb

## ¿Qué es WhatWeb?

WhatWeb es una herramienta de **identificación de tecnologías web**. Su propósito es responder a la pregunta: "¿Con qué está hecho este sitio web?". Es un escáner de reconocimiento que analiza una página web y revela las tecnologías que utiliza.

A diferencia de otras herramientas que solo miran las cabeceras del servidor, WhatWeb utiliza cientos de plugins para realizar un análisis mucho más profundo, reconociendo una enorme cantidad de aplicaciones, servicios y dispositivos.

## ¿Para qué es útil?

WhatWeb es una de las primeras herramientas que se ejecutan en cualquier auditoría de seguridad o prueba de penetración. La información que proporciona es crucial para determinar el vector de ataque.

*   **Fingerprinting de Tecnologías:** Identifica:
    *   **CMS:** WordPress, Joomla, Drupal, etc.
    *   **Frameworks de JavaScript:** jQuery, React, AngularJS, etc.
    *   **Software del Servidor Web:** Apache, Nginx, IIS, etc. (y a menudo la versión).
    *   **Sistema Operativo:** El SO subyacente del servidor.
    *   **Plataformas de E-commerce:** Magento, PrestaShop, etc.
    *   Y miles de otras tecnologías.
*   **Recopilación de Información Adicional:** A menudo puede extraer información como:
    *   Direcciones de correo electrónico.
    *   Cuentas de Google Analytics o AdSense.
    *   Títulos de página y metadatos.
*   **Selección de Exploits:** Una vez que sabes que un sitio corre una versión específica de WordPress con un plugin concreto, puedes buscar exploits dirigidos a esa combinación. WhatWeb te da la información necesaria para empezar a buscar vulnerabilidades.

## ¿Cómo se usa? (Ejemplos básicos)

WhatWeb es una herramienta de línea de comandos muy fácil de usar.

**Ejemplo 1: Escaneo básico de un sitio web**

```bash
whatweb example.com
```
WhatWeb analizará el sitio y te devolverá una lista de todas las tecnologías que ha identificado.

**Ejemplo 2: Escaneo más agresivo y detallado**

El nivel de agresividad determina cuántas peticiones realiza WhatWeb. Un nivel más alto puede descubrir más información, pero también es más "ruidoso".

```bash
whatweb -a 3 -v example.com
```
*   `-a 3`: Establece el nivel de agresividad en 3 (el más común para un escaneo profundo). Los niveles van del 1 (sigiloso) al 4 (muy agresivo).
*   `-v`: Modo "verbose" o detallado, que muestra más información sobre los plugins que se están ejecutando.

**Ejemplo 3: Escanear una lista de sitios**

Puedes pasarle un archivo de texto con una lista de URLs para escanearlas todas.

```bash
whatweb -i urls.txt
```
*   `-i`: Especifica un archivo de entrada.

## Consideraciones Adicionales

*   **Plugins:** La verdadera potencia de WhatWeb reside en su enorme base de datos de más de 1800 plugins, que son como "firmas" para detectar tecnologías. Esta base de datos se actualiza constantemente.
*   **Sigilo vs. Agresividad:** El nivel de agresividad es una compensación entre obtener la máxima información posible y no ser detectado por sistemas de seguridad. Un escaneo de nivel 1 es muy sigiloso, mientras que un nivel 3 o 4 hará muchas más peticiones.
*   **Herramienta de Reconocimiento:** WhatWeb es puramente una herramienta de reconocimiento. No explota vulnerabilidades, simplemente te dice qué tecnologías están presentes para que puedas investigar más a fondo.
*   **Legalidad:** Su uso es legal, ya que se limita a hacer peticiones a un sitio web de una manera similar a como lo haría un navegador, aunque de forma más intensiva.

---
*Nota: WhatWeb es una herramienta esencial y estándar en la industria para la fase de "fingerprinting" o reconocimiento en una auditoría de seguridad web.*
