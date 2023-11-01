#!/bin/zsh 

# Definir el lugar donde almaceno todas mis cosas de configuración de zsh
if [[ -z "$ZSH_CONF" ]]; then
  ZSH_CONF="$HOME/.zsh"
fi

# Establezca ZSH_CACHE_DIR en la ruta donde se deben crear los archivos de caché
# o usaremos el caché predeterminado/
if [[ -z "$ZSH_CACHE" ]]; then
  ZSH_CACHE="$ZSH_CONF/cache"
fi



# agregar una ruta de función
fpath=("$ZSH_CONF/.functions.zsh" $fpath)

# Cargue todas las funciones estándar (de archivos $fpath) que se indican a continuación.
autoload -U functions.zsh

# verificar si un plugin está presente en un directorio
is_plugin() {
  local base_dir=$1
  local name=$2
  builtin test -f $base_dir/plugins/$name/$name.plugin.zsh \
    || builtin test -f $base_dir/plugins/$name/_$name
}


zsh_source() {
  local context filepath="$1"

  # Construct zstyle context based on path
  case "$filepath" in
  lib/*) context="lib:${filepath:t:r}" ;;         # :t = lib_name.zsh, :r = lib_name
  plugins/*) context="plugins:${filepath:h:t}" ;; # :h = plugins/plugin_name, :t = plugin_name
  esac

  local disable_aliases=0
  zstyle -T ":omz:${context}" aliases || disable_aliases=1

  # Back up alias names prior to sourcing
  local -A aliases_pre galiases_pre
  if (( disable_aliases )); then
    aliases_pre=("${(@kv)aliases}")
    galiases_pre=("${(@kv)galiases}")
  fi

  # Source file from $ZSH_CUSTOM if it exists, otherwise from $ZSH
  if [[ -f "$ZSH_CUSTOM/$filepath" ]]; then
       source "$ZSH_CUSTOM/$filepath"
  elif [[ -f "$ZSH_CONF/$filepath" ]]; then
      source "$ZSH_CONF/$filepath"
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


# Agregue todos los complementos definidos a fpath.  Esto debe hacerse
# antes de ejecutar compinit.
for plugin ($plugins); do
  if is_plugin "$ZSH_CUSTOM" "$plugin"; then
    fpath=("$ZSH_CONF/plugins/$plugin" $fpath)
  elif is_plugin "$ZSH_CONF" "$plugin"; then
    fpath=("$ZSH_CONF/plugins/$plugin" $fpath)
  else
    echo "[ZSH] plugin '$plugin' not found"
  fi
done


# Cargue todos los complementos que se definieron en ~/.zshrc
for plugin ($plugins); do
  zsh_source "plugins/$plugin/$plugin.plugin.zsh"
done
unset plugin

# ###############
print_icon() {
  local var=$1
  if (( $+parameters[$var] )); then
    echo -n - ${(P)var}
  else
    echo -n - $icons[$1]
  fi
}