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

Esta configuración usa `nvim-ufo` con proveedor Treesitter + indent.
`foldmethod=expr`, `foldlevel=99`. Todos los comandos nativos de plegado
de Vim (`:h fold`) funcionan normalmente.

| Atajo | Acción |
| :--- | :--- |
| `zo` | **Abrir** pliegue bajo el cursor. |
| `zc` | **Cerrar** pliegue bajo el cursor. |
| `za` | **Alternar** (abrir/cerrar) pliegue bajo el cursor. |
| `zO` | Abrir **todos** los pliegues recursivamente. |
| `zC` | Cerrar **todos** los pliegues recursivamente. |
| `zA` | Alternar recursivamente (abrir/cerrar todo). |
| `zv` | Abrir pliegues lo suficiente para **revelar** el cursor. |
| `zx` | **Re-aplicar** plegado (deshacer aperturas/cierres manuales). |
| `zX` | Re-aplicar plegado (versión extendida de `zx`). |
| `zm` | Plegar **más** (aumenta profundidad: `foldlevel--`). |
| `zM` | **Cerrar todos** los pliegues del buffer (`foldlevel=0`). |
| `zr` | Plegar **menos** (reduce profundidad: `foldlevel++`). |
| `zR` | **Abrir todos** los pliegues del buffer (`foldlevel=99`). |
| `zn` | **Deshabilitar** plegado temporalmente. |
| `zN` | **Restaurar** plegado. |
| `zi` | **Alternar** plegado on/off globalmente. |
| `zp` | **Visualizar** líneas plegadas sin abrir el pliegue (peek). |

### Transparencia y UI
| Atajo | Descripción |
| :--- | :--- |
| `<leader>tt` | Alternar transparencia del fondo. |
| `<leader>te` | Habilitar transparencia. |
| `<leader>td` | Deshabilitar transparencia. |

### LSP (Lenguajes y Diagnósticos)

Configurado en `lua/plugins/lsp-zero.lua`. Funcionan en buffers con servidor de lenguaje activo (Python, Lua, Bash, C/C++, etc.).

| Atajo | Modo | Acción |
| :--- | :--- | :--- |
| `K` | Normal | Mostrar **documentación** del símbolo bajo el cursor (hover). |
| `gd` | Normal | **Ir a la definición** del símbolo. |
| `gD` | Normal | Ir a la **declaración**. |
| `gi` | Normal | Ir a la **implementación**. |
| `go` | Normal | Ir a la **definición de tipo**. |
| `gr` | Normal | Listar todas las **referencias** del símbolo. |
| `gs` | Normal | Mostrar **ayuda de firma** (argumentos de función). |
| `<F3>` | Normal | **Renombrar** símbolo en todo el proyecto. |
| `<F4>` | Normal | Listar **acciones de código** disponibles. |
| `<F4>` | Visual | Listar acciones de código para el rango seleccionado. |
| `gl` | Normal | Abrir **diagnóstico** de la línea actual en ventana flotante. |
| `[d` | Normal | Ir al **diagnóstico anterior**. |
| `]d` | Normal | Ir al **siguiente diagnóstico**. |

### Autocompletado (nvim-cmp)

Al escribir, aparece un menú con sugerencias. Navegación dentro del menú:

| Atajo | Acción |
| :--- | :--- |
| `<C-p>` | Seleccionar ítem **anterior** en el menú. |
| `<C-n>` | Seleccionar ítem **siguiente** en el menú. |
| `<C-u>` | Desplazar ventana de documentación **hacia arriba**. |
| `<C-d>` | Desplazar ventana de documentación **hacia abajo**. |
| _Enter_ | Confirmar selección actual. |

---

## 6. Atajos Esenciales de Vim/Neovim (Nativos)

### 6.1 Modos
| Comando | Descripción |
| :--- | :--- |
| `Esc` o `jk` | Volver a **Modo Normal**. |
| `i` | **Modo Insertar** (insertar antes del cursor). |
| `I` | Insertar al **inicio** de la línea. |
| `a` | Insertar **después** del cursor. |
| `A` | Insertar al **final** de la línea. |
| `o` | **Abrir** nueva línea debajo. |
| `O` | **Abrir** nueva línea arriba. |
| `v` | **Modo Visual** (seleccionar texto). |
| `V` | **Modo Visual de Línea**. |
| `<C-v>` | **Modo Visual de Bloque**. |
| `R` | **Modo Reemplazar** (sobrescribe caracteres). |

