#pragma once

#include <set>
#include <boost/filesystem.hpp>


namespace fs = boost::filesystem;
using std::string;

namespace admin {
class AdminHaklab {
public:
  std::set<std::string> matchingFile(const string &from);
  // Verifica si  un comando   existe  
  bool command(string C){
    if (fs::exists("/bin/" +  C )) {
     return true;
    } else if (fs::exists(string(getenv("PREFIX")) + "/bin/" + C)) {
     return true; 
    } 
     return false;
  };


};

} // namespace admin
