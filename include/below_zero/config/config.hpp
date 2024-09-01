#ifndef BELOW_ZERO_CONFIG
#define BELOW_ZERO_CONFIG

#include <boost/filesystem/path.hpp>

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
     bool command_exists(const std::string& cmd); 
     void InstallDesktop(); 
     void vnc_stop();
     void xwayland();
     void install_oh_my_zsh();
     std::string about(std::string &name, boost::filesystem::path &db);
  }  // belowzero::funcion  
}  // belowzero
#endif // !BELOW_ZERO_CONFIG
