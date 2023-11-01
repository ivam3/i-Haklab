#!/bin/zsh
#/usr/bin/zsh
 
if [[ "$TERM" != "dumb" ]]; then
  local reset="%{$reset_color%}"
  local fg_text="$FG[232]"
  local fg_black="$FG[232]"
  local bg_black="$BG[232]"
  local fg_error="$FG[124]"
 
  local fg_time="$FG[232]" 
  local bg_time="$BG[027]"
	
  local name=027;       local fg_name="$FG[$name]";      local bg_name="$BG[$name]"
  local comp=070;       local fg_comp="$FG[$comp]";      local bg_comp="$BG[$comp]"
  local dir=117;        local fg_dir="$FG[$dir]";        local bg_dir="$BG[$dir]" 
  local git=105;        local fg_git="$FG[$git]";        local bg_git="$BG[$git]"
  local bar=240;        local fg_bar="$FG[$bar]";        local bg_bar="$BG[$bar]"
  local jobs=117;       local fg_jobs="$FG[$jobs]";      local bg_jobs="$BG[$jobs]"
  local clock=249;      local fg_clock="$FG[$clock]";    local bg_clock="$BG[$clock]"
    
  local prompt=166
  local prompt_root=124
  local fg_prompt="%(!.$FG[$prompt_root].$FG[$prompt])"
  local bg_prompt="%(!.$BG[$prompt_root].$BG[$prompt])"
  
  local git_icon=""
  local split="$FX[no-bold]$FX[bold]"
  local spad=" "  
  local indicator="$split"
 
else
  local indicator=">"
 
fi 

local newline=$'\n'                                  #inlining $'\n' doesn't work for some reason
local return_status="%(?. .$fg_error $icons[FAIL_ICON]$newline)"     #Setup the return status indicator


local line_one='$return_status'
local line_two='$FX[bold]$fg_text$bg_name$spad%n$spad$fg_name$bg_comp$split$fg_text$spad@%m$spad$fg_comp$bg_dir$split$fg_text$spad%~$spad$fg_dir$(git_status)$bg_bar$split%E'
local line_three='$reset$bg_prompt$spad$reset$fg_prompt$indicator$reset '
 
 
autoload -U add-zsh-hook  # Esta función se utiliza para agregar ganchos (hooks) que se ejecutarán en momentos específicos durante la sesión de Zsh
add-zsh-hook precmd updatePrompt  # personalizar el prompt antes de que se muestre.
add-zsh-hook preexec checkForClears # para realizar acciones antes de ejecutar un comando.

# Esta función se ejecutará cada vez que el gancho precmd se active.
function updatePrompt() {
   if [[ -z $newPrompt || $newPrompt == "true" ]]; then
      PROMPT="$line_two$newline$line_three$reset"
      newPrompt="false"
 
   elif [[ $newPrompt == "false" ]]; then
      PROMPT="$line_one$newline$line_two$newline$line_three"    
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


RPROMPT='$FX[bold]$fg_black$(jobs_status)$FX[no-bold]$reset' 
 
PROMPT2='$reset$bg_prompt %_$spad$reset$fg_prompt$indicator$reset '
 
RPROMPT2=''
 
PROMPT3='$reset$bg_prompt ?#$spad$reset$fg_prompt$indicator$reset '
 
PROMPT4='$reset$bg_prompt +%N:%i$spad$reset$fg_prompt$indicator$reset '
 
SPROMPT="zsh: correct '%R' to '%r' [nyae]?" #this is the default, and I like it
 
TIMEFMT=`echo "$newline$fg_time$bg_time$FX[bold] %J  %*Es (%P cpu) $reset" | sed -e 's/%{//g' -e 's/%}//g'`

function jobs_status() {
   count=$((jobs -s) | wc -l)
   if [[ $count -ne "0" ]]; then
      echo "$bg_jobs$split$fg_text $count $fg_jobs"
   else 
      echo " "
   fi
}

function git_status() {
  ref=$(git symbolic-ref HEAD 2> /dev/null) 
    if [[ -z $ref ]]; then
    echo ""
  else 
     echo "$bg_git$split$fg_text $git_icon ${ref#refs/heads/}$(git_icons) $fg_git"
  fi
}
 
function git_icons() {
  #TODO: https://git-scm.com/docs/git-status
  #use these statuses to make more information
  local git_status="$(git status --porcelain 2> /dev/null)"
  if [[ -n "$git_status" ]]; then
    echo "*"
  fi
 
}