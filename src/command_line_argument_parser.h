#pragma once


//
#include "below_zero.h"
#include <functional>

// clang-format off 
// Argumentos
class arguments {
  /*
   * Conoser valor en tiempo de
   * compilacion 
   */
  constexpr static auto help_option           = "help,h";
  //constexpr static auto help_module_option  = "help-module";
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
  boost::program_options::variables_map variables;
  friend class command_line_argument_parser;

public:
  arguments(boost::program_options::variables_map variables)
      : variables(variables) {}

  bool no_arguments() {
    return variables.size() == 0;
  }

  string username() {
    return (variables.count(username_option) > 0)
               ? variables[username_option].as<string>()
               : "";
  }

  const vector<string> filenames() {
    return (variables.count(files_option_name) > 0)
               ? variables[files_option_name].as<vector<string>>()
               : vector<string>();
  }

  const vector<string> filepath() {
    return (variables.count(files_options_path) > 0)
              ? variables[files_options_path].as<vector<string>>()
              : vector<string>();
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

  string redTeam(){
    return (variables.count(ctf_red_tram) > 0)
      ? variables[ctf_red_tram].as<string>() 
      : "";
  }
  bool  redTeam(bool){
    return (variables.count(ctf_red_tram) > 0);
  }
}; // end  arguments




// 
class command_line_argument_parser {
  // Opciobes  
  po::options_description desc{"Options"};
  po::options_description config{"Configutacion"};
  po::options_description dpkg{"Create packages\n\tList of options to "
                                  "automate creating deb binary packages"};
  po::options_description automatitation{"Automatitation Options"};
  po::options_description server{"Servers"};
  po::options_description ctf{"CTF"};
public:
  command_line_argument_parser() {
    desc.add_options()
      (arguments::help_option, "Print this menu and leave")
      //(arguments::help_module_option, po::value<std::string>(),
      //   "produce a help for a given module")
      (arguments::version_option,"print version string")
      (arguments::username_option, po::value<std::string>(),
          "username to use")
      (arguments::wifi_interface,po::value<std::string>(),//("wlan0"),
          "Name of the interface to use")
      (arguments::files_options_path,po::value<vector<string>>(),
          "input patn")
      (arguments::files_option_name,po::value<vector<string>>(), 
          "input file")
      ("output,o", po::value<std::string>(), "output path");
      //  Start Config
      //  Start dpkg
      //  =============
      //  Servers
      //  =============
      server.add_options()
        (arguments::server_php,"Create PHP server");
      // --------------------
      //    CTF  
      //---------------------
       ctf.add_options()
         (arguments::ctf_red_tram,po::value<std::string>(),"Red team create live");
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
        .add(dpkg)
        .add(server)
        .add(ctf)
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



