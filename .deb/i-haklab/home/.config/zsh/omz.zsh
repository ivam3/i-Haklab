# Path to oh-my-zsh installation.
export ZSH="$ZDOTDIR/.oh-my-zsh"

# Plugins
plugins=(
    zsh-autosuggestions
    zsh-completions
    zsh-autopair
   )


# Theme
ZSH_THEME="powerlevel10k/powerlevel10k"

# polybar
if [ -d "$HOME/.local/bin" ] ; then
  PATH="$HOME/.local/bin:$PATH"
fi 

source $ZSH/oh-my-zsh.sh
