" FILE TO CONFIG VIM EDITOR
" Some tricks to use it
" :e filename      - edit another file
" :split filename  - split window and load another file
" ctrl-w up arrow  - move cursor up a window
" ctrl-w ctrl-w    - move cursor to another window (cycle)
" ctrl-w_          - maximize current window
" ctrl-w=          - make all equal size
" 10 ctrl-w+       - increase window size by 10 lines
" :vsplit file     - vertical split
" :sview file      - same as split, but readonly
" :hide            - close current window
" :only            - keep only this window open
" :ls              - show current buffers
" :b 2             - open buffer #2 in this window

set number
set numberwidth=1
set mouse=a
set clipboard=unnamed
set showcmd
set ruler
set encoding=utf-8
set showmatch
set sw=2
set relativenumber
syntax enable
set tabstop=2
set autoindent
set laststatus=2
set bg=dark

call plug#begin('~/.vim/plugged')

" Temas
Plug 'morhetz/gruvbox'

" IDE
Plug 'easymotion/vim-easymotion'
Plug 'scrooloose/nerdtree'
Plug 'christoomey/vim-tmux-navigator'

call plug#end()

colorscheme gruvbox
let g:gruvbox_contrast_dark = "hard"
let NERDTreeQuitOnOpen=1

let mapleader=" "

nmap <Leader>s <Plug>(easymotion-s2)
nmap <Leader>nt :NERDTreeFind<CR>

