# Burp Suite

## ¿Qué es Burp Suite?

Burp Suite (o simplemente "Burp") es la herramienta más utilizada y reconocida a nivel mundial para la seguridad y las pruebas de penetración de aplicaciones web. Desarrollada por PortSwigger, es una plataforma integrada que actúa como un "hombre en el medio" (Man-in-the-Middle) entre el navegador del analista y la aplicación web objetivo.

Su función principal es interceptar todo el tráfico HTTP/HTTPS para que el analista pueda inspeccionarlo, modificarlo, repetirlo y analizarlo en busca de vulnerabilidades de seguridad. Es una herramienta indispensable para cualquier profesional de la ciberseguridad, desde pentesters y cazadores de recompensas (bug hunters) hasta desarrolladores que buscan asegurar su propio código.

## ¿Para qué es útil la herramienta?

Burp Suite es una navaja suiza para el pentesting web. Su conjunto de herramientas permite realizar casi cualquier tarea relacionada con la evaluación de la seguridad de una aplicación web:

*   **Interceptación y Modificación de Tráfico:** Permite ver y cambiar cualquier parte de una solicitud (headers, cuerpo, URL) antes de que llegue al servidor, o de una respuesta antes de que llegue al navegador.
*   **Análisis Manual de Vulnerabilidades:** Es la herramienta principal para encontrar vulnerabilidades complejas que los escáneres automáticos no pueden detectar, como fallos en la lógica de negocio, control de acceso roto (IDOR), etc.
*   **Escaneo Automatizado:** Las versiones de pago de Burp incluyen un escáner muy potente que puede rastrear una aplicación y encontrar automáticamente docenas de tipos de vulnerabilidades, como Inyección SQL, Cross-Site Scripting (XSS), y muchas más.
*   **Ataques de Fuzzing y Fuerza Bruta:** Permite automatizar el envío de miles de solicitudes con diferentes cargas útiles (payloads) para probar parámetros en busca de vulnerabilidades o para realizar ataques de fuerza bruta contra formularios de inicio de sesión.
*   **Mapeo de la Aplicación:** Ayuda a construir un mapa detallado de toda la aplicación web, mostrando todos los endpoints, archivos y parámetros descubiertos.

## Herramientas Clave dentro de Burp Suite

Burp no es una sola herramienta, sino un conjunto de módulos que trabajan juntos. Los más importantes son:

*   **Proxy:** Es el corazón de Burp. Es el proxy que se sienta entre el navegador y el servidor. La pestaña "Intercept" te permite pausar y modificar el tráfico en tiempo real.
*   **Target:** Muestra un mapa del sitio de la aplicación objetivo y el historial de todas las solicitudes realizadas.
*   **Repeater:** Permite tomar una solicitud HTTP, modificarla y reenviarla una y otra vez para observar cómo las diferentes entradas afectan la respuesta del servidor. Es una de las herramientas más utilizadas para la exploración manual de vulnerabilidades.
*   **Intruder:** Es la herramienta de fuzzing. Automatiza el envío de solicitudes con cargas útiles personalizadas. Es ideal para realizar ataques de fuerza bruta, enumerar nombres de usuario o buscar vulnerabilidades de inyección.
*   **Scanner (Solo versiones de pago):** El escáner de vulnerabilidades automatizado.
*   **Decoder:** Una utilidad para codificar y decodificar datos en formatos comunes como Base64, URL, Hex, etc.
*   **Sequencer:** Analiza la aleatoriedad de los tokens generados por la aplicación (como los IDs de sesión) para ver si son predecibles.
*   **Extender:** Permite ampliar la funcionalidad de Burp mediante la instalación de extensiones (llamadas BApps) creadas por la comunidad, que añaden nuevas capacidades de escaneo, integración con otras herramientas, etc.

## ¿Cómo se usa?

El flujo de trabajo básico es el siguiente:

1.  **Configurar el Proxy:** Se inicia Burp Suite y se configura el navegador para que dirija todo su tráfico a través del proxy de Burp (normalmente en `127.0.0.1:8080`).
2.  **Instalar el Certificado de Burp:** Para que Burp pueda interceptar el tráfico HTTPS sin que el navegador muestre errores de certificado, es necesario instalar el certificado raíz de Burp en el navegador o en el sistema operativo.
3.  **Navegar por la Aplicación:** El analista navega por la aplicación web. Todo el tráfico aparece en la pestaña "Target" de Burp.
4.  **Analizar y Atacar:**
    *   Se envían solicitudes interesantes de la "Target" a "Repeater" para modificarlas y experimentar.
    *   Se envían a "Intruder" para realizar ataques automatizados.
    *   Se activa el escáner (si se tiene la versión Pro) para buscar vulnerabilidades de forma pasiva o activa.

## Versiones de Burp Suite

*   **Community Edition:** Gratuita. Incluye las herramientas manuales esenciales como Proxy, Repeater y Decoder. Es muy potente, pero carece del escáner automático y tiene un "Intruder" más lento.
*   **Professional Edition:** De pago. Incluye el escáner completo, un Intruder mucho más rápido y otras funciones avanzadas. Es el estándar de la industria para los pentesters.
*   **Enterprise Edition:** De pago. Diseñada para la integración continua y el escaneo automatizado a gran escala en entornos empresariales.

---
*Nota: La información proporcionada aquí es para fines educativos. El uso de Burp Suite debe realizarse de forma ética y legal.*
