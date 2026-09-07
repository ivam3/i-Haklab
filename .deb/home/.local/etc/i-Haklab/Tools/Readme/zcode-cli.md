# zcode-cli

Cliente de terminal para el agente de IA ZCode (Z.AI). Permite conversar con
el modelo, pedirle que escriba o modifique código, y usar comandos y plugins
desde la terminal. Se instala con el nombre **`zcode-cli`** para no interferir
con la app de escritorio `zcode`.

## Instalación

```bash
npm install -g zcode-cli
```

## Primeros pasos

1.  Abrir la interfaz:
    ```bash
    zcode-cli
    ```
2.  Guardar tu API key (una sola vez):
    ```bash
    i-Haklab setapikey   # elige zcode (o bigmodel) y pega tu key
    ```
    i-Haklab la coloca sola en la configuración. También puedes pegarla a
    mano en la interfaz con `/login` → **Z.AI Coding Plan API Key** (el
    login por navegador solo funciona en macOS).
    La primera vez se abre un asistente de configuración (`/setup` lo reabre).
3.  Probar con un prompt directo (sin abrir la interfaz):
    ```bash
    zcode-cli --prompt "hola, ¿qué puedes hacer?" --no-browser
    ```

## Comandos más usados

| Comando | Para qué sirve |
|---------|----------------|
| `zcode-cli` | Abre la interfaz de terminal (pantalla completa) |
| `zcode-cli --prompt "..." --no-browser` | Una sola pregunta sin abrir la interfaz |
| `zcode-cli --help` | Ayuda y lista de opciones |
| `zcode-cli --version` | Versiones instaladas |
| `zcode-cli doctor` | Revisa que todo esté en orden |
| `zcode-cli plugins list` | Ver plugins disponibles |

Dentro de la interfaz: `/help` (ayuda), `/login` y `/logout` (sesión),
`/model` (cambiar modelo), `/resume` (retomar sesión), `/status` (estado),
`/copy` y `/cls` (copiar / limpiar pantalla).

## Saldo y planes

*   **Coding Plan es de pago** (planes desde $18/mes): la key del CLI gasta
    de ese plan. No existe tier gratuito del Coding Plan.
*   **El plan free vive en la app de escritorio** (Start Plan por OAuth) y
    no se puede pasar al CLI.
*   **`[1113] Insufficient balance`** = todo funciona pero la cuenta no
    tiene saldo. Soluciones: recargar en
    [z.ai/manage-apikey/billing](https://z.ai/manage-apikey/billing), o
    probar el **trial gratis de BigModel**: key en
    [open.bigmodel.cn](https://open.bigmodel.cn/usercenter/apikeys) →
    `i-Haklab setapikey` → `bigmodel` → en `zcode-cli`, `/login` →
    **BigModel Coding Plan API Key**.
*   **Key rechazada (401 / auth error)** = key inválida o revocada.
    Regenérala en [z.ai/manage-apikey](https://z.ai/manage-apikey) y repite
    `i-Haklab setapikey` → `zcode`.
*   Cada instalación verifica tu saldo sola con una micro-pregunta (solo
    gasta si tienes cuota; sin saldo el chequeo es gratis).

## Notas importantes

*   **API key:** si al enviar un prompt aparece `Turn failed / Model request
    failed`, revisa que la key esté cargada (`i-Haklab setapikey` → `zcode`)
    y que tu cuenta tenga saldo (ver sección anterior).
*   **Sin navegador:** si no necesitas que el agente controle un navegador,
    agrega siempre `--no-browser` a los prompts directos.
*   **Imágenes adjuntas** (`/paste-image`) y algunas funciones de documentos
    pueden no estar disponibles en el teléfono; el resto funciona normal.
*   Tu configuración vive en `~/.zcode/cli/` (ajustes, sesiones, historial).

## Ayuda

```bash
i-Haklab about zcode-cli
```

--------

Nota: Esta herramienta integra Zcode AI bajo una version CLi no oficial en el ecosistema i-Haklab.
