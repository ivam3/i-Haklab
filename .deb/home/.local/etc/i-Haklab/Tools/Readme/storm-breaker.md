# Storm-Breaker

## ¿Qué es Storm-Breaker?

Storm-Breaker es una herramienta de ingeniería social diseñada para obtener información sensible de un dispositivo objetivo, principalmente teléfonos móviles. Al igual que otras herramientas de phishing, funciona generando un enlace malicioso que, al ser abierto por la víctima, intenta obtener acceso a diversas funciones del dispositivo.

Es una herramienta todo-en-uno que agrupa funcionalidades de varias otras herramientas de OSINT y phishing, proporcionando una interfaz sencilla para realizar ataques complejos.

## ¿Para qué es útil?

Storm-Breaker se utiliza en el ámbito del hacking ético y las pruebas de penetración para demostrar los peligros de la ingeniería social. Sus capacidades incluyen:

*   **Obtención de Información del Dispositivo:** Puede recopilar datos detallados sobre el hardware y el software del dispositivo objetivo.
*   **Geolocalización Precisa:** Al igual que `Seeker`, puede solicitar acceso a la ubicación GPS del dispositivo para obtener coordenadas exactas.
*   **Acceso a la Cámara:** Puede tomar fotos desde la cámara frontal y trasera del dispositivo sin que el usuario se dé cuenta (después de que se le haya concedido el permiso inicial).
*   **Acceso al Micrófono:** Puede grabar audio desde el micrófono del dispositivo.
*   **Phishing de Contraseñas:** Incluye plantillas para crear páginas de phishing que imitan a servicios populares y así robar credenciales.

## ¿Cómo se usa? (Ejemplo conceptual)

Storm-Breaker se ejecuta desde la línea de comandos y utiliza un servidor web local y un túnel `ngrok` (o similar) para exponer el ataque a internet.

**Flujo de trabajo típico:**

1.  **Iniciar la herramienta:** Se ejecuta el script principal desde la terminal.
    ```bash
    sudo python3 storm-breaker.py
    ```

2.  **Seleccionar un ataque:** La herramienta presenta un menú con los diferentes tipos de ataques disponibles (información del dispositivo, acceso a la cámara, etc.).

3.  **Generar el enlace:** Una vez seleccionado el ataque, la herramienta inicia un servidor local y utiliza `ngrok` para crear una URL pública.

4.  **Ingeniería Social:** El atacante debe enviar esta URL a la víctima y convencerla de que la abra. Por ejemplo, el enlace podría estar disfrazado como una oferta, una noticia o un inicio de sesión de una red social.

5.  **Recopilar los datos:** Cuando la víctima abre el enlace, se le pedirá que conceda ciertos permisos (ubicación, cámara, etc.). Si la víctima acepta, Storm-Breaker intercepta la información y la muestra en la terminal del atacante. Las imágenes, grabaciones de audio y credenciales capturadas se guardan en el equipo del atacante.

## Consideraciones Adicionales

*   **Dependencia de la Interacción del Usuario:** El éxito de Storm-Breaker depende completamente de que la víctima haga clic en el enlace y, lo que es más importante, **acepte las solicitudes de permisos**. Los navegadores modernos son cada vez más estrictos con estos permisos, lo que dificulta el ataque.
*   **Evasión y Detección:** Los enlaces de `ngrok` y las plantillas de phishing pueden ser detectados y bloqueados por servicios de correo electrónico y antivirus.
*   **Legalidad y Ética:** El uso de esta herramienta para acceder al dispositivo, la cámara, el micrófono o la ubicación de una persona sin su consentimiento explícito es una grave violación de la privacidad y es altamente ilegal. Su uso debe limitarse estrictamente a entornos de pruebas de penetración autorizados y con fines educativos.

---
*Nota: Storm-Breaker es una herramienta extremadamente intrusiva. Su uso indebido puede acarrear consecuencias legales muy serias.*
