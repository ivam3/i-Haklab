# Evilginx2

## ¿Qué es Evilginx2?

Evilginx2 es un framework de ataque de **Man-in-the-Middle (MITM)**, pero a diferencia de herramientas como [Bettercap](bettercap.md) que operan a nivel de red, Evilginx2 se enfoca en el **phishing a nivel de aplicación**. Su propósito principal es robar credenciales de inicio de sesión, pero su característica más notoria es su capacidad para **eludir la Autenticación de Múltiples Factores (MFA/2FA)**.

Actúa como un proxy inverso, sentándose entre la víctima y el sitio web legítimo. Cuando la víctima interactúa con el sitio de phishing creado por Evilginx2, la herramienta retransmite toda la comunicación al sitio real, incluyendo los códigos 2FA, y en el proceso, captura no solo el nombre de usuario y la contraseña, sino lo más importante: la **cookie de sesión**.

## ¿Para qué es útil la herramienta?

Evilginx2 es una de las herramientas más potentes y peligrosas para demostrar el impacto real de los ataques de phishing modernos.

*   **Simulación de Ataques de Phishing Avanzados:** Es la herramienta de referencia para las campañas de Red Team que buscan probar la resistencia de una organización y sus empleados a ataques de phishing sofisticados.
*   **Secuestro de Sesiones (Session Hijacking):** Su principal objetivo no es solo robar contraseñas, sino robar la cookie de sesión que se genera *después* de una autenticación exitosa (incluyendo el paso de 2FA). Con esta cookie, el atacante puede hacerse pasar por el usuario sin necesidad de la contraseña ni del dispositivo 2FA.
*   **Concienciación sobre la debilidad del 2FA basado en OTP/SMS:** Demuestra de forma práctica que los métodos de 2FA que se basan en códigos de un solo uso (como los de SMS, Google Authenticator, o notificaciones push) son vulnerables a ataques de phishing en tiempo real.

**ADVERTENCIA:** El uso de esta herramienta para cualquier propósito que no sea una prueba de penetración autorizada y ética es **ilegal** y muy malicioso.

## ¿Cómo funciona?

1.  **Configuración del Dominio y el Servidor:** El atacante necesita un servidor que controle y un nombre de dominio que parezca legítimo (typosquatting), por ejemplo, `login.microsott.com` en lugar de `login.microsoft.com`.
2.  **Configuración de los "Phishlets":** Evilginx2 utiliza archivos de configuración llamados `phishlets`. Cada phishlet le dice a Evilginx2 cómo actuar como proxy para un sitio web específico (por ejemplo, `linkedin.com`, `gmail.com`, `office365.com`), especificando qué rutas interceptar y qué cookies robar.
3.  **La Víctima Recibe el Enlace:** El atacante envía el enlace de phishing (`https://login.microsott.com`) a la víctima.
4.  **Proxy Inverso en Acción:**
    *   La víctima visita el sitio malicioso. Su navegador se conecta a Evilginx2.
    *   Evilginx2 se conecta al sitio web legítimo (ej. `login.microsoft.com`) y le retransmite la página de inicio de sesión a la víctima. La víctima ve la página real, no una copia.
    *   La víctima introduce su nombre de usuario y contraseña. Evilginx2 los captura y se los pasa al sitio legítimo.
    *   El sitio legítimo, al ver las credenciales correctas, solicita el código 2FA.
    *   La víctima introduce su código 2FA. Evilginx2 lo captura y se lo pasa al sitio legítimo.
5.  **Captura de la Cookie de Sesión:**
    *   El sitio legítimo verifica el código 2FA y, si es correcto, emite una cookie de sesión y redirige al usuario a su cuenta.
    *   Evilginx2 intercepta esta cookie de sesión **antes** de que llegue al navegador de la víctima. En este punto, el ataque ha tenido éxito.
    *   Evilginx2 guarda las credenciales y la cookie de sesión, y luego redirige a la víctima al sitio web legítimo para que la experiencia sea fluida y el usuario no sospeche nada.

## ¿Cómo se usa?

Evilginx2 funciona como un shell interactivo.

1.  **Configurar el Servidor y DNS:** Apuntar el dominio de phishing a la IP del servidor donde corre Evilginx2.
2.  **Configurar Evilginx2:**
    ```bash
    # En el shell de evilginx
    > config domain mi-dominio-phishing.com
    > config ip <IP_de_tu_servidor>
    ```

3.  **Habilitar un Phishlet:**
    ```bash
    > phishlets enable office365
    ```

4.  **Obtener la URL de Phishing:**
    ```bash
    > phishlets get-url office365
    ```
    Esto te dará la URL maliciosa para enviar a la víctima.

5.  **Monitorear las Sesiones Capturadas:**
    ```bash
    > sessions
    ```
    Este comando mostrará una tabla con las credenciales y las cookies de sesión que han sido capturadas.

## Consideraciones Adicionales

*   **Escrito en Go:** Evilginx2 es un binario único escrito en Go, lo que lo hace muy rápido y fácil de desplegar sin dependencias.
*   **Certificados SSL:** La herramienta gestiona automáticamente la obtención de certificados SSL/TLS para los dominios de phishing utilizando Let's Encrypt, haciendo que los sitios falsos parezcan aún más legítimos con el candado de HTTPS.
*   **Mitigación:** La única forma efectiva de protección contra este tipo de ataques es usar **estándares de 2FA resistentes al phishing**, como las llaves de seguridad de hardware **FIDO2/WebAuthn** (por ejemplo, YubiKey). Estos protocolos vinculan criptográficamente la autenticación al dominio real, por lo que el intento de inicio de sesión en el dominio de phishing fallaría.

---
*Nota: Esta información se proporciona con fines estrictamente educativos para comprender los ataques de phishing modernos. No intentes replicar estos ataques fuera de un entorno de pruebas de penetración legal y autorizado.*
