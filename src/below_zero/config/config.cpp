#include "below_zero/config/config.hpp"
#include <boost/filesystem/directory.hpp>
#include <fstream>
#include <boost/process/system.hpp>
#include <boost/process/spawn.hpp>
#include <iostream>
#include <string>

namespace bp = boost::process;
namespace fs = boost::filesystem;


namespace belowzero {
  void funcion::xwayland(){
     bp::system("termux-x11;");
     bp::system("am start -n com.termux.x11/com.termux.x11.MainActivity;");
     bp::system("dbus-launch --exit-with-session startxfce4");
     bp::system("pulseaudio --start --exit-idle-time=-1 2>/dev/null");
     bp::system("pacmd load-module module-native-protocol-tcp auth-ip-acl=127.0.0.1 auth-anonymous=1");
     bp::system("killall main pulseaudio gvfsd dbus-daemon dbus-launch  2>/dev/null");
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
}


