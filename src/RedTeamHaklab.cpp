#include "../include/redteam/RedTeamHaklab.h"


void redteam::ResTeamHakalb::mkt(std::string machineName){
  // Lista de directorios 
  std::list<std::string>list{"nmap","content","exploits","scripts"};
  fs::create_directory(machineName);
  for(auto file : list){
    fs::create_directory( machineName + "/" + file);
  }
  std::string command = "tree " + machineName;
  static_cast<void>(std::system(command.c_str()));
};


