" Vim indent file
" Language:   Águila
" Maintainer: i-Haklab

if exists("b:did_indent")
  finish
endif
let b:did_indent = 1

setlocal indentexpr=GetAguilaIndent()
setlocal indentkeys=0{,0},0),0],!^F,o,O,e
setlocal nosmartindent

let b:undo_indent = "setlocal indentexpr< indentkeys< smartindent<"

function! GetAguilaIndent() abort
  let l:plnum = prevnonblank(v:lnum - 1)
  if l:plnum == 0
    return 0
  endif

  let l:ind = indent(l:plnum)
  let l:curr = getline(v:lnum)

  " La línea actual cierra un bloque: desindentar un nivel.
  if l:curr =~# '^\s*[]})]'
    let l:ind -= shiftwidth()
  endif

  " Balance de la línea anterior, ignorando los comentarios.
  let l:code = substitute(getline(l:plnum), '#.*$', '', '')
  let l:open = len(l:code) - len(substitute(l:code, '[[({]', '', 'g'))
  let l:close = len(l:code) - len(substitute(l:code, '[])}]', '', 'g'))
  if l:open > l:close
    let l:ind += shiftwidth()
  endif

  return l:ind < 0 ? 0 : l:ind
endfunction
