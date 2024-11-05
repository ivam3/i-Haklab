-- Variables   locales   
local fn = vim.fn
local g = vim.g
local opt  = vim.opt
----------------------------------------
--            Notas   
------------------------------------------
-- Sugerencia: use `:h <opción>` para averiguar el significado si es necesario
------------------------------------------

-- General
g.mapleader = ','

opt.shell = "/bin/sh"               -- Para  evitar   conflicto con   fish    
opt.completeopt = {'menu', 'menuone', 'noselect'} -- Auto completado  
opt.clipboard=unnamedplus           -- Usar la clipboard del sistema   
opt.mouse = 'a'                     -- Usar  el  maus  


-- Tab  
opt.tabstop = 4                 -- number of visual spaces per TAB    
opt.softtabstop = 4             -- number of spacesin tab when editing
opt.shiftwidth = 4              -- insert 4 spaces on a tab
opt.expandtab = true            -- tabs are spaces, mainly because of python

-- Searching
vim.opt.incsearch = true            -- search as characters are entered
vim.opt.hlsearch = false            -- do not highlight matches
vim.opt.ignorecase = true           -- ignore case in searches by default
vim.opt.smartcase = true            -- but make it case sensitive if an uppercase is entered

-- UI config
opt.number = true               -- show absolute number
opt.relativenumber = true       -- add numbers to each line on the left side
opt.cursorline = true           -- highlight cursor line underneath the cursor horizontally
opt.splitbelow = true           -- open new vertical split bottom
opt.splitright = true           -- open new horizontal splits right
vim.opt.termguicolors = true    -- enabl 24-bit RGB color in the TUI
opt.showmode = false
opt.signcolumn = 'yes'           -- Espacio  
opt.termguicolors = true         -- "mejor versión" del tema de color
opt.wrap = true

-- LSP                    
vim.opt.signcolumn = 'yes'      --   Reserva un espacio en la cuneta    

