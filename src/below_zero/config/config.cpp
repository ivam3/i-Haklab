#include "below_zero/config/config.hpp"
#include <unistd.h>
#include <boost/filesystem/directory.hpp>
#include <boost/process/child.hpp>
#include <boost/process/detail/child_decl.hpp>
#include <boost/process/spawn.hpp>
#include <boost/process/system.hpp>
#include <iostream>
#include <fstream>
#include <string>
#include <vector>


namespace bp = boost::process;
namespace fs = boost::filesystem;

namespace belowzero {
 
   void funcion::InstallDesktop(){
     belowzero::Desktop desktop;
     std::cout << "Installing Termux Desktop..." << std::endl;
     bp::system("pkg autoclean; pkg update -y; pkg upgrade -y;");
     std::cout << "Enabling Termux X11-repo..." << std::endl;
     bp::system("pkg install -y x11-repo;");
     std::cout <<  "Installing required programs... \n" << std::endl;
     std::vector<std::string> pkg_desktop{"bc", "bmon", "calc", "calcurse", "curl", "dbus", "desktop-file-utils", "elinks", "feh", "fontconfig-utils", "fsmon", "geany", "git", "gtk2", "gtk3", "htop", "imagemagick", "jq", "leafpad", "man", "mpc", "mpd", "mutt", "ncmpcpp", "ncurses-utils", "neofetch", "netsurf", "obconf",  "openbox", "openssl-tool", "polybar", "ranger", "rofi", "startup-notification", "termux-api", "thunar",  "tigervnc", "vim", "wget", "xarchiver", "xbitmaps", "xcompmgr", "xfce4-settings", "xfce4-terminal", "xmlstarlet", "xorg-font-util", "xorg-xrdb"};
    }

   void Desktop::start_xwayland() {
    using namespace std;
    // Inicia el proceso de x11 en un hilo separado
    cout << "Starting termux-x11..." << endl;
    thread x11_thread([]() { bp::system("termux-x11");});
    cout << "Starting XFCE..." << endl;
    sleep(3);
    thread dbus_thead([](){bp::system("dbus-launch --exit-with-session startxfce4");});
    cout << "Starting PulseAudio..." << endl;
    bp::system("pulseaudio --start --exit-idle-time=-1 2>/dev/null");
    cout << "Starting pacmd... " << endl;
    bp::system("pacmd load-module module-native-protocol-tcp auth-ip-acl=127.0.0.1 auth-anonymous=1");
    bp::system("am start -n com.termux.x11/com.termux.x11.MainActivity");
    // Ejecuten en segundo plano
    x11_thread.join();
    dbus_thead.join();
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

  void funcion::vnc_start(){ 
      fs::path conf{fs::path(std::getenv("HOME")) / ".config/vnc/xstartup"};
      if(!fs::exists(conf) && fs::is_symlink("~/.vnc/xstartup")){
         std::cerr << "No found :" << conf << std::endl;
    };
      bp::system("vncserver -listen tcp ");
      bp::system("vncserver -list");
      bp::system("termux-open vnc://127.0.0.1:5901");
  }
bool funcion::command_exists(const std::string& cmd) {
    return fs::exists(cmd);
}
}


