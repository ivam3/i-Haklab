--      ====Toggleterm====
--
--    https://github.com/akinsho/toggleterm.nvim#roadmap
-------------------------------------------------
require('toggleterm').setup({
  open_mapping = '<C-t>',
  direction = 'float', -- horizontal, vertical o float
  shade_terminals = true,
  persist_size = false,
  float_opts = {  -- Tamaño y posicion de terminal
    border = 'double',
    width = 90,
    height = 15,
    winblend = 3,
    zindex = 6,
  },
})
