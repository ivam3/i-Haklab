-- 
--
local lsp_zero = require('lsp-zero')

-- Para  "vim-cmp"
--
local cmp = require('cmp')
local luasnip = require('luasnip') 
local cmp_action = lsp_zero.cmp_action()
local select_opts = {behavior = cmp.SelectBehavior.Select}

-- Configuración LSP 
local lspconfig = require('lspconfig')
local lsp_defaults = lspconfig.util.default_config

-- Snippets
require('luasnip.loaders.from_vscode').lazy_load() 

-- Configuracion de "lsp-zero"
lsp_zero.on_attach(function(client, bufnr)
  lsp_zero.default_keymaps({buffer = bufnr}) -- Mapa de tecla predeterminado cargado en el buffer actual 
end)
-- 
lsp_zero.set_sign_icons({
  error = '✘',
  warn  = '▲',
  hint  = '⚑',
  info  = ''
})
-- Aca es donde va a estar nuestra Configuracion de lsp-zero
lsp_zero.setup()


vim.diagnostic.config({
  virtual_text = false, -- Muestra mensaje de diagnóstico con un "texto virtual" al final de la línea.
  signs = true, -- Mostrar un "signo" en la línea donde hay un diagnóstico presente
  underline = true, -- Subrayar la localización de un diagnóstico.
  update_in_insert = true, -- Actualizar los diagnósticos mientras se edita el documento en modo de inserción.
  severity_sort = true, -- Ordenar los diagnósticos de acuerdo a su prioridad
  float = false,  -- Habilitar ventanas flotantes para mostrar los mensajes de diagnósticos 
  float = {
    style = 'minimal',
    border = 'rounded',
    source = 'always',
    header = '',
    prefix = '',
  },
})

