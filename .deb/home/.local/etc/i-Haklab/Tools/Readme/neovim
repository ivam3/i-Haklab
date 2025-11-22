# Documentación de la Configuración de Neovim

Este documento proporciona una visión general completa de esta configuración de Neovim, diseñada para ser un entorno de desarrollo moderno, eficiente y altamente funcional, con un fuerte enfoque en la integración de la IA.

## 1. ¿Qué es Neovim?

**Neovim** es un editor de texto modal basado en Vim, pero modernizado y refactorizado. Hereda toda la potencia y eficiencia de Vim (operación mediante modos, edición sin ratón, alta personalización) y le añade características modernas como una mejor arquitectura de plugins, integración con scripts de Lua, soporte asíncrono nativo y una terminal integrada. Es conocido por su velocidad, bajo consumo de recursos y una comunidad de usuarios muy activa que crea constantemente nuevos plugins y herramientas.

## 2. ¿Qué es Lua y por qué se usa en Neovim?

**Lua** es un lenguaje de programación (scripting) ligero, rápido y potente. Neovim lo ha adoptado como su principal lenguaje de configuración y extensión, reemplazando en gran medida al tradicional VimScript.

**Ventajas de usar Lua en Neovim:**
- **Velocidad:** Lua es significativamente más rápido que VimScript, lo que hace que el editor se inicie y funcione con mayor fluidez.
- **Sintaxis Moderna:** Su sintaxis es más sencilla y legible para quienes vienen de lenguajes como Python o JavaScript.
- **Ecosistema:** Permite el acceso a un vasto ecosistema de librerías a través de LuaJIT y su FFI (Foreign Function Interface), lo que posibilita integraciones más complejas.
- **Mejor API:** Neovim expone una API completa y bien documentada para Lua, permitiendo a los plugins interactuar con el editor de una manera más profunda y estable.

En esta configuración, prácticamente todo (`init.lua`, plugins, atajos) está escrito en Lua.

---

## 3. Plugins Instalados

Esta configuración utiliza `lazy.nvim` como gestor de plugins. A continuación se listan los plugins instalados y su función principal.

| Plugin | Repositorio | Descripción |
| :--- | :--- | :--- |
| **Code Companion** | `olimorris/codecompanion.nvim` | **Asistente de IA principal.** Permite interactuar con modelos como Gemini, OpenAI, etc., directamente en el editor. |
| **zk-nvim** | `mickael-menu/zk-nvim` | Un sistema de toma de notas basado en texto plano, ideal para crear una base de conocimiento personal (Zettelkasten). |
| **Conform** | `stevearc/conform.nvim` | Formatea el código automáticamente al guardar, usando herramientas externas como `prettier`, `black`, `stylua`, etc. |
| **Grammarous** | `rhysd/vim-grammarous` | Revisa la gramática del texto (principalmente en inglés). |
| **Copilot.vim** | `github/copilot.vim` | Integración oficial con GitHub Copilot para sugerencias de código. |
| **Tokyo Night** | `folke/tokyonight.nvim` | El tema de colores oscuro y popular que se usa en esta configuración. |
| **Lualine** | `nvim-lualine/lualine.nvim` | Una barra de estado personalizable y atractiva en la parte inferior de la ventana. |
| **Bufferline** | `akinsho/bufferline.nvim` | Una línea de pestañas en la parte superior para gestionar y navegar entre los archivos abiertos (buffers). |
| **Telescope** | `nvim-telescope/telescope.nvim` | **Buscador interactivo.** Permite buscar archivos, texto, buffers, commits de git y mucho más con una interfaz flotante. |
| **Nvim Tree** | `nvim-tree/nvim-tree.lua` | Un explorador de archivos en forma de árbol, similar al de VSCode. |
| **Indent Blankline** | `lukas-reineke/indent-blankline.nvim` | Muestra líneas verticales para visualizar mejor los niveles de indentación del código. |
| **Toggleterm** | `akinsho/toggleterm.nvim` | Permite abrir y gestionar terminales en ventanas flotantes o divididas. |
| **Neural** | `dense-analysis/neural` | Otro cliente de IA que permite interactuar con modelos de lenguaje. |
| **Git.nvim** | `dinhhuy258/git.nvim` | Proporciona integraciones y utilidades para trabajar con Git. |
| **Smear-Cursor** | `sphamba/smear-cursor.nvim` | Un efecto visual divertido que deja una estela de "fuego" al mover el cursor. |
| **LSP Zero** | `VonHeikemen/lsp-zero.nvim` | **El corazón del autocompletado e IDE.** Facilita la configuración del LSP (Language Server Protocol), autocompletado (con nvim-cmp) y snippets (con LuaSnip). |
| **Transparent** | `xiyaowong/transparent.nvim` | Permite hacer el fondo de Neovim transparente. |
| **Treesitter** | `nvim-treesitter/nvim-treesitter` | **Motor de coloreado de sintaxis.** Analiza el código de forma estructural para un resaltado más preciso y rápido. |
| **Nui** | `muniftanjim/nui.nvim` | Una librería de componentes de UI para que otros plugins puedan crear interfaces complejas. |

