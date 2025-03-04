--  https://lsp-zero.netlify.app/docs/language-server-configuration.html
local lsp = require('lsp-zero')
lsp.preset('recommended', {
    set_lsp_keymaps = true, -- P habilitar todas las combinaciones de teclas predeterminadas,
    manage_nvim_cmp = true,
})

-- INFO:   :help  vim.diagnostic
-- diagnósticos
vim.diagnostic.config({
    virtual_text = true,
    signs = true,
    update_in_insert = false,
    underline = true,
    severity_sort = false,
    float = true,
})

-- 
local lspconfig = require('lspconfig')

-- Esto debe ejecutarse antes de configurar cualquier servidor de idiomas.
local lspconfig_defaults = lspconfig.util.default_config
lspconfig_defaults.capabilities = vim.tbl_deep_extend(
        'force',
        lspconfig_defaults.capabilities,
        require('cmp_nvim_lsp').default_capabilities()
    ),

    ----------------------Solo para servidores LSP----------------
    -- Info:  :help lspconfig-keybindings.

    vim.api.nvim_create_autocmd('LspAttach', {
        desc = 'Acciones LSP',
        callback = function()
            local bufmap = function(mode, lhs, rhs)
                local opts = { buffer = true }
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
            bufmap('n', '<F3>', '<cmd>lua vim.lsp.buf.rename()<cr>')

            -- Listar "code actions" disponibles en la posición del cursor
            bufmap('n', '<F4>', '<cmd>lua vim.lsp.buf.code_action()<cr>')
            bufmap('x', '<F4>', '<cmd>lua vim.lsp.buf.range_code_action()<cr>')

            -- Mostrar diagnósticos de la línea actual
            bufmap('n', 'gl', '<cmd>lua vim.diagnostic.open_float()<cr>')

            -- Saltar al diagnóstico anterior
            bufmap('n', '[d', '<cmd>lua vim.diagnostic.goto_prev()<cr>')

            -- Saltar al siguiente diagnóstico
            bufmap('n', ']d', '<cmd>lua vim.diagnostic.goto_next()<cr>')
        end
    })

----------------------------------------------------------------

-- servidores de idioma
lspconfig.zk.setup({})
lspconfig.pyright.setup{}
lspconfig.bashls.setup({})
lspconfig.lua_ls.setup({})
lspconfig.clangd.setup {
    cmd = { "clangd", "--background-index", "--clang-tidy" }
}
---------------------------------------------------
--             =====Auto compleado=====
--------------------------------------------------
vim.opt.completeopt = { 'menu', 'menuone', 'noselect' }
-- Para configurar nvim-cmp necesitamos dos módulos
local cmp = require('cmp')
local luasnip = require('luasnip')
local select_opts = { behavior = cmp.SelectBehavior.Select }

cmp.setup({
    sources = {
        { name = 'nvim_lsp' },
    },
    mapping = cmp.mapping.preset.insert({
        -- confirm completion
        -- ['<C-y>'] = cmp.mapping.confirm({select = true}),
        -- ['<C-ee>'] = cmp.mapping.close(),
        -- Navigate between completion items
        ['<C-p>'] = cmp.mapping.select_prev_item({ behavior = 'select' }),
        ['<C-n>'] = cmp.mapping.select_next_item({ behavior = 'select' }),
        -- scroll up and down the documentation window
        ['<C-u>'] = cmp.mapping.scroll_docs(-4),
        ['<C-d>'] = cmp.mapping.scroll_docs(4),
    }),
    snippet = {
        expand = function(args)
            luasnip.lsp_expand(args.body)
        end
    },
    -- Controla la apariencia de la ventana donde se muestra la documentación de un item.
    window = {
        documentation = cmp.config.window.bordered()
    },
    -- icon basado en el nombre de la fuente
    formatting = {
        fields = { 'menu', 'abbr', 'kind' }, -- Controla  el orden en el que aparecen  los elementos
        format = function(entry, item)
            local menu_icon = {
                nvim_lsp = 'λ',
                luasnip = '⋗',
                buffer = 'Ω',
                path = '🖫',
                nvim_lua = "Π",
            }

            item.menu = menu_icon[entry.source.name]
            return item
        end,
    },
})

lsp.setup()
