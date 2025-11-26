# cloudflared

## ¿Qué es cloudflared?

`cloudflared` es el demonio y la herramienta de línea de comandos que impulsa los **Túneles de Cloudflare (Cloudflare Tunnels)**. Es una pieza de software que se instala en tu servidor o máquina local y crea una conexión saliente segura y persistente entre tu máquina y la red global de Cloudflare.

Su propósito fundamental es permitirte exponer servicios que se ejecutan localmente (como un servidor web, un servicio SSH, etc.) a Internet de forma segura, sin tener que abrir puertos en tu firewall ni exponer directamente tu dirección IP pública.

## ¿Para qué es útil la herramienta?

`cloudflared` es una herramienta extremadamente versátil con beneficios tanto para desarrolladores como para administradores de sistemas y profesionales de la seguridad.

*   **Exponer Servicios Locales de Forma Segura:**
    *   Puedes ejecutar un servidor de desarrollo web en tu portátil y hacerlo accesible a través de un dominio público `https://tunel-temporal.try.cloudflare.com` para mostrar tu trabajo a un cliente o a un compañero de equipo.
    *   Puedes auto-alojar (self-host) una aplicación web en un servidor en tu casa (como una Raspberry Pi) y hacerla accesible de forma segura y robusta a través de tu propio dominio, aprovechando toda la protección de Cloudflare.

*   **Ocultar la IP de Origen:** Al enrutar todo el tráfico a través de Cloudflare, la dirección IP real de tu servidor nunca se expone al público, protegiéndote de ataques directos, escaneos de puertos y ataques de denegación de servicio (DDoS).

*   **Simplificar la Configuración de Red (Zero Trust):**
    *   Elimina la necesidad de configurar reglas complejas de reenvío de puertos (port forwarding) en tu router.
    *   No necesitas una IP pública estática. Funciona perfectamente con conexiones a internet domésticas que tienen IPs dinámicas.
    *   Permite crear accesos seguros a recursos internos (SSH, RDP, bases de datos) sin necesidad de una VPN tradicional, aplicando políticas de acceso basadas en la identidad.

## ¿Cómo funciona?

1.  **Instalación:** Instalas el demonio `cloudflared` en la máquina donde se ejecuta el servicio que quieres exponer (por ejemplo, tu servidor web que escucha en `localhost:8000`).
2.  **Conexión Saliente:** `cloudflared` establece varias conexiones salientes y persistentes con los centros de datos más cercanos de Cloudflare. Debido a que la conexión se inicia desde tu servidor hacia afuera, no se necesita abrir ningún puerto de entrada en tu firewall.
3.  **Enrutamiento de Tráfico:** Cuando un usuario visita el dominio que has configurado (por ejemplo, `mi-app.com`), la solicitud llega primero a la red de Cloudflare.
4.  **Túnel:** Cloudflare enruta esa solicitud a través del túnel seguro que `cloudflared` ha establecido, y la reenvía a tu servicio local (por ejemplo, a `localhost:8000`).
5.  **Respuesta:** La respuesta de tu servicio local viaja de vuelta por el túnel a Cloudflare, que a su vez la entrega al usuario final.

Todo este proceso es transparente para el usuario final, que simplemente interactúa con un sitio web normal y seguro (HTTPS).

## ¿Cómo se usa? (Ejemplos básicos)

`cloudflared` tiene dos modos principales de uso: túneles rápidos (Quick Tunnels) para pruebas temporales y túneles persistentes (Named Tunnels) para producción.

### Ejemplo 1: Túnel Rápido (Quick Tunnel)

Este es el caso de uso más sencillo para exponer un servicio local temporalmente.

Supongamos que tienes un servidor web de desarrollo escuchando en el puerto `8000`. Con un solo comando, puedes exponerlo a internet:

```bash
cloudflared tunnel --url http://localhost:8000
```

**Salida de ejemplo:**
```
2023-10-27T12:00:00Z INF |  Your quick Tunnel has been created! Visit it at the following address:
2023-10-27T12:00:00Z INF |  https://some-random-name-goes-here.try.cloudflare.com
```
Ahora, cualquiera en el mundo puede acceder a tu servidor local visitando esa URL HTTPS. El túnel se cierra en cuanto detienes el comando.

### Ejemplo 2: Túnel Persistente (Named Tunnel)

Este es el método recomendado para producción. Es más robusto y se configura para que se ejecute como un servicio en segundo plano.

1.  **Autenticar `cloudflared`:**
    ```bash
    cloudflared tunnel login
    ```

2.  **Crear un túnel con un nombre:**
    ```bash
    cloudflared tunnel create mi-tunel-de-produccion
    ```

3.  **Configurar el túnel:**
    Se crea un archivo de configuración (`~/.cloudflared/config.yml` o similar) para decirle al túnel a dónde enrutar el tráfico.

4.  **Enrutar el tráfico DNS:**
    Se le dice a Cloudflare que el tráfico para `mi-app.com` debe ser manejado por este túnel.
    ```bash
    cloudflared tunnel route dns mi-tunel-de-produccion mi-app.com
    ```

5.  **Ejecutar el túnel (como servicio):**
    ```bash
    cloudflared tunnel run mi-tunel-de-produccion
    ```

## Consideraciones Adicionales

*   **Gratuito y de Pago:** El uso básico de Cloudflare Tunnels es gratuito. Las funciones más avanzadas para equipos y empresas pueden requerir un plan de pago.
*   **Seguridad del Túnel:** El túnel en sí está cifrado, y puedes añadir capas adicionales de autenticación (como Google, GitHub, o SSO) antes de que un usuario pueda acceder al servicio, implementando un modelo de seguridad "Zero Trust".

---
*Nota: `cloudflared` es una herramienta oficial de Cloudflare diseñada para mejorar la seguridad. Su configuración y uso adecuados son clave para proteger tu infraestructura.*
