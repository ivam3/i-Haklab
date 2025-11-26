# D-TECT

## ¿Qué es D-TECT?

D-TECT es un framework de pruebas de penetración de código abierto, escrito en Python. Su objetivo es automatizar muchas de las tareas comunes de la fase de reconocimiento y detección de vulnerabilidades en una auditoría de seguridad web.

Funciona como una suite "todo en uno" que integra varias funcionalidades para que un pentester pueda obtener rápidamente una visión general de la postura de seguridad de una aplicación web.

## ¿Para qué es útil la herramienta?

D-TECT es útil para realizar una evaluación de seguridad rápida y automatizada de un sitio web. Sus principales funcionalidades incluyen:

*   **Recopilación de Información (OSINT):**
    *   **Enumeración de Subdominios:** Descubre subdominios asociados a un dominio principal.
    *   **Escaneo de Puertos:** Detecta qué puertos están abiertos en el servidor objetivo.
    *   **Búsqueda de Whois:** Obtiene información de registro sobre el dominio.
    *   **Detección de CMS:** Identifica si el sitio utiliza un sistema de gestión de contenidos como WordPress, Joomla, etc.

*   **Detección de Vulnerabilidades:**
    *   **Escaneo de XSS (Cross-Site Scripting):** Busca posibles vulnerabilidades de XSS reflejado y almacenado.
    *   **Detección de Inyección SQL:** Realiza comprobaciones básicas para detectar posibles puntos de inyección SQL.
    *   **Búsqueda de Páginas de Administración:** Intenta encontrar la página de inicio de sesión del panel de administración del sitio.
    *   **Análisis de Encabezados de Seguridad:** Comprueba si el sitio ha implementado correctamente los encabezados de seguridad HTTP (como CSP, HSTS, X-Frame-Options).

*   **Escaneo Específico para WordPress:**
    *   **Enumeración de usuarios:** Intenta listar los nombres de usuario de un sitio de WordPress.
    *   **Detección de temas y plugins:** Identifica el tema y los plugins utilizados, lo que puede ayudar a buscar vulnerabilidades conocidas en ellos.

## ¿Cómo se usa? (Ejemplo conceptual)

D-TECT funciona como un shell interactivo en la línea de comandos, similar a otras herramientas como Metasploit.

1.  **Iniciar la herramienta:**
    ```bash
    python d-tect.py
    ```

2.  **Establecer el objetivo:**
    Una vez dentro del shell de D-TECT, lo primero es establecer la URL del sitio que se va a analizar.
    ```
    d-tect> set target http://example.com
    ```

3.  **Ejecutar un módulo:**
    Después de establecer el objetivo, puedes ejecutar los diferentes módulos de escaneo.
    ```
    # Para buscar subdominios
    d-tect> run subdomain_enum

    # Para buscar vulnerabilidades XSS
    d-tect> run xss_scan

    # Para realizar un escaneo completo de WordPress
    d-tect> run wordpress_scan
    ```

4.  **Ver los resultados:**
    La herramienta mostrará los resultados de cada escaneo en la consola y, a menudo, los guardará en archivos de registro para un análisis posterior.

## Consideraciones Adicionales

*   **Herramienta Automatizada:** D-TECT es principalmente una herramienta de escaneo automatizado. Esto la hace ideal para obtener una visión general rápida, pero no reemplaza el análisis manual profundo que puede realizar un pentester experimentado con herramientas como [Burp Suite](burpsuite.md).
*   **Falsos Positivos y Negativos:** Como cualquier escáner automatizado, puede generar falsos positivos (informar una vulnerabilidad que no existe) o falsos negativos (no detectar una vulnerabilidad que sí existe). Los resultados siempre deben ser verificados manualmente.
*   **Enfoque en la Detección:** Su nombre lo indica ("Detectar"). La herramienta está enfocada en la detección de posibles debilidades, no en su explotación. Para explotar las vulnerabilidades encontradas, se necesitarían otras herramientas.
*   **Legalidad:** Solo debes ejecutar D-TECT contra sitios web para los que tengas permiso explícito de realizar pruebas de seguridad. El escaneo no autorizado se considera una actividad hostil.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética.*
