//  autor :  @demonr_rip
// @demonr_rip
#include "../include/redteam/RedTeamHaklab.h"
#include <boost/array.hpp>

void redteam::ResTeamHakalb::mkt(std::string machineName) {
  // Lista de directorios
  boost::array<std::string, 4> list{"nmap", "content", "exploits", "scripts"};
  fs::create_directory(machineName);
  for (auto file : list) {
    fs::create_directory(machineName + "/" + file);
  }
  std::string command = "tree " + machineName;
  // Ejecuta comando del sistema
  static_cast<void>(std::system(command.c_str()));
};
