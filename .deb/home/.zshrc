# Donde esta todo lo necesario
ZSH="$HOME/.zsh"
# tema a utilisar 
ZSH_THEME="powerlevel10k"

# Enable Powerlevel10k instant prompt. Should stay close to the top of ~/.zshrc.
# Initialization code that may require console input (password prompts, [y/n]
# confirmations, etc.) must go above this block; everything else may go below.
if [[ -r "${XDG_CACHE_HOME:-$ZSH/cache}/p10k-instant-prompt-${(%):-%n}.zsh" ]]; then
  source "${XDG_CACHE_HOME:-$ZSH/cache}/p10k-instant-prompt-${(%):-%n}.zsh"
fi

# Para agregar plugins disponibles (.zsh/plugins)
plugins=(zsh-autosuggestions zsh-syntax-highlighting )

# inicia todas las configuraciones 
source ~/.zsh/start-zsh/start-zsh.sh


#------tmux-------
if command -v tmux>/dev/null; then
   if ! tmux has-session -t DemonHunter 2>/dev/null; then
      tmux new-session -A -s DemonHunter
   fi
fi

# Historia de ZSH
HISTFILE=$ZSH/cache/history # Mantenga nuestro directorio de inicio ordenado guardando el archivo hist en otro lugar
SAVEHIST=10000 # Gran historia
HISTSIZE=10000 # Gran historia
setopt EXTENDED_HISTORY # Incluye más información sobre cuándo se ejecutó el comando, etc.
setopt APPEND_HISTORY # Permitir que varias sesiones de terminal se agreguen a un historial de comandos zsh
setopt HIST_FIND_NO_DUPS # Cuando el historial de búsqueda no muestra los resultados que ya han pasado dos veces
setopt HIST_EXPIRE_DUPS_FIRST # Cuando se ingresan duplicados, deshacerse de los duplicados primero cuando presionamos $HISTSIZE
setopt HIST_IGNORE_SPACE # No ingrese comandos en el historial si comienzan con un espacio
setopt HIST_VERIFY # hace que los comandos de sustitución del historial sean un poco más agradables.  no entiendo completamente
setopt SHARE_HISTORY # Comparte el historial en múltiples sesiones de zsh, en tiempo real
setopt HIST_IGNORE_DUPS # No escribir eventos en el historial que sean duplicados del evento inmediatamente anterior
setopt INC_APPEND_HISTORY # Agrega comandos al historial a medida que se escriben, no espere hasta que salga el shell
setopt HIST_REDUCE_BLANKS # Elimina espacios en blanco adicionales de cada línea de comando que se agrega al historial

export HISTORY_IGNORE="(ls|cd|pwd|exit|sudo reboot|history|cd -|cd ..)"

# ---------------(Alias)-------------------
alias -g ../='cd ../'
alias -g .../='cd ../../'
alias -g ...../='cd ../../../..'
alias -g ....../='cd ../../../../..'
alias -g ......./='cd ../../../../../..'
alias -g ......../='cd ../../../../../../..'  
alias ls="lsd -h --color='auto'"
alias lsa='lsd -a'
alias ll='lsd -l'
alias la='lsd -la'
#--------------------------------
# Usar por default C++20
alias clang++='clang++ --std=c++20'


# To customize prompt, run `p10k configure` or edit ~/.p10k.zsh.
[[ ! -f ~/.p10k.zsh ]] || source ~/.p10k.zsh


#-------((((((configuracion de k10))))))----
# POWERLEVEL9K_BACKGROUND=''


# polybar
if [ -d "$HOME/.local/bin" ] ;
  then PATH="$HOME/.local/bin:$PATH"
fi

export VISUAL="${EDITOR}"
export EDITOR='nvim'
export TERMINAL='alacritty'
export BROWSER='firefox'
