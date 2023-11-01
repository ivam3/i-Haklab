source $PREFIX/share/zsh/plugins/zsh-syntax-highlighting/zsh-syntax-highlighting.zsh
source $PREFIX/share/zsh/plugins/zsh-autosuggestions/zsh-autosuggestions.zsh


local  ZSH_CONF=$HOME/.zsh                     # Definir el lugar donde almaceno todas mis cosas de configuración de zsh
local  ZSH_CACHE=$ZSH_CONF/cache               # para almacenar archivos como historial y zcompdump
local  LOCAL_ZSHRC=$HOME/.zshlocal/.zshrc      # Permitir que la máquina local tenga su propio zshrc predominante si así lo desea

# Cargar archivos de configuración externos y herramientas
source $ZSH_CONF/functions.zsh # Cargar funciones varias.    
source $ZSH_CONF/spectrum.zsh # Poner a disposición bonitos colores
source $ZSH_CONF/prompts.zsh # Configura  PS1, PS2, etc.
source $ZSH_CONF/termsupport.zsh # Establecer el título de la ventana del terminal y otras cosas específicas del terminal

# Establecer variables importantes del shell
export EDITOR=vi # Establecer editor predeterminado
export WORDCHARS='' # Este es el valor predeterminado de oh-my-zsh, creo que me gustaría que fuera un poco diferente
export PAGER=less # Establecer buscapersonas predeterminado
export LESS="-R" # Establecer las opciones predeterminadas para menos
export LANG="es_US.UTF-8" # No estoy seguro de quién mira esto, pero sé que es bueno configurarlo en general
   
 # Varios
setopt ZLE # Habilite el editor de líneas ZLE, que es el comportamiento predeterminado, pero para estar seguro
declare -U path # evitar entradas duplicadas en la ruta
#eval $(dircolors $ZSH_CONF/dircolors) # Utiliza colores personalizados para LS, como se describe en dircolors
LESSHISTFILE="/dev/null" # Evitar que se cree el archivo less hist, no lo quiero
# umask 002 # Permisos predeterminados para archivos nuevos, reste 777 para comprender
setopt NO_BEEP # Desactivar pitidos
setopt AUTO_CD # Envía comandos de cd sin necesidad de 'cd'
setopt MULTI_OS # Puede canalizar a múltiples salidas
unsetopt NO_HUP # Mata todos los procesos secundarios cuando salgamos, no los dejes ejecutándose
setopt INTERACTIVE_COMMENTS # Permite comentarios en el shell interactivo.
setopt RC_EXPAND_PARAM # Abc{$cool}efg donde $cool es una matriz que rodea todas las variables de la matriz individualmente
unsetopt FLOW_CONTROL # Ctrl+S y Ctrl+Q normalmente desactivan/habilitan la entrada tty.  Esto desactiva esas entradas.
setopt LONG_LIST_JOBS # Listar trabajos en formato largo de forma predeterminada.  (No sé qué hace esto pero suena bien)
setopt vi            # Make the shell act like vi if i hit escape
# === Corepcion ===
setopt CORRECT
setopt CORRECT_ALL


# Historia de ZSH
HISTFILE=$ZSH_CACHE/history # Mantenga nuestro directorio de inicio ordenado guardando el archivo hist en otro lugar
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

# ZSH Autocompletar
   # Figure out the short hostname
   if [[ "$OSTYPE" = Demon* ]]; then          
      # OS X's $HOST changes with dhcp, etc., so use ComputerName if possible.
      SHORT_HOST=$(scutil --get ComputerName 2>/dev/null) || SHORT_HOST=${HOST/.*/}
   else
      SHORT_HOST=${HOST/.*/}
   fi

# completar automáticamente con una interfa
zstyle ':completion:*' menu select

 #the auto complete dump is a cache file where ZSH stores its auto complete data, for faster load times
