# Herdr (herdrdev/herdr)

## ¿Qué es Herdr?

**Herdr** (`herdrdev/herdr`) es el runtime donde viven tus agentes de codificación con IA. Es un gestor de workspaces en terminal (TUI) que organiza tus sesiones en espacios de trabajo, tabs y panes persistentes, con servidor en segundo plano y clientes ligeros. Está escrito en Rust, usa `libghostty-vt` para renderizar terminales y expone una API por socket para orquestar agentes (Claude Code, Codex, OpenCode, Pi, OMP, Copilot, Hermes, etc.) desde CLI o plugins. En Termux se distribuye como binario estático `linux-aarch64` y se instala en `$PREFIX/bin/herdr`.

## ¿Para qué es útil la herramienta?

Herdr resuelve el caos de múltiples agentes en paralelo, siendo ideal para:

*   **Workspaces persistentes:** Cada workspace agrupa repo/rama/cwd; tabs y panes sobreviven a desconexiones y se restauran tras reinicio (`resume_agents_on_restore`).
*   **Multiplexado de terminal:** Split, zoom, swap, scrollback, copy-mode, gráficas kitty y redibujado eficiente para sesiones con muchos panes ocupados.
*   **Orquestación de agentes:** Detecta estado (idle/working/blocked), inicia/inyecta prompts (`herdr agent start/prompt/send-keys/wait`), gestiona integraciones (`herdr integration install <agent>`) y sesiones nativas (`--resume`).
*   **Control remoto y plugin:** Soporta `herdr --remote <ssh-target>` con keepalive SSH, live handoff en `herdr update`, API socket (`herdr api`, `herdr pane ...`, `herdr workspace ...`) y sistema de plugins con hooks/eventos.
*   **TUI productivo:** Navegador de sesiones (`prefix+g`), sidebar colapsable, status indicators y notificaciones (toast/sonido) sin spinner continuo.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado vía `apt install herdr` (deb `aarch64` estricto, postinst descarga siempre `latest` estable desde `https://herdr.dev/latest.json` con verificación SHA-256), úsalo así:

**Ejemplo 1: Iniciar o adjuntar sesión persistente**

```bash
herdr
# o con nombre
herdr --session mi-proyecto
```

**Ejemplo 2: Ver estado y versión**

```bash
herdr --version          # p.ej. herdr 0.8.2
herdr status server
herdr status client
```

**Ejemplo 3: Trabajar con panes y agentes**

```bash
# dividir pane actual y lanzar un agente
herdr pane split --current
herdr agent start --pane w1:p1 -- claude --resume <id>

# inyectar prompt a agente vivo
herdr agent prompt <agent|pane> "explica este repo y propón refactor"

# leer/escribir en panes
herdr pane read w1:p1
herdr pane send-keys w1:p1 "ls -la"
```

**Ejemplo 4: Actualizar y gestionar canal**

```bash
herdr update                 # descarga y verifica SHA-256 del release
herdr update --handoff       # live handoff si el servidor lo soporta
herdr channel set stable
herdr channel set preview
```

**Ejemplo 5: Remoto vía SSH**

```bash
herdr --remote usuario@host --session prod
```

## Consideraciones Adicionales

*   **Instalación en Termux:** Paquete `.deb` `aarch64` estricto en `ivam3/termux-packages`. `preinst` verifica que no seas root y limpia clon legacy `~/.local/share/herdr` (plantilla python); `postinst` detecta `linux-aarch64` (`uname -s`/`uname -m`), descarga `herdr-linux-aarch64` desde `herdr.dev/latest.json` (parsing con `awk` sin `jq`), verifica `SHA-256` (`sha256sum`/`shasum`/`openssl`), instala en `$PREFIX/bin/herdr` (`chmod +x`) y deja `fixer` en `$PREFIX/bin/fixer`. No requiere `glibc` (binario estáticamente enlazado, válido para Android Bionic).
*   **Dependencias del paquete:** `curl`, `coreutils`, `gawk` (para `curl`/`awk`/`sha256sum`). Sin `git`/`python`.
*   **Siempre latest:** Cada `apt install`/`postinst` consulta `https://herdr.dev/latest.json` (hoy `0.8.2`) y usa `assets.linux-aarch64` + `sha256.linux-aarch64`; `herdr update` usa el mismo manifest.
*   **Desinstalación:** `prerm` pregunta `[Y/n]` antes de borrar datos de usuario (`~/.config/herdr`, `~/.local/share/herdr`, `~/.cache/herdr`); `postrm` borra `$PREFIX/bin/herdr` (instalado por `postinst`, no trackeado por dpkg). `fixer` se conserva (compartido con otros paquetes ivam3).
*   **Fallback cargo (solo si herdr.dev/GitHub bloqueados o build custom):** Upstream `git clone https://github.com/herdrdev/herdr && cargo build --release` falla en Termux por `build.rs:zig_target()` que solo mapea `aarch64-unknown-linux-gnu` (no `aarch64-linux-android`). Usa:
    ```bash
    pkg install rust zig
    git clone https://github.com/herdrdev/herdr && cd herdr
    rustup target add aarch64-unknown-linux-gnu
    cargo build --target aarch64-unknown-linux-gnu --release
    cp target/aarch64-unknown-linux-gnu/release/herdr $PREFIX/bin/herdr
    ```
    Requiere `zig 0.16+` para compilar `vendor/libghostty-vt` y genera binario dinámico vs el estático del release.
*   **Config y skill:** `herdr --default-config`, `herdr --skill` (skill para agentes), `~/.config/herdr/config.toml`.

---
*Nota: Esta herramienta integra el runtime de agentes para multiplexar terminales y orquestar IA en el ecosistema i-Haklab/Termux.*
