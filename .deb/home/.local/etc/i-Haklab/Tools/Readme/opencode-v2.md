# OpenCode v2 (opencode-v2)

## ¿Qué es OpenCode v2?

**OpenCode v2** es la nueva generación del agente de programación de código abierto para terminal. En i-Haklab se distribuye como un **binario nativo glibc (Bun) para aarch64**, instalado vía `apt` como `opencode-v2`. No reemplaza a la v1: ambos paquetes conviven y cada uno mantiene su propio comando, configuración y sesiones.

| Característica | `opencode` (v1) | `opencode-v2` |
|---|---|---|
| Versión empacada | 1.19.3-1 | 2.0.32-1 |
| Comando | `opencode` | `opencode-v2` |
| Configuración | `~/.config/opencode/` | `~/.opencode-v2/config/opencode/` |
| Datos y sesiones | `~/.local/share/opencode/` | `~/.opencode-v2/data/opencode/` |
| API keys | `~/.opencode/.env` | `~/.opencode-v2/.env` |
| Actualización | `opencode upgrade` | `pkg update && pkg upgrade` |
| Servidor web | `opencode web` | `opencode-v2 serve` |
| Credenciales/proveedores | `opencode providers` / `opencode auth` | `opencode-v2 auth` |

## ¿Para qué es útil la herramienta?

OpenCode v2 conserva el flujo Plan/Build de la v1 y añade una arquitectura cliente-servidor más completa:

*   **TUI y modo headless:** interfaz interactiva o `opencode-v2 run` para tareas puntuales, con salida `--format json` para scripts.
*   **Servicio en segundo plano:** `opencode-v2 service start|status|stop` mantiene el servidor vivo; `serve` expone la API v2 y la interfaz web, y `api` consulta el servidor en ejecución.
*   **Sesiones persistentes:** `session list|delete|export|import`, además de `--continue`, `--session` y `--fork` para retomar o bifurcar conversaciones.
*   **Multi-proveedor y MCP:** `auth login`, `models`, `mcp` y `plugin` permiten conectar OpenAI, Anthropic, Gemini, Groq, OpenRouter, modelos locales y herramientas externas.
*   **Aislamiento de la v1:** configuración, caché, estado y base de datos SQLite propias (`~/.opencode-v2/`), por lo que puedes probar v2 sin tocar tu entorno de v1.

## ¿Cómo se usa? (Ejemplos básicos)

Instalación (requiere glibc; si no lo tienes, primero `pkg install glibc-repo`):

```bash
pkg install opencode-v2
```

**Ejemplo 1: Iniciar la interfaz interactiva (TUI)**

```bash
opencode-v2
```
*(Dentro de la TUI, `/init` genera `AGENTS.md` y la tecla `Tab` alterna entre Plan y Build).*

**Ejemplo 2: Ejecutar una tarea puntual**

```bash
opencode-v2 run "Crea una función en Python para validar direcciones IP"
opencode-v2 run --model provider/model --format json "Resume los cambios sin commit"
```

**Ejemplo 3: Autenticar proveedores y listar modelos**

```bash
opencode-v2 auth login
opencode-v2 models
```

**Ejemplo 4: Levantar el servidor en segundo plano**

```bash
opencode-v2 service start
opencode-v2 service status
```

## Consideraciones Adicionales

*   **Convivencia con v1:** `opencode` y `opencode-v2` pueden instalarse juntos y ejecutarse a la vez; no comparten configuración, credenciales ni sesiones.
*   **Actualización:** usa siempre `pkg update && pkg upgrade` (o reinstala el paquete). **No uses** `opencode-v2 upgrade`: el autoupdater reemplaza el binario y pierde el intérprete ELF parcheado para Termux; por eso el paquete define `OPENCODE_DISABLE_AUTOUPDATE=1`.
*   **Binario nativo:** no requiere Node.js/npm; el `postinst` descarga la versión fijada `2.0.32` desde npm, la extrae en `~/.local/share/opencode-v2/opencode.real` y compila un lanzador que limpia `LD_PRELOAD` y fija las rutas XDG.
*   **API keys:** edita `~/.opencode-v2/.env` (plantilla en `$PREFIX/share/opencode-v2/env.example`) o usa `opencode-v2 auth login`. También puedes definir `OPENCODE_MODEL` para el modelo por defecto.
*   **Configuración:** `~/.opencode-v2/config/opencode/opencode.json(c)`; verifica las rutas efectivas con `opencode-v2 debug paths`.
*   **Servicio vs. standalone:** si prefieres no dejar un proceso en segundo plano, ejecuta `opencode-v2 --standalone`; para la API/web usa `opencode-v2 serve`.
*   **Permisos:** v2 confirma cambios y comandos por defecto; `--auto` aprueba automáticamente lo que no esté denegado (úsalo con cuidado).
*   **Cambios de CLI frente a v1:** `web` pasa a `serve`, `providers` a `auth`, `completion` al flag `--completions`, y `export/import` a `session export|import`; se añaden `api`, `mini`, `pair`, `reload` y `plugin`.
*   **Desinstalación:** `pkg uninstall opencode-v2` conserva configuración y sesiones; `pkg uninstall --purge opencode-v2` las elimina.

---
*Nota: OpenCode v2 convive con la v1 en el ecosistema i-Haklab, con rutas y credenciales independientes.*
