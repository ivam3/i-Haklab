# Este archivo se obtiene en todas las invocaciones del shell.
# Si la bandera -f está presente o si la opción no_rcs 
# se establecido dentro de este archivo, todos los demás archivos de inicialización
# se omiten
#
# Este archivo debe contener comandos para configurar el comando.
# ruta de búsqueda, además de otras variables de entorno importantes
# Este archivo no debe contener comandos que produzcan
# salida
#
# Orden global: zshenv, zprofile, zshrc, zlogin

##### Historia de ZSH ######## 
#
# linking ~/.zshenv to $ZDOTDIR/.zshenv   
ZDOTDIR="${${(%):-%x}:P:h}"


ZSH="$HOME/.zsh"
export HISTFILE=$ZSH/cache/history     # Mantenga nuestro directorio de inicio ordenado guardando el archivo hist en otro lugar
export SAVEHIST=10000                  # Gran historia
export HISTSIZE=10000                  # Gran historia
export HISTORY_IGNORE="(ls|cd|pwd|exit|sudo reboot|history|cd -|cd ..)"


#### 
export  USER=i-Haklab
export  DISPLAY=:0
export  PULSE_SERVER=127.0.0.1
export  GOPATH="/data/data/com.termux/files/home/go"
export  GOROOT="/data/data/com.termux/files/usr/lib/go"
export  JAVA_HOME="/data/data/com.termux/files/usr/opt/openjdk"
export  LD_LIBRARY_PATH="/data/data/com.termux/files/usr/lib"
export  LLVM_BUILD="/data/data/com.termux/files/usr/lib"
export  LLVM_HOME="/data/data/com.termux/files/usr/lib/cmake/llvm"
export  ANDROID_ALLOW_UNDEFINED_SYMBOLS="On"
export  TOOLS="/data/data/com.termux/files/home/.local/share"

###### 
export BROWSER="firefox"

