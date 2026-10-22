# DeepSeek Harness (deepseek-harness)

## ¿Qué es DeepSeek Harness?

**DeepSeek Harness** (`dsh`) es un entorno de agente para terminal desarrollado por DeepSeek. Organiza sus capacidades mediante **perfiles** (`web`, `headless`, `acp`, `sdk` y `sdk-minimal`) que combinan plugins y capas de configuración para adaptar el agente a distintas formas de uso: interfaz web, ejecución puntual, integración con editores o comunicación mediante SDK.

En i-Haklab se distribuye como el paquete `deepseek-harness` para `aarch64`. Incluye un runtime **Node.js glibc privado** y no reemplaza ni modifica el Node.js de Termux.

| Dato | Valor |
|---|---|
| Paquete | `deepseek-harness` |
| Comando principal | `dsh` |
| Versión de dsh | `0.2.1-rc.2` |
| Node.js incluido | `24.22.1` (linux-arm64, glibc) |
| Arquitectura | `aarch64` |
| Datos del usuario | `~/.dsh` |
| Runtime | `~/.local/share/deepseek-harness` |

## ¿Para qué es útil la herramienta?

DeepSeek Harness está pensado para trabajar con un agente que puede leer archivos, ejecutar comandos y modificar código desde la terminal o desde el navegador:

*   **Interfaz web local:** `dsh web` levanta una interfaz en `127.0.0.1:3080`, útil para trabajar desde el navegador de Android.
*   **Tareas puntuales:** `dsh headless "..."` responde una instrucción y termina, ideal para scripts o automatizaciones.
*   **Perfiles especializados:** `web`, `headless`, `acp` y `sdk` permiten usar el mismo motor con distintos clientes y flujos.
*   **Plugins y personalización:** cada perfil puede ampliarse con paquetes adicionales mediante `dsh plugin`.
*   **Trabajo con código:** lectura y edición de archivos, ejecución de comandos, sesiones persistentes y adjuntos, según el perfil y los plugins activos.
*   **Integración con otras herramientas:** los perfiles `acp` y `sdk` exponen el agente por stdio para clientes externos.

## ¿Cómo se usa? (Ejemplos básicos)

Instalación (si aún no tienes glibc):

```bash
pkg install glibc-repo
pkg install deepseek-harness
```

**Ejemplo 1: Abrir la interfaz web**

```bash
dsh web --no-open
```

El comando imprime una URL con un token de acceso, por ejemplo:

```text
http://127.0.0.1:3080/?token=...
```

Copia esa URL en el navegador de Android. El token es privado; no compartas el enlace.

**Ejemplo 2: Ejecutar una tarea y salir**

```bash
dsh headless "Crea un script en Python que valide direcciones IP"
```

También puedes pasar la tarea por stdin o solicitar eventos en JSON:

```bash
echo "Resume los archivos de este proyecto" | dsh headless
dsh headless --json "Ejecuta las pruebas y explica los fallos"
```

**Ejemplo 3: Retomar una sesión headless**

```bash
dsh headless --session-id mi-sesion "Continúa con el cambio pendiente"
```

**Ejemplo 4: Crear un perfil personalizado a partir de una plantilla**

```bash
dsh rescue --from-default-profile web
```

**Ejemplo 5: Añadir un plugin a un perfil**

```bash
dsh plugin --profile web add <paquete>
```

Sustituye `<paquete>` por el nombre del plugin que quieras instalar. Los perfiles se guardan bajo `~/.dsh/profiles/`.

**Ejemplo 6: Usar los wrappers npm/pnpm del runtime aislado**

```bash
dsh-npm --version
dsh-npx --version
dsh-pnpm --version
```

Estos comandos usan el Node.js glibc incluido por el paquete, no el Node.js del sistema.

## Consideraciones Adicionales

*   **Requiere glibc:** el paquete usa el cargador glibc de Termux. Si falta, instala `glibc-repo` antes de continuar.
*   **Runtime aislado:** `dsh`, `dsh-node`, `dsh-npm`, `dsh-npx` y `dsh-pnpm` viven en `$PREFIX/bin`; el runtime completo está en `~/.local/share/deepseek-harness`. No necesitas instalar Node.js aparte.
*   **Web local:** por defecto escucha en `127.0.0.1:3080`. Usa `--port <puerto>` para cambiarlo y `--host <IP>` para enlazar una interfaz concreta. `dsh web` no abre un navegador en Termux; por eso se recomienda `--no-open`.
*   **Credenciales:** en la interfaz web, configura la clave desde **Ajustes → Modelos** (la referencia habitual es `DEEPSEEK_API_KEY`). En `headless`, exporta `DEEPSEEK_API_KEY` o colócala en el `.env` del directorio actual o en `~/.dsh/.env`. Para usar un endpoint compatible, ajusta `DEEPSEEK_BASE_URL`.
*   **Configuración y datos:** `~/.dsh` contiene perfiles, sesiones, credenciales y adjuntos. `~/.agents` se usa para instrucciones y recursos compartidos del agente. Evita versionar estas carpetas en Git.
*   **Seguridad:** el agente puede leer y modificar archivos y ejecutar comandos. Ejecútalo en directorios controlados, revisa los cambios antes de aceptarlos y no expongas la interfaz web fuera de `127.0.0.1` sin las precauciones adecuadas.
*   **Actualización:** usa `pkg update && pkg upgrade` para actualizar el paquete; no dependas de un actualizador automático interno.
*   **Desinstalación:** `pkg uninstall deepseek-harness` elimina el runtime pero conserva `~/.dsh`. Usa `pkg uninstall --purge deepseek-harness` si también quieres borrar los datos del usuario.

---
*Nota: Esta herramienta integra el agente DeepSeek Harness y su runtime glibc aislado en el ecosistema i-Haklab.*
