# OpenClaw (openclaw-android)

## ¿Qué es OpenClaw?

**OpenClaw** es una avanzada plataforma de agentes de IA adaptada para ejecutarse de forma nativa en dispositivos Android a través de Termux. A diferencia de otras implementaciones que requieren entornos pesados como `proot-distro`, la versión `openclaw-android` utiliza una arquitectura optimizada que reduce drásticamente el consumo de recursos (de ~1GB a solo ~200MB), permitiendo que el hardware del móvil actúe como un nodo de IA potente y eficiente.

## ¿Para qué es útil la herramienta?

OpenClaw transforma un dispositivo Android en un centro de operaciones inteligente, permitiendo:

*   **Control Remoto vía Mensajería:** Interactuar con el sistema operativo Android mediante bots de **Telegram** y **WhatsApp**.
*   **Automatización con IA:** Ejecutar agentes (como Claude o Gemini) para realizar tareas complejas, responder consultas o gestionar archivos localmente.
*   **Integración con el Hardware:** Consultar el estado de la batería, enviar SMS, tomar fotos o abrir aplicaciones de forma remota (requiere `termux-api`).
*   **Servidor de Desarrollo Móvil:** Incluye herramientas como `code-server` y asistentes de código por IA para programar directamente desde el teléfono.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado mediante el script de bootstrap del repositorio, puedes gestionar el agente con los siguientes comandos:

**Ejemplo 1: Configuración inicial y vinculación**

```bash
openclaw onboard
```
*(Sigue las instrucciones para configurar tus credenciales y preferencias).*

**Ejemplo 2: Vincular un canal de Telegram**

```bash
openclaw channels add --channel telegram
```
*(Deberás proporcionar el API Token de tu bot creado en @BotFather).*

**Ejemplo 3: Vincular WhatsApp (Escaneo de QR)**

```bash
openclaw channels add --channel whatsapp
```
*(Escanea el código QR que aparecerá en la terminal desde la opción "Dispositivos vinculados" de WhatsApp).*

**Ejemplo 4: Iniciar el servicio principal**

```bash
openclaw gateway
```
*(Este comando activa el "cerebro" del agente para que empiece a recibir comandos desde los bots).*

**Ejemplo 5: Comandos desde el chat (Telegram/WhatsApp)**

Una vez activo, puedes escribirle a tu bot:
*   *"¿Cuál es el estado de mi batería?"*
*   *"Haz un backup de la carpeta /home/scripts"*
*   *"Envía un WhatsApp a Mamá que diga: Ya llegué"*

## Consideraciones Adicionales

*   **Privacidad y Seguridad:** OpenClaw tiene acceso a tus mensajes y archivos. Nunca compartas tu `gateway token` y utiliza API Keys de proveedores confiables.
*   **Termux:API:** Para funciones de control físico (cámara, SMS, batería), es obligatorio tener instalada la aplicación **Termux:API** desde F-Droid.
*   **Rendimiento:** Esta versión nativa es ideal para dispositivos con recursos limitados o para quienes buscan convertir un teléfono antiguo en un servidor de IA de bajo consumo.

---
*Nota: OpenClaw representa el siguiente nivel en la integración de agentes autónomos dentro del ecosistema i-Haklab.*