### 6.2 Movimiento Básico
| Comando | Descripción |
| :--- | :--- |
| `h` / `j` / `k` / `l` | Izquierda / Abajo / Arriba / Derecha (carácter). |
| `0` | Ir al **inicio** de la línea (columna 0). |
| `^` | Ir al **primer carácter no espacio** de la línea. |
| `$` | Ir al **final** de la línea. |
| `gg` | Ir al **principio** del archivo. |
| `G` | Ir al **final** del archivo. |
| `{n}G` o `{n}gg` | Ir a la **línea n** específica. |
| `w` | Avanzar una **palabra** (signos de puntuación la delimitan). |
| `b` | Retroceder una **palabra**. |
| `e` | Al **final** de la palabra actual o siguiente. |
| `W` / `B` / `E` | Igual que `w`/`b`/`e` pero por PALABRAS (solo espacios). |
| `H` | Ir a la parte **alta** (High) de la pantalla. |
| `M` | Ir a la **mitad** (Middle) de la pantalla. |
| `L` | Ir a la parte **baja** (Low) de la pantalla. |
| `{` | Saltar al **párrafo anterior**. |
| `}` | Saltar al **siguiente párrafo**. |
| `(` | Saltar a la **oración anterior**. |
| `)` | Saltar a la **siguiente oración**. |
| `%` | Saltar al **paréntesis / llave / corchete** coincidente. |
| `zz` | **Centrar** la pantalla en la posición del cursor. |
| `zt` | Colocar el cursor en la **parte superior** de la pantalla. |
| `zb` | Colocar el cursor en la **parte inferior** de la pantalla. |
| `<C-u>` | **Media página arriba** (Up). |
| `<C-d>` | **Media página abajo** (Down). |
| `<C-b>` | **Página completa arriba** (Back). |
| `<C-f>` | **Página completa abajo** (Forward). |
| `<C-y>` | Desplazar pantalla **una línea arriba** (sin mover cursor). |
| `<C-e>` | Desplazar pantalla **una línea abajo** (sin mover cursor). |
| `<C-o>` | Ir **atrás** en el historial de saltos (jump list). |
| `<C-i>` | Ir **adelante** en el historial de saltos. |

### 6.3 Edición Básica
| Comando | Descripción |
| :--- | :--- |
| `u` | **Deshacer** (Undo). |
| `<C-r>` | **Rehacer** (Redo). |
| `.` | **Repetir** el último cambio. |
| `y` | Copiar (Yank). |
| `yy` | Copiar **línea completa**. |
| `p` | Pegar **después** del cursor. |
| `P` | Pegar **antes** del cursor. |
| `d` | Borrar / Cortar. |
| `dd` | Borrar **línea completa**. |
| `x` | Borrar el **carácter bajo el cursor**. |
| `X` | Borrar el **carácter antes del cursor**. |
| `D` | Borrar desde el cursor **hasta el final de línea**. |
| `C` | Cambiar desde el cursor **hasta el final de línea** (pasa a insertar). |
| `cc` | Cambiar (reemplazar) **línea completa**. |
| `s` | **Sustituir** carácter bajo el cursor (pasa a insertar). |
| `S` | **Sustituir** línea completa. |
| `r` | **Reemplazar** un solo carácter (vuelve a modo normal). |
| `J` | **Unir** línea actual con la siguiente. |
| `~` | Cambiar **mayúscula / minúscula** del carácter bajo el cursor. |
| `<` | **Indentar a la izquierda** (según shiftwidth). |
| `>` | **Indentar a la derecha**. |
| `==` | **Auto-indentar** la línea. |
| `>>` | Indentar línea a la derecha (sin mover cursor). |
| `<<` | Indentar línea a la izquierda. |
| `<C-a>` | **Incrementar** el número bajo el cursor. |
| `<C-x>` | **Decrementar** el número bajo el cursor. |

