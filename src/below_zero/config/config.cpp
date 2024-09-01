#include "below_zero/config/config.hpp"
#include <boost/filesystem/directory.hpp>
#include <boost/process/system.hpp>
#include <fstream>
#include <iostream>
#include <vector>


namespace bp = boost::process;
namespace fs = boost::filesystem;

namespace belowzero {
   
   void funcion::InstallDesktop(){
     std::cout << "Installing Termux Desktop..." << std::endl;
     bp::system("pkg autoclean; pkg update -y; pkg upgrade -y;");
     std::cout << "Enabling Termux X11-repo..." << std::endl;
     bp::system("pkg install -y x11-repo;");
     std::cout <<  "Installing required programs... \n" << std::endl;
     std::vector<std::string> pkg_desktop{"bc", "bmon", "calc", "calcurse", "curl", "dbus", "desktop-file-utils", "elinks", "feh", "fontconfig-utils", "fsmon", "geany", "git", "gtk2", "gtk3", "htop", "imagemagick", "jq", "leafpad", "man", "mpc", "mpd", "mutt", "ncmpcpp", "ncurses-utils", "neofetch", "netsurf", "obconf",  "openbox", "openssl-tool", "polybar", "ranger", "rofi", "startup-notification", "termux-api", "thunar",  "tigervnc", "vim", "wget", "xarchiver", "xbitmaps", "xcompmgr", "xfce4-settings", "xfce4-terminal", "xmlstarlet", "xorg-font-util", "xorg-xrdb"};
    }

   std::string funcion::about(std::string &name, fs::path &db) {
  if (!fs::is_directory(db)) {
    std::cerr << "[ERROR] No found " << db << std::endl;
  };

  std::string txtCommand{};
  fs::path L (std::string(1,std::toupper(name[0])));
  fs::path file(name + ".md");
  db /= L;
  std::fstream fd(fs::path(db / file).c_str());
  if (fd.is_open()) {
    std::stringstream buffer;
    buffer << fd.rdbuf();
    fd.close();
    txtCommand = buffer.str();
  } else {
    std::cout << "Con la inicial " << name[0] << " tengo :" << std::endl;
    for (fs::directory_entry& entry : fs::directory_iterator(db)) {
      std::cout << entry.path().stem() << std::endl;
    }
  }
  return txtCommand;
}  // about
  
void funcion::vnc_stop(){
    bp::system("killall Xvnc");
    std::cout <<  "succesfull stop desktop" << std::endl;
  }; 
}


