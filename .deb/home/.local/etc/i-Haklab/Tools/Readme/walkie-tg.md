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

## Consideraciones Adicionales

*   **Auto-detección de chat**: la primera vez que le escribes al bot, el puente detecta tu `chat_id` y lo guarda en `~/.config/walkie-tg/chat.json` (chmod 600). También puedes fijarlo con `WALKIE_TG_CHAT`.
*   **Config alternativa**: en lugar de variables de entorno puedes crear `~/.config/walkie-tg/config.json` con `{"channel": "...", "secret": "...", "chatId": 123456789}`.
*   **Persistencia**: `walkie-tg start` lanza el puente en segundo plano con `nohup` y mantiene la CPU activa con `termux-wake-lock` (si está instalado).
*   **Identidad en walkie**: el puente usa `clientId = tg-bot` (`WALKIE_TG_ID` para cambiarlo), así los mensajes del bot se distinguen de los demás.
*   **Seguridad**: el token y el chat_id se guardan con permisos `600`. No compartas el token.
*   **Dependencia interna**: el puente hace `require()` directo de `~/.local/share/walkie/node_modules/walkie-sh/src/client.js` (API IPC local). Si el paquete walkie se reinstala, el puente sigue funcionando sin cambios.

---
*Nota: Esta herramienta integra mensajería P2P (Walkie) con Telegram en el ecosistema i-Haklab, sin servidores intermedios.*
