# telegram-desktop

## ¿Qué es?

Cliente oficial de Telegram para escritorio, empaquetado en el repo `x11` de Termux. Corre bajo Termux-X11 (XFCE).

## Síntoma que corrige i-Haklab

Al abrir mini-apps / Bot WebApps (p. ej. @BotFather) en lugar de cargar aparece el error:

> Unfortunately, you can't open this menu with your current system configuration.
> Please install WebKitGTK (webkit2gtk-4.1/webkit2gtk-4.0) using your package manager.

El diálogo queda volcado en `~/tmp/out.txt` y en el log (`~/.local/share/TelegramDesktop/log.txt`) aparece `WebView Error: No library`.

## Causa

*   El paquete `telegram-desktop` **no declara** `webkit2gtk` como dependencia.
*   Termux empaqueta WebKitGTK **sin SONAME versionado** (`libwebkit2gtk-4.1.so` sin `.so.0`), pero Telegram hace `dlopen` de `libwebkit2gtk-4.1.so.0` / `libwebkitgtk-6.0.so.4` → falla aunque WebKit esté instalado.
*   No existen `bubblewrap`/`xdg-dbus-proxy` en los repos Termux y Android bloquea namespaces → el sandbox de WebKit debe desactivarse por variables de entorno.

## ¿Qué hace `pkg2conf telegram-desktop`?

*   Instala `webkit2gtk-4.1` si falta (`dpkg -s` como guarda).
*   Crea los 4 symlinks SONAME idempotentes en `${PREFIX}/lib`.
*   Instala `~/.local/bin/telegram-desktop-x11` (lanzador con `WEBKIT_DISABLE_SANDBOX_THIS_IS_DANGEROUS=1`, `WEBKIT_DISABLE_DMABUF_RENDERER=1`, `GDK_BACKEND=x11`, `QT_QPA_PLATFORM=xcb`).
*   Instala el override `~/.local/share/applications/org.telegram.desktop.desktop` (`Exec=telegram-desktop-x11`) y refresca la base de datos de escritorio.
*   Limpia el marcador `~/tmp/out.txt`.

## ¿Cómo se usa? (Ejemplos básicos)

Tras instalar, **cierra Telegram por completo y reábelo desde el menú Whisker** (no hereda el entorno si ya corría). Luego abre cualquier mini-app: debe cargar en vez del error.

```bash
pkg2conf telegram-desktop   # re-aplica el fix manualmente si hace falta
```

## Consideraciones Adicionales

*   Desactivar el sandbox de WebKit reduce su aislamiento: úsalo para Telegram, no como ajuste global.
*   Las WebApps pesadas con WebGL/WASM (p. ej. apps Flet/Flutter a pantalla completa) pueden quedar en negro sobre llvmpipe; para el bot propio se recomienda exponer una ruta HTML ligera con `Telegram.WebApp.openLink()` hacia el contenido pesado.

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
