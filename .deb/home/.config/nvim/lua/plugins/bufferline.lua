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
	   	-- buffer_close_icon = "",
      buffer_close_icon = '',
      -- modified_icon = "●",
	    close_icon = "",
		  close_icon = '',
		  left_trunc_marker = "",
		  right_trunc_marker = "",
 ------------------------------------------------
      max_name_length = 30,
		  max_prefix_length = 30, -- prefijo utilizado cuando se elimina la duplicación de un búfer
		  tab_size = 21,
		  diagnostics = false, -- | "nvim_lsp" | "coc",
		  diagnostics_update_in_insert = false,
------------------------------------------------
offsets = { { filetype = "NvimTree", text = "", padding = 1 } },
		  show_buffer_icons = true,
		  show_buffer_close_icons = true,
		  show_close_icon = true,
      show_tab_indicators = true,
		  persist_buffer_sort = true, --  si los búferes ordenados personalizados deben persistir o no
------------------------------------------------
      separator_style = "thin", -- | "thick" | "thin" | { 'any', 'any' },
		  enforce_regular_tabs = true,
		  always_show_bufferline = true,
------------------------------------------------
       style_preset = bufferline.style_preset.no_italic,
            style_preset = {
                bufferline.style_preset.minimal,
                bufferline.style_preset.minima,
              }
}, 
})

-------------------------------------------------
--          Experimemtal 
------------------------------------------------
groups = {
  options = {
    toggle_hidden_on_enter = true -- cuando vuelve a ingresar a un grupo oculto, esta opción vuelve a abrir ese grupo para que el búfer sea visible 
  },
  items = {
    {
      name = "Tests", -- Obligatorio
      highlight = {gui = "underline", guisp = "blue"}, -- Optional
      priority = 2, -- determines where it will appear relative to other groups (Optional)
      icon = "", -- Optional
      matcher = function(buf) -- Mandatory
        return buf.name:match('%_test') or buf.name:match('%_spec')
      end,
    },
    {
      name = "Docs",
      highlight = {gui = "undercurl", guisp = "green"},
      auto_close = false,  -- cerrar o no este grupo si no contiene el búfer actual
      matcher = function(buf)
        return buf.name:match('%.md') or buf.name:match('%.txt')
      end,
      separator = { -- Optional
        style = require('bufferline.groups').separator.tab
      },
    }
  }
}------------------------------------------------
