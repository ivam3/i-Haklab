--[[ 
-- sintaxis 
-- vim.keymap.set(<mode>, <key>, <action>, <opts>)      
-- Help 
-- :h vim.keymap.set   
--]]

-- Variable  
local map = vim.keymap.set

  
------------------------------------------------------
--           Window      
------------------------------------------------------
map("n", "<C-h>", "<C-w>h", { desc = "switch window left" })
map("n", "<C-l>", "<C-w>l", { desc = "switch window right" })
map("n", "<C-j>", "<C-w>j", { desc = "switch window down" })
map("n", "<C-k>", "<C-w>k", { desc = "switch window up" })


------------------------------------------------------
--        Formateador 
------------------------------------------------------
map("n", "<leader>fm", function()
  require("conform").format { lsp_fallback = true }
end, { desc = "general format file" })

------------------------------------------------------
---           Telescope
------------------------------------------------------
map("n", "<leader>fw", "<cmd>Telescope live_grep<CR>", { desc = "telescope live grep" })
map("n", "<leader>fb", "<cmd>Telescope buffers<CR>", { desc = "telescope find buffers" })
map("n", "<leader>fh", "<cmd>Telescope help_tags<CR>", { desc = "telescope help page" })
map("n", "<leader>ma", "<cmd>Telescope marks<CR>", { desc = "telescope find marks" })
map("n", "<leader>fo", "<cmd>Telescope oldfiles<CR>", { desc = "telescope find oldfiles" })
map("n", "<leader>fz", "<cmd>Telescope current_buffer_fuzzy_find<CR>", { desc = "telescope find in current buffer" })
map("n", "<leader>cm", "<cmd>Telescope git_commits<CR>", { desc = "telescope git commits" })
map("n", "<leader>gt", "<cmd>Telescope git_status<CR>", { desc = "telescope git status" })
map("n", "<leader>pt", "<cmd>Telescope terms<CR>", { desc = "telescope pick hidden term" })
map("n", "<leader>ff", "<cmd>Telescope find_files<cr>", { desc = "telescope find files" })
map(
  "n",
  "<leader>fa",
  "<cmd>Telescope find_files follow=true no_ignore=true hidden=true<CR>",
  { desc = "telescope find all files" }
)

------------------------------------------------------
--            Mios  xD   
------------------------------------------------------
-- map leader+w to save current file in normal mode
map("n", "<Leader>w", ":write<CR>", { noremap = true, silent = true })
-- Abrir el init.lua
map('n', '<leader>ei', '<cmd>:e $MYVIMRC<cr>')
-- Guardar cambios y Cerrar neovim 
map('n', '<leader>x', '<cmd>:x<cr>')

------------------------------------------------------
--           Buffer 
------------------------------------------------------
-- Moverse entre buffer 
map('n', '<C-b>n', '<cmd>:bnext<cr>') 
map('n', '<C-b>p', '<cmd>:bprevious<cr>')
-- Cerrar el buffer actual 
map('n', '<C-b>q', '<cmd>:bdelete<cr>')
-- Cerrar neovim sin guardar
map('n', '<C-c>', '<cmd>:q!<cr>')
-- Guardar cambios
map('n', '<C-w>', '<cmd>:w<cr>')
-- Guardar cambios y Cerrar neovim 
map('n', '<C-x>', '<cmd>:x<cr>')
---==========================
--
 
-----------------------------------------------------
--  Cambiar tamaño de wentana   Pendiente 
------------------------------------------------------
--[[
map('n', '<C-i>l', '<cmd>:exe "resize" . (winheight(0) * 5/4)<cr>')
map('n', '<C-i>h', '<cmd>:exe "resize" . (winheight(0) * 4/5)<cr>')
map('n', '<C-i>j', '<cmd>:exe "vertical resize" . (winheight(0) * 5/4)<cr>')
map('n', '<C-i>k', '<cmd>:exe "horizontal resize" . (winheight(0) * 4/5)<cr>')
--]]
---========================

------------------------------------------------------
--     Asignaciones de ventanas de terminal
------------------------------------------------------
function _G.set_terminal_keymaps()
  local opts = {buffer = 0}
  map('t', '<esc>', [[<C-\><C-n>]], opts)
  map('t', 'jk', [[<C-\><C-n>]], opts)
  map('t', '<C-h>', [[<Cmd>wincmd h<CR>]], opts)
  map('t', '<C-j>', [[<Cmd>wincmd j<CR>]], opts)
  map('t', '<C-k>', [[<Cmd>wincmd k<CR>]], opts)
  map('t', '<C-l>', [[<Cmd>wincmd l<CR>]], opts)
  map('t', '<C-w>', [[<C-\><C-n><C-w>]], opts)
end
-- if you only want these mappings for toggle term use term://*toggleterm#* instead
vim.cmd('autocmd! TermOpen term://* lua set_terminal_keymaps()')

-- Activa interaccion con chatGPT de openAI con neura
map('n', '<leader>n', '<cmd>Neural<cr>')

-- Activar / desactivar fondo transparente
map('n', '<leader>te', '<cmd>TransparentEnable<cr>')
map('n', '<leader>td', '<cmd>TransparentDisable<cr>')
map('n', '<leader>tt', '<cmd>TransparentToggle<cr>')
