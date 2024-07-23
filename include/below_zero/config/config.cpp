#include <string>
#include <vector>


namespace belowzero {
  namespace config {
     std::vector<std::string> home_file { 
       "zsh/.zshenv", ".bashrc", ".dircolors", ".dmenurc", ".gitconfig",
        ".inputrc", ".luarc.json", ".prettierrc", ".pryrc", ".pystartup", ".reek.yml", 
        ".stylua.toml", ".typos.toml", ".Xresources"};    
     std::vector<std::string> config_dir {
    "autorandr", "bat", "bundle", "cmus", "delta", "fontconfig", "gitignore.global",
    "htop", "kitty", "lazygit", "libinput-gestures.conf", "ranger", "shell", "tmux", "zsh",
    "sysinfo.conkyrc", "topgrade.toml", "bluetuith", "alacritty"
     }; 
     
     void backup_configs();
     void install_oh_my_zsh();  
  } // config  
} // belowzero
