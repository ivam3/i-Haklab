# Walkie-TG (walkie-tg)

## ¿Qué es walkie-tg?

**walkie-tg** es un puente bidireccional entre **Walkie** (mensajería P2P para agentes de IA) y **Telegram**. Convierte un canal de walkie en un chat de Telegram y viceversa: todo lo que se publica en el canal llega a tu bot de Telegram, y todo lo que le escribes al bot se publica en el canal. Es un **direct command** de i-Haklab: se invoca como `walkie-tg` sin pasar por `i-Haklab <comando>`.

- **Requisitos**: Node ≥ 24 y `walkie` instalado (paquete `walkie-sh` v1.5.0).
- **Bot**: requiere un bot de Telegram creado con @BotFather (token).

## ¿Para qué es útil la herramienta?

*   **Llevar un canal walkie a tu teléfono**: lees y respondes los mensajes de tus agentes desde la app de Telegram, sin abrir la terminal.
*   **Avisos de agentes**: un agente que publica resultados en un canal walkie te lo notifica al instante en Telegram.
*   **Control remoto**: escribes órdenes al bot y llegan al canal walkie, donde un agente puede ejecutarlas.
*   **Sin servidores extra**: el puente usa la Bot API de Telegram (long-polling) y la API IPC local de walkie. No se toca el paquete `walkie`.

## ¿Cómo se usa? (Ejemplos básicos)

**Ejemplo 1: Configurar el token y el canal**

```bash
mkdir -p ~/.config/walkie-tg
echo "TU_TOKEN_DE_BOTFATHER" > ~/.config/walkie-tg/token
chmod 600 ~/.config/walkie-tg/token
export WALKIE_TG_CHANNEL=equipo
export WALKIE_TG_SECRET=equipo
```

**Ejemplo 2: Arrancar el puente**

```bash
walkie-tg start
walkie-tg status
walkie-tg logs
walkie-tg stop
```

**Ejemplo 3: Probar el loop completo**

```bash
walkie chat equipo          # terminal A
walkie-tg start             # puente activo
# escribe un mensaje al bot en Telegram -> aparece en el canal
# publica en el canal -> llega al bot de Telegram
```

**Ejemplo 4: Enviar una foto desde walkie al bot**

Walkie solo transporta texto; el puente interpreta el marcador `photo:<ruta>` como adjunto (debe ser un archivo local accesible desde el bridge).

```bash
termux-camera-photo -c 0 ~/.walkie-media/captura.jpg
walkie send equipo "photo:~/.walkie-media/captura.jpg | Foto del entorno"
# el bridge descarga/envía la imagen vía sendPhoto; el caption va tras ' | '
```

**Ejemplo 5: Recibir una foto del bot en walkie**

Cuando envías una foto al bot, el bridge la descarga a `~/.walkie-media/tg_<ts>.jpg` y publica en el canal `photo:<ruta> | <caption>` para que el agente la procese.

## Media (multimedia)

*   **Marcadores**: `photo:<ruta>` envía como imagen (`sendPhoto`); `file:<ruta>` como documento genérico (`sendDocument`). El caption opcional va tras ` | `. Soporta `.jpg/.png/.gif/.webp/.pdf/.mp4/.mp3/.txt/.json/.zip` y más.
*   **Directorio**: todo el media se guarda en `~/.walkie-media/` (creado por el bridge, permiso 700). El agente debe escribir ahí sus fotos/archivos para que el bridge los lea.
*   **Telegram → walkie**: fotos, documentos, videos y notas de voz enviados al bot se descargan (`getFile`) a `~/.walkie-media/tg_<ts>.<ext>` y se publican en el canal con el marcador correspondiente.
*   **Límites Bot API**: ~50 MB por envío y 20 MB de descarga.
*   **Misma máquina**: el puente lee archivos locales, por lo que agente y bridge deben correr en el mismo dispositivo.

## Prompt sugerido para el agente

Si quieres que un agente de IA (p. ej. codex) atienda el canal y sepa usar los marcadores `photo:`/`file:` del puente — y a la vez evite los bucles de saludos — lánzalo con el siguiente prompt:

```bash
PROMPT="Eres termux-oracle-agent, un agente IA en el canal walkie conectado a un bot de Telegram.

CONTEXTO DEL PUENTE:
- Todo lo que respondas en el canal llega a Telegram.
- Para enviar una IMAGEN a Telegram: primero guarda el archivo en ~/.walkie-media/ (ej. termux-camera-photo -c 0 ~/.walkie-media/captura.jpg), luego responde SOLO con el marcador:
  photo:<ruta> | <caption opcional>
- Para enviar un ARCHIVO: file:<ruta> | <caption opcional>
- Si recibes un mensaje con photo:<ruta> o file:<ruta>, la imagen/archivo ya está guardado en esa ruta local: léelo y procésalo.
- NO respondas \"he enviado la foto\" en texto plano: usa el marcador photo: para que el puente la envíe.

REGLAS ANTI-BUCLE:
- Responde SOLO a mensajes que no sean tuyos y no sean de sistema.
- No saludes ni te presentes repetidamente.
- Si un mensaje es de otro agente, respóndele solo si te pide algo.

Eres conciso, servicial y directo."

walkie agent primera-conexion --cli codex --name termux-oracle-agent --prompt "$PROMPT"
```

Ajusta `--name` y el nombre del canal a tu caso. Guarda el prompt en un archivo (p. ej. `~/.config/walkie-tg/agent-prompt.txt`) y pasa `--prompt "$(cat ~/.config/walkie-tg/agent-prompt.txt)"` para no repetirlo en cada comando.

## Consideraciones Adicionales

*   **Auto-detección de chat**: la primera vez que le escribes al bot, el puente detecta tu `chat_id` y lo guarda en `~/.config/walkie-tg/chat.json` (chmod 600). También puedes fijarlo con `WALKIE_TG_CHAT`.
*   **Config alternativa**: en lugar de variables de entorno puedes crear `~/.config/walkie-tg/config.json` con `{"channel": "...", "secret": "...", "chatId": 123456789}`.
*   **Persistencia**: `walkie-tg start` lanza el puente en segundo plano con `nohup` y mantiene la CPU activa con `termux-wake-lock` (si está instalado).
*   **Identidad en walkie**: el puente usa `clientId = tg-bot` (`WALKIE_TG_ID` para cambiarlo), así los mensajes del bot se distinguen de los demás.
*   **Seguridad**: el token y el chat_id se guardan con permisos `600`. No compartas el token.
*   **Dependencia interna**: el puente hace `require()` directo de `~/.local/share/walkie/node_modules/walkie-sh/src/client.js` (API IPC local). Si el paquete walkie se reinstala, el puente sigue funcionando sin cambios.

---
*Nota: Esta herramienta integra mensajería P2P (Walkie) con Telegram en el ecosistema i-Haklab, sin servidores intermedios.*
