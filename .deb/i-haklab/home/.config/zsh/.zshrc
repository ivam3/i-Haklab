# Este archivo se obtiene únicamente para shells interactivos.  Él
# debe contener comandos para configurar alias, funciones,
# opciones, combinaciones de teclas, etc.
#
# orden Gloval : zshenv, zprofile, zshrc, zlogin    

# Load configs in specific order
source "$ZDOTDIR/prompt/init.zsh"
source "$ZDOTDIR/omz.zsh"
source "$ZDOTDIR/options.zsh"
source "$ZDOTDIR/completions.zsh"
source ~/.config/shell/functions.sh
source ~/.config/shell/aliases.sh
source "$ZDOTDIR/aliases.zsh"
source "$ZDOTDIR/keys.zsh"