local ZSH_COMPDUMP="$ZSH_CACHE/acdump-${SHORT_HOST}-${ZSH_VERSION}"  #where to store autocomplete data
autoload -U compinit                                    # Autoload auto completion
compinit -i -d "${ZSH_COMPDUMP}"                        # Init auto completion; tell where to store autocomplete dump
zstyle ':completion:*' menu select                      # Have the menu highlight as we cycle through options
zstyle ':completion:*' matcher-list 'm:{a-z}={A-Z}'     # Case-insensitive (uppercase from lowercase) completion
setopt COMPLETE_IN_WORD                                 # Allow completion from within a word/phrase
setopt ALWAYS_TO_END                                    # When completing from the middle of a word, move cursor to end of word
setopt MENU_COMPLETE                                    # When using auto-complete, put the first option on the line immediately
setopt COMPLETE_ALIASES                                 # Turn on completion for aliases as well
setopt LIST_ROWS_FIRST


# globalizar
setopt NO_CASE_GLOB # Blobbing que no distingue entre mayúsculas y minúsculas
setopt EXTENDED_GLOB # Permitir las potentes funciones globales de zsh, consulte el enlace:
# http://www.refining-linux.org/archives/37/ZSH-Gem-2-Extended-globbing-and-expansion/
setopt NUMERIC_GLOB_SORT # Ordena los globos que se expanden a números numéricamente, no por letras (es decir, 01 2 03)
   
 # Alias
git config --global alias.lg "log --color --graph --pretty=format:'%Cred%h%Creset -%C(yellow)%d%Creset %s %Cgreen(%cr)%C(bold blue)<%an>%Creset' --abbrev-commit" 

alias -g ...='../..'
alias -g ....='../../..'
alias -g .....='../../../..'
alias -g ......='../../../../..'
alias -g .......='../../../../../..'
alias -g ........='../../../../../../..'
   
alias ls="ls -h --color='auto'"
alias lsa='ls -a'
alias ll='ls -l'
alias la='ls -la'
alias cdl=changeDirectory; function changeDirectory { cd $1 ; la }

alias md='mkdir -p'
alias rd='rmdir'

# Search running processes. Usage: psg <process_name>
alias psg="ps aux $( [[ -n "$(uname -a | grep CYGWIN )" ]] && echo '-W') | grep -i $1"

# Copy with a progress bar
alias cpv="rsync -poghb --backup-dir=/tmp/rsync -e /dev/null --progress --" 

alias d='dirs -v | head -10'                      # List the last ten directories we've been to this session, no duplicates



# Key Bindings
bindkey "^K" kill-whole-line                      # [Ctrl-K] erase whole line
bindkey '^[[1;5C' forward-word                    # [Ctrl-RightArrow] - move forward one word
bindkey '^[[1;5D' backward-word                   # [Ctrl-LeftArrow] - move backward one word                    
bindkey '^?' backward-delete-char                 # [Backspace] - delete backward
bindkey "${terminfo[kdch1]}" delete-char          # [Delete] - delete forward
bindkey '\e[2~' overwrite-mode                    # [Insert] - toggles overwrite mode                  
bindkey "${terminfo[kpp]}" up-line-or-history     # [PageUp] - Up a line of history
bindkey "${terminfo[knp]}" down-line-or-history   # [PageDown] - Down a line of history
bindkey "^[[A" history-search-backward            # start typing + [Up-Arrow] - fuzzy find history forward  
bindkey "^[[B" history-search-forward             # start typing + [Down-Arrow] - fuzzy find history backward
bindkey '\e[H' beginning-of-line                  # Note: this works on cygwin/mintty, may not work on other systems 
bindkey '\e[F' end-of-line                        # Note: this works on cygwin/mintty, may not work on other systems
bindkey "\e\e" sudo-command-line                  # [Esc] [Esc] - insert "sudo" at beginning of line
      zle -N sudo-command-line
      sudo-command-line() {
            [[ -z $BUFFER ]] && zle up-history
            if [[ $BUFFER == sudo\ * ]]; then
                  LBUFFER="${LBUFFER#sudo }"
            else
                  LBUFFER="sudo $LBUFFER"
            fi
      }
      

# Ctrl+d para cerrar linea de comandos 
exit_zsh() { exit }
zle -N exit_zsh
bindkey '^D' exit_zsh

#i %(?.<success expression>.<failure expression>)   
#PROMPT='%F{cyan}%~%f'
#PROMPT+='%(?.%(!.%F{white}❯%F{yellow}❯%F{red}.%F{blue}❯%F{cyan}❯%F{green})❯.%F{red}❯❯❯)%f '

# Lado derecho de la pantalla  
#RPROMPT='%t'
