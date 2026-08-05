# ttyd

## ¿Qué es ttyd?

`ttyd` es una herramienta que comparte tu terminal a través de la web. Convierte el comando que especifiques (tu shell, por ejemplo) en una terminal interactiva accesible desde el navegador usando HTTP/HTTPS y WebSockets. No usa protocolo SSH: es una página web que renderiza la terminal en tiempo real.

## ¿Para qué es útil en i-Haklab?

*   **Terminal web local:** Abre tu shell (la que uses, detectada vía `$SHELL`) en `http://127.0.0.1:<puerto>` para usarla desde otro navegador o dispositivo en tu misma red.
*   **Acceso remoto WAN:** Combinado con `cloudflared` obtienes una URL pública `https://...trycloudflare.com` con cifrado SSL, sin abrir puertos ni configurar port forwarding.
*   **Solución a `tmate` E:503:** Es el reemplazo de la capa HTTPS de tmate.io, que devuelve `503 No server is available to handle this request` por saturación de sus servidores web públicos.

## Cómo se usa en i-Haklab

El wrapper `ttyd` de i-Haklab intercepta los modos `--local` y `--remote`; cualquier otro argumento pasa directo al binario real `$PREFIX/bin/ttyd`.

### Ejemplo 1: Terminal web local

```bash
ttyd --local
```

Obtiene un puerto libre con la función `getPORT` y levanta la terminal en:

```
http://127.0.0.1:<puerto>
```

### Ejemplo 2: Terminal web pública (WAN con cloudflared)

```bash
ttyd --remote
```

1. Valida que `cloudflared` esté instalado (`chk-pkg cloudflared cloudflared`).
2. Levanta `ttyd` en background sobre el puerto libre.
3. Lanza `cloudflared tunnel --url http://127.0.0.1:<puerto>` en background.
4. Filtra de sus logs la URL pública `https://...trycloudflare.com` y la muestra en la salida estándar.

```
(_➤) Terminal web pública:
 ╰─➤ https://tunnel-glasses-predict-adopted.trycloudflare.com
```

### Ejemplo 3: Uso directo del binario real

```bash
ttyd -p 8080 bash
```

Cualquier invocación que no sea `--local`/`-l` o `--remote`/`-r` se reenvía tal cual a `$PREFIX/bin/ttyd`.

## Notas

*   **Shell:** el wrapper usa `$SHELL` del usuario (bash, zsh o fish según su configuración).
*   **Writable:** el wrapper lanza `ttyd` con `-W` (modo writable), necesario para poder escribir en la terminal desde el navegador. Sin `-W`, ttyd arranca en readonly y no se puede teclear.
*   **Directorio de trabajo:** se fija a `$HOME` con `-w` para que la shell abra siempre en el home, sin importar desde dónde se invoque el wrapper.
*   **Puerto:** se obtiene con la función `getPORT` de i-Haklab (requiere `nmap`).
*   **Túnel sin cuenta:** los túneles *quick* de Cloudflare no tienen garantía de uptime; para producción se recomienda un *named tunnel*.
*   **Detener:** `Ctrl+C` mata tanto `ttyd` como `cloudflared`.

---
*Nota: `ttyd` es una herramienta oficial open source para compartir terminales web. `cloudflared` es el demonio oficial de Cloudflare Tunnels.*
