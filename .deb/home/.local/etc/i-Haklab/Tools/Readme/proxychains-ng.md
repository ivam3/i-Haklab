# proxychains-ng

## ¿Qué es proxychains-ng?

`proxychains-ng` (ProxyChains Next Generation) es una herramienta de línea de comandos para sistemas tipo UNIX. Permite forzar que cualquier conexión TCP realizada por una aplicación específica pase a través de una serie de proxies (como SOCKS4, SOCKS5, HTTP o HTTPS). Es la evolución y continuación mantenida del proyecto original `proxychains`.

## ¿Para qué es útil la herramienta?

Es una herramienta esencial en el arsenal de privacidad y seguridad para:

*   **Anonimato:** Ocultar la dirección IP real del usuario enrutando el tráfico a través de múltiples nodos (ej. Tor).
*   **Evasión de Firewalls:** Acceder a servicios bloqueados en una red local pasando a través de un proxy externo.
*   **Pentesting:** Ejecutar herramientas de escaneo (como Nmap) o ataque de forma anónima o pivotando a través de máquinas comprometidas.
*   **Forzar Proxies:** Usar proxies con aplicaciones que no tienen soporte nativo para configuración de proxy.

## ¿Cómo se usa? (Ejemplos básicos)

El uso básico consiste en anteponer `proxychains4` al comando que quieres ejecutar.

**Ejemplo 1: Ejecutar un comando a través de Tor**

Asumiendo que Tor está corriendo en `127.0.0.1:9050` y configurado en `proxychains.conf`:

```bash
proxychains4 curl ifconfig.me
```
Esto mostrará la IP de salida de la red Tor, no tu IP real.

**Ejemplo 2: Escaneo con Nmap anónimo**

```bash
proxychains4 nmap -sT -Pn google.com
```
*Nota: Nmap requiere escaneo TCP completo (`-sT`) a través de proxies, ya que el escaneo SYN (`-sS`) no suele funcionar.*

**Ejemplo 3: Abrir una shell proxificada**

```bash
proxychains4 bash
```
Cualquier comando ejecutado dentro de esta nueva shell pasará por los proxies configurados.

## Consideraciones Adicionales

*   **Configuración:** El archivo clave es `/etc/proxychains.conf` (o `proxychains.conf` en el directorio actual). Aquí se definen los proxies y el modo de encadenamiento:
    *   `dynamic_chain`: Salta proxies caídos (recomendado).
    *   `strict_chain`: Falla si un proxy cae.
    *   `random_chain`: Usa proxies aleatorios de la lista.
*   **DNS:** Proxychains intenta resolver nombres de dominio a través del proxy (proxy_dns) para evitar fugas de DNS, lo cual es crucial para el anonimato real.
*   **UDP:** Históricamente solo soportaba TCP. Versiones muy recientes tienen soporte experimental para UDP, pero la fiabilidad varía.

---
*Nota: Es vital verificar la configuración antes de operaciones sensibles para asegurar que el tráfico realmente está siendo enrutado.*
