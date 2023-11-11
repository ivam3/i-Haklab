#!/bin/bash

#Terminar las instancias de barras que ya se están ejecutando 
# Si todas sus barras tienen ipc habilitado, puede usar
polybar-msg cmd quit
# De lo contrario puedes utilizar la opción nuclear:
# killall -q polybar

# Espere hasta que los procesos se hayan cerrado
while pgrep -u $UID -x polybar >/dev/null; do sleep 1; done 
for MON in $(bspc query --names --monitors); do 
    MONITOR=$MON polybar -r -c ~/.config/polybar/config.ini worktops &
done 
echo "Bars launched..."