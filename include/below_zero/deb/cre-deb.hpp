#ifndef BELOW_ZERO_DEB
#define BELOW_ZERO_DEB

#include <boost/filesystem.hpp>
#include <boost/filesystem/directory.hpp>
#include <boost/filesystem/operations.hpp>
#include <boost/json.hpp>
#include <cstdlib>
#include <iostream>
#include <list>
#include <string>

namespace fs = boost::filesystem;

class CreateDeb{
   std::list<std::string> files_conf {"control","src","doc","config"};
   std::list<std::string> control_conf {}; 
  public:
     CreateDeb(fs::path proyec);
 //    ~CreateDeb();
};

CreateDeb::CreateDeb(fs::path proyec){
  if(!fs::exists(proyec)){
    std::cerr << "File no found :" + proyec.string() << std::endl; 
    exit(1);
  }
  // Crear  directoriios  de   trabajo   
  for(std::string files : files_conf){
    fs::create_directory(proyec / files);
  };
 
  // control  config   

  for(fs::directory_entry &dir_entry : fs::directory_iterator{proyec}){
  
  };
}

#endif // !BELOW_ZERO_DEB