### 6.4 Búsqueda y Navegación por Patrón
| Comando | Descripción |
| :--- | :--- |
| `/texto` | Buscar **texto** hacia adelante. |
| `?texto` | Buscar **texto** hacia atrás. |
| `n` | Ir a la **siguiente** coincidencia. |
| `N` | Ir a la **anterior** coincidencia. |
| `*` | Buscar la **palabra bajo el cursor** hacia adelante. |
| `#` | Buscar la **palabra bajo el cursor** hacia atrás. |
| `f{char}` | Saltar **hacia adelante** al carácter `{char}` en la línea. |
| `F{char}` | Saltar **hacia atrás** al carácter `{char}` en la línea. |
| `t{char}` | Saltar **hasta antes** del carácter (adelante). |
| `T{char}` | Saltar **hasta después** del carácter (atrás). |
| `;` | **Repetir** el último comando `f`/`t`/`F`/`T`. |
| `,` | Repetir el último comando `f`/`t`/`F`/`T` en **dirección inversa**. |
| `:s/viejo/nuevo/g` | Reemplazar texto en la línea actual. |
| `:%s/viejo/nuevo/g` | Reemplazar texto **globalmente** en todo el archivo. |
| `:%s/viejo/nuevo/gc` | Reemplazar **pidiendo confirmación** cada vez. |

### 6.5 Text Objects (Operador + Objeto)

Se combinan con operadores (`d`, `y`, `c`, `v`). Ejemplos con `d` (borrar):

| Objeto | Descripción | Ejemplo |
| :--- | :--- | :--- |
| `iw` | **Dentro** de la palabra | `diw` = borrar palabra |
| `aw` | **Alrededor** de la palabra (incluye espacio) | `daw` |
| `iW` | Dentro de PALABRA (todo hasta espacio) | `diW` |
| `i(` / `i)` | Dentro de **paréntesis** `( )` | `di(` |
| `a(` / `a)` | Paréntesis **incluyéndolos** | `da(` |
| `i[` / `i]` | Dentro de **corchetes** `[ ]` | `ci[` |
| `i{` / `i}` | Dentro de **llaves** `{ }` | `di{` |
| `i<` / `i>` | Dentro de **ángulos** `< >` | `ci<` |
| `it` | **Dentro de etiqueta** HTML/XML | `dit` |
| `at` | **Alrededor de etiqueta** (incluyéndola) | `dat` |
| `i'` | Dentro de **comillas simples** `' '` | `ci'` |
| `i"` | Dentro de **comillas dobles** `" "` | `ci"` |
| `i\`` | Dentro de **backticks** `` ` `` | `ci\`` |
| `ip` | **Dentro del párrafo** | `dip` |
| `is` | **Dentro de la oración** | `cis` |

Los objetos funcionan con cualquier operador: `y` (copiar), `c` (cambiar), `d` (borrar), `v` (seleccionar visualmente).

### 6.6 Modo Visual (Selección)
| Comando | Descripción |
| :--- | :--- |
| `v` | Iniciar selección **visual por caracteres**. |
| `V` | Iniciar selección **visual por línea**. |
| `<C-v>` | Iniciar selección **visual por bloque**. |
| `o` | Mover el cursor al **otro extremo** de la selección. |
| `aw` | Seleccionar una **palabra**. |
| `iw` | Seleccionar **palabra interior**. |
| `a(` / `i(` | Seleccionar dentro / alrededor de paréntesis. |
| `gv` | **Re-seleccionar** la selección visual anterior. |
| `y` | Copiar (yank) la selección. |
| `d` | Borrar / cortar la selección. |
| `c` | Cambiar la selección (pasa a insertar). |
| `>` | Indentar selección a la derecha. |
| `<` | Indentar selección a la izquierda. |
| `J` | Unir todas las líneas seleccionadas en una sola. |
| `~` | Alternar mayúscula / minúscula de la selección. |
| `u` | Convertir selección a **minúsculas**. |
| `U` | Convertir selección a **mayúsculas**. |

### 6.7 Modo Insertar
| Comando | Descripción |
| :--- | :--- |
| `<C-h>` | Borrar carácter antes del cursor (backspace). |
| `<C-w>` | Borrar **palabra** antes del cursor. |
| `<C-u>` | Borrar todo **desde el inicio de línea** hasta el cursor. |
| `<C-t>` | Indentar **a la derecha** (inserta shiftwidth espacios). |
| `<C-d>` | Indentar **a la izquierda** (borra shiftwidth espacios). |
| `<C-j>` | Insertar **nueva línea** (Enter). |
| `<C-r>{reg}` | Insertar contenido del **registro** `{reg}`. |
| `<C-r>"` | Insertar el **último texto borrado o copiado**. |
| `<C-r>*` | Insertar contenido del **portapapeles del sistema**. |
| `<C-o>` | Ejecutar **un comando** en modo normal y regresar. |
| `<C-v>` | Insertar carácter **literal** (ej. caracteres de control). |
| `<C-k>` | Insertar **dígrafo** (caracteres especiales como ñ, á, ü). |
| `<C-e>` | Insertar el carácter que está **debajo** del cursor. |
| `<C-y>` | Insertar el carácter que está **encima** del cursor. |
| `<C-n>` | **Completar palabra** (siguiente sugerencia). |
| `<C-p>` | **Completar palabra** (anterior sugerencia). |

