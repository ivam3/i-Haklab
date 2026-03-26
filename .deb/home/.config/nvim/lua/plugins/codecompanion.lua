-- #################################################################
-- ##                                                             ##
-- ##     CONFIGURACIÓN DE PROVEEDOR DE LLM PARA CODECOMPANION    ##
-- ##                                                             ##
-- #################################################################

-- Configuración de directorio temporal para Termux
local termux_tmp = "/data/data/com.termux/files/usr/tmp"
vim.env.TMPDIR = termux_tmp
vim.env.TMP = termux_tmp
vim.env.TEMP = termux_tmp
vim.env.XDG_RUNTIME_DIR = termux_tmp

-- Forzar a plenary a usar el directorio temporal de Termux
local ok_plenary, job = pcall(require, "plenary.job")
if ok_plenary then
  job.tmpdir = termux_tmp
end

-- -----------------------------------------------------------------
--   Define la clave de API directamente en el entorno de Neovim  -- 
-- -----------------------------------------------------------------
-- ¡RECUERDA CONFIGURAR CON TU CLAVE REAL!
-- 
local file = os.getenv("HOME") .. "/.local/etc/i-Haklab/variables"  
  
local f = io.open(file, "r")  
if not f then  
  vim.notify("Unreachable APIKEY", vim.log.levels.ERROR)  
  return  
end  
  
for line in f:lines() do
  -- 1. Quitamos 'export ' si existe para facilitar el match
  local clean_line = line:gsub("^%s*export%s+", "")
  -- 2. Capturamos solo si empieza por APIKEY_, ignorando comillas
  local key, value = clean_line:match("^%s*(APIKEY_[%w_]+)%s*=%s*[\"']?(.-)[\"']?%s*$")
  
  if key and value then
    vim.env[key] = value
  end
end  
  
f:close()

-- #################################################################
-- ##                                                             ##
-- ##       CONFIGURACION ACTIVA POR DEFECTO GEMINI (GOOGLE)      ##
-- ##                                                             ##
-- ## Para usar un proveedor diferente, comenta la configuración  ##
-- ## activa de Gemini de arriba y descomenta la que desees usar  ##
-- ##                                                             ##
-- #################################################################
require("codecompanion").setup({
  adapters = {
    http = { -- <--- Creado para solucionar el warning de obsoleto
      gemini = function()
        return require("codecompanion.adapters").extend("gemini", {
          env = {
            -- Aquí es donde se lee la clave de API que definimos arriba.
            api_key = os.getenv("APIKEY_gemini"),
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
            api_key = os.getenv("APIKEY_chatGPT"),
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
            api_key = os.getenv("APIKEY_claude"),
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
            api_key = os.getenv("APIKEY_deepseek"),
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
