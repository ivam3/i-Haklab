#include "below_zero/desktop/desktop.hpp"
#include <boost/filesystem/directory.hpp>
#include <boost/filesystem/operations.hpp>
#include <cstdlib>
#include <iostream>
#include <boost/thread.hpp>
#include <boost/process/system.hpp>
#include <string>

namespace bp = boost::process;
namespace belowzero {
   void DesktopXwayland::start() {
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

 void DesktopVNC::start(){ 
      fs::path conf{fs::path(std::getenv("HOME")) / ".config/vnc/xstartup"};
      if(!fs::exists(conf) || fs::is_symlink("~/.vnc/xstartup")){
         std::cerr << "No found :" << conf << std::endl;
    };
      bp::system("vncserver -listen tcp ");
      bp::system("vncserver -list");
      bp::system("termux-open vnc://127.0.0.1:5901");
  }

bool  DesktopVNC::backup(std::vector<std::string> *v, fs::path path = getenv("HOME")){
   if(!fs::exists(path / ".backup") && std::string(getenv("HACKLAB_BACKUP")) == "true"){
     std::cout <<  "Se creo una copia de tus datos en '.backup'" << std::endl;
     fs::create_directory(path / ".backup");
     return true;
    }
   for (const fs::directory_entry& x : fs::directory_iterator(path) ) {
     
   }
    return true;
 }
}


