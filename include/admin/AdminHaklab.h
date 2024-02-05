#pragma once

#include <cstdlib>
#include <iostream>
#include <set>
#include <filesystem>

namespace admin {
class AdminHaklab {
public:
  std::set<std::string> matchingFile(const std::string &from);
  // Verifica si  un comando   existe   
  bool command(const char &cm){
    if (std::filesystem::exists("/bin/" + std::to_string(cm))) {
     return true;
    } else if (std::filesystem::exists(std::string(getenv("PREFIX")) + "/bin/" + cm)) {
     return true; 
    } 
     return false;
  };
};
} // namespace admin
