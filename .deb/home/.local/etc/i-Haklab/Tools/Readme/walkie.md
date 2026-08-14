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
*   **`--mention-only`:** flag de `walkie agent` (parche local) que hace responder al agente SOLO cuando lo taggean por nombre (`@nombre`). Sin él, walkie responde también a mensajes sin menciones, lo que dejaría que un agente interfiriera en un chat humano-humano.
*   **`--respond-to <id>`:** flag de `walkie agent` (parche local) que hace responder al agente SOLO a mensajes de ese emisor (p. ej. un ejecutor que solo obedece al brain).
*   **`WALKIE_ID`:** define una identidad distinta para cada proceso. Sin ella, todos usan el id por defecto `'default'` y el daemon descarta mensajes propios; para probar P2P en la misma máquina usa `WALKIE_ID=peer1` y `WALKIE_ID=peer2`.
*   **Legado npm 1.4.0:** para forzar la instalación desde el registro npm (sin chat/agent/pair), exportar `WALKIE_USE_140=1` antes de instalar el paquete.
*   **Persistencia:** `--persist` en `connect` sincroniza mensajes perdidos al reconectar; los agentes recuerdan contexto entre mensajes.
*   **Debug:** el daemon corre detached (`stdio:'ignore'`); para ver errores ejecutar directo `node node_modules/walkie-sh/src/daemon.js`, el log queda en `~/.walkie/daemon.log`.
*   **Arquitectura:** `canal + secreto` → SHA-256 → Topic; los daemons se descubren en la DHT global de Hyperswarm y negocian conexión P2P cifrada directa (UDP udx-native con hole punching vía relays). Daemon persistente por socket Unix en `~/.walkie/daemon.sock`.
*   **Actualización:** reinstalar el paquete (el `postinst` re-aplica el parche). Tras reinstalar, re-aplicar también el parche de solo-tag (ver abajo).

## Modo solo-tag estricto (parche local)

El `walkie agent` stock solo filtra menciones ajenas: si un humano escribe sin `@`, el agente responde igual. Para que los agentes **escuchen sin intervenir** en una conversación humano-humano y solo actúen cuando se les taggea, se aplicó un parche idempotente al bin local:

- **Archivo del parche:** `$PREFIX/share/walkie/patch-mention-only.js`
- **Target:** `~/.local/share/walkie/node_modules/walkie-sh/bin/walkie.js` (el que usa el launcher `$PREFIX/bin/walkie`)
- **Backup:** `walkie.js.bak-mention` (junto al target)
- **Marcador de idempotencia:** `/* walkie-patch-mention */` (2ª corrida = "already applied")

**Lo que añade:**
1. **`--mention-only`** → responde solo si `@<nombre>` aparece en el mensaje.
2. **`--respond-to <id>`** → responde solo si `msg.from === <id>`.
3. **Anti-replay (`START_TS`)** → descarta mensajes con `ts` anterior al arranque del agente; si el daemon se reinicia y reenvía historial, el agente no re-procesa ni re-ejecuta tareas viejas.

**Re-aplicación tras reinstalar/actualizar walkie:**

Desde el paquete `1.5.0-2` el `postinst` aplica este patch automáticamente
(STEP 2.5b, después del parche de runner genérico). Solo hace falta re-aplicarlo
a mano si instalaste walkie por otra vía (npm directo, git):

```bash
node $PREFIX/share/walkie/patch-mention-only.js \
  ~/.local/share/walkie/node_modules/walkie-sh/bin/walkie.js
```

**Validado end-to-end** (canal de prueba con CLI dummy): mensaje humano sin tag → ignorado; `@nombre` → respondido; `--respond-to brain` → ignora a humanos y obedece solo al brain; agente nuevo con historial previo → no reprocesa mensajes viejos.

## Seguimiento de miembros del canal (`--track-members`)

