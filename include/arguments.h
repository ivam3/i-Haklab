#pragma once 

#include <boost/program_options.hpp>

namespace po = boost::program_options;

// Nuestro   almacenamiento de argumentos 
class arguments {
  /*
   * Conoser valor en tiempo de
   * compilacion 
   */
  constexpr static auto help_option           = "help,h";
  //constexpr static auto help_module_option  = "help-module-root";
  constexpr static auto version_option        = "version,v";
  constexpr static auto username_option       = "username";
  constexpr static auto files_option_name     = "input-files";
  constexpr static auto files_options_path    = "input-path";
  constexpr static auto port_option           = "port";
  constexpr static auto host_options          = "host"; 
  constexpr static auto files_update_file     = "update-file,U"; 
  constexpr static auto files_output          = "output,o"; 
  constexpr static auto server_php            = "server-php";
  constexpr static auto wifi_interface        = "interface";
  constexpr static auto ctf_red_tram          = "dir-red-team";
  constexpr static auto ctf_mkt               = "mkt";
  constexpr static auto info_about            = "about";

  po::variables_map variables;
  //   (feiend) Otorga acceso a los mienbros pribados y protegidos
  //   Declaracion 
  friend class command_line_argument_parser;

public:
  arguments(po::variables_map variables)
      : variables(variables) {}

  bool no_arguments() {
    return variables.size() == 0;
  }


  std::string username() {
    return (variables.count(username_option) > 0)
               ? variables[username_option].as<std::string>()
               : "";
  }

  const std::vector<std::string> filenames() {
    return (variables.count(files_option_name) > 0)
               ? variables[files_option_name].as<std::vector<std::string>>()
               : std::vector<std::string>();
  }

  const std::vector<std::string> filepath() {
    return (variables.count(files_options_path) > 0)
              ? variables[files_options_path].as<std::vector<std::string>>()
              : std::vector<std::string>();
  }

  bool file_update(){
    if (variables.count("update-file")  && !variables.count(files_options_path)) {
     //   std::cerr << "Error: 'update-file' option requires 'path' option to be specified." << std::endl;
        return false;
    } else if (variables.count("update-file")  && variables.count(files_options_path)) {
       return true; 
    }
    return false;
  }
  


  bool server(){
    return (variables.count(server_php) > 0 ) 
           ? true
           : false ;
  }

  std::string redTeam(){
    return (variables.count(ctf_red_tram) > 0)
      ? variables[ctf_red_tram].as<std::string>() 
      : "";
  }
  bool  redTeam(bool){
    return (variables.count(ctf_red_tram));
  }

  bool  mkt(bool){
    return (variables.count(ctf_mkt));
  }
  const  std::string mkt(){
    return variables[ctf_mkt].as<std::string>();
  }
}; // end  arguments



