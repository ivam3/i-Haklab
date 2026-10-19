" Vim syntax file
" Language:    Águila
" Maintainer:  i-Haklab
" Filenames:   *.ag
" Referencia:  lexer de Águila v2.4.3

if exists("b:current_syntax")
  finish
endif

syn case match

" Llamada a función: identificador inmediatamente seguido de '('.
" Se define antes que las palabras clave para que éstas tengan prioridad.
syn match   aguilaFunction   "\<\h\w*\ze\s*("

" Palabras reservadas del lexer v2.4.3
syn keyword aguilaConditional si sino
syn keyword aguilaRepeat      mientras para en hasta romper continuar
syn keyword aguilaKeyword     funcion clase importar retornar intentar capturar nuevo asincrono esperar segun caso defecto
syn keyword aguilaStatement   imprimir
syn keyword aguilaLogical     y o no
syn keyword aguilaBoolean     verdadero falso nulo

" Tipos y funciones integradas
syn keyword aguilaType        Numero Texto Logico Lista Diccionario Conjunto
syn keyword aguilaBuiltin     leer afirmar conjunto

" Métodos de biblioteca estándar (solo se resaltan tras un punto)
syn match   aguilaMethod      +\.\@<=\(agregar\|eliminar\|insertar\|longitud\|contiene\|ordenar\|invertir\|limpiar\|copiar\|unir\|sublista\|claves\|valores\|obtener\|intersectar\|diferencia\|a_lista\|mayusculas\|minusculas\|reemplazar\|dividir\|recortar\|conectar\|consulta\|ejecutar\|cerrar\|parsear\|stringificar\|escribir\|leer\|sin\|cos\|tan\|sqrt\|aleatorio\|suma\|minimo\|maximo\|a_texto\|redondear\|piso\|techo\|abs\)\>+

" Números
syn match   aguilaNumber      "\<\d\+\(\.\d\+\)\?"

" Operadores
syn match   aguilaOperator    "=="
syn match   aguilaOperator    "!="
syn match   aguilaOperator    ">="
syn match   aguilaOperator    "<="
syn match   aguilaOperator    "->"
syn match   aguilaOperator    "\*\*"
syn match   aguilaOperator    "[-+*/%<>=]=\?"
syn match   aguilaOperator    "!"

" Cadenas
syn match   aguilaEscape      +\\.+ contained
syn region  aguilaString      start=+"+ skip=+\\"+ end=+"+ contains=aguilaEscape
syn region  aguilaString      start=+'+ skip=+\\'+ end=+'+ contains=aguilaEscape

" Cadenas interpoladas: prefijo a"..." (f"..." también, por compatibilidad).
" El runtime v2.4.3 todavía no evalúa la interpolación, pero se resalta igual.
syn region  aguilaInterpString start=+\<[af]"+ end=+"+ contains=aguilaEscape,aguilaInterpExpr
syn region  aguilaInterpExpr   start=+{+ end=+}+ contained contains=TOP

" Comentarios
syn match   aguilaComment     "#.*$" contains=@Spell

" Enlaces a grupos estándar
hi def link aguilaComment       Comment
hi def link aguilaConditional   Conditional
hi def link aguilaRepeat        Repeat
hi def link aguilaKeyword       Keyword
hi def link aguilaStatement     Statement
hi def link aguilaLogical       Operator
hi def link aguilaBoolean       Boolean
hi def link aguilaType          Type
hi def link aguilaBuiltin       Function
hi def link aguilaMethod        Function
hi def link aguilaFunction      Function
hi def link aguilaNumber        Number
hi def link aguilaOperator      Operator
hi def link aguilaString        String
hi def link aguilaInterpString  String
hi def link aguilaEscape        SpecialChar
hi def link aguilaInterpExpr    Special

let b:current_syntax = "aguila"