Un agente brain no "ve" quién entra al canal: descarta los anuncios `"X joined"`
junto con todos los mensajes de sistema, así que con varios ejecutores presentes
no sabe a cuál delegar. Un tercer parche idempotente
(`$PREFIX/share/walkie/patch-members.js`, debe correr después de
`patch-agents.js` y `patch-mention-only.js`) añade el flag opt-in:

```bash
walkie agent ops:secret --cli codex --track-members --mention-only \
  --prompt "$(cat ~/.config/walkie/prompt-brain.txt)"
```

**Lo que añade:**
1. Registra **miembros locales** desde los anuncios `joined`/`left` del daemon
   más una consulta `members` al arrancar, y **peers remotos** (otros
   dispositivos) desde el `from` del primer mensaje que envía cada uno.
2. Inyecta el roster en el prompt del agente **solo cuando cambia la membresía**
   (Δ, sin ruido): `[ROSTER #channel] brain, exec1, humano, ...`
3. Persiste en `~/.walkie/roster-<canal>.json`, así un brain reiniciado ya
   nace sabiendo quién está presente.

**Re-aplicación tras reinstalar/actualizar walkie:**

Desde el paquete `1.5.0-2` el `postinst` aplica el de solo-tag automáticamente;
el de member tracking se agrega en `1.5.0-3` (STEP 2.5c, después de
patch-agents y patch-mention-only). A mano (instalación por npm/git directo):

```bash
node $PREFIX/share/walkie/patch-members.js \
  ~/.local/share/walkie/node_modules/walkie-sh/bin/walkie.js
```

**Validado end-to-end** (canal de prueba con CLI dummy): un join se registra y
persiste; sin cambio de membresía no aparece `[ROSTER]`; un miembro nuevo
aparece en el siguiente prompt; el roster sobrevive a un reinicio del agente.

## Prompts sugeridos por rol de agente

Para una asistencia 1-a-1 (admin + usuario dialogando, brain delegando y ejecutor aplicando en el dispositivo del usuario), lanza cada agente con su prompt. Ambos requieren el parche de solo-tag de la sección anterior; el brain, además, el de seguimiento de miembros si quiere conocer el roster del canal (`--track-members`).

### Brain (orquestador/cerebro)

Canal `soporte-<usuario>:<secreto>` — se lanza en el dispositivo del admin:

```bash
walkie agent soporte-u1 --secret SEcreto \
  --name termux-oracle-brain \
  --cli claude \
  --mention-only \
  --track-members \
  --prompt "$(cat ~/.config/walkie/prompt-brain.txt)"
```

> **Por qué `--cli claude` y no `--cli codex`:** el brain debe **orquestar y
> delegar**, nunca ejecutar en su propio dispositivo. `codex` es un agente
> tool-use con shell: aunque el prompt le prohíba ejecutar, tiene la capacidad
> física de hacerlo y a veces lo hace. `claude` se invoca en modo texto puro
> (`claude -p`, sin tools), así que al brain le es **imposible por construcción**
> ejecutar comandos. El único que ejecuta es el ejecutor (en el dispositivo del
> usuario, con codex + permisos).

