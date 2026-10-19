if vim.b.did_ftplugin then
  return
end
vim.b.did_ftplugin = 1

vim.bo.commentstring = "# %s"
vim.bo.comments = ":#"
vim.bo.suffixesadd = ".ag"

local function aguila_run(subcomando)
  vim.cmd("write")
  local archivo = vim.fn.shellescape(vim.fn.expand("%:p"))
  vim.cmd("!" .. subcomando .. " " .. archivo)
end

vim.keymap.set("n", "<localleader>r", function()
  aguila_run("aguila ejecutar")
end, { buffer = true, desc = "Águila: ejecutar archivo" })

vim.keymap.set("n", "<localleader>c", function()
  aguila_run("aguila chequear")
end, { buffer = true, desc = "Águila: chequear archivo" })

vim.keymap.set("n", "<localleader>b", function()
  aguila_run("aguila compilar")
end, { buffer = true, desc = "Águila: compilar a JavaScript" })

vim.b.undo_ftplugin = "setlocal commentstring< comments< suffixesadd< | sil! nunmap <buffer> <localleader>r | sil! nunmap <buffer> <localleader>c | sil! nunmap <buffer> <localleader>b"
