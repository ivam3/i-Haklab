# ttyd

## ¿Qué es ttyd?

`ttyd` es una herramienta que comparte tu terminal a través de la web. Convierte el comando que especifiques (tu shell, por ejemplo) en una terminal interactiva accesible desde el navegador usando HTTP/HTTPS y WebSockets. No usa protocolo SSH: es una página web que renderiza la terminal en tiempo real.

## ¿Para qué es útil en i-Haklab?

*   **Terminal web local:** Abre tu shell (la que uses, detectada vía `$SHELL`) en `http://127.0.0.1:<puerto>` para usarla desde otro navegador o dispositivo en tu misma red.
*   **Acceso remoto WAN:** Combinado con `cloudflared` obtienes una URL pública `https://...trycloudflare.com` con cifrado SSL, sin abrir puertos ni configurar port forwarding.
*   **Solución a `tmate` E:503:** Es el reemplazo de la capa HTTPS de tmate.io, que devuelve `503 No server is available to handle this request` por saturación de sus servidores web públicos.

## Cómo se usa en i-Haklab

i-Haklab añade dos modos cómodos, `--local` y `--remote`; cualquier otro uso funciona igual que el `ttyd` original.

### Ejemplo 1: Terminal web local

```bash
ttyd --local
```

Busca un puerto libre y levanta la terminal en:

```
http://127.0.0.1:<puerto>
```

### Ejemplo 2: Terminal web pública (WAN con cloudflared)

```bash
ttyd --remote
```

1. Revisa que `cloudflared` esté instalado (y te avisa si falta).
2. Levanta la terminal en un puerto libre.
3. Crea el túnel público hacia ese puerto.
4. Te muestra la URL pública `https://...trycloudflare.com` lista para abrir.

```
(_➤) Terminal web pública:
 ╰─➤ https://tunnel-glasses-predict-adopted.trycloudflare.com
```

### Ejemplo 3: Uso directo del binario real

```bash
ttyd -p 8080 bash
```

Todo lo que no sea `--local`/`-l` o `--remote`/`-r` funciona igual que el `ttyd` original.

## Notas

*   **Shell:** se usa tu shell habitual (bash, zsh o fish).
*   **Escritura:** la terminal web permite escribir (modo writable); sin eso solo podrías mirar.
*   **Carpeta inicial:** siempre abre en tu home, la ejecutes desde donde la ejecutes.
*   **Puerto:** se busca uno libre automáticamente (requiere `nmap`).
*   **Túnel sin cuenta:** los túneles *quick* de Cloudflare no tienen garantía de uptime; para producción se recomienda un *named tunnel*.
*   **Detener:** `Ctrl+C` mata tanto `ttyd` como `cloudflared`.

---
*Nota: `ttyd` es una herramienta oficial open source para compartir terminales web. `cloudflared` es el demonio oficial de Cloudflare Tunnels.*

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
