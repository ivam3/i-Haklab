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
end

function lazy.setup(plugins)
  -- Pueden comentar la siguiente línea una vez que lazy.nvim esté instalado
  lazy.install(lazy.path)

  vim.opt.rtp:prepend(lazy.path)
  require('lazy').setup(plugins, lazy.opts)
end

lazy.path = vim.fn.stdpath('data') .. '/lazy/lazy.nvim'
lazy.opts = {}

lazy.setup({
  ---
  -- Lista de plugins
  --- Partomar  notas de texto sin formato
  {
  "mickael-menu/zk-nvim",
  config = function()
    require("zk").setup({
      -- See Setup section below
    })
  end
},
  {'rhysd/vim-grammarous'},
  -- Tema 
  {'folke/tokyonight.nvim'},
  -- Linea inferiol
  {'nvim-lualine/lualine.nvim'},
  -- Linea superiol 
  {'akinsho/bufferline.nvim', version = "*", dependencies = 'nvim-tree/nvim-web-devicons'},
  -- Buscar de forma interavtiva 
  {
    'nvim-telescope/telescope.nvim', tag = '0.1.1',
-- or                              , branch = '0.1.1',
      dependencies = { 'nvim-lua/plenary.nvim' }
    },

    -- Albol de directorio 
  {
  "nvim-tree/nvim-tree.lua",
  version = "*",
  dependencies = {
    "nvim-tree/nvim-web-devicons",
  },
  config = function()
    require("nvim-tree").setup {}
  end,
},
   -- Linea en blanco de sangría 
   { "lukas-reineke/indent-blankline.nvim" },
   -- Tarminal 
     {'akinsho/toggleterm.nvim', version = "*", config = true},
   -- IA 
   {'dense-analysis/neural'},
   {'muniftanjim/nui.nvim'},
   {'elpiloto/significant.nvim'},
   {'williamboman/nvim-lsp-installer'},
   -- Gir ---> Pendiente a cambiar 
   {'dinhhuy258/git.nvim'},
----------------------------------------------------
{
  'VonHeikemen/lsp-zero.nvim',
  branch = 'v1.x',
  dependencies = {
    -- LSP Support
    {'neovim/nvim-lspconfig'},             -- Required
    -- Autocompletion
    {'hrsh7th/nvim-cmp'},         --
    {'hrsh7th/cmp-nvim-lsp'},   
    {'hrsh7th/cmp-buffer'},       
    {'hrsh7th/cmp-path'},         
    {'saadparwaiz1/cmp_luasnip'}, 
    {'hrsh7th/cmp-nvim-lua'},
    {'jiangmiao/auto-pairs'},

    -- Snippets
    {'L3MON4D3/LuaSnip'},             
    {'rafamadriz/friendly-snippets'},
    -- transparent background
    {'xiyaowong/transparent.nvim'},
    {'nvim-treesitter/nvim-treesitter'},
  }
}
----------------------------------------------------
})
----------------------------------
--        ==Arcivo de  configuracion===
------------------------------------
require('settings')
require('keymaps')
require('plugins.tokyonight') -- Tema 
require('plugins.lualine')    -- Lina inferiol 
require('plugins.bufferline') --- Line superiol   
require('plugins.lsp-zero') -- Soporte para LSP 
require('plugins.blankline') -- guías de sangría a todas las líneas (incluidas las líneas vacías).
require("plugins.telescope")  -- filtrar de forma interactiva
require("plugins.toggleterm")  -- Terminal 
require("plugins.neural")  -- IA  -- IA  
require("plugins.tree")     -- Albor de directoria 
require("plugins.git")      -- Cosas de git 
require("zk")              -- Para texto sin formato 
