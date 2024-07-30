#ifndef BELOW_ZERO_CONFIG
#define BELOW_ZERO_CONFIG

#include <string>
#include <boost/filesystem/path.hpp>


namespace belowzero {
  
class Desktop {   
  public:
    Desktop() = default;
    std::string IteratorPkg(std::vector<std::string> &v);
};

 
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
     void InstallDesktop(); 
     void vnc_start();
     void vnc_stop();
     void xwayland();
     void backup_configs();
     void install_oh_my_zsh();
     std::string about(std::string &name, boost::filesystem::path &db);
  }  // belowzero::funcion  
}   // belowzero
#endif // !BELOW_ZERO_CONFIG
