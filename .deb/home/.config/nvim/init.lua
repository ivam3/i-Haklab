--=====Opciones====== 
--Expande tab a dos espacios
vim.opt.tabstop = 2
vim.opt.shiftwidth = 2
vim.opt.softtabstop = 2
vim.opt.expandtab = true

-- En que modo estamos 
vim.opt.showmode = false
-- Numero de linea
vim.opt.number = true
vim.opt.relativenumber = false
--Tecla lider 
vim.g.mapleader = ','
vim.g.maplocalleader = '.' -- no se para que es 
--===Opciones Fin=====


--====Atajos de teclado====
-- Abrir el init.lua
vim.keymap.set('n', '<leader>ei', '<cmd>:e $MYVIMRC<cr>')
--Terminal
--vim.keymap.set('n', '<leader>t',  '<cmd>:terminal<cr>')
--Guardar 
vim.keymap.set('n', '<leader>s',  '<cmd>:w<cr>')
--
-- Moverse entre buffer 
vim.keymap.set('n', '<S-l>', '<cmd>:bnext<cr>') --shif+l
vim.keymap.set('n', '<S-h>', '<cmd>:bprevious<cr>')
-- Cerrar el buffer actual 
vim.keymap.set('n', '<leader>q', '<cmd>:bdelete!<cr>')
--
--
-- resize de los split
vim.keymap.set('n', '<leader>h+', '<cmd>:exe "resize" . (winheight(0) * 5/4)<cr>')
vim.keymap.set('n', '<leader>h-', '<cmd>:exe "resize" . (winheight(0) * 4/5)<cr>')
vim.keymap.set('n', '<leader>w+', '<cmd>:exe "vertical resize" . (winheight(0) * 5/4)<cr>')
vim.keymap.set('n', '<leader>w-', '<cmd>:exe "horizontal resize" . (winheight(0) * 4/5)<cr>')
--====Fin============

----------------------------------------------
--      Administrador de paquetes
----------------------------------------------
--https://github.com/folke/lazy.nvim
-- :Lazy
local lazy = {}

function lazy.install(path)
  if not vim.loop.fs_stat(path) then
    print('Installing lazy.nvim....')
    vim.fn.system({
      'git',
      'clone',
      '--filter=blob:none',
      'https://github.com/folke/lazy.nvim.git',
      '--branch=stable', -- latest stable release
      path,
    })
  end

  neural_path = vim.fn.stdpath('data') .. '/lazy/neural'
  if vim.fn.empty(vim.fn.glob(neural_path)) > 0 then
    vim.fn.system({
      'git',
      'clone',
      '--depth',
      '1',
      'https://github.com/dense-analysis/neural.git',
      neural_path,
    })
    -- Agregar la ruta al directorio de neural a la variable 'runtimepath'
    vim.o.runtimepath = vim.o.runtimepath .. ',' .. neural_path
  end
end

function lazy.setup(plugins)
-- Pueden comentar la siguiente línea una vez que lazy.nvim esté instalado
  lazy.install(lazy.path)

  vim.opt.rtp:prepend(lazy.path)
  require('lazy').setup(plugins, lazy.opts)
end

--Ruta de configuracion 
lazy.path = vim.fn.stdpath('data') .. '/lazy/lazy.nvim'
lazy.opts = {}