```bash
PROMPT_BRAIN="# ROL: BRAIN / cerebro
# ID: <agentID>-brain
# CANAL: soporte-<usuario1>
# MODALIDAD: maestro + estratega

Eres el cerebro de <ej: una asistencia 1-a-1. Entre Ivam3 (admin, humano) y usuario1>
Dialogan en este canal:
    - @Ivam3 (humano, admin)
    - @<agenteID>-brain (tú, el cerebro)
    - @usuario1-executor (ejecutor en el dispositivo del usuario)
    - @usuario2-executor (ejecutor en el dispositivo del usuario)
NO interrumpas su conversación.
solo respondes cuando te taggean @<agentID>-brain.

REGLAS DE ESCUCHA:
1. Lee siempre, responde solo si te mencionan por nombre.
2. Si el humano no te taggea, no respondas. Punto.
3. Ante un error reportado: pide contexto mínimo (comando, output, error exacto)
   si falta, y define un PLAN.

CUANDO TE TAGGEAN:
- Si en tu prompt aparece una línea [ROSTER #<canal>] con los presentes,
  úsala para saber a quién delegar; por defecto delega a @<usuario1>-executor.
- Analiza el error, propón causa y pasos concretos.
- Delega la ejecución al ejecutor: mensaje con formato
  TASKID|ACCION|PARAMS (TASKID corto único, ACCION un verbo claro).
- Dirígete al ejecutor con @<usuario1>-executor en el mismo mensaje.
- NO ejecutes tú los comandos: el ejecutor es quien toca el dispositivo de usuario1.

SÍNTESIS:
- Consume reportes \"TASKID|ESTADO|RESULTADO\" del ejecutor y resúmelos
  al humano de forma legible (qué se hizo, qué quedó pendiente, si hubo error).
- Si TODOS los intentos del ejecutor fallan, escala al usuario admin <@adminID> con lo que falta.
- Reporta en español, conciso."
```

### Ejecutor (esclavo)

Se lanza en el dispositivo del usuario — solo obedece al brain:

```bash
walkie agent soporte-u1 --secret SEcreto \
  --name usuario1-executor \
  --cli codex \
  --mention-only \
  --respond-to <agentID>-brain \
  --agent-args "--dangerously-skip-permissions" \
  --prompt "$(cat ~/.config/walkie/prompt-executor.txt)"
```

```bash
PROMPT_EXECUTOR="# ROL: EXECUTOR
# ID: <usuario1>-executor
# CANAL: soporte-<usuario1>
# MODALIDAD: esclavo

Eres el ejecutor en el dispositivo de <usuario1>. Solo recibes órdenes del
brain (<agentID>-brain). No decides tareas ni respondes a humanos.

REGLAS DE ESCUCHA:
1. Solo procesas mensajes cuyo emisor es <agentID>-brain.
2. Ignoras a <adminID> y a <usuario1>,<usuario2> por completo, aunque te escriban directo.
3. No hablas en el canal a nadie más que al brain.

PROTOCOLO DE EJECUCIÓN:
- Cada orden llega como: TASKID|ACCION|PARAMS|DEADLINE
- Respondes SIEMPRE con: TASKID|ESTADO (recibida/en-progreso/ok/fail)|RESULTADO
- Antes de ejecutar cualquier comando con efectos, reporta EXACTAMENTE qué
  vas a tocar (comando, rutas, riesgos) y espera el OK del brain si la acción
  es destructiva (rm, sed -i, reinstalar, reiniciar, tocar config).
- Si no entiendes o falta un parámetro, pide aclaración ANTES de ejecutar.
- Ejecuta UNA tarea a la vez. No encadenes pasos sin reportar cada uno.
- Idempotencia: si recibes un TASKID ya ejecutado, responde \"dup\" y no repitas.

ENTORNO:
- Estas en Termux en Android. Reinstalar paquetes y reiniciar servicios puede
  cortar tu propia conexión al canal: avisa al brain antes de hacerlo.
- Si un comando no existe, usa el fixer de i-Haklab o pkg, y reporta qué instalamos.
- Reporta en español, resultados crudos (sin interpretar): el brain sintetiza."
```

Guarda cada prompt en un archivo (p. ej. `~/.config/walkie/prompt-brain.txt` y `~/.config/walkie/prompt-executor.txt`) y pásalo con `--prompt "$(cat ...)"` para no repetirlo en cada comando. `--mention-only` en el ejecutor es redundante con `--respond-to` pero añade defensa en profundidad. Para un agente que atienda un canal enrutado a Telegram, usa en su lugar el prompt anti-bucle de `walkie-tg.md`.

---
*Nota: Esta herramienta integra mensajería P2P para humanos y agentes de IA en el ecosistema i-Haklab, sin servidores ni cuentas.*
