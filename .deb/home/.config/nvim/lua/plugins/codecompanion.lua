-- #################################################################
-- ##                                                             ##
-- ##     CONFIGURACIÓN DE PROVEEDOR DE LLM PARA CODECOMPANION      ##
-- ##                                                             ##
-- #################################################################

-- -----------------------------------------------------------------
-- --      CONFIGURACIÓN ACTIVA: Gemini (Google)
-- -----------------------------------------------------------------
-- Define la clave de API directamente en el entorno de Neovim.
-- ¡RECUERDA REEMPLAZAR 'YOUR_GEMINI_API_KEY_HERE' CON TU CLAVE REAL!
vim.env.GEMINI_API_KEY = 'YOUR_GEMINI_API_KEY_HERE'

-- Configuración para Code Companion con Gemini
require("codecompanion").setup({
  adapters = {
    http = { -- <--- Creado para solucionar el warning de obsoleto
      gemini = function()
        return require("codecompanion.adapters").extend("gemini", {
          env = {
            -- Aquí es donde se lee la clave de API que definimos arriba.
            api_key = os.getenv("GEMINI_API_KEY"),
          },
          -- Opcional: puedes especificar un modelo, por ejemplo "gemini-1.5-flash".
          -- model = "gemini-pro",
        })
      end,
    },
  },
  strategies = {
    chat = { adapter = "gemini" },
    inline = { adapter = "gemini" },
    agent = { adapter = "gemini" },
  },
})


-- #################################################################
-- ##                                                             ##
-- ##       CONFIGURACIONES ALTERNATIVAS (COMENTADAS)             ##
-- ##                                                             ##
-- ## Para usar un proveedor diferente, comenta la configuración  ##
-- ## activa de Gemini de arriba y descomenta una de las          ##
-- ## siguientes secciones.                                       ##
-- ##                                                             ##
-- #################################################################


-- -----------------------------------------------------------------
-- --      CONFIGURACIÓN ALTERNATIVA: OpenAI (ChatGPT)
-- -----------------------------------------------------------------
--[[
-- Descomenta las siguientes líneas para usar OpenAI.
-- DEBES definir tu clave de API de OpenAI.
vim.env.OPENAI_API_KEY = "TU_CLAVE_DE_OPENAI_AQUI"

require("codecompanion").setup({
  adapters = {
    http = { -- <--- Creado para solucionar el warning de obsoleto
      openai = function()
        return require("codecompanion.adapters").extend("openai", {
          env = {
            api_key = os.getenv("OPENAI_API_KEY"),
          },
          -- Opcional: define un modelo por defecto
          -- schema = { model = { default = "gpt-4o" } }
        })
      end,
    },
  },
  strategies = {
    chat = { adapter = "openai" },
    inline = { adapter = "openai" },
    agent = { adapter = "openai" },
  },
})
--]]


-- -----------------------------------------------------------------
-- --      CONFIGURACIÓN ALTERNATIVA: Anthropic (Claude)
-- -----------------------------------------------------------------
--[[
-- Descomenta las siguientes líneas para usar Anthropic.
-- DEBES definir tu clave de API de Anthropic.
vim.env.ANTHROPIC_API_KEY = "TU_CLAVE_DE_ANTHROPIC_AQUI"

require("codecompanion").setup({
  adapters = {
    http = { -- <--- Creado para solucionar el warning de obsoleto
      anthropic = function()
        return require("codecompanion.adapters").extend("anthropic", {
          env = {
            api_key = os.getenv("ANTHROPIC_API_KEY"),
          },
          -- Opcional: define un modelo por defecto
          -- schema = { model = { default = "claude-3-opus-20240229" } }
        })
      end,
    },
  },
  strategies = {
    chat = { adapter = "anthropic" },
    inline = { adapter = "anthropic" },
    agent = { adapter = "anthropic" },
  },
})
--]]


-- -----------------------------------------------------------------
-- --      CONFIGURACIÓN ALTERNATIVA: DeepSeek
-- -----------------------------------------------------------------
--[[
-- Descomenta las siguientes líneas para usar DeepSeek.
-- DEBES definir tu clave de API de DeepSeek.
vim.env.DEEPSEEK_API_KEY = "TU_CLAVE_DE_DEEPSEEK_AQUI"

require("codecompanion").setup({
  adapters = {
    http = { -- <--- Creado para solucionar el warning de obsoleto
      deepseek = function()
        return require("codecompanion.adapters").extend("deepseek", {
          env = {
            api_key = os.getenv("DEEPSEEK_API_KEY"),
          },
          -- Opcional: define un modelo por defecto
          schema = { model = { default = "deepseek-chat" } }
        })
      end,
    },
  },
  strategies = {
    chat = { adapter = "deepseek" },
    inline = { adapter = "deepseek" },
    agent = { adapter = "deepseek" },
  },
})
--]]


-- -----------------------------------------------------------------
-- --      CONFIGURACIÓN ALTERNATIVA: GitHub Copilot
-- -----------------------------------------------------------------
--[[
-- Descomenta la siguiente sección para usar GitHub Copilot.
-- NOTA: Esto asume que ya tienes un plugin de Copilot
--       (como copilot.vim o copilot.lua) instalado y autenticado.
--       Copilot NO va bajo 'http' porque usa un mecanismo diferente
--       de integración, no una API HTTP directa en este contexto.
require("codecompanion").setup({
  adapters = {
    -- Copilot NO va bajo 'http'
    copilot = function()
      return require("codecompanion.adapters").extend("copilot", {})
    end,
  },
  strategies = {
    -- Copilot es excelente para sugerencias en línea
    chat = { adapter = "copilot" },
    inline = { adapter = "copilot" },
    agent = { adapter = "copilot" },
  },
})
--]]
