#!/bin/zsh
 
if [[ "$TERM" != "dumb" ]]; then
  local reset="%{$reset_color%}"
  local fg_text="$FG[163]"
  local fg_error="$FG[124]"
 
  local fg_time="$FG[232]" 

	
  local name=027;       local fg_name="$FG[$name]";      local bg_name="$BG[$name]"
  local comp=070;       local fg_comp="$FG[$comp]";      local bg_comp="$BG[$comp]"
  local dir=068;        local fg_dir="$FG[$dir]";        local bg_dir="$BG[$dir]" 
  local git=105;        local fg_git="$FG[$git]";        local bg_git="$BG[$git]"
  local bar=238;        local fg_bar="$FG[$bar]";        local bg_bar="$BG[$bar]"
  local jobs=117;       local fg_jobs="$FG[$jobs]";      local bg_jobs="$BG[$jobs]"
  local clock=249;      local fg_clock="$FG[$clock]";    local bg_clock="$BG[$clock]"
    
  local prompt=166
  local prompt_root=124
  local fg_prompt="%(!.$FG[$prompt_root].$FG[$prompt])"
  local bg_prompt="%(!.$BG[$prompt_root].$BG[$prompt])"
  
  local split="$FX[no-bold]$FX[bold]"
  local spad=" "  
  local indicator="$split"
 
else
  local indicator=">"
 
fi



# Visual
# %E -

local newline=$'\n'        #inlining $'\n' doesn't work for some reason
local return_status="%(?. .$fg_error $(print_icon FAIL_ICON)$newline)"     #Setup the return status indicator

local line_one='$return_status'
local line_two='$FX[bold]$fg_text$spad%~$spad'
local line_three='$(prompt_git)'
local line_four='$reset ➜ '
# jobs_status , ram 
local r_line_one='%(1j.%j.)$spad$(free_ram)'

autoload -U add-zsh-hook  # Esta función se utiliza para agregar ganchos (hooks) que se ejecutarán en momentos específicos durante la sesión de Zsh
add-zsh-hook precmd updatePrompt  # personalizar el prompt antes de que se muestre.
add-zsh-hook preexec checkForClears # para realizar acciones antes de ejecutar un comando.

# Esta función se ejecutará cada vez que el gancho precmd se active.
function updatePrompt() {
  # -z = Es cierto si la longitud de la cadena es cero.
   if [[ -z $newPrompt || $newPrompt == "true" ]]; then
      PROMPT="$line_two$newline$line_three$line_four$reset"
      RPROMPT="$r_line_one"
      newPrompt="false"
 
   elif [[ $newPrompt == "false" ]]; then # Se muestra despues de un error
      PROMPT="$line_one$newline$line_two$newline$line_three$line_four" 
      RPROMPT="$r_line_one"   
   fi 
 
   if [[ -n $lastCommand ]]; then
      unset $lastCommand # eleminar 
   fi
}
 
function checkForClears() {
   if [[ $1 =~ "^ *clear" ]]; then  #TODO I would like to check for "reset" here as well, but it causes bugs
      newPrompt="true"
   fi
}

# construcciones del shell (como ' if ' y ' for ') que se han iniciado en la línea 
PROMPT2='$reset$bg_prompt %_$spad$reset$fg_prompt$indicator$reset '
 
RPROMPT2=''
 
PROMPT3='$reset$bg_prompt ?#$spad$reset$fg_prompt$indicator$reset '
 
PROMPT4='$reset$bg_prompt +%N:%i$spad$reset$fg_prompt$indicator$reset '
 
SPROMPT="zsh: correct '%R' to '%r' [nyae]?" #this is the default, and I like it
 
TIMEFMT=`echo "$newline$fg_time$bg_time$FX[bold] %J  %*Es (%P cpu) $reset" | sed -e 's/%{//g' -e 's/%}//g'`


# Función para obtener el directorio actual abreviado
function directory(){
  dir='%~'
  echo -e $dit  
}

