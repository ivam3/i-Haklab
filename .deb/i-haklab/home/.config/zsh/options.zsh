# Options
setopt ZLE      # Habilite el editor de líneas ZLE, que es el comportamiento predeterminado, pero para estar seguro
# declare -U path # Evitar las entradas duplicadas en la ruta.
setopt AUTO_CD                  # Envía comandos de cd sin necesidad de 'cd'
autoload -U compinit            # Autocarga completa
setopt NO_CASE_GLOB             # No distinge entre mayuscula y minuscula

setopt extended_glob
setopt glob_dots
setopt interactive_comments
setopt menu_complete
setopt nomatch
setopt sharehistory
unsetopt beep

#  ┬ ┬┬┌─┐┌┬┐┌─┐┬─┐┬ ┬
#  ├─┤│└─┐ │ │ │├┬┘└┬┘
#  ┴ ┴┴└─┘ ┴ └─┘┴└─ ┴ 
setopt EXTENDED_HISTORY         # Incluye más información sobre cuándo se ejecutó el comando, etc.
setopt APPEND_HISTORY           # Permitir que varias sesiones de terminal se agreguen a un historial de comandos zsh
setopt HIST_FIND_NO_DUPS        # Cuando el historial de búsqueda no muestra los resultados que ya han pasado dos veces
setopt HIST_EXPIRE_DUPS_FIRST   # Cuando se ingresan duplicados, deshacerse de los duplicados primero cuando presionamos $HISTSIZE
setopt HIST_IGNORE_SPACE        # No ingrese comandos en el historial si comienzan con un espacio
setopt HIST_VERIFY              # hace que los comandos de sustitución del historial sean un poco más agradables.  no entiendo completamente
setopt SHARE_HISTORY            # Comparte el historial en múltiples sesiones de zsh, en tiempo real
setopt INC_APPEND_HISTORY       # Agrega comandos al historial a medida que se escriben, no espere hasta que salga el shell
setopt HIST_REDUCE_BLANKS       # Elimina espacios en blanco adicionales de cada línea de comando que se agrega al historial
setopt HIST_IGNORE_DUPS         # No escribir eventos en el historial que sean duplicados del evento inmediatamente anterior

setopt appendhistory
setopt sharehistory
setopt hist_ignore_space
setopt hist_expire_dups_first
setopt hist_ignore_all_dups
setopt hist_save_no_dups
setopt hist_ignore_dups
setopt hist_find_no_dups

# Rename module
autoload -U zmv
