#pragma once

#include <boost/program_options.hpp>
#include <string>
#include <vector>
#include <iostream>


namespace po = boost::program_options;

// clang-format off 

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
        std::cerr << "Error: 'update-file' option requires 'path' option to be specified." << std::endl;
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




// 
class command_line_argument_parser {
  // Opciobes  
  po::options_description desc{"Options"};
  po::options_description config{"Configutacion"};
  po::options_description red{"Red"};
  po::options_description automatitation{"Automatitation Options"};
  po::options_description server{"Servers"};
  po::options_description ctf{"CTF"};
  po::options_description info{"Info"};
public:
  command_line_argument_parser() {
    desc.add_options()
      (arguments::help_option, "Print this menu and leave")
      //(arguments::help_module_option, po::value<std::string>(),
      //   "produce a help for a given module")
      (arguments::version_option,"print version std::string")
      (arguments::username_option, po::value<std::string>(),
          "username to use")
            (arguments::files_options_path,po::value<std::vector<std::string>>(),
          "input patn")
      (arguments::files_option_name,po::value<std::vector<std::string>>(), 
          "input file")
      ("output,o", po::value<std::string>(), 
          "output path");
      //  Start Config
      //  red 
      red.add_options()
        (arguments::wifi_interface,po::value<std::string>(),//("wlan0"),
          "Name of the interface to use");
        

      //  Info 
      info.add_options()
        (arguments::info_about,po::value<std::string>(),"Show informations about tool/framework");
      //  =============
      //  Servers
      //  =============
      server.add_options()
        (arguments::server_php,
            "Create PHP server");
      // --------------------
      //    CTF  
      //---------------------
       ctf.add_options()
         (arguments::ctf_red_tram,po::value<std::string>(),
            "Red team create directories");
       ctf.add_options()
         (arguments::ctf_mkt,po::value<std::string>(),"Create working directories ");
      //  -----------------------
      //  Start automatitation
      //  ----------------------
       automatitation.add_options()
         (arguments::files_update_file,
            "Update matching files here and there");
  }

  arguments parse(int argc, const char *argv[]) {
    po::variables_map variables;
    // -1   todo lo que sobra jj
    po::positional_options_description positionalOptions;
    positionalOptions
      .add(arguments::files_option_name, -1);
  
  
    po::options_description All;
     All.add(desc)
        .add(config)
        .add(red)
        .add(server)
        .add(ctf)
        .add(info)
        .add(automatitation);
 

    po::store(po::command_line_parser(argc, argv)
                  .options(All)
                  .positional(positionalOptions)
                  .run(),
              variables);

    po::notify(variables);
   
    if (variables.count("help")) {
      std::cout << All << std::endl;
    }

    return arguments(variables);
  }
};  // end command_line_argument_parser
// clang-format on 



