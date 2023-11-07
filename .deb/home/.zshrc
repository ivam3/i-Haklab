# Donde esta todo lo necesario
ZSH="$HOME/.zsh"
# tema a utilisar 
ZSH_THEME="powerlevel9k"
# Nesesario para el buen funcionamiento de (powerlevelk9k)
INSTALLATION_DIR=$ZSH


# Para agregar plugins disponibles (.zsh/plugins)
plugins=(zsh-autosuggestions zsh-syntax-highlighting )

# inicia todas las configuraciones 
source ~/.zsh/start-zsh/start-zsh.sh

# Usar por default C++20
alias clang++='clang++ --std=c++20'

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

# ---------------(Alias)-------------------
alias -g ...='../..'
alias -g ....='../../..'
alias -g .....='../../../..'
alias -g ......='../../../../..'
alias -g .......='../../../../../..'
alias -g ........='../../../../../../..'  
alias ls="lsd -h --color='auto'"
alias lsa='lsd -a'
alias ll='lsd -l'
alias la='lsd -la'
#--------------------------------



#---- ---((((((configuracion K9))))))----
DIR_BACKGROUND='237'
DIR_DEFAULT_BACKGROUND="clear"
DIR_DEFAULT_FOREGROUND="012"
DIR_FOREGROUND='010'
DIR_HOME_BACKGROUND="clear"
DIR_HOME_FOREGROUND="012"
DIR_HOME_SUBFOLDER_BACKGROUND="clear"
DIR_HOME_SUBFOLDER_FOREGROUND="012"
DIR_PATH_SEPARATOR="%F{008}/%F{cyan}"

DIR_ETC_BACKGROUND="clear"
ETC_ICON='%F{blue}\uf423'
DIR_WRITABLE_FORBIDDEN_FOREGROUND="red"
DIR_WRITABLE_FORBIDDEN_BACKGROUND="clear"

GO_ICON="\uf7b7"
GO_VERSION_BACKGROUND='clear'
GO_VERSION_FOREGROUND='081'

HOME_ICON="\ufb26"


LEFT_PROMPT_ELEMENTS=(dir vcs )
LEFT_SUBSEGMENT_SEPARATOR='%F{008}\uf460%F{008}'

LINUX_MANJARO_ICON="\uf312 "
LINUX_UBUNTU_ICON="\uf31b "


MULTILINE_FIRST_PROMPT_PREFIX=""
MULTILINE_LAST_PROMPT_PREFIX=" \uf101 "

NVM_BACKGROUND='clear'
NVM_FOREGROUND='green'

OS_ICON_BACKGROUND='clear'
OS_ICON_FOREGROUND='cyan'

PROMPT_ADD_NEWLINE=true
PROMPT_ON_NEWLINE=true

RIGHT_PROMPT_ELEMENTS=(status  background_jobs disk_usage os_icon)
RIGHT_SEGMENT_SEPARATOR=''
RIGHT_SUBSEGMENT_SEPARATOR='%F{008}\uf104%F{008}'

SHORTEN_DELIMITER='%F{008} …%F{008}'
SHORTEN_DIR_LENGTH=3
SHORTEN_STRATEGY="none"

STATUS_ERROR_BACKGROUND="clear"
STATUS_ERROR_FOREGROUND="001"
STATUS_OK_BACKGROUND="clear"
STATUS_BACKGROUND="clear"
CARRIAGE_RETURN_ICON="\uf071"


VCS_CLEAN_BACKGROUND='clear'
VCS_CLEAN_FOREGROUND='green'
VCS_MODIFIED_BACKGROUND='clear'
VCS_MODIFIED_FOREGROUND='yellow'
VCS_UNTRACKED_BACKGROUND='clear'
VCS_UNTRACKED_FOREGROUND='green'

 