lazy.setup({
  ---
  -- Lista de plugins
  -- Un tema limpio y oscuro de Neovim
  {'folke/tokyonight.nvim'},
  --Bara infeeior de la pantalla 
  {'nvim-lualine/lualine.nvim'},
  -- navegar por el árbol de archivos
  {'preservim/nerdtree', version = "*", dependencies = 'ryanoasis/vim-devicons'},
  -- Configuracion para LSP 
  {'neovim/nvim-lspconfig'},
  -- mostrar todos los archivos abiertos
  {'akinsho/bufferline.nvim', version = "*", dependencies = 'nvim-tree/nvim-web-devicons'},
  -- Línea en blanco de sangría
  {'lukas-reineke/indent-blankline.nvim'},
  -- Para comentar codigo
  {'numToStr/Comment.nvim'}, 
  -- filtrar de manera interactiva
    {
    'nvim-telescope/telescope.nvim', tag = '0.1.1',
-- or                              , branch = '0.1.1',
      dependencies = { 'nvim-lua/plenary.nvim' }
    },
  -- Terminal
  {'akinsho/toggleterm.nvim'},

  ------------------------------------
  --     Autocompletado
  -------------------------------------
  -- autocompletado cómodo e inteligente
    {'hrsh7th/nvim-cmp'},
  -- proporciona sugerencias basadas en el archivo actual.
    {'hrsh7th/cmp-buffer'},
  -- proporciona finalizaciones basadas en el sistema de archivos.
    {'hrsh7th/cmp-path'},
  -- muestra snippets en las sugerencias.
    {'saadparwaiz1/cmp_luasnip'},
  -- muestra los datos enviados por el servidor de idioma.  
    {'hrsh7th/cmp-nvim-lsp'},
  -- proporciona finalizaciones basadas en la api lua de neovim.  
    {'hrsh7th/cmp-nvim-lua'},
    {'hrsh7th/vim-vsnip'},
    {'rafamadriz/friendly-snippets'},
  -- proporciona a Neural plugin para el uso de api de openAI|chatGPT 
    {'dense-analysis/neural'},
    {'muniftanjim/nui.nvim'},
    {'elpiloto/significant.nvim'},
  -- Lista de plugins para el uso de api de openAI|chatGPT 
    {'dense-analysis/neural'},
    {'muniftanjim/nui.nvim'},
    {'elpiloto/significant.nvim'},
----------------------------------------------
-- Pendiente 
-- https://github.com/tpope/vim-surround
-- https://github.com/editorconfig/editorconfig-vim
-- https://github.com/folke/which-key.nvim
})

-- Configure Neural like so in Lua
require('neural').setup({
    source = {
        openai = {
            api_key = "OPENAI_KEY" 
        },
    }
})


-------------------------------------------------↴
--          =====indicadores====
-- help gitsigns-functions   help gitsigns-config
-- -------------------------------------------------↴


