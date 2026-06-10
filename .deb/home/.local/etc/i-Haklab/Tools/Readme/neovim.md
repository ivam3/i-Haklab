# Documentación de la Configuración de Neovim

Este documento proporciona una visión general completa de esta configuración de Neovim, diseñada para ser un entorno de desarrollo moderno, eficiente y altamente funcional, con un fuerte enfoque en la integración de la IA y herramientas de productividad avanzada.

## 1. ¿Qué es Neovim?

**Neovim** es un editor de texto modal basado en Vim. Hereda toda la potencia y eficiencia de Vim (operación mediante modos, edición sin ratón, alta personalización) y le añade características modernas como una mejor arquitectura de plugins, integración con scripts de Lua, soporte asíncrono nativo y una terminal integrada.

## 2. ¿Qué es Lua y por qué se usa en Neovim?

**Lua** es el lenguaje principal de configuración de Neovim. Es significativamente más rápido que el antiguo VimScript y permite una configuración más limpia, modular y potente.

---

## 3. Plugins Instalados

Esta configuración utiliza `lazy.nvim` como gestor de plugins.

| Plugin | Repositorio | Descripción |
| :--- | :--- | :--- |
| **Code Companion** | `olimorris/codecompanion.nvim` | **Asistente de IA principal.** |
| **nvim-ufo** | `kevinhwang91/nvim-ufo` | **Plegado de código avanzado.** |
| **LSP Zero** | `VonHeikemen/lsp-zero.nvim` | **IDE (LSP, Autocompletado, Snippets).** |
| **Telescope** | `nvim-telescope/telescope.nvim` | **Buscador interactivo universal.** |
| **Nvim Tree** | `nvim-tree/nvim-tree.lua` | **Explorador de archivos lateral.** |
| **zk-nvim** | `mickael-menu/zk-nvim` | Toma de notas Zettelkasten. |
| **Conform** | `stevearc/conform.nvim` | Formateador automático al guardar. |
| **Tokyo Night** | `folke/tokyonight.nvim` | Tema de colores principal. |
| **Lualine** | `nvim-lualine/lualine.nvim` | Barra de estado inferior. |
| **Bufferline** | `akinsho/bufferline.nvim` | Gestión de pestañas superior. |
| **Toggleterm** | `akinsho/toggleterm.nvim` | Terminales integradas. |
| **Significant** | `elpiloto/significant.nvim` | Animaciones de diagnóstico. |
| **Auto Pairs** | `jiangmiao/auto-pairs` | Cierre automático de paréntesis. |
| **Neural** | `dense-analysis/neural` | Cliente de IA secundario. |
| **Treesitter** | `nvim-treesitter/nvim-treesitter` | Resaltado de sintaxis avanzado. |

---

## 4. Gestión de Archivos (Nvim Tree)

El explorador de archivos se encuentra en el lateral izquierdo.

### Atajos para el Árbol
| Atajo | Acción |
| :--- | :--- |
| `<leader>e` | **Abrir / Cerrar el explorador.** |
| `a` | **Crear un nuevo archivo** (dentro del árbol). |
| `r` | **Renombrar un archivo** o carpeta. |
| `d` | **Borrar un archivo** (pide confirmación). |
| `x` | Cortar un archivo. |
| `c` | Copiar un archivo. |
| `p` | Pegar un archivo. |
| `Enter` | Abrir el archivo o entrar en carpeta. |
| `g?` | Mostrar ayuda de Nvim Tree con todos los comandos. |

---

## 5. Atajos de Teclado Personalizados

La `<leader>` key está configurada como la coma (`,`).

### Navegación y Ventanas
| Atajo | Descripción |
| :--- | :--- |
| `<C-h>` | Moverse a la ventana izquierda. |
| `<C-j>` | Moverse a la ventana inferior. |
| `<C-k>` | Moverse a la ventana superior. |
| `<C-l>` | Moverse a la ventana derecha. |
| `<leader>w` | Guardar archivo actual (`:write`). |
| `<C-w>` | Guardar archivo actual (`:w`). |
| `<leader>x` | Guardar y cerrar Neovim (`:x`). |
| `<C-x>` | Guardar y cerrar Neovim. |
| `<C-c>` | Salir de Neovim sin guardar (`:q!`). |
| `<leader>ei` | Abrir configuración `init.lua`. |