### 6.8 Registros y Macros
| Comando | Descripción |
| :--- | :--- |
| `"{reg}` | Especificar registro a usar (ej. `"a`, `"b`, `"+`). |
| `"+y` | Copiar (yank) al **portapapeles del sistema**. |
| `"+p` | Pegar desde el **portapapeles del sistema**. |
| `:reg` | Mostrar **todos los registros** y su contenido. |
| `q{reg}` | **Grabar macro** en el registro `{reg}`. |
| `q` | Dejar de grabar la macro. |
| `@{reg}` | **Reproducir** la macro guardada en el registro `{reg}`. |
| `@@` | Repetir la **última macro ejecutada**. |

### 6.9 Marcas (Marks)
| Comando | Descripción |
| :--- | :--- |
| `m{a-zA-Z}` | Establecer **marca** en la posición actual del cursor. |
| `'{a-z}` | Saltar al **inicio de línea** de la marca local. |
| `` `{a-z} `` | Saltar a la **posición exacta** (columna) de la marca local. |
| `'{A-Z}` | Saltar a la marca **entre archivos** (global). |
| `` `. `` | Ir a la posición del **último cambio**. |
| `` `^ `` | Ir a la posición de la **última inserción**. |
| `` `[ `` / `` `] `` | Ir al **inicio / final** del último yank o cambio. |
| `` `< `` / `` `> `` | Ir al **inicio / final** de la última selección visual. |
| `:marks` | Listar todas las marcas definidas. |

### 6.10 Pestañas y Buffers
| Comando | Descripción |
| :--- | :--- |
| `:tabnew` | Crear una nueva **pestaña**. |
| `:tabclose` | Cerrar la pestaña actual. |
| `gt` | Ir a la **siguiente pestaña**. |
| `gT` | Ir a la **pestaña anterior**. |
| `{n}gt` | Ir a la pestaña número `n`. |
| `:bn` | Ir al **siguiente buffer**. |
| `:bp` | Ir al **buffer anterior**. |
| `:bd` | **Eliminar** (cerrar) el buffer actual. |
| `:ls` | Listar todos los buffers abiertos. |

### 6.11 Ventanas y Splits
| Comando | Descripción |
| :--- | :--- |
| `<C-w>s` o `:sp` | Dividir ventana **horizontalmente** (split). |
| `<C-w>v` o `:vsp` | Dividir ventana **verticalmente**. |
| `<C-w>c` | **Cerrar** la ventana actual. |
| `<C-w>o` | Cerrar **otras** ventanas (mantener solo la actual). |
| `<C-w>=` | **Igualar** el tamaño de todas las ventanas. |
| `<C-w>_` | **Maximizar** la altura de la ventana actual. |
| `<C-w>\|` | **Maximizar** el ancho de la ventana actual. |
| `:resize {n}` | Cambiar la altura de la ventana a `n` líneas. |
| `:vertical resize {n}` | Cambiar el ancho de la ventana a `n` columnas. |

### 6.12 Comandos y Trucos Útiles
| Comando | Descripción |
| :--- | :--- |
| `:q!` | Salir **sin guardar** (quitar!). |
| `:w` | **Guardar** el archivo. |
| `:wq` o `:x` | Guardar y **salir**. |
| `:e!` | **Recargar** el archivo (descartar cambios). |
| `:e {archivo}` | **Abrir** otro archivo en el buffer actual. |
| `:help {tema}` | Abrir la ayuda de Neovim sobre `{tema}`. |
| `:nohlsearch` | **Limpiar** el resaltado de la última búsqueda. |
| `:set {opción}?` | Ver el valor actual de una opción. |
| `:!{comando}` | Ejecutar un **comando del shell** (una vez). |
| `:r!{comando}` | Insertar la **salida de un comando** en el buffer. |
| `:r {archivo}` | Insertar el contenido de un **archivo** en el buffer. |
| `:%!{comando}` | Filtrar todo el buffer a través de un comando externo. |
| `gf` | Ir al **archivo** cuyo nombre está bajo el cursor. |
| `g;` | Ir a la **posición del último cambio** en el historial. |
| `g,` | Ir a la **siguiente posición de cambio** en el historial. |
| `ga` | Mostrar el código **ASCII / Unicode** del carácter bajo el cursor. |
| `:scriptnames` | Listar todos los **scripts cargados** con sus rutas. |
| `:messages` | Ver los **mensajes recientes** de Neovim. |
| `:map` | Mostrar **todos los atajos de teclado** definidos. |

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
| `<C-w>` | Terminal | Enviar `Ctrl+W` al proceso interno (ej. cerrar panel en tmux). |

