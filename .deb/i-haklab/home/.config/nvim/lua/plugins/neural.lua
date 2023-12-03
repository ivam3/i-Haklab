local file = os.getenv("HOME") .. "/.local/etc/i-Haklab/variables"
local l = 24
local n = 0

for i in io.lines(file) do
  n = n + 1
  if n == l then
    APIKEY_neovim = string.match(i, 'APIKEY_neovim=(.+)')
    break
  end
end

require('neural').setup({
  source = {
    openai = {
      api_key = "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",
    },
  },
})
