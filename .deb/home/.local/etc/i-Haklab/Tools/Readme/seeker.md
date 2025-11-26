# Seeker

## ¿Qué es Seeker?

Seeker es una herramienta de prueba de penetración y hacking ético diseñada para obtener información de geolocalización de alta precisión de un objetivo. A diferencia de otras herramientas que se basan en la dirección IP (lo cual es muy impreciso), Seeker utiliza un enfoque de ingeniería social.

Funciona generando una página web falsa que, al ser abierta por el objetivo, solicita permisos de ubicación a través de la API de geolocalización del navegador. Si el objetivo acepta, Seeker recibe datos detallados, incluyendo:

-   Latitud y Longitud
-   Altitud y Precisión
-   Dirección, velocidad y más (si el dispositivo los proporciona).

## ¿Para qué es útil?

Seeker es una herramienta poderosa para demostrar los riesgos de la ingeniería social y cómo se puede engañar a un usuario para que revele información sensible. Sus usos principales son:

-   **Pruebas de Penetración:** En una campaña de phishing, un pentester puede usar Seeker para demostrar el impacto de un ataque exitoso, mostrando qué tan precisa puede ser la información de ubicación obtenida.
-   **Concienciación sobre Seguridad:** Se puede utilizar para educar a los empleados o al público en general sobre los peligros de hacer clic en enlaces sospechosos y conceder permisos sin pensar.
-   **Recopilación de Inteligencia (OSINT):** En el contexto de una investigación de fuente abierta, puede ayudar a verificar la ubicación de una persona de interés (siempre que se use de manera ética y legal).

## ¿Cómo se usa? (Ejemplo conceptual)

Seeker generalmente se ejecuta desde la línea de comandos en un entorno que pueda ejecutar Python y exponer un puerto a internet (a menudo se usa con `ngrok` para esto).

**Flujo de trabajo típico:**

1.  **Ejecutar Seeker:** Inicias la herramienta en tu máquina.
    ```bash
    python3 seeker.py
    ```

2.  **Generar el enlace malicioso:** Seeker levanta un servidor web en un puerto local (por ejemplo, `8080`) y te proporciona una URL. A menudo, el ataque se centra en una plantilla que simula ser de una aplicación conocida como Google Drive, WhatsApp, etc.

3.  **Exponer el servidor a Internet:** Usando una herramienta como `ngrok`, expones tu servidor local a internet para que cualquiera pueda acceder a él.
    ```bash
    ngrok http 8080
    ```
    Ngrok te dará una URL pública (por ejemplo, `https://random-string.ngrok.io`).

4.  **Enviar el enlace al objetivo:** Envías la URL de `ngrok` a tu objetivo a través de un mensaje, correo electrónico, etc.

5.  **Esperar a que el objetivo interactúe:** Cuando el objetivo abre el enlace, verá una página que le pide permiso para acceder a su ubicación. Si acepta, Seeker interceptará las coordenadas y te las mostrará en la terminal, junto con un enlace a Google Maps para visualizar la ubicación.

## Consideraciones Adicionales

-   **Ingeniería Social:** La efectividad de Seeker depende al 100% de la ingeniería social. El objetivo debe ser convencido de hacer clic en el enlace y, lo más importante, de aceptar la solicitud de permiso de ubicación.
-   **Permisos del Navegador:** La herramienta se basa en las APIs del navegador. Si el navegador del objetivo bloquea las solicitudes de ubicación por defecto o si el usuario las niega, el ataque no funcionará.
-   **Legalidad:** El uso de Seeker para rastrear a una persona sin su consentimiento explícito es una grave violación de la privacidad y es ilegal en la mayoría de las jurisdicciones. Solo debe usarse para fines educativos y en pruebas de penetración autorizadas.

---
*Nota: Esta herramienta debe ser utilizada con extrema precaución y responsabilidad. Su propósito es educativo y para la evaluación de la seguridad, no para el espionaje o el acoso.*
