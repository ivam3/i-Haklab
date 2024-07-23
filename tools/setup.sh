#!/bin/bash


declare -a common_packages=(
  lsd  curl wget git zsh tmux bat fzf eza unzip neovim ripgrep ncdu ranger vim zoxide
)

install_tmux(){
  mkdir -p ~/.config/tmux/plugins/
  git clone https://github.com/tmux-plugins/tpm ~/.tmux/plugins/tpm
}


install_oh_my_zsh() {
    echo -e "\u001b[7m Installing oh-my-zsh...\u001b[0m"
    mkdir "$HOME"/.config/zsh
    export ZDOTDIR=$HOME/.config/zsh
    sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" "" --unattended

    echo -e "\u001b[7m Installing zsh plugins...\u001b[0m"
    gh="https://github.com/"
    omz="$ZDOTDIR/.oh-my-zsh/custom"
    omz_plugin="$omz/plugins/"

    git clone "$gh/romkatv/powerlevel10k" "$omz/themes/powerlevel10k" --depth 1

    cd "$omz_plugin" || exit
    git clone "$gh/zsh-users/zsh-autosuggestions"
    git clone "$gh/clarketm/zsh-completions"
    git clone "$gh/hlissner/zsh-autopair"
    cd - || exit

    chsh -s "$(which zsh)"
}

declare -a config_dirs=(
    "autorandr" "bat" "bundle" "cmus" "delta" "fish" "fontconfig" "gitignore.global"
    "htop" "kitty" "lazygit" "libinput-gestures.conf" "ranger" "shell" "tmux" "zsh"
    "sysinfo.conkyrc" "topgrade.toml" "bluetuith" "alacritty"
)

declare -a home_files=(
    "zsh/.zshenv" ".bashrc" ".dircolors" ".dmenurc" ".gitconfig" ".inputrc" ".luarc.json"
    ".prettierrc" ".pryrc" ".pystartup" ".reek.yml" ".stylua.toml" ".typos.toml"
    ".vimrc" ".Xresources"
)

backup_configs() {
    echo -e "\u001b[33;1m Backing up existing files... \u001b[0m"
    for dir in "${config_dirs[@]}"; do
        mv -v "$HOME/.config/$dir" "$HOME/.config/$dir.old"
    done
    for file in "${home_files[@]}"; do
        mv -v "$HOME/$file" "$HOME/$file.old"
    done
    echo -e "\u001b[36;1m Done backing up files as '.old'! . \u001b[0m"
}

main "$@"
