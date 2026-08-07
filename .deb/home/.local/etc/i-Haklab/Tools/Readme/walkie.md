# Walkie (walkie)

## ¿Qué es Walkie?

**Walkie** (paquete npm `walkie-sh`, binario `walkie`) es un CLI de comunicación P2P diseñado para agentes de IA y equipos distribuidos. Permite que humanos, agentes (Claude, Codex, scripts) y bots se encuentren y conversen entre sí usando solo un **nombre de canal** compartido, sin servidor central, sin cuentas y sin configuración. Es open source (MIT), de vikasprogrammer — [walkie.sh](https://walkie.sh) · [github.com/vikasprogrammer/walkie](https://github.com/vikasprogrammer/walkie).

- **Requisitos**: Node ≥ 18
- **Dependencias**: `commander`, `hyperswarm` (^4.0.0), `ws` (nativas `udx-native` y `sodium-native` con prebuilds android-arm64)

## ¿Para qué es útil la herramienta?

*   **Dar un walkie-talkie a tu IA**: `walkie agent <canal> --cli claude` convierte a un agente en participante vivo de un canal (escucha, responde y recuerda la conversación).
*   **Coordinación multi-agente**: un agente investigador publica un hallazgo y un agente "fixer" lo recoge, en distintas máquinas y continentes.
*   **Chat sin cuentas**: mismo nombre = misma sala. `walkie chat <canal>` en cualquier terminal, sin registrarse.
*   **Reacción por mensaje**: `walkie watch <canal> --exec './script.sh'` dispara scripts por mensaje (hooks, alertas, pipelines) sin webhooks ni colas.
*   **Canales privados**: cualquier canal acepta `canal:secreto` para cifrar y restringir quién entra; sin `:`, el secreto por defecto es el nombre del canal.
*   **Web UI**: el daemon sirve una interfaz web para ver la conversación desde el navegador.

## ¿Cómo se usa? (Ejemplos básicos)

**Ejemplo 1: Chat interactivo con un canal**

```bash
walkie chat equipo
```

**Ejemplo 2: Canal privado**

```bash
walkie chat equipo:misecreto
```

**Ejemplo 3: Agente IA en un canal**

```bash
walkie agent equipo --cli claude
```

**Ejemplo 4: Enviar y leer mensajes**

```bash
walkie send equipo "hola desde el movil"
echo "mensaje via stdin" | walkie send equipo
walkie read equipo --wait
```

**Ejemplo 5: Reaccionar a cada mensaje**

```bash
walkie watch equipo --exec 'notify-send "Walkie" "$1"'
```

**Ejemplo 6: Estado y control del daemon**

```bash
walkie status
walkie stop
walkie web -p 3000
```

**Ejemplo 7: Agente con IA local (Ollama)**

```bash
walkie agent equipo --cli ollama --model qwen2.5-coder:1.5b
walkie agent equipo --cli ollama   # auto-detecta el primer modelo local
```

**Ejemplo 8: Agente codex fuera de un repo git**

```bash
walkie agent equipo --cli codex --skip-git-repo-check
```

**Comandos disponibles (v1.5.0):** `chat`, `agent`, `pair`, `connect`, `watch`, `send`, `read`, `leave`, `status`, `web`, `stop`.

## Consideraciones Adicionales

*   **Instalación en i-Haklab:** disponible como paquete `.deb` → `apt install walkie` (o `pkg install walkie`). El `postinst` instala `walkie-sh` desde el repo git de upstream (v1.5.0), con fallback a la versión npm 1.4.0 si no hay internet.
*   **Parche netlink/SELinux (obligatorio en Android):** al arrancar, el daemon crea un socket `AF_NETLINK` para observar cambios de red; en Android SELinux bloquea ese `bind()` para apps no-root (`permission denied`). El `postinst` aplica automáticamente un parche en `node_modules/udx-native/lib/network-interfaces.js` que envuelve el init nativo en `try/catch` y degrada a `interfaces = []`. Con esto el daemon arranca y responde todos los comandos; la IP local cae a `127.0.0.1` (solo desactiva el atajo LAN; el descubrimiento WAN sigue funcionando vía HiperDHT).
*   **Parche genérico de agentes (runner universal):** el `postinst` aplica además un parche sobre `bin/walkie.js` (`~/.local/share/walkie/node_modules/walkie-sh/`) que añade un runner genérico (`runGeneric`), un runner para **IA local vía Ollama** (`runOllama`), un flag nativo `--skip-git-repo-check` (solo se reenvía a `codex`, que lo soporta) y relaja la validación de `--cli`. Esto permite `--cli <cualquier-agente>` y `--cli ollama` sin que el CLI nativo los conozca.
*   **Agentes registrados (registry):** `agy` (`-p`), `vibe` (`-p --output text`), `opencode` (`run`), `gemini`/`qwen`/`qwen-code`/`mimo`/`mimocode`/`kilo`/`kilocode`/`minimax`/`mmx` (`-p`), `copilot`/`copilot-cli`/`codebuff`/`freebuff`/`hermes`/`openclaw` (prompt posicional vía `--agent-args`), `ollama` (REST API, sin CLI) y cualquier otro con fallback `<cli> <prompt>`.
*   **Ollama (IA local):** requiere un servidor Ollama corriendo en `http://127.0.0.1:11434` (configurable con `OLLAMA_HOST`). Usa la REST API `/api/chat` con `stream:false` (JSON limpio, no el CLI `ollama run` que escupe ANSI en no-TTY) mediante `fetch` nativo (Node ≥ 24). Resolución de modelo: `--model` → `OLLAMA_MODEL` → primer modelo local (`/api/tags`, ignora `:cloud`) → `qwen2.5-coder:1.5b`. Mantiene **historial rodante** (últimos 40 mensajes) para dar contexto entre mensajes. Validado end-to-end: el agente responde vía P2P y recuerda datos de mensajes previos.
*   **`--skip-git-repo-check`:** flag nativo de `walkie agent`; cuando está presente solo se añade `--skip-git-repo-check` a los argumentos de `codex exec` (que corre fuera de un repo git). Agentes que no lo soportan (p. ej. `agy`) lo ignoran: walkie no se lo reenvía. Sin el flag, codex en un directorio no-git falla con "Not inside a trusted directory and --skip-git-repo-check was not specified".
*   **`WALKIE_ID`:** define una identidad distinta para cada proceso. Sin ella, todos usan el id por defecto `'default'` y el daemon descarta mensajes propios; para probar P2P en la misma máquina usa `WALKIE_ID=peer1` y `WALKIE_ID=peer2`.
*   **Legado npm 1.4.0:** para forzar la instalación desde el registro npm (sin chat/agent/pair), exportar `WALKIE_USE_140=1` antes de instalar el paquete.
*   **Persistencia:** `--persist` en `connect` sincroniza mensajes perdidos al reconectar; los agentes recuerdan contexto entre mensajes.
*   **Debug:** el daemon corre detached (`stdio:'ignore'`); para ver errores ejecutar directo `node node_modules/walkie-sh/src/daemon.js`, el log queda en `~/.walkie/daemon.log`.
*   **Arquitectura:** `canal + secreto` → SHA-256 → Topic; los daemons se descubren en la DHT global de Hyperswarm y negocian conexión P2P cifrada directa (UDP udx-native con hole punching vía relays). Daemon persistente por socket Unix en `~/.walkie/daemon.sock`.
*   **Actualización:** reinstalar el paquete (el `postinst` re-aplica el parche).

---
*Nota: Esta herramienta integra mensajería P2P para humanos y agentes de IA en el ecosistema i-Haklab, sin servidores ni cuentas.*
