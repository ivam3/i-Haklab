#!/bin/bash
# Función de formato ANSI (\033[<código>m)
# 0: restablecer, 1: negrita
dm_f() {
  [ $# -gt 0 ] || return
  IFS=";" printf "\033[%sm" $*
}

# Si stdout no es una terminal, ignore todo el formato
[ -t 1 ] || dm_f() { :; }

# Proteger contra la ejecución de start-zsh que no sea zsh (use la sintaxis POSIX aquí)
[ -n "$ZSH_VERSION" ] || {
  dm_ptree() {
    # Obtener el árbol de procesos del proceso actual
    pid=$$; pids="$pid"
    while [ ${pid-0} -ne 1 ] && ppid=$(ps -e -o pid,ppid | awk "\$1 == $pid { print \$2 }"); do
      pids="$pids $pid"; pid=$ppid
    done

    # Mostrar árbol de procesos
    case "$(uname)" in
    Linux) ps -o ppid,pid,command -f -p $pids 2>/dev/null ;;
    Darwin|*) ps -o ppid,pid,command -p $pids 2>/dev/null ;;
    esac

    # If ps command failed, try Busybox ps
    [ $? -eq 0 ] || ps -o ppid,pid,comm | awk "NR == 1 || index(\"$pids\", \$2) != 0"
  }

  {
    shell=$(ps -o pid,comm | awk "\$1 == $$ { print \$2 }")
    printf "$(dm_f 1 31)Error:$(dm_f 22) start-zsh no puede ser cargado: $(dm_f 1)${shell}$(dm_f 22). "
    printf "Nesesitas correr $(dm_f 1)zsh$(dm_f 22) instead.$(dm_f 0)\n"
    printf "$(dm_f 33)Aquí está el árbol de proceso:$(dm_f 22)\n\n"
    dm_ptree
    printf "$(dm_f 0)\n"
  } >&2

  return 1
}
# Compruebe si en el modo de emulación, si es así, vuelva temprano
[[ "$(emulate)" = zsh ]] || {
  printf "$(dm_f 1 31)Error:$(dm_f 22) start-zsh no se puede cargar \`$(emulate)\` emulation mode.$(dm_f 0)\n" >&2
  returnn 1
}

unset -f dm_f


# Si ZSH no está definido, ruta predeterminada 
if [[ -z "$ZSH" ]]; then
  ZSH="${HOME}/.zsh"
fi


# Establezca ZSH_CACHE_DIR en la ruta donde se deben crear los archivos de caché
# o usaremos el caché predeterminado/
if [[ -z "$ZSH_CACHE_DIR" ]]; then
  ZSH_CACHE_DIR="$ZSH/cache"
fi


# Cree el directorio de caché y finalización y agréguelo a $fpath
mkdir -p "$ZSH_CACHE_DIR/completions"
(( ${fpath[(Ie)"${ZSH_CACHE_DIR}/completions"]} )) || fpath=("$ZSH_CACHE_DIR/completions" $fpath)

# Busque actualizaciones en la carga inicial...
# source "$ZSH/tools/check_for_upgrade.sh"

#-----------------Inicializa----------
# agregar una ruta de función
fpath=("$ZSH/functions" "$ZSH/cache/completions" $fpath)

# Cargue todas las funciones estándar (de archivos $fpath) que se indican a continuación.
autoload -U compaudit compinit zrecompile 

# Configure ZSH_CUSTOM en la ruta donde se encuentran sus archivos de configuración personalizados.
# y los complementos existen, o usaremos el valor predeterminado personalizado/
if [[ -z "$ZSH_CUSTOM" ]]; then
    ZSH_CUSTOM="$ZSH/custom"
fi

is_plugin() {
  local base_dir=$1
  local name=$2
  builtin test -f $base_dir/plugins/$name/$name.plugin.zsh \
    || builtin test -f $base_dir/plugins/$name/_$name
}

# Agregue todos los complementos definidos a fpath.  Esto debe hacerse
# antes de ejecutar compinit.
for plugin ($plugins); do
  if is_plugin "$ZSH_CUSTOM" "$plugin"; then
    fpath=("$ZSH_CUSTOM   $plugin" $fpath)
  elif is_plugin "$ZSH" "$plugin"; then
    fpath=("$ZSH/plugins/$plugin" $fpath)
  else
    echo "[zsh] plugin '$plugin' no encontrado"
  fi
done

