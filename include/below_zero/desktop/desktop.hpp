#ifndef DESKATOP_BELOW_ZERO
#define DESKATOP_BELOW_ZERO

#include <boost/filesystem/path.hpp>

namespace fs = boost::filesystem;
namespace belowzero { 
 class DesktopVNC {
   std::vector<std::string> files_conf{".vnc"};
   bool backup(std::vector<std::string> *v, fs::path path);   
   public:
      DesktopVNC() = default;
      static void start();
} ;

 
class DesktopXwayland {   
  public:
    DesktopXwayland() = default;
    static void start();
};
}

#endif // !DESKATOP_BELOW_ZERO