-------------------------------------------------
--      ====Toggleterm====
--
--    https://github.com/akinsho/toggleterm.nvim#roadmap
-------------------------------------------------
require('toggleterm').setup({
  open_mapping = '<C-g>',
  direction = 'float', -- horizontal, vertical o float
  shade_terminals = true
})
-------------------------------------------------
--       ==== Telescope===
-- Comandos y upciones       
--:Telescope builtin:Telescope builtin
--:help telescope.setup()
--https://github.com/nvim-telescope/telescope.nvim
-------------------------------------------------
--require('telescope').setup{}
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
-- Ejecuta una búsqueda interactiva en el archivo actual.
vim.keymap.set('n', '<leader>fs', '<cmd>Telescope current_buffer_fuzzy_find<cr>')
-------------------------------------------------
--       ====Comment===
--   https://github.com/numToStr/Comment.nvim#%EF%B8%8F-setup 
---------------------------------------------------
require('Comment').setup({})
-------------------------------------------------
--       =======guías de indentación=======
--      :help indent-blankline-variablessin 
---------------------------------------------------
vim.opt.termguicolors = true
vim.cmd [[highlight IndentBlanklineIndent1 guifg=#E06C75 gui=nocombine]]
vim.cmd [[highlight IndentBlanklineIndent2 guifg=#E5C07B gui=nocombine]]
vim.cmd [[highlight IndentBlanklineIndent3 guifg=#98C379 gui=nocombine]]
vim.cmd [[highlight IndentBlanklineIndent4 guifg=#56B6C2 gui=nocombine]]
vim.cmd [[highlight IndentBlanklineIndent5 guifg=#61AFEF gui=nocombine]]
vim.cmd [[highlight IndentBlanklineIndent6 guifg=#C678DD gui=nocombine]]

vim.opt.list = true
vim.opt.listchars:append "space:⋅"
vim.opt.listchars:append "eol:↴"

require("indent_blankline").setup {
    space_char_blankline = " ",
    char_highlight_list = {
        "IndentBlanklineIndent1",
        "IndentBlanklineIndent2",
        "IndentBlanklineIndent3",
        "IndentBlanklineIndent4",
        "IndentBlanklineIndent5",
        "IndentBlanklineIndent6",
    },
}

-------------------------------------------------
--		=======bufferline=======
--
--		:help bufferline-highlights.
-------------------------------------------------
vim.opt.termguicolors = true
require('bufferline').setup {
  options = {
      numbers = 'none',
      diagnostics = 'nvim_lsp',
      seperator_style = 'padded_slant',
      show_tab_indicators = true,
      show_buffer_close_icons = false,
      show_close_icon = true,
    },
  }
-------------------------------------------------
--		=======LSP=======
--	:help lspconfig-server-configurations
-------------------------------------------------
-- Configurar servidores de idiomas.
local lspconfig = require('lspconfig')
local lsp_defaults = lspconfig.util.default_config

lsp_defaults.capabilities = vim.tbl_deep_extend(
  'force',
  lsp_defaults.capabilities,
  require('cmp_nvim_lsp').default_capabilities()
)
-- Para conocer las opciones disponibles en la función .setup
-- :help lspconfig-setup 
lspconfig.lua_ls.setup({
  single_file_support = true,
  flags = {
    debounce_text_changes = 150,
  },
}) -- lua
lspconfig.clangd.setup{} -- C++
lspconfig.pyright.setup {}  --python
lspconfig.bashls.setup{}    --bash 
lspconfig.texlab.setup{}    --markdown 
-------------------------------------------------
--              =======lsp Autocompletado=======
--        https://vonheikemen.github.io/devlog/es/tools/setup-nvim-lspconfig-plus-nvim-cmp/      
-------------------------------------------------
vim.opt.completeopt = {'menu', 'menuone', 'noselect'}
--nvim-cmp
local cmp = require 'cmp'
--local luasnip = require('luasnip')

local select_opts = {behavior = cmp.SelectBehavior.Select}

cmp.setup({
  snippet = {
      -- REQUIRED - you must specify a snippet engine
      expand = function(args)
        vim.fn["vsnip#anonymous"](args.body) -- For `vsnip` users.
        -- require('luasnip').lsp_expand(args.body) -- For `luasnip` users.
        -- require('snippy').expand_snippet(args.body) -- For `snippy` users.
        -- vim.fn["UltiSnips#Anon"](args.body) -- For `ultisnips` users.
      end,
    },
   sources = {
  {name = 'vsnip'},
 -- Autocompleta rutas de archivos
  {name = 'path'},
  -- Muestra sugerencias basadas en la respuesta de un servidor LSP.
  {name = 'nvim_lsp', keyword_length = 1},
  -- Sugiere palabras que se encuentra en el archivo actual.
  {name = 'buffer', keyword_length = 3},
  -- Muestra los snippets cargados. Si elegimos un snippet lo expande
  {name = 'luasnip', keyword_length = 2},
},

window = {
  documentation = cmp.config.window.bordered()
},
-- controla el orden en el que aparecen los elementos de un item.
formatting = {
  fields = {'menu', 'abbr', 'kind'},
  format = function(entry, item)
    local menu_icon = {
      nvim_lsp = 'λ',
      luasnip = '⋗',
      buffer = 'Ω',
      path = '🖫',
    };

    item.menu = menu_icon[entry.source.name]
    return item
  end,
  },
  -- lista de atajos
  mapping = {
  -- Navegacion 
  ['<Up>'] = cmp.mapping.select_prev_item(select_opts),
  ['<Down>'] = cmp.mapping.select_next_item(select_opts),
  ['<C-p>'] = cmp.mapping.select_prev_item(select_opts),
  ['<C-n>'] = cmp.mapping.select_next_item(select_opts),
  -- Desplaza el texto de la ventana de documentación.
  ['<C-u>'] = cmp.mapping.scroll_docs(-4),
  ['<C-d>'] = cmp.mapping.scroll_docs(4),
  -- Cancelar el autocompletado.
  ['<C-e>'] = cmp.mapping.abort(),
  -- Confirma la selección.
  ['<C-y>'] = cmp.mapping.confirm({select = true}),
  ['<CR>'] = cmp.mapping.confirm({select = false}),
  -- Salta al próximo placeholder de un snippet.
  ['<C-f>'] = cmp.mapping(function(fallback)
  if luasnip.jumpable(1) then
    luasnip.jump(1)
  else
    fallback()
  end
end, {'i', 's'}),
 -- Salta al placeholder anterior de un snippet
 ['<C-b>'] = cmp.mapping(function(fallback)
  if luasnip.jumpable(-1) then
    luasnip.jump(-1)
  else
    fallback()
  end
end, {'i', 's'}),
-- Autocompletado con tab.
['<Tab>'] = cmp.mapping(function(fallback)
  local col = vim.fn.col('.') - 1

  if cmp.visible() then
    cmp.select_next_item(select_opts)
  elseif col == 0 or vim.fn.getline('.'):sub(col, col):match('%s') then
    fallback()
  else
    cmp.complete()
  end
end, {'i', 's'}),
-- Si la lista de sugerencias es visible, navega al item anterior.
['<S-Tab>'] = cmp.mapping(function(fallback)
  if cmp.visible() then
    cmp.select_prev_item(select_opts)
  else
    fallback()
  end
end, {'i', 's'}),
  },
})  

-- 
snippet = {
  expand = function(args)
    luasnip.lsp_expand(args.body)
  end
},
-----------------Personalizando los íconos de diagnóstico-----


-- Mapas globales. 
-- Ver ':help vim.diagnostic.* `Para documentación sobre cualquiera de las siguientes funciones
----------------------------------------------------------
-- Interactuar con el sistema de diagnóstico 
--
-- Abre una ventana flotante que muestra los errores y mensajes con respecto al cursor.
vim.keymap.set('n', '<space>e', vim.diagnostic.open_float)
-- Permite navegar al error o mensaje anterior.
vim.keymap.set('n', '[d', vim.diagnostic.goto_prev)
-- Permite navegar al siguiente error o mensaje.
vim.keymap.set('n', ']d', vim.diagnostic.goto_next)
-- Guardar los errores y mensajes de diagnóstico en una lista que puede ser revisada más tarde.
vim.keymap.set('n', '<space>q', vim.diagnostic.setloclist)
-------------------------------------------------------------

-- Use el comando automático LspAttach para mapear solo las siguientes claves 
-- después de que el servidor de idioma se conecte al búfer actual
vim.api.nvim_create_autocmd('LspAttach', {
  group = vim.api.nvim_create_augroup('UserLspConfig', {}),
  callback = function(ev)
    -- Habilitar finalización activada por <c-x><c-o>
    vim.bo[ev.buf].omnifunc = 'v:lua.vim.lsp.omnifunc'

-- Asignaciones locales de búfer.
-- Consulte `:help vim.lsp.*` para obtener documentación sobre cualquiera de las siguientes funciones
local opts = { buffer = ev.buf }
-- muestra la ubicación de la declaración del símbolo bajo el cursor
vim.keymap.set('n', 'gD', vim.lsp.buf.declaration, opts)
-- muestra la ubicación de definición del símbolo bajo el cursor
vim.keymap.set('n', 'gd', vim.lsp.buf.definition, opts)
-- muestra información detallada sobre el símbolo bajo el cursor en un cuadro emergente
vim.keymap.set('n', 'K', vim.lsp.buf.hover, opts)
-- muestra la ubicación de la implementación del símbolo
vim.keymap.set('n', 'gi', vim.lsp.buf.implementation, opts)
-- 
vim.keymap.set('n', '<C-k>', vim.lsp.buf.signature_help, opts)
-- añade una carpeta al espacio de trabajo
vim.keymap.set('n', '<space>wa', vim.lsp.buf.add_workspace_folder, opts)
-- elimina una carpeta del espacio de trabajo
vim.keymap.set('n', '<space>wr', vim.lsp.buf.remove_workspace_folder, opts)
-- lista todas las carpetas del espacio de trabajo
vim.keymap.set('n', '<space>wl', function()
    print(vim.inspect(vim.lsp.buf.list_workspace_folders()))
end, opts)
-- muestra la definición del tipo
vim.keymap.set('n', '<space>D', vim.lsp.buf.type_definition, opts)
-- renombra el símbolo bajo el cursor
vim.keymap.set('n', '<space>rn', vim.lsp.buf.rename, opts)
-- muestra una lista de acciones que se pueden realizar en el código seleccionado
vim.keymap.set({ 'n', 'v' }, '<space>ca', vim.lsp.buf.code_action, opts)
-- muestra una lista de referencias al símbolo seleccionado
vim.keymap.set('n', 'gr', vim.lsp.buf.references, opts)
vim.keymap.set('n', '<space>f', function()
vim.lsp.buf.format { async = true }
    end, opts)
  end,
})
-------------------------------------------------
--      NerdTree configuracion
-------------------------------------------------
-- alternar mostrar/ocultar NERDTree usando <C-n> y <líder>n
vim.keymap.set("n", "<leader>n", ":NERDTreeToggle<cr>", {noremap = true})
-- revelar búfer abierto en NERDTree.
vim.keymap.set("n", "<leader>r", "<cmd>:NERDTreeFind<cr>", {noremap = true})
-------------------------------------------------
--            ===tokyonight===
-------------------------------------------------
--===Habilite el esquema de colores 
vim.cmd[[colorscheme tokyonight-moon]]
--para asegurarnos de tener la "mejor versión" del tema. 
vim.opt.termguicolors = true
-------------------------------------------------
--          --======luqline conf ====---
-------------------------------------------------
--Habilitar 
require('lualine').setup()

local lualine = require('lualine')

-- Color table for highlights
-- stylua: ignore
local colors = {
  bg       = '#202328',
  fg       = '#bbc2cf',
  yellow   = '#ECBE7B',
  cyan     = '#008080',
  darkblue = '#081633',
  green    = '#98be65',
  orange   = '#FF8800',
  violet   = '#a9a1e1',
  magenta  = '#c678dd',
  blue     = '#51afef',
  red      = '#ec5f67',
}

local conditions = {
  buffer_not_empty = function()
    return vim.fn.empty(vim.fn.expand('%:t')) ~= 1
  end,
  hide_in_width = function()
    return vim.fn.winwidth(0) > 80
  end,
  check_git_workspace = function()
    local filepath = vim.fn.expand('%:p:h')
    local gitdir = vim.fn.finddir('.git', filepath .. ';')
    return gitdir and #gitdir > 0 and #gitdir < #filepath
  end,
}

-- Config
local config = {
  options = {
    -- Disable sections and component separators
    component_separators = '',
    section_separators = '',
    theme = {
      -- We are going to use lualine_c an lualine_x as left and
      -- right section. Both are highlighted by c theme .  So we
      -- are just setting default looks o statusline
      normal = { c = { fg = colors.fg, bg = colors.bg } },
      inactive = { c = { fg = colors.fg, bg = colors.bg } },
    },
  },
  sections = {
    -- these are to remove the defaults
    lualine_a = {},
    lualine_b = {},
    lualine_y = {},
    lualine_z = {},
    -- These will be filled later
    lualine_c = {},
    lualine_x = {},
  },
  inactive_sections = {
    -- these are to remove the defaults
    lualine_a = {},
    lualine_b = {},
    lualine_y = {},
    lualine_z = {},
    lualine_c = {},
    lualine_x = {},
  },
}

-- Inserts a component in lualine_c at left section
local function ins_left(component)
  table.insert(config.sections.lualine_c, component)
end

-- Inserts a component in lualine_x at right section
local function ins_right(component)
  table.insert(config.sections.lualine_x, component)
end

ins_left {
  function()
    return '▊'
  end,
  color = { fg = colors.blue }, -- Sets highlighting of component
  padding = { left = 0, right = 1 }, -- No necesitamos espacio antes de esto.
}

ins_left {
  -- componente de modo
  function()
    return ''
  end,
  color = function()
    -- cambio automático de color según el modo neovims
    local mode_color = {
      n = colors.red,
      i = colors.green,
      v = colors.blue,
      [''] = colors.blue,
      V = colors.blue,
      c = colors.magenta,
      no = colors.red,
      s = colors.orange,
      S = colors.orange,
      [''] = colors.orange,
      ic = colors.yellow,
      R = colors.violet,
      Rv = colors.violet,
      cv = colors.red,
      ce = colors.red,
      r = colors.cyan,
      rm = colors.cyan,
      ['r?'] = colors.cyan,
      ['!'] = colors.red,
      t = colors.red,
    }
    return { fg = mode_color[vim.fn.mode()] }
  end,
  padding = { right = 1 },
}

ins_left {
  -- componente de tamaño de archivo
  'filesize',
  cond = conditions.buffer_not_empty,
}

ins_left {
  'filename',
  cond = conditions.buffer_not_empty,
  color = { fg = colors.magenta, gui = 'bold' },
}

ins_left { 'location' }

ins_left { 'progress', color = { fg = colors.fg, gui = 'bold' } }

ins_left {
  'diagnostics',
  sources = { 'nvim_diagnostic' },
  symbols = { error = ' ', warn = ' ', info = ' ' },
  diagnostics_color = {
    color_error = { fg = colors.red },
    color_warn = { fg = colors.yellow },
    color_info = { fg = colors.cyan },
  },
}

-- Inserte la sección media.  Puedes hacer cualquier cantidad de secciones en neovim :)
-- para lualine es cualquier número mayor que 2
ins_left {
  function()
    return '%='
  end,
}

ins_left {
  -- Nombre del servidor Lsp.
  function()
    local msg = 'No Active Lsp'
    local buf_ft = vim.api.nvim_buf_get_option(0, 'filetype')
    local clients = vim.lsp.get_active_clients()
    if next(clients) == nil then
      return msg
    end
    for _, client in ipairs(clients) do
      local filetypes = client.config.filetypes
      if filetypes and vim.fn.index(filetypes, buf_ft) ~= -1 then
        return client.name
      end
    end
    return msg
  end,
  icon = ' LSP:',
  color = { fg = '#ffffff', gui = 'bold' },
}

-- Agregar componentes a las secciones correctas
ins_right {
  'o:encoding', -- Componente de opción igual a y codificación en VIML
  fmt = string.upper, -- Tampoco estoy seguro de por qué está en mayúsculas;)
  cond = conditions.hide_in_width,
  color = { fg = colors.green, gui = 'bold' },
}

ins_right {
  'fileformat',
  fmt = string.upper,
  icons_enabled = false, -- Creo que los íconos son geniales, pero Eviline no los tiene.  final
  color = { fg = colors.green, gui = 'bold' },
}

ins_right {
  'branch',
  icon = '',
  color = { fg = colors.violet, gui = 'bold' },
}

ins_right {
  'diff',
  -- ¿Soy yo o el símbolo de nos modificó realmente raro?
  symbols = { added = ' ', modified = '󰝤 ', removed = ' ' },
  diff_color = {
    added = { fg = colors.green },
    modified = { fg = colors.orange },
    removed = { fg = colors.red },
  },
  cond = conditions.hide_in_width,
}

ins_right {
  function()
    return '▊'
  end,
  color = { fg = colors.blue },
  padding = { left = 1 },
}

-- Ahora no olvides inicializar lualine
lualine.setup(config)
--===Find===---
--