# Mwmoria libre 
function free_ram(){
  print_icon RAM_ICON && free -h | grep "Mem:" | awk '{print $4}'
    }

function __git_prompt_git() {
  GIT_OPTIONAL_LOCKS=0 command git "$@"
}

function parse_git_dirty() {
  local STATUS
  local -a FLAGS
  FLAGS=('--porcelain')
  if [[ "$(__git_prompt_git config --get oh-my-zsh.hide-dirty)" != "1" ]]; then
    if [[ "${DISABLE_UNTRACKED_FILES_DIRTY:-}" == "true" ]]; then
      FLAGS+='--untracked-files=no'
    fi
    case "${GIT_STATUS_IGNORE_SUBMODULES:-}" in
      git)
        # let git decide (this respects per-repo config in .gitmodules)
        ;;
      *)
        # if unset: ignore dirty submodules
        # other values are passed to --ignore-submodules
        FLAGS+="--ignore-submodules=${GIT_STATUS_IGNORE_SUBMODULES:-dirty}"
        ;;
    esac
    STATUS=$(__git_prompt_git status ${FLAGS} 2> /dev/null | tail -n 1)
  fi
  if [[ -n $STATUS ]]; then
    echo "$ZSH_THEME_GIT_PROMPT_DIRTY"
  else
    echo "$ZSH_THEME_GIT_PROMPT_CLEAN"
  fi
}


function prompt_git() {
  (( $+commands[git] )) || return
  if [[ "$(git config --get oh-my-zsh.hide-status 2>/dev/null)" = 1 ]]; then
    return
  fi
  local PL_BRANCH_CHAR
  () {
    PL_BRANCH_CHAR=$'\ue0a0'         # 
  }
  local ref dirty mode repo_path

   if [[ "$(git rev-parse --is-inside-work-tree 2>/dev/null)" = "true" ]]; then
    repo_path=$(git rev-parse --git-dir 2>/dev/null)
    dirty=$(parse_git_dirty)
    ref=$(git symbolic-ref HEAD 2> /dev/null) || \
    ref="◈ $(git describe --exact-match --tags HEAD 2> /dev/null)" || \
    ref="➦ $(git rev-parse --short HEAD 2> /dev/null)" 
    if [[ -n $dirty ]]; then
      echo -ne "$fg_git"
    else
      echo -ne "$fg_git"
    fi

    local ahead behind
    ahead=$(git log --oneline @{upstream}.. 2>/dev/null)
    behind=$(git log --oneline ..@{upstream} 2>/dev/null)
    if [[ -n "$ahead" ]] && [[ -n "$behind" ]]; then
      PL_BRANCH_CHAR=$'\u21c5'
    elif [[ -n "$ahead" ]]; then
      PL_BRANCH_CHAR=$'\u21b1'
    elif [[ -n "$behind" ]]; then
      PL_BRANCH_CHAR=$'\u21b0'
    fi

    if [[ -e "${repo_path}/BISECT_LOG" ]]; then
      mode=" <B>"
    elif [[ -e "${repo_path}/MERGE_HEAD" ]]; then
      mode=" >M<"
    elif [[ -e "${repo_path}/rebase" || -e "${repo_path}/rebase-apply" || -e "${repo_path}/rebase-merge" || -e "${repo_path}/../.dotest" ]]; then
      mode=" >R>"
    fi

    setopt promptsubst
    autoload -Uz vcs_info

    zstyle ':vcs_info:*' get-revision true
    zstyle ':vcs_info:*' check-for-changes true
    zstyle ':vcs_info:*' stagedstr '✚'
    zstyle ':vcs_info:*' unstagedstr '±'
    zstyle ':vcs_info:*' formats ' %u%c'
    zstyle ':vcs_info:*' actionformats ' %u%c'
    vcs_info
    echo -n "${${ref:gs/%/%%}/refs\/heads\//$PL_BRANCH_CHAR }${vcs_info_msg_0_%% }${mode}"
  fi
}
