--[[local ensure_packer = function()
local fn = vim.fn
local install_path = fn.stdpath('data')..'/site/pack/packer/start/packer.nvim'
  if fn.empty(fn.glob(install_path)) > 0 then
    fn.system({'git', 'clone', '--depth', '1', 'https://github.com/wbthomason/packer.nvim', install_path})    vim.cmd [[packadd packer.nvim]]
--[[    return true
  end
  return false
end

local packer_bootstrap = ensure_packer()

return require('packer').startup(function(use)
  use 'wbthomason/packer.nvim'
  -- My plugins here
  -- Tema 
  use  'folke/tokyonight.nvim'
  -- Bara inferior de la pantalla 
  use {
  'nvim-lualine/lualine.nvim',
  requires = {{ 'nvim-tree/nvim-web-devicons', opt = true }}
}
   -- Linea superiol 
   use {'akinsho/bufferline.nvim', 
   tag = "*",
   requires = 'nvim-tree/nvim-web-devicons'
 }
   ----------------------
   -- Auto completado 
   -- --------------------
   use {
  'VonHeikemen/lsp-zero.nvim',
 branch = 'v1.x',
  requires = {
    -- Soporte LSP
    {'neovim/nvim-lspconfig'},
   
    -- Autocompletado
    -- 
    {'hrsh7th/nvim-cmp'},
    -- Proporciona finalizaciones basada en el buffer
    {'hrsh7th/cmp-buffer'},
    -- proporciona finalizaciones basadas en el sistema de archivos.
    {'hrsh7th/cmp-path'},
    -- muestra snippets en las sugerencias. [ojo[
    {'saadparwaiz1/cmp_luasnip'},
    -- muestra los datos enviados por el servidor de idioma.
    {'hrsh7th/cmp-nvim-lsp'},
    -- proporciona finalizaciones basadas en la api lua de neovim.
    {'hrsh7th/cmp-nvim-lua'},

    -- Snippets
    {'L3MON4D3/LuaSnip'},
    {'rafamadriz/friendly-snippets'},
  }
}
    -- Albol de directorio 
    use {
  'nvim-tree/nvim-tree.lua',
  tag = "*", requires = {{
    'nvim-tree/nvim-web-devicons'
  }},
  config = function()
    require("nvim-tree").setup {}
  end
}
    --- sangria 
    use "lukas-reineke/indent-blankline.nvim"
    --- filtrar de manera interactiva 
    use {
  'nvim-telescope/telescope.nvim', tag = '0.1.1',
-- or                            , branch = '0.1.x',
  requires = 'nvim-lua/plenary.nvim'
}
  -- Terminal 
  use {"akinsho/toggleterm.nvim", tag = '*', config = function()
  require("toggleterm").setup()
end}
  -- IA 
  use 'dense-analysis/neural'
  --  .///
  use {
    'williamboman/nvim-lsp-installer'
  }
  -- Para Git 
  use {
  'dinhhuy258/git.nvim'
   }
  if packer_bootstrap then
    require('packer').sync()
  end
end)
--]]
--
--
--
local lazypath = vim.fn.stdpath("data") .. "/lazy/lazy.nvim"
if not vim.loop.fs_stat(lazypath) then
  print('Installing lazy.nvim....')
  vim.fn.system({
    "git",
    "clone",
    "--filter=blob:none",
    "https://github.com/folke/lazy.nvim.git",
    "--branch=stable", -- latest stable release
    lazypath,
  })
end
vim.opt.rtp:prepend(lazypath)
require("lazy").setup(plugins, opts)

require("lazy").setup({
     {'folke/tokyonight.nvim'},
})
