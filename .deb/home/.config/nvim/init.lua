vim.env.PATH = vim.env.PATH .. ':/data/data/com.termux/files/usr/bin'
-- Bootstrap lazy.nvim
local lazypath = vim.fn.stdpath("data") .. "/lazy/lazy.nvim"
if not (vim.uv or vim.loop).fs_stat(lazypath) then
  local lazyrepo = "https://github.com/folke/lazy.nvim.git"
  print('Installing lazy.nvim....')
  local out = vim.fn.system({ "git", "clone", "--filter=blob:none", "--branch=stable", lazyrepo, lazypath })
  if vim.v.shell_error ~= 0 then
    vim.api.nvim_echo({
      { "Failed to clone lazy.nvim:\n", "ErrorMsg" },
      { out, "WarningMsg" },
      { "\nPress any key to exit..." },
    }, true, {})
    vim.fn.getchar()
    os.exit(1)
  end
end
vim.opt.rtp:prepend(lazypath)


require("lazy").setup({
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
  -- formatting!
  {
    "stevearc/conform.nvim",
    opts = {},
  },
  {'rhysd/vim-grammarous'},
  -- Github Copilot
  {'github/copilot.vim'}, -- CONFIGURATION NEEDED RUNNING ':Copilot setup .''
  -- Tema 
  {'folke/tokyonight.nvim'},
  -- Linea inferiol
  {'nvim-lualine/lualine.nvim'},
  -- Linea superiol 
  {'akinsho/bufferline.nvim', version = "*", dependencies = 'nvim-tree/nvim-web-devicons'},
  -- Buscar de forma interavtiva 
  {
    'nvim-telescope/telescope.nvim', tag = '0.1.8',
-- or                              , branch = '0.1.xx,
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
{
    "lukas-reineke/indent-blankline.nvim", 
},    
    -- Tarminal 
     {'akinsho/toggleterm.nvim', version = "*", config = true},
   -- IA 
   {'dense-analysis/neural'},
   {'muniftanjim/nui.nvim'},
   {'elpiloto/significant.nvim'},
   -- {'williamboman/nvim-lsp-installer'},
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
require("plugins.formatting")         -- Formatting  
require('plugins.tokyonight')         -- Tema 
require('plugins.lualine')            -- Lina inferiol 
require('plugins.bufferline')         -- Line superiol   
require('plugins.lsp-zero')           -- Soporte para LSP 
require('plugins.blankline')          -- guías de sangría a todas las líneas  
require("plugins.telescope")          -- filtrar de forma interactiva
require("plugins.toggleterm")         -- Terminal 
require("plugins.neural")             -- IA  
require("plugins.git")                -- Cosas de git 
require("zk")                         -- Para texto sin formato 
