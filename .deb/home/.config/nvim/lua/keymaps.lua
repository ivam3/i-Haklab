-- Alias 
local map = vim.api.nvim_set_keymap
local default_ops =  {noremap = true , silent = true}
local cmd = vim.cmd
--local vim = vim.opt

--[[  

<S-l> shef+l
<C-l> control + l 
----]]

------------------------------------------------------
--  Explorador de archivos.
------------------------------------------------------
--  Si quieren personalizarlo primero revisen las opciones disponibles.
--  :help nvim-tree-setup
vim.keymap.set('n', '<F2>', '<cmd>NvimTreeOpen<cr>')
-- deshabilite netrw al comienzo de su init.lua (muy recomendable)
vim.g.loaded_netrw = 1
vim.g.loaded_netrwPlugin = 1
-- establecer termguicolors para habilitar grupos destacados
vim.opt.termguicolors = true
--👇👇👇👇👇👇👇👇👇👇👇👇👇👇
--Mostrar las asignaciones: g?
------------------------------------------------------
--
-- Abrir el init.lua
vim.keymap.set('n', '<leader>ei', '<cmd>:e $MYVIMRC<cr>')
--
------------------------------------------------------
--   Buffer 
------------------------------------------------------
-- Moverse entre buffer 
vim.keymap.set('n', '<C-b>n', '<cmd>:bnext<cr>') 
vim.keymap.set('n', '<C-b>p', '<cmd>:bprevious<cr>')
-- Cerrar el buffer actual 
vim.keymap.set('n', '<C-b>q', '<cmd>:bdelete<cr>')
-- Cerrar neovim sin guardar
vim.keymap.set('n', '<C-c>', '<cmd>:q!<cr>')
-- Guardar cambios
vim.keymap.set('n', '<C-w>', '<cmd>:w<cr>')
-- Guardar cambios y Cerrar neovim 
vim.keymap.set('n', '<C-x>', '<cmd>:x<cr>')
---==========================
--
------------------------------------------------------
--  Cambiar tamaño de wentana   Pendiente 
------------------------------------------------------
--[[
vim.keymap.set('n', '<C-i>l', '<cmd>:exe "resize" . (winheight(0) * 5/4)<cr>')
vim.keymap.set('n', '<C-i>h', '<cmd>:exe "resize" . (winheight(0) * 4/5)<cr>')
vim.keymap.set('n', '<C-i>j', '<cmd>:exe "vertical resize" . (winheight(0) * 5/4)<cr>')
vim.keymap.set('n', '<C-i>k', '<cmd>:exe "horizontal resize" . (winheight(0) * 4/5)<cr>')
--]]
---========================
--
--
-- No estos seguro del uso 
------------------------------------------------------
--     Asignaciones de ventanas de terminal
------------------------------------------------------
function _G.set_terminal_keymaps()
  local opts = {buffer = 0}
  vim.keymap.set('t', '<esc>', [[<C-\><C-n>]], opts)
  vim.keymap.set('t', 'jk', [[<C-\><C-n>]], opts)
  vim.keymap.set('t', '<S-h>', [[<Cmd>wincmd h<CR>]], opts)
  vim.keymap.set('t', '<S-j>', [[<Cmd>wincmd j<CR>]], opts)
  vim.keymap.set('t', '<S-k>', [[<Cmd>wincmd k<CR>]], opts)
  vim.keymap.set('t', '<S-l>', [[<Cmd>wincmd l<CR>]], opts)
  vim.keymap.set('t', '<S-w>', [[<C-\><C-n><C-w>]], opts)
end
vim.cmd('autocmd! TermOpen term://* lua set_terminal_keymaps()')
------------------------------------------------------
--      Telescope 
------------------------------------------------------
-- ~/.config/nvim/lua/plugins/telescope.lua
----------------------
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

--
------------------------
--   lsp-zero predeterminado
-------------------------
-- ~/.config/nvim/lua/plugins/lsp-zero.lua
--
-- Copia al portapapeles. No es para termux
--vim.keymap.set({'n', 'x'}, 'cp', '"+y')
-- Pegar desde el portapapeles.
--vim.keymap.set({'n', 'x'}, 'cv', '"+p')