---

## 4. Atajos de Teclado (Keymaps)

La `<leader>` key (tecla líder) está configurada por defecto como `alt+,`.

### Navegación y Ventanas
| Atajo | Modo | Descripción |
| :--- | :--- | :--- |
| `<C-h>` | Normal | Moverse a la ventana de la izquierda. |
| `<C-l>` | Normal | Moverse a la ventana de la derecha. |
| `<C-j>` | Normal | Moverse a la ventana de abajo. |
| `<C-k>` | Normal | Moverse a la ventana de arriba. |

### Edición y Archivos
| Atajo | Modo | Descripción |
| :--- | :--- | :--- |
| `<Leader>w` | Normal | Guardar el archivo actual (`:write`). |
| `<Leader>x` | Normal | Guardar y cerrar (`:x`). |
| `<Leader>ei` | Normal | Abrir el archivo de configuración principal (`init.lua`). |
| `<C-w>` | Normal | Guardar el archivo actual (`:w`). |
| `<C-x>` | Normal | Guardar y cerrar (`:x`). |
| `<C-c>` | Normal | Salir sin guardar (`:q!`). |
| `<leader>fm` | Normal | Formatear el archivo actual con `conform.nvim`. |

### Buffers (Pestañas)
| Atajo | Modo | Descripción |
| :--- | :--- | :--- |
| `<C-t>`  | Todos  | Ir a la terminal flotante. |
| `<C-b>p` | Normal | Ir al buffer anterior. |
| `<C-b>q` | Normal | Cerrar el buffer actual. |

### Telescope (Búsqueda)
| Atajo | Modo | Descripción |
| :--- | :--- | :--- |
| `<leader>ff` | Normal | Buscar archivos en el proyecto. |
| `<leader>fa` | Normal | Buscar en TODOS los archivos (incluyendo ocultos e ignorados). |
| `<leader>fw` | Normal | Buscar una cadena de texto en todo el proyecto (live grep). |
| `<leader>fb` | Normal | Buscar en los buffers abiertos. |
| `<leader>fh` | Normal | Buscar en las páginas de ayuda. |

### Plugins e IA
| Atajo | Modo | Descripción |
| :--- | :--- | :--- |
| `<leader>ca`| Normal/Visual | **Abrir el menú de acciones de Code Companion.** |
| `<leader>n` | Normal | Activar la interacción con el plugin `neural`. |
| `<leader>te`| Normal | Activar fondo transparente. |
| `<leader>td`| Normal | Desactivar fondo transparente. |
| `<leader>tt`| Normal | Alternar fondo transparente. |
| `<leader>gt`| Normal | Ver el estado de Git con Telescope. |

### Terminal (dentro de una ventana de terminal)
| Atajo | Modo | Descripción |
| :--- | :--- | :--- |
| `<C-b>q`| Terminal | Volver al modo Normal desde el modo de inserción del terminal. |
| `<esc>` o `jk`| Terminal | Volver al modo Normal desde el modo de inserción del terminal. |
| `<C-h/j/k/l>`| Terminal | Navegar entre ventanas de Neovim sin salir del terminal. |

---

## 5. Estructura de la Configuración

- **`init.lua`**: El punto de entrada principal. Carga `lazy.nvim` y la lista de todos los plugins. También carga los demás archivos de configuración.
- **`lua/`**: Directorio principal para la configuración en Lua.
  - **`lua/keymaps.lua`**: Define todos los atajos de teclado personalizados.
  - **`lua/settings.lua`**: Contiene opciones generales de Neovim (números de línea, indentación, etc.).
  - **`lua/plugins/`**: Cada archivo en este directorio contiene la configuración específica para un plugin, manteniendo el `init.lua` limpio.

---

## 6. Gestión de Plugins con Lazy.nvim

`lazy.nvim` facilita la gestión de plugins.
- **`:Lazy`**: Abre la interfaz de `lazy.nvim` para ver el estado de los plugins.
- **`:Lazy sync`**: Sincroniza la configuración, instalando los plugins que falten y eliminando los que ya no estén en la configuración.
- **`:Lazy update`**: Actualiza todos los plugins a su última versión.

---

## 7. Gestión de API Keys

Para los servicios de IA, las claves de API se gestionan en `lua/plugins/codecompanion.lua`. Dentro de este archivo, puedes activar la configuración para diferentes proveedores (Gemini, OpenAI, etc.) y debes colocar tu clave de API en la variable correspondiente. A su vez la clave de API para neural se configura en `lua/plugins/neural.lua`.
