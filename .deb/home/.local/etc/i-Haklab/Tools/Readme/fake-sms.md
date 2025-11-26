# Fake-SMS (Suplantación de SMS)

## ¿Qué es una herramienta de "Fake SMS"?

En el contexto de la ciberseguridad, una herramienta de "Fake SMS" no se refiere a un generador de conversaciones falsas para memes, sino a una utilidad para realizar **Suplantación de SMS (SMS Spoofing)**.

El SMS Spoofing es una técnica que permite enviar un mensaje de texto a un teléfono manipulando la información del remitente. Esto hace que el mensaje parezca provenir de un número de teléfono o un nombre de contacto diferente al del remitente real. Por ejemplo, un atacante podría enviar un SMS que en el teléfono de la víctima aparezca como si viniera de "Google", "Banco Santander", o de un contacto de confianza.

## ¿Para qué es útil la herramienta?

Estas herramientas son un componente clave en los ataques de ingeniería social y son utilizadas tanto por atacantes maliciosos como por profesionales de la seguridad en pruebas de penetración.

*   **Simulación de Phishing (Smishing):** Es su uso principal en pentesting. Un profesional de la seguridad puede usar una de estas herramientas para enviar mensajes a los empleados de una empresa, simulando ser el departamento de TI, un servicio conocido (como Microsoft Office 365) o un banco. El objetivo es comprobar cuántos empleados hacen clic en un enlace malicioso o revelan información sensible.
*   **Pruebas de Concienciación de Empleados:** Ayuda a las empresas a evaluar la eficacia de sus programas de formación en seguridad y a concienciar a los empleados sobre los peligros del "smishing" (phishing por SMS).
*   **Ataques de Ingeniería Social:** Los ciberdelincuentes las utilizan para:
    *   Distribuir malware.
    *   Robar credenciales de inicio de sesión.
    *   Engañar a las víctimas para que autoricen transacciones fraudulentas.
    *   Intentar interceptar códigos de autenticación de múltiples factores (MFA) enviados por SMS.

**ADVERTENCIA:** El uso de estas herramientas para enviar mensajes fraudulentos o no solicitados es **ilegal** y poco ético.

## ¿Cómo funciona?

El protocolo SMS, en su diseño original, no tenía mecanismos de autenticación robustos para el remitente. Las herramientas de suplantación de SMS explotan esta debilidad utilizando pasarelas de SMS (SMS gateways) de terceros.

1.  **El Servicio de Pasarela (Gateway):** El atacante no envía el SMS directamente desde su teléfono. En su lugar, utiliza un servicio en línea o una API de una pasarela de SMS.
2.  **API con Capacidad de Spoofing:** Muchas de estas pasarelas, especialmente las más antiguas o las que tienen políticas de seguridad laxas, permiten al usuario especificar el "Sender ID" (Identificador del Remitente) en su solicitud de API. Este Sender ID puede ser un número de teléfono (numérico) o un nombre (alfanumérico, como "Google").
3.  **Envío del Mensaje:** La herramienta de "Fake SMS" simplemente proporciona una interfaz fácil de usar para interactuar con una de estas APIs. El usuario introduce el número de la víctima, el mensaje y el remitente que desea suplantar. La herramienta envía esta información a la pasarela.
4.  **Recepción por la Víctima:** La pasarela de SMS enruta el mensaje a través de la red de telefonía global, y el teléfono de la víctima lo recibe, mostrando el Sender ID falsificado que el atacante especificó. Para la víctima, el mensaje es indistinguible de uno legítimo.

## ¿Cómo se usaría? (Ejemplo conceptual)

Una herramienta de este tipo, ya sea de línea de comandos o una interfaz web, pediría los siguientes datos:

*   **Número del Destinatario:** El número de teléfono de la víctima.
*   **Remitente Falsificado (Sender ID):** El número o nombre que se desea suplantar (ej. `+1-800-555-0199` o `SoporteTI`).
*   **Mensaje:** El contenido del SMS, que normalmente incluiría un enlace a un sitio de phishing.

**Ejemplo de mensaje de smishing:**
> **Remitente:** SoporteTI
> **Mensaje:** Actividad inusual detectada en su cuenta de Office 365. Por favor, verifique su identidad inmediatamente en https://portal-office365-seguridad.com para evitar el bloqueo de su cuenta.

## Consideraciones Adicionales

*   **Legalidad y Ética:** El envío de mensajes de texto suplantados sin el consentimiento del receptor es ilegal en muchas jurisdicciones. En el contexto de una prueba de penetración, se requiere un permiso explícito y por escrito del cliente.
*   **Mitigación:** Es muy difícil para un usuario final protegerse técnicamente, ya que el engaño ocurre a nivel de la red de telecomunicaciones. La mejor defensa es la **concienciación**:
    *   Ser siempre escéptico ante los mensajes de texto inesperados, incluso si parecen venir de una fuente legítima.
    *   Nunca hacer clic en enlaces o descargar archivos de SMS no solicitados.
    *   Verificar siempre la solicitud a través de un canal de comunicación diferente y conocido (por ejemplo, llamando al número oficial del banco o visitando el sitio web oficial directamente desde el navegador).
*   **SMS Bomber:** Una variante de estas herramientas es el "SMS Bomber", cuyo único propósito es el acoso, enviando cientos o miles de SMS a un número en un corto período de tiempo para colapsar el teléfono de la víctima con notificaciones.

---
*Nota: La información proporcionada aquí es para fines educativos para comprender los vectores de ataque de ingeniería social. No utilices estas técnicas de forma maliciosa.*
