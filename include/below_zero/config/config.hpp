#ifndef BELOW_ZERO_CONFIG
#define BELOW_ZERO_CONFIG

BELOW_ZERO_CONFIG
#define BELOW_ZERO_CONFIG

namespace belowzero {
   namespace funcion {  
  /* std::vector<std::string> home_file { 
       "zsh/.zshenv", ".bashrc", ".dircolors", ".dmenurc", ".gitconfig",
        ".inputrc", ".luarc.json", ".prettierrc", ".pryrc", ".pystartup", ".reek.yml", 
        ".stylua.toml", ".typos.toml", ".Xresources"};    
     std::vector<std::string> config_dir {
    "autorandr", "bat", "bundle", "cmus", "delta", "fontconfig", "gitignore.global",
    "htop", "kitty", "lazygit", "libinput-gestures.conf", "ranger", "shell", "tmux", "zsh",
    "sysinfo.conkyrc", "topgrade.toml", "bluetuith", "alacritty"
     }; */
     
     void gui_vnc();
     void backup_configs();
     void install_oh_my_zsh();
  }  // belowzero::funcion  
}   // belowzero
#endif // !BELOW_ZERO_CONFIG
