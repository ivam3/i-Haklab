vim.env.TMPDIR = '/data/data/com.termux/files/usr/tmp'

local lazy = {}

vim.env.PATH = vim.env.PATH .. ':/data/data/com.termux/files/usr/bin'

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
  -- formatting!
  {
    "stevearc/conform.nvim",
    opts = {},
  },
  {'rhysd/vim-grammarous'},
  -- Github Copilot
  {'github/copilot.vim', commit = 'dfe0a3a1c256167d181488a73ec6ccab8d8931a9'}, -- CONFIGURATION NEEDED RUNNING ':Copilot setup .''
  -- Tema 
  {'folke/tokyonight.nvim'},
  -- Linea inferiol
  {
    'nvim-lualine/lualine.nvim',
    dependencies = { 'nvim-tree/nvim-web-devicons' }
  },
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
    -- Plegado de código con nvim-ufo
   {
   "kevinhwang91/nvim-ufo",
   dependencies = {
     "kevinhwang91/promise-async",
   },
   event = "VeryLazy",
   config = function()
     require("ufo").setup({
       provider_selector = function()
         return { "treesitter", "indent" }
       end,
     })
   end,
   },
   -- Gir ---> Pendiente a cambiar 
   {'dinhhuy258/git.nvim'},
   -- Gitsigns (cambios git en la línea de estado / margin)
   {'lewis6991/gitsigns.nvim', opts = {}},
   -- Efecto "smear" para el cursor
   {
     "sphamba/smear-cursor.nvim",
     priority = 1000, -- Cargar después del tema de colores
     opts = {
       -- Carácter para la cabeza (puedes probar con '🔥', '*', '>', etc.)
       head = "🔥",
       -- Color para la cabeza (un rojo fuerte)
       head_fg = "#FF0000",
       -- Colores para la estela (mezcla de rojos, naranjas y amarillos)
       tail_fg = { "#FF0000", "#FF4500", "#FFA500", "#FFD700", "#FFFF00" },
       -- Otros ajustes que puedes experimentar
       tail_length = 7, -- Un poco más larga la estela
       timeout = 15,    -- Que tarde un poco más en desaparecer
     },
   },
  {
    'olimorris/codecompanion.nvim',
    dependencies = {
        'nvim-lua/plenary.nvim',
        'nvim-telescope/telescope.nvim',
    },
  },
  -- IA local con Ollama (colaboración demon; no altera lo existente)
  {
    "nomnivore/ollama.nvim",
    dependencies = {
      "nvim-lua/plenary.nvim",
    },
    config = function()
      require("ollama").setup({
        model = "deepseek-coder:1.3b",
        prompts = {
          Translate_To_Spanish = {
            prompt = "Traduce este código a español (comentarios y explicaciones):\n\n$sel",
            action = "display",
            options = { temperature = 0.3 },
          },
          Find_Bugs = {
            prompt = "Encuentra posibles bugs o problemas en este código:\n\n$sel",
            action = "display",
            options = { temperature = 0.1 },
          },
          Document_Code = {
            prompt = "Genera documentación (comentarios) para este código:\n\n$sel",
            action = "replace",
            extract = "```[%w+]+\n(.-)```",
            options = { temperature = 0.2 },
          },
          Optimize_Code = {
            prompt = "Optimiza este código para mejor rendimiento:\n\n$sel",
            action = "display",
            options = { temperature = 0.4 },
          },
        },
        url = "http://127.0.0.1:11434",
        serve = {
          on_start = false,
          command = "ollama",
          args = { "serve" },
          stop_command = "pkill",
          stop_args = { "-SIGTERM", "ollama" },
        },
      })
    end,
    cmd = { "Ollama", "OllamaModel", "OllamaServe", "OllamaServeStop" },
    keys = {
      {
        -- OJO: coma literal y no <leader>: mapleader (',') se define en
        -- lua/settings.lua DESPUÉS de lazy.setup, así que <leader> aquí
        -- se expandiría al valor por defecto '\'. La coma equivale a <leader>.
        ",lm",
        function()
          -- Guard contra E5108: ollama.nvim lee las marcas '< '> sin
          -- validarlas; en modo normal sin selección previa son {0,0,0,0}
          -- o rancias y nvim_buf_get_text revienta. En visual siempre válidas.
          local s = vim.fn.getpos("'<")
          local e = vim.fn.getpos("'>")
          local bad = s[2] == 0 or e[2] == 0
            or (s[2] > e[2])
            or (s[2] == e[2] and s[3] > e[3])
          if bad then
            vim.notify("Ollama: selecciona código en modo visual primero y pulsa ,lm", vim.log.levels.WARN, { title = "Ollama" })
            return
          end
          -- Availability check: warn instead of failing with a raw curl error.
          if vim.fn.executable("ollama") == 0 then
            vim.notify("Ollama binary not found. Install it with: pkg install ollama", vim.log.levels.WARN, { title = "Ollama" })
            return
          end
          -- Fast probe of the local server (short timeout, no hang on failure).
          local probe_ok = pcall(function()
            local out = vim.fn.system({ "curl", "--silent", "--max-time", "2", "http://127.0.0.1:11434/api/tags" })
            if vim.v.shell_error ~= 0 or out == "" then error("unreachable") end
          end)
          if not probe_ok then
            vim.notify("Ollama server is not running. Start it with: ollama serve (then pull a model, e.g. ollama pull deepseek-coder:1.3b)", vim.log.levels.WARN, { title = "Ollama" })
            return
          end
          require("ollama").prompt()
        end,        desc = "ollama prompt",
        mode = { "n", "v" },
      },
    },
  },
  {'neovim/nvim-lspconfig', tag = "v1.8.0"},
  {'hrsh7th/nvim-cmp'},
  {'hrsh7th/cmp-nvim-lsp'},
  {'hrsh7th/cmp-buffer'},
  {'hrsh7th/cmp-path'},
  {'saadparwaiz1/cmp_luasnip'},
  {'hrsh7th/cmp-nvim-lua'},
  {'jiangmiao/auto-pairs'},
  {'L3MON4D3/LuaSnip'},
  {'rafamadriz/friendly-snippets'},
  {'xiyaowong/transparent.nvim'},
  {'nvim-treesitter/nvim-treesitter'},
  {'williamboman/mason.nvim'},
  {'williamboman/mason-lspconfig.nvim'},
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
require("plugins.git")                -- Cosas de git 
require("plugins.zk")                   -- Plain text notes
require("plugins.react")                -- Web LSP servers (on demand, manual install via :Mason)
require("plugins.codecompanion")      -- Code Companion 

-- ----------------------------------------------------------------------------
-- Ollama server exit prompt (shared service: keep running by default)
-- ----------------------------------------------------------------------------
-- Only prompt on interactive exits while an "ollama serve" process is alive.
-- Headless/scripted exits quit silently and never kill the server.
vim.api.nvim_create_autocmd("VimLeavePre", {
  callback = function()
    if #vim.api.nvim_list_uis() == 0 then return end
    if vim.fn.executable("pgrep") == 0 then return end
    vim.fn.system({ "pgrep", "-f", "ollama serve" })
    if vim.v.shell_error ~= 0 then return end -- no server running, exit quietly
    local choice = vim.fn.confirm("Ollama server is still running. Stop it?", "&Keep running\n&Stop server", 1)
    if choice == 2 then
      vim.fn.system({ "pkill", "-SIGTERM", "-f", "ollama serve" })
    end
  end,
})
