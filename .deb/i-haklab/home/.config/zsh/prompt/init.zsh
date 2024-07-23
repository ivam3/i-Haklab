# Enable Powerlevel10k instant prompt.
if [[ -r "${XDG_CACHE_HOME:-$HOME/.cache}/p10k-instant-prompt-${(%):-%n}.zsh" ]]; then
  source "${XDG_CACHE_HOME:-$HOME/.cache}/p10k-instant-prompt-${(%):-%n}.zsh"
fi

source "$ZDOTDIR/prompt/p10k.zsh"
source "$ZDOTDIR/prompt/powerlevel2k.zsh"
source "$ZDOTDIR/prompt/p10k.mise.zsh"

