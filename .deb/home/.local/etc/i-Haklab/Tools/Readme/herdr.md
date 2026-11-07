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

Una vez instalado con `apt install herdr` (siempre se descarga la última versión estable y verificada), úsalo así:

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

*   **Instalación:** `apt install herdr`. No necesitas compilar nada ni instalar dependencias extra; funciona directo en Android.
*   **Siempre actualizado:** Cada instalación trae la última versión estable y verificada. Para actualizar después usa `herdr update`.
*   **Desinstalación:** Al desinstalar se te pregunta antes de borrar tus datos (`~/.config/herdr`, `~/.local/share/herdr`, `~/.cache/herdr`).
*   **Configuración:** `herdr --default-config` genera la config base en `~/.config/herdr/config.toml`; `herdr --skill` muestra la ayuda para agentes.

---
*Nota: Esta herramienta integra el runtime de agentes para multiplexar terminales y orquestar IA en el ecosistema i-Haklab/Termux.*

---

## Atajos de Teclado

> **Tecla prefijo por defecto:** `Ctrl+B`
>
> Los atajos con `prefix+` requieren pulsar primero la tecla prefijo y luego la tecla indicada.
> Los atajos directos (`Ctrl+...`) se ejecutan sin prefijo previo.

### 🌐 Sesión / Global

| Atajo | Acción |
|---|---|
| `prefix+?` | Mostrar ayuda de atajos |
| `prefix+s` | Abrir ajustes (settings) |
| `prefix+q` | Desconectar cliente (detach) |
| `prefix+Shift+R` | Recargar configuración en caliente |
| `prefix+o` | Abrir destino de notificación activa |

### 🗂️ Workspaces

| Atajo | Acción |
|---|---|
| `prefix+w` | Selector de workspaces (picker) |
| `prefix+g` | Ir a sesión/workspace (goto) |
| `prefix+Shift+N` | Crear nuevo workspace |
| `prefix+Shift+G` | Crear nuevo worktree |
| `prefix+Shift+W` | Renombrar workspace actual |
| `prefix+Shift+D` | Cerrar workspace actual |

### 📑 Tabs

| Atajo | Acción |
|---|---|
| `prefix+c` | Nueva tab |
| `prefix+n` | Ir a la tab siguiente |
| `prefix+p` | Ir a la tab anterior |
| `prefix+1`…`prefix+9` | Saltar directamente a la tab N |
| `prefix+Shift+T` | Renombrar tab actual |
| `prefix+Shift+X` | Cerrar tab actual |

### 🪟 Panes (paneles)

| Atajo | Acción |
|---|---|
| `prefix+v` | Dividir pane verticalmente |
| `prefix+-` | Dividir pane horizontalmente |
| `prefix+x` | Cerrar pane actual |
| `prefix+z` | Zoom / pantalla completa al pane actual |
| `prefix+h` | Enfocar pane izquierdo |
| `prefix+j` | Enfocar pane inferior |
| `prefix+k` | Enfocar pane superior |
| `prefix+l` | Enfocar pane derecho |
| `prefix+Tab` | Ciclar al siguiente pane |
| `prefix+Shift+Tab` | Ciclar al pane anterior |
| `prefix+Shift+P` | Renombrar pane actual |
| `prefix+e` | Editar scrollback en editor externo |
| `prefix+r` | Entrar en modo redimensionar (resize mode) |
| `prefix+b` | Colapsar / expandir sidebar de agentes |

### 🤖 Agentes

| Atajo | Acción |
|---|---|
| `prefix+Alt+1`…`9` | Enfocar agente N en el panel *(requiere configurar `focus_agent` en config)* |

> **Tip:** En modo navigate (navegador de panes), usa `h/j/k/l` o las flechas para moverte entre panes y workspaces sin necesitar el prefijo.

### 🖱️ Modo navegar (Navigate Mode)

Activo al abrir el goto (`prefix+g`) o el workspace picker:

| Tecla | Acción |
|---|---|
| `↑` / `↓` | Moverse entre workspaces |
| `h` / `←` | Enfocar pane a la izquierda |
| `j` | Enfocar pane inferior |
| `k` | Enfocar pane superior |
| `l` / `→` | Enfocar pane a la derecha |
| `Enter` | Confirmar selección |
| `Esc` | Cancelar / salir del modo |

### 📋 Copy Mode (Scrollback)

Activa copy mode con `prefix+e` o scroll con el ratón:

| Tecla | Acción |
|---|---|
| `↑` / `k` | Scroll hacia arriba |
| `↓` / `j` | Scroll hacia abajo |
| `Page Up` | Página anterior |
| `Page Down` | Página siguiente |
| `q` / `Esc` | Salir de copy mode |

### ⚙️ Personalización de atajos

Todos los atajos son configurables en `~/.config/herdr/config.toml` bajo la sección `[keys]`. Para generar la config base con todos los valores comentados:

```bash
herdr --default-config > ~/.config/herdr/config.toml
```

Para resetear keybindings a los valores por defecto:

```bash
herdr config reset-keys
```

Para atajos indexados directos (sin prefijo), configura en `config.toml`:

```toml
[keys.indexed]
tabs = "ctrl"           # ctrl+1..9 cambia tabs directamente
workspaces = "ctrl+shift" # ctrl+shift+1..9 cambia workspaces
agents = "alt"          # alt+1..9 enfoca agentes
```

---
*Nota: Esta herramienta integra el runtime de agentes para multiplexar terminales y orquestar IA en el ecosistema i-Haklab/Termux.*
