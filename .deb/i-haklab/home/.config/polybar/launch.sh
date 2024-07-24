#!/bin/bash 

killall polybar 
if type "xrandr"; then 
   for m in $(polybar --list-monitors | cut -d":" -f1); do 
     MONITOR=$m polybar --reload main-bar & 
   done 
else 
  polybar --reload main-bar & 
fi 
