
# GoPhish

## ¿Qué es GoPhish?

GoPhish es un framework de phishing de código abierto y de código abierto diseñado para simular ataques de phishing en el mundo real. Desarrollado en Go (Golang), proporciona una plataforma sencilla y completa para que las organizaciones y profesionales de la seguridad puedan probar la resiliencia de sus sistemas y, más importante aún, la conciencia de seguridad de sus empleados frente a ataques de ingeniería social.

GoPhish se ejecuta como un servidor web con una interfaz de usuario intuitiva que permite diseñar, lanzar y rastrear campañas de phishing.

## ¿Para qué es útil la herramienta?

GoPhish es una herramienta invaluable en el ámbito de la ciberseguridad, principalmente para:

-   **Simulación de Phishing Ético:** Permite a las empresas realizar pruebas de phishing controladas para identificar vulnerabilidades en sus procesos y en la formación de sus empleados.
-   **Entrenamiento y Concienciación:** Al simular ataques reales, ayuda a educar a los usuarios sobre cómo identificar correos electrónicos maliciosos y otras tácticas de ingeniería social.
-   **Evaluación de Controles de Seguridad:** Probar la eficacia de los filtros de correo electrónico, sistemas de detección de intrusiones y otras defensas técnicas contra ataques de phishing.
-   **Análisis Post-Campaña:** Ofrece métricas detalladas sobre la campaña, como cuántos usuarios abrieron el correo, hicieron clic en enlaces, y si introdujeron credenciales.

## ¿Cómo se usa?

El uso de GoPhish implica una serie de pasos para configurar y lanzar una campaña de phishing.

### 1. Instalación

1.  **Descargar:** Descarga los binarios precompilados para tu sistema operativo (Windows, Linux, macOS) desde el sitio web oficial de GoPhish o su repositorio de GitHub.
2.  **Descomprimir:** Descomprime el archivo descargado.
3.  **Ejecutar:** Abre una terminal o línea de comandos en el directorio donde descomprimiste GoPhish y ejecuta el binario (por ejemplo, `./gophish` en Linux/macOS o `gophish.exe` en Windows).
4.  **Acceder a la Interfaz Web:** GoPhish se ejecutará en segundo plano y te proporcionará una URL (normalmente `https://localhost:3333`) y credenciales temporales (usuario y contraseña) para acceder a su interfaz de administración web.

### 2. Configuración de una Campaña (Pasos en la interfaz web)

Una vez en la interfaz web de GoPhish, los pasos para crear una campaña son los siguientes:

1.  **Perfiles de Envío (Sending Profiles):** Configura los detalles de un servidor SMTP (puede ser un servicio de correo legítimo o uno configurado para pruebas) que GoPhish utilizará para enviar los correos electrónicos de phishing.
    -   Navega a `Sending Profiles` y haz clic en `New Profile`.
    -   Introduce el `Name`, `From` (dirección de correo del remitente), `Host` (servidor SMTP), `Username`, `Password`, y selecciona el `Encrypt` (normalmente TLS).

2.  **Grupos de Usuarios (Users & Groups):** Crea grupos de usuarios a los que se dirigirá la campaña. Puedes añadir usuarios manualmente o importarlos desde un archivo CSV.
    -   Navega a `Users & Groups` y haz clic en `New Group`.
    -   Añade `First Name`, `Last Name`, `Email` y `Position` para cada usuario.

3.  **Plantillas de Correo Electrónico (Email Templates):** Diseña el correo electrónico de phishing. Puedes importar el contenido de un correo electrónico real o crearlo desde cero.
    -   Navega a `Email Templates` y haz clic en `New Template`.
    -   Introduce un `Name`, `Subject` y el `HTML` del correo. Es crucial incluir el marcador de posición `{{.URL}}` en el enlace de phishing para que GoPhish lo reemplace con la URL de la página de aterrizaje.

4.  **Páginas de Aterrizaje (Landing Pages):** Configura la página web falsa a la que los usuarios serán redirigidos si hacen clic en el enlace de phishing.
    -   Navega a `Landing Pages` y haz clic en `New Page`.
    -   Introduce un `Name` y el `HTML` de la página. Puedes marcar la opción `Capture Submitted Credentials` si la página tiene un formulario de inicio de sesión.

5.  **Campañas (Campaigns):** Une todos los componentes anteriores para lanzar la campaña.
    -   Navega a `Campaigns` y haz clic en `New Campaign`.
    -   Introduce un `Name`, selecciona la `Email Template`, `Landing Page`, `URL` (la dirección donde se alojará tu servidor GoPhish), `Sending Profile` y `User Group`.
    -   Haz clic en `Launch Campaign`.

### 3. Seguimiento de Resultados

Una vez lanzada, GoPhish te proporcionará un panel de control con estadísticas en tiempo real sobre el progreso de la campaña, incluyendo:

-   Correos enviados.
-   Correos abiertos.
-   Clics en enlaces.
-   Credenciales capturadas.
-   Correos reportados por los usuarios.

## Otras consideraciones

-   **Ética y Legalidad:** Es fundamental recordar que GoPhish es una herramienta de seguridad que debe utilizarse **siempre con el consentimiento expreso y por escrito** de la organización y los individuos involucrados. El uso no autorizado de GoPhish para fines maliciosos es ilegal y puede tener graves consecuencias.
-   **Certificados SSL:** Para que las campañas parezcan más legítimas, es recomendable configurar GoPhish con un certificado SSL válido para su servidor web.
-   **Evasión de Defensas:** Las plantillas de correo y las páginas de aterrizaje deben diseñarse cuidadosamente para evitar ser detectadas por los filtros de spam y las defensas de seguridad del correo electrónico.
