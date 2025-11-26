
# ngrok

## ¿Qué es ngrok?

`ngrok` es una herramienta multiplataforma que crea túneles seguros y temporales desde tu máquina local hacia Internet. Esto permite exponer un servidor de desarrollo local, una aplicación web, una API o cualquier servicio que se ejecute en tu máquina a una URL pública de Internet. `ngrok` es especialmente útil cuando necesitas que servicios externos (como webhooks, APIs de terceros o usuarios remotos) interactúen con tu entorno de desarrollo local.

Funciona estableciendo una conexión segura entre tu máquina local y los servidores de `ngrok` en la nube. Todo el tráfico hacia la URL pública de `ngrok` se reenvía a través de este túnel a un puerto específico en tu máquina.

## ¿Para qué es útil la herramienta?

`ngrok` es una herramienta esencial para desarrolladores, pentesters y cualquier persona que necesite exponer temporalmente un servicio local a Internet:

-   **Pruebas de Webhooks:** Es invaluable para probar servicios que dependen de webhooks (ej. pasarelas de pago, APIs de comunicación, integraciones con GitHub, Slack), ya que estos servicios necesitan enviar datos a una URL pública.
-   **Compartir Demos y Desarrollo:** Permite compartir fácilmente tu trabajo local con clientes o compañeros de equipo para demostraciones, obtener feedback o colaborar, sin necesidad de desplegar la aplicación en un servidor de staging.
-   **Desarrollo y Pruebas de API:** Facilita las pruebas de APIs que se ejecutan localmente, permitiendo que otras aplicaciones o clientes las consuman desde Internet.
-   **Pruebas de Aplicaciones Móviles:** Los desarrolladores pueden probar sus aplicaciones móviles contra un backend que se ejecuta localmente.
-   **Acceso Remoto a Servicios Locales:** Puedes acceder a herramientas o servicios internos que se ejecutan en tu máquina local desde cualquier lugar con conexión a Internet.
-   **Inspección de Tráfico:** `ngrok` proporciona una interfaz web local (generalmente en `http://localhost:4040`) para inspeccionar en tiempo real las peticiones y respuestas que pasan por el túnel, lo que es muy útil para depurar.

## ¿Cómo se usa?

`ngrok` es una herramienta de línea de comandos.

### 1. Instalación y Configuración

1.  **Descargar `ngrok`:**
    Visita el sitio web oficial de `ngrok` ([ngrok.com](https://ngrok.com/)) y descarga el binario para tu sistema operativo (Windows, Linux, macOS).

2.  **Instalar `ngrok`:**
    Descomprime el archivo descargado en una ubicación conveniente de tu sistema. Para mayor facilidad, puedes añadir el directorio donde lo descomprimiste a la variable de entorno `PATH` de tu sistema.

3.  **Conectar tu cuenta (Autenticación):**
    -   Crea una cuenta gratuita en `ngrok.com`.
    -   En el panel de control de `ngrok`, encontrarás tu "authtoken" (token de autenticación).
    -   En tu terminal, ejecuta el siguiente comando para añadir tu token de autenticación. Esto registrará el token en tu sistema para usos futuros.
        ```bash
        ngrok config add-authtoken <TU_TOKEN_DE_AUTENTICACION>
        ```
        (Reemplaza `<TU_TOKEN_DE_AUTENTICACION>` con el token real de tu cuenta).

### 2. Uso Básico (Exponer un Servicio Local)

1.  **Asegúrate de que tu servicio local esté en ejecución:**
    Verifica que tu aplicación web, API o servicio se esté ejecutando en un puerto específico de tu máquina local (ej. `http://localhost:8000` o `http://localhost:3000`).

2.  **Exponer el puerto con `ngrok`:**
    Abre tu terminal y ejecuta `ngrok` especificando el protocolo y el puerto de tu servicio local.

    ```bash
    ngrok http 8000
    ```
    (Reemplaza `8000` con el puerto en el que se ejecuta tu servicio).

    `ngrok` mostrará información sobre el túnel, incluyendo la URL pública (HTTP y HTTPS) que ahora apunta a tu servicio local.

### 3. Opciones Comunes

-   `ngrok http <puerto>`: Crea un túnel HTTP/HTTPS al puerto especificado.
-   `ngrok tcp <puerto>`: Crea un túnel TCP para servicios que no son HTTP (ej. SSH, RDP).
-   `ngrok tls <puerto>`: Crea un túnel TLS para servicios TLS/SSL.
-   `--region <región>`: Especifica la región del servidor `ngrok` a utilizar (ej. `us`, `eu`, `ap`).
-   `--subdomain <nombre>`: (Requiere una cuenta de pago) Permite solicitar un subdominio personalizado para tu URL pública (ej. `mi-app.ngrok.io`).
-   `--auth <usuario:contraseña>`: Protege tu túnel con autenticación básica HTTP.

### 4. Interfaz de Inspección Web

Mientras `ngrok` se ejecuta, puedes abrir tu navegador web y visitar `http://localhost:4040` (o el puerto que `ngrok` te indique) para ver una interfaz de inspección. Esta interfaz te permite ver todas las peticiones y respuestas que pasan por tu túnel, facilitando la depuración y el monitoreo del tráfico.

## Otras Consideraciones

-   **Seguridad:** Al exponer un servicio local a Internet, estás abriendo un posible punto de entrada a tu máquina. Asegúrate de que el servicio que expones sea seguro y de que entiendes los riesgos. Evita exponer servicios sensibles o datos de producción.
-   **Duración del Túnel:** Los túneles de la versión gratuita de `ngrok` son temporales y cambiarán la URL pública cada vez que inicies un nuevo túnel.
-   **Uso Ético:** Usa `ngrok` de manera ética y responsable, solo con tus propios servicios o con el permiso explícito.
