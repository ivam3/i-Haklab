#include "below_zero/config/config.hpp"
#include <boost/filesystem/directory.hpp>
#include <boost/process/spawn.hpp>
#include <iostream>

namespace bp = boost::process;
namespace fs = boost::filesystem;

namespace belowzero {
    void funcion::gui_vnc(){ 
      fs::path conf{fs::path(std::getenv("HOME")) / ".config/vnc/xstartup"};
      if(!fs::exists(conf) && fs::is_symlink("~/.vnc/xstartup")){
         std::cout << "No found :" << conf << std::endl;
    };
     bp::spawn("vncserver");
  }
}


