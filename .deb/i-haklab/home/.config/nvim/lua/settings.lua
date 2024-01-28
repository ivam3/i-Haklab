-- Neovim API alias 
local cmd = vim.cmd
local exec = vim.api.nvim_exec
local fn = vim.fn
local g = vim.g
local opt  = vim.opt
local map = vim.api.nvim_set_keymap
local default_ops =  {noremap = true , silent = true}
local cmd = vim.cmd


-- General
--
vim.g.mapleader = ','
--
----------------------------------------
--            =UI=
------------------------------------------
--  Desactivar en el modo q estamos 
opt.showmode = false
-- Dame espacio ...? 
opt.signcolumn = 'yes'
-- Expande tab a dos espacios
opt.tabstop = 2
opt.shiftwidth = 2
opt.softtabstop = 2
opt.expandtab = true

opt.number = true  -- numero
opt.termguicolors = true --  "mejor versión" del tema de color

-- Maus
opt.mouse = 'a'
-- Texto largo
opt.wrap = true
-- Lee o modifica valores específicos para una ventana.
--vim.wo.colorcolumn = '80'
opt.cursorline = true

----------------------------------------------
-- Blakline
--
vim.opt.termguicolors = true

-- Autocompletado
--
opt.completeopt = {'menu', 'menuone', 'noselect'}

