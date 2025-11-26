# Blackbox (Pruebas de Caja Negra)

## ¿Qué es "Blackbox"?

En el contexto de la ciberseguridad y las pruebas de software, el término **"Blackbox"** (Caja Negra) no se refiere a una única herramienta, sino a una **metodología de prueba**. Una prueba de caja negra es aquella en la que el analista o pentester no tiene ningún conocimiento previo sobre el funcionamiento interno del sistema que está evaluando.

El sistema (ya sea una aplicación, una red o un servidor) es tratado como una "caja negra". El analista sabe qué *entradas* puede proporcionar y qué *salidas* debe esperar, pero no tiene idea del código fuente, la arquitectura, o la lógica interna que procesa esas entradas para producir las salidas.

## ¿Para qué es útil este enfoque?

La metodología de caja negra es fundamental en las pruebas de penetración (pentesting) porque simula de la forma más realista posible un ataque externo. Un atacante real, en la mayoría de los casos, no tiene acceso al código fuente de la aplicación de su víctima.

Este enfoque es útil para:

*   **Simular Ataques Externos:** Permite evaluar la seguridad de un sistema desde la perspectiva de un atacante real que no tiene información privilegiada.
*   **Identificar Vulnerabilidades de Lógica de Negocio:** Al interactuar con la aplicación como lo haría un usuario final, es posible descubrir fallos en la lógica que no serían evidentes al revisar el código.
*   **Verificar la Funcionalidad de Seguridad:** Permite comprobar si las defensas de la aplicación (como la validación de entradas, la autenticación, y el control de acceso) funcionan correctamente desde el exterior.
*   **Encontrar Vulnerabilidades Técnicas Comunes:** Es el método utilizado para encontrar vulnerabilidades como:
    *   Inyección SQL (SQLi)
    *   Cross-Site Scripting (XSS)
    *   Cross-Site Request Forgery (CSRF)
    *   Inyección de Comandos
    *   Y muchas otras.

## Herramientas comunes para Pruebas de Caja Negra

Aunque "Blackbox" es un enfoque, existen innumerables herramientas que operan bajo este principio. La lista de herramientas proporcionada en tu proyecto contiene muchas de ellas. Algunos ejemplos clave son:

*   **Escáneres de Vulnerabilidades Web:**
    *   **Nikto:** Escanea servidores web en busca de archivos peligrosos, versiones de software desactualizadas y otros problemas de configuración.
    *   **Nmap:** Aunque es un escáner de red, se usa en modo de caja negra para descubrir puertos abiertos, servicios en ejecución y sistemas operativos.
    *   **Wapiti / ZAP (OWASP) / Burp Suite:** Son escáneres más avanzados que rastrean una aplicación web, analizan cada parámetro y buscan activamente vulnerabilidades de inyección.

*   **Herramientas de Fuzzing:**
    *   **Wfuzz / Ffuf:** Herramientas que envían una gran cantidad de entradas semi-aleatorias a una aplicación para provocar errores inesperados que puedan revelar una vulnerabilidad.

*   **Proxies de Interceptación:**
    *   **Burp Suite / ZAP (OWASP):** Permiten al pentester interceptar, ver y modificar todas las solicitudes que van desde su navegador a la aplicación, lo que es la esencia de una prueba de caja negra manual.

## Ejemplo de un Flujo de Trabajo de Caja Negra

Supongamos que un pentester tiene la tarea de evaluar la seguridad de una aplicación web en `https://example.com`.

1.  **Reconocimiento (con herramientas de caja negra):**
    *   Usa `nmap` para ver qué puertos están abiertos en el servidor de `example.com`.
    *   Usa `nikto` para obtener una visión general rápida de posibles problemas de configuración.
    *   Usa `amass` o `subfinder` para descubrir otros subdominios que puedan tener aplicaciones olvidadas.

2.  **Mapeo de la Aplicación (con un proxy):**
    *   Configura `Burp Suite` como proxy y navega por toda la aplicación. Burp mapeará silenciosamente todas las páginas, funciones y parámetros.

3.  **Búsqueda de Vulnerabilidades (manual y automatizada):**
    *   Usa el escáner automatizado de Burp para realizar una primera pasada en busca de vulnerabilidades comunes.
    *   Manualmente, el pentester examina cada parámetro. Por ejemplo, si ve una URL como `https://example.com/profile?user_id=123`, intentará cambiar el `123` a `124` para ver si puede acceder al perfil de otro usuario (vulnerabilidad IDOR). Intentará inyectar código SQL en el parámetro para ver si la aplicación es vulnerable a SQLi.

En todo este proceso, el pentester no necesita ver ni una sola línea del código fuente de la aplicación.

## Cajas Negras vs. Blancas vs. Grises

*   **Caja Negra (Black Box):** Cero conocimiento interno.
*   **Caja Blanca (White Box):** Acceso completo al código fuente y a la documentación de la arquitectura. Permite un análisis mucho más profundo y es típico de una auditoría de código.
*   **Caja Gris (Gray Box):** Conocimiento parcial. El pentester podría tener las credenciales de un usuario de bajo privilegio, o un diagrama de la arquitectura, pero no el código fuente.

---
*Nota: Las pruebas de caja negra, como cualquier forma de pentesting, deben realizarse únicamente en sistemas para los que se tiene autorización explícita.*
