require("conform").setup({
  formatters_by_ft = {
    lua = { "stylua" },
    python = { "isort", "black" },
    rust = { "rustfmt", lsp_format = "fallback" },
    sh = { "shfmt" },
    bash = { "shfmt" },
    cpp = { "clang-format" },
    java = { "google-java-format" },
    javascript = { "prettierd", "prettier", stop_after_first = true },
    C = {"clang-format"},
  },
})
