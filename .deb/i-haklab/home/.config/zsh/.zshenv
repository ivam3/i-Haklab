# linking ~/.zshenv to $ZDOTDIR/.zshenv


#  ◤✞ 𝕳𝖎𝖘𝖙𝖔𝖗𝖎𝖆 ✞◥  
export HISTFILE=~/.config/zsh/zhistory
export HISTSIZE=5000
export SAVEHIST=5000
export HISTORY_IGNORE="(ls|cd|pwd|exit|history|cd -|cd ..)"

#  (false , true ) Haser copia de seguridad de previas confifuraciones 
export HACKALB_BACKUP=false

# polybar
if [ -d "$HOME/.local/bin" ] ; then
  PATH="$HOME/.local/bin:$PATH"
fi 


export DISPLAY=:0
export XDG_RUNTIME_DIR=${TMPDIR}


export USER="𝕯𝖊𝖒𝖔𝖓"

export EDITOR=nvim
# export CLIPCOPY=wl-copy
# export CLIPPASTE=wl-paste

export ZDOTDIR=$HOME/.config/zsh
export ZSH_PLUGINS_ALIAS_TIPS_TEXT="Alias: "
export ZSH_TMUX_AUTOSTART='false'
export ZSH_TMUX_AUTOSTART_ONCE='false'
export ZSH_TMUX_AUTOCONNECT='false'
export DISABLE_AUTO_TITLE='true'

export GOPATH=$HOME/.go
export GOBIN=$GOPATH/bin
export PATH=$GOBIN:$PATH
export PATH=$HOME/.config/npm/bin:$PATH


