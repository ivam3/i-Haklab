# linking ~/.zshenv to $ZDOTDIR/.zshenv

export XDG_RUNTIME_DIR=$HOME/.config
# export DISPLAY=:0
# export WAYLAND_DISPLAY=:0

export USER=Demon

export EDITOR=nvim
export CLIPCOPY=wl-copy
export CLIPPASTE=wl-paste

export ZDOTDIR=$HOME/.config/zsh
export ZSH_PLUGINS_ALIAS_TIPS_TEXT="Alias: "
export ZSH_TMUX_AUTOSTART='false'
export ZSH_TMUX_AUTOSTART_ONCE='false'
export ZSH_TMUX_AUTOCONNECT='false'
export DISABLE_AUTO_TITLE='true'

export PATH=$HOME/.local/bin:$PATH
export GOPATH=$HOME/.go
export GOBIN=$GOPATH/bin
export PATH=$GOBIN:$PATH
export PATH=$HOME/.config/npm/bin:$PATH

export JAVA_HOME=/data/data/com.termux/files/usr/opt/openjdk
export LD_LIBRARY_PATH=/data/data/com.termux/files/usr/lib

