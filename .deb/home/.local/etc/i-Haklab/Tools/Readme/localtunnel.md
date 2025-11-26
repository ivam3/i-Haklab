
# LocalTunnel

## ¿Qué es LocalTunnel?

LocalTunnel es una herramienta de línea de comandos que permite exponer un servidor web de desarrollo local a Internet. Crea un "túnel" seguro desde tu máquina local a un dominio público (`.loca.lt`), lo que facilita que otras personas accedan a tu aplicación localmente sin necesidad de desplegarla en un servidor remoto o configurar complejos firewalls y DNS.

Es especialmente útil para probar webhooks, compartir demostraciones en vivo con clientes o colaborar con compañeros de equipo en un entorno de desarrollo.

## ¿Para qué es útil la herramienta?

LocalTunnel simplifica el proceso de compartir el trabajo local y probar integraciones que requieren acceso público. Sus principales utilidades son:

-   **Pruebas de Webhooks:** Muchas APIs (como pasarelas de pago o servicios de comunicación) envían notificaciones a través de webhooks. LocalTunnel permite recibir estos webhooks en tu entorno de desarrollo local.
-   **Demostraciones a Clientes:** Puedes mostrar el progreso de una aplicación a clientes o colaboradores sin la necesidad de desplegarla en un entorno de staging.
-   **Colaboración en Desarrollo:** Permite que varios desarrolladores accedan a la instancia local de otro desarrollador para depuración conjunta o pruebas.
-   **Pruebas en Dispositivos Móviles/Externos:** Facilita las pruebas de aplicaciones web en dispositivos móviles o desde una red externa, asegurando que la experiencia es correcta antes del despliegue.
-   **Proyectos de IoT:** Útil para exponer servicios que se ejecutan en dispositivos Raspberry Pi u otros dispositivos IoT en redes locales.

## ¿Cómo se usa?

LocalTunnel es una herramienta basada en Node.js y se instala a través de `npm` (Node Package Manager).

### 1. Instalación

1.  **Instalar Node.js:** Asegúrate de tener Node.js instalado en tu sistema. Puedes descargarlo desde [nodejs.org](https://nodejs.org/).
2.  **Instalar LocalTunnel globalmente:** Abre tu terminal y ejecuta el siguiente comando para instalar LocalTunnel:

    ```bash
    npm install -g localtunnel
    ```
    La opción `-g` lo instala globalmente, haciendo que el comando `lt` esté disponible en cualquier directorio.

### 2. Uso Básico

Una vez instalado, sigue estos pasos:

1.  **Inicia tu aplicación web local:** Asegúrate de que tu servidor web de desarrollo esté funcionando en un puerto específico. Por ejemplo, si tu aplicación se ejecuta en `http://localhost:3000`.

2.  **Expón tu aplicación usando LocalTunnel:** Abre una nueva terminal y ejecuta `lt` especificando el puerto de tu aplicación local.

    ```bash
    lt --port 3000
    ```
    LocalTunnel se conectará a un servidor en la nube y te proporcionará una URL pública (ej. `https://randomstring.loca.lt`). Esta URL ahora apunta a tu servidor local.

3.  **Comparte la URL:** Puedes compartir esta URL con quien necesites que acceda a tu aplicación local.

4.  **Detener LocalTunnel:** Para cerrar el túnel, simplemente presiona `Ctrl + C` en la terminal donde se está ejecutando el comando `lt`.

### 3. Opciones Comunes

-   `--port <puerto>`: **Obligatorio.** Especifica el puerto de tu servidor local.
-   `--subdomain <nombre_subdominio>`: Permite solicitar un subdominio personalizado. Si está disponible, tu URL será `https://<nombre_subdominio>.loca.lt`. Si no está disponible, LocalTunnel te asignará uno aleatorio.

    ```bash
    lt --port 8000 --subdomain mi-app-demo
    ```
-   `--local-host <host_local>`: Si tu aplicación no se ejecuta en `localhost`, puedes especificar un host local diferente.

## Otras Consideraciones

-   **Seguridad:** Ten en cuenta que al exponer tu servidor local a Internet, estás abriendo un posible punto de entrada. Es crucial ser consciente de la seguridad de tu aplicación local y los datos que maneja. No uses LocalTunnel para exponer aplicaciones en entornos de producción con datos sensibles.
-   **HTTPS por Defecto:** LocalTunnel asegura todos los túneles con HTTPS, lo que proporciona una capa básica de seguridad para la comunicación.
-   **No es para Producción:** LocalTunnel está diseñado explícitamente para entornos de desarrollo y pruebas, no para el despliegue de aplicaciones en producción.