### Buffers (Pestañas)
| Atajo | Descripción |
| :--- | :--- |
| `<C-b>n` | Ir al siguiente buffer. |
| `<C-b>p` | Ir al buffer anterior. |
| `<C-b>q` | Cerrar el buffer actual. |

### Telescope (Búsqueda Interactiva)
| Atajo | Descripción |
| :--- | :--- |
| `<leader>ff` | Buscar archivos por nombre. |
| `<leader>fa` | Buscar en todos los archivos (ocultos, ignorados). |
| `<leader>fo` | **Buscar archivos recientes (Oldfiles).** |
| `<leader>fw` | Buscar texto en el proyecto (Live Grep). |
| `<leader>fb` | Listar y buscar buffers abiertos. |
| `<leader>fz` | Buscar texto dentro del buffer actual. |
| `<leader>fh` | Buscar en las páginas de ayuda. |
| `<leader>ma` | Buscar marcas (marks). |
| `<leader>gt` | Ver estado de Git (status). |
| `<leader>cm` | Ver historial de commits. |
| `<leader>pt` | Seleccionar terminales ocultas. |

### IA y Herramientas
| Atajo | Descripción |
| :--- | :--- |
| `<A-,>ca` | Abrir acciones de **Code Companion**. |
| `<A-,>cc` | Abrir chat de **Code Companion**. |
| `<A-,>ci` | Code Companion Inline (Vibe coding). |
| `<A-,>ce` | Explicar código con **Code Companion**. |
| `<leader>n` | Activar interfaz de **Neural**. |
| `<leader>fm` | Formatear código con **Conform**. |

### Plegado de Código (nvim-ufo)
| Atajo | Descripción |
| :--- | :--- |
| `zR` | Abrir todos los pliegues del buffer. |
| `zM` | Cerrar todos los pliegues del buffer. |

### Transparencia y UI
| Atajo | Descripción |
| :--- | :--- |
| `<leader>tt` | Alternar transparencia del fondo. |
| `<leader>te` | Habilitar transparencia. |
| `<leader>td` | Deshabilitar transparencia. |

---

## 6. Atajos Esenciales de Neovim (Nativos)

### Modos
- `i`: Entrar en **Modo Insertar**.
- `Esc` o `jk`: Volver a **Modo Normal**.
- `v`: **Modo Visual** (para seleccionar texto).
- `V`: **Modo Visual de Línea**.

### Edición Básica
- `u`: Deshacer (Undo).
- `<C-r>`: Rehacer (Redo).
- `y`: Copiar (Yank).
- `p`: Pegar (Paste).
- `d`: Borrar/Cortar (Delete).
- `x`: Borrar el carácter bajo el cursor.
- `o`: Abrir nueva línea abajo.
- `O`: Abrir nueva línea arriba.

### Movimiento y Búsqueda
- `gg`: Ir al principio del archivo.
- `G`: Ir al final del archivo.
- `/`: Buscar palabra (usar `n` para siguiente).
- `:%s/viejo/nuevo/g`: Reemplazar texto globalmente.

---

## 7. Estructura de la Configuración

- **`init.lua`**: Punto de entrada.
- **`lua/settings.lua`**: Opciones del sistema.
- **`lua/keymaps.lua`**: Definición de atajos.
- **`lua/plugins/`**: Configuraciones de plugins específicos.

## 8. Terminal

Esta configuración utiliza **Toggleterm** para gestionar terminales integradas.

| Atajo | Modo | Descripción |
| :--- | :--- | :--- |
| `<C-t>` | Normal | **Abrir / Cerrar terminal flotante.** |
| `<esc>` o `jk` | Terminal | Volver a modo Normal desde la terminal. |
| `<C-h/j/k/l>` | Terminal | Navegar entre ventanas de Neovim sin salir del terminal. |
