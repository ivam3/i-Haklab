-----------------------------------------------
--           Documentaciom 
-----------------------------------------------
-- :help bufferline-configuration
-- https://github.com/akinsho/bufferline.nvim   
-----------------------------------------------
local bufferline = require('bufferline')
bufferline.setup ({
   options = {
     numbers = "none",
     close_command = "Bdelete! %d", -- Acsion de raton 
     right_mouse_command = "Bdelete! %d",
     left_mouse_command = "buffer %d",
     middle_mouse_command = nil, ---------
     -- Nota: no cambuar ...&
      indicator_icon = "▎",
	   	-- buffer_close_icon = "",
      buffer_close_icon = '',
      -- modified_icon = "●",
		  close_icon = '',
		  left_trunc_marker = "",
		  right_trunc_marker = "",
 ------------------------------------------------
      max_name_length = 30,
		  max_prefix_length = 30, -- prefijo utilizado cuando se elimina la duplicación de un búfer
		  tab_size = 21,
		  diagnostics = "nvim_lsp", -- show LSP errors and warnings in the tabline
		  diagnostics_update_in_insert = false,
------------------------------------------------
offsets = { { filetype = "NvimTree", text = "  Explorador  ", padding = 1, separator = true } },
		  show_buffer_icons = true,
		  show_buffer_close_icons = true,
		  show_close_icon = true,
      show_tab_indicators = true,
		  persist_buffer_sort = true, --  si los búferes ordenados personalizados deben persistir o no
------------------------------------------------
      separator_style = "thin", -- | "thick" | "thin" | { 'any', 'any' },
		  enforce_regular_tabs = false,
		  always_show_bufferline = true,
      hover = { enabled = true, delay = 200, reveal = { "close" } },
------------------------------------------------
       -- Single style preset (a duplicate assignment here would shadow the first one)
       style_preset = bufferline.style_preset.minimal,
},
})

-------------------------------------------------
-- Buffer groups (must use groups.setup; a bare global table has no effect)
-------------------------------------------------
require("bufferline.groups").setup({
  options = {
    toggle_hidden_on_enter = true -- reopens a hidden group when entering one of its buffers
  },
  items = {
    {
      name = "Tests", -- Mandatory
      highlight = {gui = "underline", guisp = "blue"}, -- Optional
      priority = 2, -- determines where it will appear relative to other groups (Optional)
      icon = "", -- Optional
      matcher = function(buf) -- Mandatory
        return buf.name:match('%_test') or buf.name:match('%_spec')
      end,
    },
    {
      name = "Docs",
      highlight = {gui = "undercurl", guisp = "green"},
      auto_close = false,  -- whether or not to close this group if it doesn't contain the current buffer
      matcher = function(buf)
        return buf.name:match('%.md') or buf.name:match('%.txt')
      end,
      separator = { -- Optional
        style = require('bufferline.groups').separator.tab
      },
    }
  }
})
