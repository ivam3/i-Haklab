-- #################################################################
-- ##                                                             ##
-- ##     CONFIGURACIÓN DE PROVEEDOR DE LLM PARA CODECOMPANION    ##
-- ##                                                             ##
-- #################################################################
-- Cada adapter corresponde a una variable declarada en
-- ~/.local/etc/i-Haklab/variables (APIKEY_*). Se definen todas
-- aunque estén vacías, para que cada usuario de i-Haklab tenga
-- la opción disponible con solo asignar valor vía `i-Haklab setapikey`.
-- No-LLM (phonescan, testsprite) se excluyen a propósito.
-- Default activo: gemini (verificado con saldo free el 2026-10-10).

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
--   Carga APIKEY_* al entorno de Neovim desde variables de i-Haklab
-- -----------------------------------------------------------------
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
-- ##  SETUP ÚNICO: todos los adapters (default: gemini)           ##
-- ##  Para cambiar de proveedor, edita `strategies` abajo o usa  ##
-- ##  :CodeCompanionChat adapter=<nombre>                         ##
-- ##  Nombres: gemini, openai, anthropic, claude,               ##
-- ##  deepseek, mistral, groq, kimi, togetherai, bigmodel,        ##
-- ##  zcode, openrouter, copilot                                  ##
-- #################################################################
require("codecompanion").setup({
  adapters = {
    http = {
      -- APIKEY_gemini (verificado OK: gemini-2.5-flash)
      gemini = function()
        return require("codecompanion.adapters").extend("gemini", {
          env = { api_key = os.getenv("APIKEY_gemini") },
          schema = { model = { default = "gemini-2.5-flash" } },
        })
      end,
      -- APIKEY_chatGPT (nativo openai)
      openai = function()
        return require("codecompanion.adapters").extend("openai", {
          env = { api_key = os.getenv("APIKEY_chatGPT") },
          schema = { model = { default = "gpt-4o-mini" } },
        })
      end,
      -- APIKEY_anthropic (nativo anthropic)
      anthropic = function()
        return require("codecompanion.adapters").extend("anthropic", {
          env = { api_key = os.getenv("APIKEY_anthropic") },
        })
      end,
      -- APIKEY_claude (alias anthropic)
      claude = function()
        return require("codecompanion.adapters").extend("anthropic", {
          env = { api_key = os.getenv("APIKEY_claude") },
        })
      end,
      -- APIKEY_deepseek (nativo)
      deepseek = function()
        return require("codecompanion.adapters").extend("deepseek", {
          env = { api_key = os.getenv("APIKEY_deepseek") },
          schema = { model = { default = "deepseek-chat" } },
        })
      end,
      -- APIKEY_mistralAI (nativo; OK solo con open-mistral-7b, small-latest da 429)
      mistral = function()
        return require("codecompanion.adapters").extend("mistral", {
          env = { api_key = os.getenv("APIKEY_mistralAI") },
          schema = { model = { default = "open-mistral-7b" } },
        })
      end,
      -- APIKEY_groq
      groq = function()
        return require("codecompanion.adapters").extend("openai_compatible", {
          env = {
            url = "https://api.groq.com/openai",
            api_key = os.getenv("APIKEY_groq"),
            chat_url = "/v1/chat/completions",
            models_endpoint = "/v1/models",
          },
          schema = { model = { default = "llama-3.3-70b-versatile" } },
        })
      end,
      -- APIKEY_kimi / Moonshot 
      kimi = function()
        return require("codecompanion.adapters").extend("openai_compatible", {
          env = {
            url = "https://api.moonshot.cn/v1",
            api_key = os.getenv("APIKEY_kimi"),
            chat_url = "/v1/chat/completions",
            models_endpoint = "/v1/models",
          },
          schema = { model = { default = "moonshot-v1-8k" } },
        })
      end,
      -- APIKEY_togetherai 
      togetherai = function()
        return require("codecompanion.adapters").extend("openai_compatible", {
          env = {
            url = "https://api.together.xyz/v1",
            api_key = os.getenv("APIKEY_togetherai"),
            chat_url = "/v1/chat/completions",
            models_endpoint = "/v1/models",
          },
          schema = { model = { default = "meta-llama/Llama-3.3-70B-Instruct-Turbo" } },
        })
      end,
      -- APIKEY_bigmodel / Zhipu 
      bigmodel = function()
        return require("codecompanion.adapters").extend("openai_compatible", {
          env = {
            url = "https://open.bigmodel.cn/api/paas/v4",
            api_key = os.getenv("APIKEY_bigmodel"),
            chat_url = "/v1/chat/completions",
            models_endpoint = "/v1/models",
          },
          schema = { model = { default = "glm-4.5-air" } },
        })
      end,
      -- APIKEY_zcode (mismo endpoint Zhipu, otra variable)
      zcode = function()
        return require("codecompanion.adapters").extend("openai_compatible", {
          env = {
            url = "https://open.bigmodel.cn/api/paas/v4",
            api_key = os.getenv("APIKEY_zcode"),
            chat_url = "/v1/chat/completions",
            models_endpoint = "/v1/models",
          },
          schema = { model = { default = "glm-4.5-air" } },
        })
      end,
      -- APIKEY_openrouter (verificado OK con modelos :free, ej. liquid/lfm-2.5-2.6b:free)
      openrouter = function()
        return require("codecompanion.adapters").extend("openai_compatible", {
          env = {
            url = "https://openrouter.ai/api/v1",
            api_key = os.getenv("APIKEY_openrouter"),
            chat_url = "/v1/chat/completions",
            models_endpoint = "/v1/models",
          },
          schema = { model = { default = "liquid/lfm-2.5-2.6b:free" } },
        })
      end,
    },
    -- Copilot no usa APIKEY_* (usa auth del plugin copilot.vim ya instalado).
    copilot = function()
      return require("codecompanion.adapters").extend("copilot", {})
    end,
  },
  strategies = {
    chat = { adapter = "gemini" },
    inline = { adapter = "gemini" },
    agent = { adapter = "gemini" },
  },
})

-- Ejemplos de cambio rápido (edita `strategies` arriba):
--   chat = { adapter = "openrouter" }, inline = { adapter = "openrouter" }
--   chat = { adapter = "mistral" }    -- usa open-mistral-7b (único con cuota free verificada)
--   chat = { adapter = "deepseek" }   -- requiere saldo
--   chat = { adapter = "copilot" }    -- sin APIKEY, requiere :Copilot setup
