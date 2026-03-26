-- #################################################################
-- ##                                                             ##
-- ##     CONFIGURACIÓN DE PROVEEDOR DE LLM PARA NEURAL           ##
-- ##                                                             ##
-- #################################################################
-- -----------------------------------------------------------------
--   Define la clave de API directamente en el entorno de Neovim  -- 
-- -----------------------------------------------------------------
-- ¡RECUERDA CONFIGURAR CON TU APIKEY EJECUTANDO 'i-Haklab setapikey'
-- 
local file = os.getenv("HOME") .. "/.local/etc/i-Haklab/variables"  
  
local f = io.open(file, "r")  
if not f then  
  vim.notify("Unreachable APIKEY", vim.log.levels.ERROR)  
  return  
end  
  
for line in f:lines() do  
  local key, value = line:match("^(APIKEY_%w+)%=(.+)$")  
  if key and value then  
    vim.env[key] = value  
  end  
end  
  
f:close()

require('neural').setup({
  source = {
    openai = {
      api_key = os.getenv("APIKEY_neural"),
    },
  },
})