---

## 9. Opciones del Sistema (settings.lua)

Configurado en `lua/settings.lua`. Opciones generales que definen el comportamiento del editor.

### Rendimiento
| Opción | Valor | Descripción |
| :--- | :--- | :--- |
| `updatetime` | `250` | Tiempo en ms para actualizar diagnósticos LSP y swap. Default: 4000. |
| `timeoutlen` | `300` | Tiempo en ms para esperar combinaciones de teclas secuenciales (ej. `<C-b>n`). Default: 1000. |

### Edición
| Opción | Valor | Descripción |
| :--- | :--- | :--- |
| `undofile` | `true` | Guarda el historial de deshacer entre sesiones (persistente). |
| `swapfile` | `false` | Desactiva archivos `.swp` (innecesarios con undofile activo). |
| `backup` | `false` | Desactiva archivos `~` de backup. |
| `confirm` | `true` | Pregunta "¿Guardar cambios?" en lugar de fallar al cerrar sin guardar. |
| `clipboard` | `unnamedplus` | Usa el portapapeles del sistema para copiar/pegar. |
| `mouse` | `a` | Habilita el ratón en todos los modos. |
| `shell` | `/bin/sh` | Evita conflictos con shells no compatibles (fish). |

### Visualización
| Opción | Valor | Descripción |
| :--- | :--- | :--- |
| `scrolloff` | `8` | Mantiene 8 líneas de contexto visibles arriba/abajo del cursor. |
| `sidescrolloff` | `8` | Mantiene 8 columnas de margen horizontal antes de desplazar. |
| `pumheight` | `10` | Limita el menú de autocompletado a 10 ítems visibles. |
| `number` | `true` | Muestra números de línea absolutos. |
| `relativenumber` | `true` | Muestra números relativos (distancia al cursor). |
| `cursorline` | `true` | Resalta la línea donde está el cursor. |
| `termguicolors` | `true` | Activa color de 24 bits en la terminal. |
| `signcolumn` | `yes` | Reserva espacio a la izquierda para diagnósticos LSP. |
| `wrap` | `true` | Salto de línea automático (word wrap). |
| `showmode` | `false` | Oculta "-- INSERT --" porque lualine ya lo muestra. |

### Tabulación
| Opción | Valor | Descripción |
| :--- | :--- | :--- |
| `tabstop` | `4` | Espacios visuales por tabulador. |
| `softtabstop` | `4` | Espacios al editar dentro de un tab. |
| `shiftwidth` | `4` | Espacios insertados al indentar con `>` / `<`. |
| `expandtab` | `true` | Convierte tabs en espacios. |

### Búsqueda
| Opción | Valor | Descripción |
| :--- | :--- | :--- |
| `incsearch` | `true` | Busca mientras escribes. |
| `hlsearch` | `false` | No resalta permanentemente las coincidencias. |
| `ignorecase` | `true` | Búsqueda sin distinción de mayúsculas. |
| `smartcase` | `true` | Si escribes mayúscula, distingue mayúsculas. |

### Plegado (Fold)
| Opción | Valor | Descripción |
| :--- | :--- | :--- |
| `foldmethod` | `expr` | Método de plegado basado en expresión Treesitter. |
| `foldexpr` | `v:lua.vim.treesitter.foldexpr()` | Expresión Treesitter para plegado sintáctico preciso. |
| `foldenable` | `true` | Habilita el plegado al iniciar. |
| `foldlevel` | `99` | Nivel de plegado inicial (todos abiertos). |
| `foldlevelstart` | `99` | Mismo valor al abrir archivos nuevos. |
| `foldcolumn` | `1` | Muestra una columna con indicadores de plegado. |
