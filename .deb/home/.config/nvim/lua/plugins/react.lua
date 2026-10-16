-- react.lua -- Web development LSP servers (on demand)
-- No automatic installation: servers start only when their binary exists.
-- Install a missing server once with :Mason (e.g. :MasonInstall typescript-language-server).

local web_servers = {
  ts_ls = {
    cmd = { 'typescript-language-server', '--stdio' },
    filetypes = { 'javascript', 'javascriptreact', 'typescript', 'typescriptreact' },
    root_dir = require('lspconfig.util').root_pattern('package.json', 'tsconfig.json', '.git'),
  },
  html = {
    cmd = { 'vscode-html-language-server', '--stdio' },
    filetypes = { 'html' },
  },
  cssls = {
    cmd = { 'vscode-css-language-server', '--stdio' },
    filetypes = { 'css', 'scss', 'less' },
  },
  tailwindcss = {
    cmd = { 'tailwindcss-language-server', '--stdio' },
    filetypes = { 'html', 'css', 'javascriptreact', 'typescriptreact' },
    root_dir = require('lspconfig.util').root_pattern('tailwind.config.js', 'tailwind.config.ts', 'package.json', '.git'),
  },
}

local capabilities = vim.lsp.protocol.make_client_capabilities()
local has_cmp, cmp_lsp = pcall(require, 'cmp_nvim_lsp')
if has_cmp then
  capabilities = vim.tbl_deep_extend('force', capabilities, cmp_lsp.default_capabilities())
end

for name, config in pairs(web_servers) do
  -- Skip servers whose binary is not installed (manual install via :Mason).
  if vim.fn.executable(config.cmd[1]) == 1 then
    vim.api.nvim_create_autocmd('FileType', {
      pattern = config.filetypes,
      callback = function(args)
        local clients = vim.lsp.get_clients({ name = name, bufnr = args.buf })
        if #clients == 0 then
          vim.lsp.start({
            name = name,
            cmd = config.cmd,
            root_dir = config.root_dir,
            capabilities = capabilities,
          })
        end
      end,
    })
  end
end
