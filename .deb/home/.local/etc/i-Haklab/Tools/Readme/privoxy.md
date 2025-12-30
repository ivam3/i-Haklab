# privoxy

## ¿Qué es privoxy?

Privoxy es un proxy web no-caché (non-caching web proxy) con capacidades avanzadas de filtrado para mejorar la privacidad, modificar datos de páginas web y encabezados HTTP, controlar el acceso y eliminar anuncios y otra basura de Internet. A diferencia de otros proxies, su foco principal es la privacidad y el control del usuario sobre el contenido web.

## ¿Para qué es útil la herramienta?

Privoxy se utiliza principalmente para:

*   **Bloqueo de Publicidad:** Eliminar banners, pop-ups y rastreadores web antes de que lleguen al navegador.
*   **Mejora de la Privacidad:** Ocultar información del usuario (User-Agent, Referer) y gestionar cookies de forma avanzada.
*   **Intermediario para Tor:** A menudo se usa (o se usaba) junto con Tor para redirigir tráfico web que no soporta SOCKS directamente, aunque los navegadores modernos ya manejan SOCKS mejor.
*   **Reescritura de Contenido:** Modificar el código HTML de las páginas web al vuelo para eliminar elementos molestos o inseguros.

## ¿Cómo se usa? (Ejemplos básicos)

Privoxy funciona como un servicio en segundo plano.

**Ejemplo 1: Iniciar el servicio**

```bash
privoxy /ruta/a/config
# O simplemente como servicio:
service privoxy start
```

**Ejemplo 2: Configuración del Navegador**

Para que funcione, debes configurar tu navegador para que use el proxy de Privoxy.
*   **IP:** 127.0.0.1 (localhost)
*   **Puerto:** 8118 (por defecto)

**Ejemplo 3: Encadenamiento con Tor (Chainloading)**

Para enviar tráfico a través de la red Tor, se edita el archivo de configuración (`config`) de Privoxy añadiendo:

```text
forward-socks5t / 127.0.0.1:9050 .
```
Esto le dice a Privoxy que reenvíe todo el tráfico al puerto SOCKS de Tor.

**Ejemplo 4: Acceder a la interfaz de control**

Privoxy tiene una interfaz web interna para ver su estado y configuración. Navega a:
`http://p.p/` o `http://config.privoxy.org/` (Solo accesible si estás usando el proxy).

## Consideraciones Adicionales

*   **Configuración:** La potencia de Privoxy reside en sus archivos de "acciones" (`*.action`) y filtros (`*.filter`), que permiten reglas muy granulares por dominio.
*   **Rendimiento:** Al filtrar contenido, puede ralentizar ligeramente la navegación, pero a menudo la acelera al bloquear la descarga de publicidad pesada.

---
*Nota: Es una herramienta poderosa para usuarios avanzados que desean control total sobre lo que entra y sale de su navegador.*