_dm_source() {
  local context filepath="$1"

  # Construct zstyle context based on path
  case "$filepath" in
  lib/*) context="lib:${filepath:t:r}" ;;         # :t = lib_name.zsh, :r = lib_name
  plugins/*) context="plugins:${filepath:h:t}" ;; # :h = plugins/plugin_name, :t = plugin_name
  esac

  local disable_aliases=0
  zstyle -T ":dm:${context}" aliases || disable_aliases=1

  # Back up alias names prior to sourcing
  local -A aliases_pre galiases_pre
  if (( disable_aliases )); then
    aliases_pre=("${(@kv)aliases}")
    galiases_pre=("${(@kv)galiases}")
  fi

  # Source file from $ZSH_CUSTOM if it exists, otherwise from $ZSH
  if [[ -f "$ZSH_CUSTOM/$filepath" ]]; then
    source "$ZSH_CUSTOM/$filepath"
  elif [[ -f "$ZSH/$filepath" ]]; then
    source "$ZSH/$filepath"
  fi

  # Unset all aliases that don't appear in the backed up list of aliases
  if (( disable_aliases )); then
    if (( #aliases_pre )); then
      aliases=("${(@kv)aliases_pre}")
    else
      (( #aliases )) && unalias "${(@k)aliases}"
    fi
    if (( #galiases_pre )); then
      galiases=("${(@kv)galiases_pre}")
    else
      (( #galiases )) && unalias "${(@k)galiases}"
    fi
  fi
}
# Carga todos los archivos lib en ~/oh-my-zsh/lib que terminan en .zsh
# consejo: Agrega archivos que no quieras en git a .gitignore
# for lib_file ("$ZSH"/lib/*.zsh); do
#   _dm_source "lib/${lib_file:t}"
# done
# unset lib_file

# Cargue todos los complementos que se definieron en ~/.zshrc
for plugin ($plugins); do
  _dm_source "plugins/$plugin/$plugin.plugin.zsh"
done
unset plugin

# Cargue todas sus configuraciones personalizadas desde personalizado/
for config_file ("$ZSH_CUSTOM"/*.zsh(N)); do
  source "$config_file"
done
unset config_file

# Cargar el tema
is_theme() {
  local base_dir=$1
  local name=$2
  builtin test -f $base_dir/$name.zsh-theme
}

if [[ -n "$ZSH_THEME" ]]; then
  if is_theme "$ZSH_CUSTOM" "$ZSH_THEME"; then
    source "$ZSH_CUSTOM/$ZSH_THEME.zsh-theme"
  elif is_theme "$ZSH_CUSTOM/themes" "$ZSH_THEME"; then
    source "$ZSH_CUSTOM/themes/$ZSH_THEME.zsh-theme"
  elif is_theme "$ZSH/themes/$ZSH_THEME" "$ZSH_THEME"; then
    source "$ZSH/themes/$ZSH_THEME/$ZSH_THEME.zsh-theme"
  else
    echo "[zsh] theme '$ZSH_THEME' no encontrado "
  fi
fi

# set completion colors to be the same as `ls`, after theme has been loaded
[[ -z "$LS_COLORS" ]] || zstyle ':completion:*' list-colors "${(s.:.)LS_COLORS}"

# temux 
# -n : la cadena no es null 
if [[ -n "$TMUX" ]]; then 
  tmux attach -t "$USER" &>/dev/null || tmux new-session -A  -s "$USER" >/dev/null 2>&1
fi

tmux new-session  -A -s "$USER"


on_exit() {
  echo "¡Hasta luego! Que tengas un gran día 🌟😊"
  sleep 1
}

baner_pantalla() {
  bash "/data/data/com.termux/files/home/.local/etc/i-Haklab/banner/i-Haklab"
}


function extract {  
   
   file=$1
   dir=$2
 
   if [[ -n $dir ]]; then
      mkdir -p $dir; 
      echo Extracting $1 into $2 ...
   else 
      echo Extracting $1 ...
   fi
 
   if [[ ! -f $1 ]] ; then
      echo "'$1' is not a valid file"
   else
      case $1 in
         *.tar.bz2)   
             if [[ -n $dir ]]; then dc="-C $dir"; fi
             cmd="tar xjvf $1 $dc" 
             echo $cmd
             eval ${cmd}
             ;;   
         *.tar.gz)    
             if [[ -n $dir ]]; then dc="-C $dir"; fi
             cmd="tar xzvf $1 $dc"; 
             echo $cmd;
             eval ${cmd}
             ;;
         *.tar)       
             if [[ -n $dir ]]; then dc="-C $dir"; fi
             cmd="tar vxf $1 $dc";
             echo $cmd;
             eval ${cmd}
             ;;
         *.tbz2)      
             if [[ -n $dir ]]; then dc="-C $dir"; fi
             cmd="tar xjvf $1 $dc";
             echo $cmd; 
             eval ${cmd}
             ;;  
         *.tgz) 
             if [[ -n $dir ]]; then dc="-C $dir"; fi
             cmd="tar xzf $1 $dc"; 
             echo $cmd; 
             eval ${cmd} 
             ;;    
         *.bz2)       
             if [[ -n $dir ]]; then dc="-C $dir"; fi
             cmd="tar jf $1 $dc"; 
             echo $cmd; 
             eval ${cmd} 
             ;;     
         *.zip)       
             if [[ -n $dir ]]; then dc="-d $dir"; fi
             cmd="unzip $1 $dc"; 
             echo $cmd; 
             eval ${cmd}
             ;;
         *.gz)
             if [[ -n $dir ]]; then dc="-C $dir"; fi
             cmd="tar zf $1 $dc"; 
             echo $cmd; 
             eval ${cmd}
             ;;
         *.7z)        
             #TODO dir
             cmd="7z x -o$dir $1"; 
             echo $cmd; 
             eval ${cmd} 
             ;;
         *.rar)       
             #TODO Dir
             cmd="unrar x $1 $dir";
             echo $cmd;
             eval ${cmd}
             ;;
         *)           
            echo "'$1' cannot be extracted via extract()" 
            ;;
         esac
   fi
}