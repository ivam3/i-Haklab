-----------------------------------------------------
--  Explorador de archivos.
------------------------------------------------------
-- Abre file 
vim.keymap.set('n', '<leader>f', '<cmd>NvimTreeOpen<cr>')
-- deshabilite netrw al comienzo de su init.lua (muy recomendable)
vim.g.loaded_netrw = 1
vim.g.loaded_netrwPlugin = 1
-- establecer termguicolors para habilitar grupos destacados
vim.opt.termguicolors = true

-----------------------------------------------------
--        😼 
-----------------------------------------------------
-- Abrir el init.lua
vim.keymap.set('n', '<leader>ei', '<cmd>:e $MYVIMRC<cr>')
-- Cerrar neovim sin guardar
vim.keymap.set('n', '<leader>qq', '<cmd>:q!<cr>')
-- Guardar cambios
vim.keymap.set('n', '<leader>w', '<cmd>:w<cr>')
-- Guardar cambios y Cerrar neovim 
vim.keymap.set('n', '<leader>x', '<cmd>:x<cr>')

------------------------------------------------------
--   Buffer 
------------------------------------------------------
-- Moverse entre buffer 
vim.keymap.set('n', '<C-b>n', '<cmd>:bnext<cr>') 
vim.keymap.set('n', '<C-b>p', '<cmd>:bprevious<cr>')
-- Cerrar el buffer actual 
vim.keymap.set('n', '<C-b>q', '<cmd>:bdelete<cr>')
------------------------------------------------------

-----------------------------------------------------
--      Telescope 
------------------------------------------------------
-- Muestra la lista de archivos abiertos.
vim.keymap.set('n', '<leader><space>', '<cmd>Telescope buffers<cr>')
-- Muestra el historial de archivos.
vim.keymap.set('n', '<leader>?', '<cmd>Telescope oldfiles<cr>')
-- Muestra los archivos del directorio de trabajo actual.
vim.keymap.set('n', '<leader>ff', '<cmd>Telescope find_files<cr>')
-- Ejecuta una búsqueda interactiva en cada línea código de cada archivo en el directorio actual.
vim.keymap.set('n', '<leader>fg', '<cmd>Telescope live_grep<cr>')
-- Muestra la lista de "diagnósticos" del archivo actual. Un diagnóstico puede ser un error de sintaxis, una advertencia o una sugerencia.
vim.keymap.set('n', '<leader>fd', '<cmd>Telescope diagnostics<cr>')
-- Ejecuta una búsqueda interactiva en el archivo actual
vim.keymap.set('n', '<leader>fs', '<cmd>Telescope current_buffer_fuzzy_find<cr>')
-- Activa interaccion con chatGPT de openAI con neura
vim.keymap.set('n', '<leader>n', '<cmd>Neural<cr>')
-- Activar / desactivar fondo transparente
vim.keymap.set('n', '<leader>be', '<cmd>TransparentEnable<cr>')
vim.keymap.set('n', '<leader>bd', '<cmd>TransparentDisable<cr>')
vim.keymap.set('n', '<leader>bt', '<cmd>TransparentToggle<cr>')
--------------------------------------------------------------

