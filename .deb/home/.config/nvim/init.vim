set title  " Muestra el nombre del archivo en la ventana de la terminal
set number  " Muestra los números de las líneas
set mouse=a  " Permite la integración del mouse (seleccionar texto, mover el cursor)

set nowrap  " No dividir la línea si es muy larga

"set cursorline  " Resalta la línea actual
set colorcolumn=120  " Muestra la columna límite a 120 caracteres

" Indentación a 2 espacios
set tabstop=2 
set shiftwidth=2
set softtabstop=2
set shiftround
set expandtab  " Insertar espacios en lugar de <Tab>s

set hidden  " Permitir cambiar de buffers sin tener que guardarlos

set ignorecase  " Ignorar mayúsculas al hacer una búsqueda
set smartcase  " No ignorar mayúsculas si la palabra a buscar contiene mayúsculas

set spelllang=en,es  " Corregir palabras usando diccionarios en inglés y español

set termguicolors  " Activa true colors en la terminal
set background=dark  " Fondo del tema: light o dark
colorscheme darkblue  " Nombre del tema

"Install vim-plug if it doesn't installed yet
if empty(glob('~/.config/nvim/autoload/plug.vim'))
    silent !curl -fLo ~/.config/nvim/autoload/plug.vim --create-dirs
        \ https://raw.githubusercontent.com/junegunn/vim-plug/master/plug.vim
    autocmd VimEnter * PlugInstall --sync | source $MYVIMRC
endif

call plug#begin('~/.config/nvim/plugged') " Directorio de plugins
Plug 'nvim-lua/plenary.nvim' "Popup de buqueda de líneas
Plug 'nvim-telescope/telescope.nvim' "Popup de búsqueda de archivos
Plug 'ap/vim-buftabline' "Barra superior (pestañas de archivos)
Plug 'preservim/nerdtree' "Arbol de directorios
Plug 'camspiers/lens.vim' "Redimensiona el tamaño de la ventana de vim
"Plug 'michaelb/sniprun' "Ejectua codigo sin salir de vim
call plug#end()

nmap <C-P> :Telescope git_files hidden=true <CR>
nmap <C-T> :Telescope live_grep <CR>

:let g:NERDTreeWinSize=40
nmap <C-w> :NERDTreeToggle<cr>
nmap <C-s> :NERDTreeFind<CR>