------------------------------------------------
-- Donde comiensa la Configuracion de "vim-cmp"
cmp.setup({
  preselect = 'item',
  -- Preseleccionar el primer elemento de finalización 
  completion = {
    completeopt = 'menu,menuone,noinsert'
  },
-- 
  mapping = {
    ['<Tab>'] = function(fallback)
      if cmp.visible() then
        cmp.select_next_item()
      else
        fallback()
      end
    end
  },
-- 
  snippet = {
   expand = function(args)
   luasnip.lsp_expand(args.body)
   vim.fn["vsnip#anonymous"](args.body) -- For `vsnip` users.
   -- require('luasnip').lsp_expand(args.body) -- For `luasnip` users.
   -- require('snippy').expand_snippet(args.body) -- For `snippy` users.
   vim.fn["UltiSnips#Anon"](args.body) -- For `ulti
   end
  },
-- ventana donde se muestra la documentación de un item. nvim-cmp 
  window = {
    documentation = cmp.config.window.bordered(),
  },
 -- Lista que controla el orden en el que aparecen los elementos de un  item.
  formatting = {
    fields = {'menu', 'abbr', 'kind'}
  },
-- icon basado en el nombre de la fuente
formatting = {
  fields = {'menu', 'abbr', 'kind'},
  format = function(entry, item)
    local menu_icon = {
      nvim_lsp = 'λ',
      luasnip = '⋗',
      buffer = 'Ω',
      path = '»',
    }

    item.menu = menu_icon[entry.source.name]
    return item
  end,
},
-- Salta al próximo placeholder de un snippet.
['<C-1>'] = cmp.mapping(function(fallback)
  if luasnip.jumpable(1) then
    luasnip.jump(1)
  else
    fallback()
  end
end, {'i', 's'}),
-- Salta al placeholder anterior de un snippet.
['<C-0>'] = cmp.mapping(function(fallback)
  if luasnip.jumpable(-1) then
    luasnip.jump(-1)
  else
    fallback()
  end
end, {'i', 's'}),

-- 
  sources = {
    {name = 'path'}, -- Auto completado de rutas 
    {name = 'nvim_lsp', keyword_length = 1 }, -- Mustra sugerencias basada en LSP
    {name = 'vsnip' }, -- For vsnip users.
    {name = 'nvim_lsp'},
    {name = 'nvim_lua'},
    {name = 'buffer', keyword_length = 3}, -- Sugiere palabra del archivo actual
    {name = 'luasnip', keyword_length = 2}, --  Muestra los snippets cargados 
  },
-- confirmar  selecion 
  mapping = {
  ['<CR>'] = cmp.mapping.confirm({select = false}),

-- Navegar entre suegerencias
  ['<Up>'] = cmp.mapping.select_prev_item(select_opts),
  ['<Down>'] = cmp.mapping.select_next_item(select_opts),

  ['<C-p>'] = cmp.mapping.select_prev_item(select_opts),
  ['<C-n>'] = cmp.mapping.select_next_item(select_opts),
-- Desplaza el texto de la ventana de documentación
  ['<C-u>'] = cmp.mapping.scroll_docs(-4),
  ['<C-d>'] = cmp.mapping.scroll_docs(4),
-- Cancelar el autocompletado
  ['<C-e>'] = cmp.mapping.abort(),
-- Salta al próximo placeholder de un snippet.
  ['<C-f>'] = cmp.mapping(function(fallback)
  if luasnip.jumpable(1) then
    luasnip.jump(1)
  else
    fallback()
  end
end, {'i', 's'}),
--  Salta al placeholder anterior de un snippet
['<C-b>'] = cmp.mapping(function(fallback)
  if luasnip.jumpable(-1) then
    luasnip.jump(-1)
  else
    fallback()
  end
end, {'i', 's'}),
-- Autocompletado con tab.
['<Tab>'] = cmp.mapping(function(fallback)
  local col = vim.fn.col('.') - 1

  if cmp.visible() then
    cmp.select_next_item(select_opts)
  elseif col == 0 or vim.fn.getline('.'):sub(col, col):match('%s') then
    fallback()
  else
    cmp.complete()
  end
end, {'i', 's'}),
-- Si la lista de sugerencias es visible, navega al item anterior
['<S-Tab>'] = cmp.mapping(function(fallback)
  if cmp.visible() then
    cmp.select_prev_item(select_opts)
  else
    fallback()
  end
end, {'i', 's'}),
}})


-- Aquí utilizamos vim.tbl_deep_extend para mezclar de manera segura las capacidades que ofrece lspconfig
lsp_defaults.capabilities = vim.tbl_deep_extend(
  'force',
  lsp_defaults.capabilities,
  require('cmp_nvim_lsp').default_capabilities()
),


--[
-- Para conocer las opciones disponibles de .setup() revisen la documentación con -- el comando :help lspconfig-setup.
--]

-- servidores de idioma LSP 
lspconfig.clangd.setup {
  capabilities = lsp_capabilities, -- Esta opción le dice al servidor qué capacidades del protocolo LSP soporta Neovim.
}  -- C++
lspconfig.zk.setup{
  capabilities = lsp_capabilities,
} -- markdown  
lspconfig.bashls.setup{
  capabilities = lsp_capabilities,
} -- bash 
lspconfig.pyright.setup{
  capabilities = lsp_capabilities,
} -- Python
-- lspconfig.lua_ls.setup({
--  capabilities = lsp_capabilities,
-- }) -- Lua

-- Esto nos dará la libertad de colocar nuestros atajos en cualquier lugar de nuestra configuración.
vim.api.nvim_create_autocmd('LspAttach', {
  desc = 'Acciones LSP',
  callback = function()
    local bufmap = function(mode, lhs, rhs)
      local opts = {buffer = true}
      vim.keymap.set(mode, lhs, rhs, opts)
    end

    -- Muestra información sobre símbolo debajo del cursor
    bufmap('n', 'K', '<cmd>lua vim.lsp.buf.hover()<cr>')

    -- Saltar a definición
    bufmap('n', 'gd', '<cmd>lua vim.lsp.buf.definition()<cr>')

    -- Saltar a declaración
    bufmap('n', 'gD', '<cmd>lua vim.lsp.buf.declaration()<cr>')

    -- Mostrar implementaciones
    bufmap('n', 'gi', '<cmd>lua vim.lsp.buf.implementation()<cr>')

    -- Saltar a definición de tipo
    bufmap('n', 'go', '<cmd>lua vim.lsp.buf.type_definition()<cr>')

    -- Listar referencias
    bufmap('n', 'gr', '<cmd>lua vim.lsp.buf.references()<cr>')

    -- Mostrar argumentos de función
    bufmap('n', 'gs', '<cmd>lua vim.lsp.buf.signature_help()<cr>')

    -- Renombrar símbolo
    bufmap('n', '<F2>', '<cmd>lua vim.lsp.buf.rename()<cr>')

    -- Listar "code actions" disponibles en la posición del cursor
    bufmap('n', '<F4>', '<cmd>lua vim.lsp.buf.code_action()<cr>')

    -- Mostrar diagnósticos de la línea actual
    bufmap('n', 'gl', '<cmd>lua vim.diagnostic.open_float()<cr>')

    -- Saltar al diagnóstico anterior
    bufmap('n', '[d', '<cmd>lua vim.diagnostic.goto_prev()<cr>')

    -- Saltar al siguiente diagnóstico
    bufmap('n', ']d', '<cmd>lua vim.diagnostic.goto_next()<cr>')
  end
})

-- Con esto nuestros atajos serán creado cada vez que Neovim vincule un servidor LSP a un archivo
--


