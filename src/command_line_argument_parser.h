#pragma once


//
#include "below_zero.h"
#include <vector>

// clang-format off 
// Argumentos
class arguments {
  // Options
  constexpr static auto help_option = "help,h";
  //constexpr static auto help_module_option = "help-module";
  constexpr static auto version_option = "version,v";
  constexpr static auto username_option_name = "username";
  constexpr static auto username_option = "username";
  constexpr static auto files_option_name = "input-files";
  constexpr static auto files_options_path    = "path";
  constexpr static auto port_option           = "port";
  constexpr static auto files_update_file           = "update-file,U"; 

  boost::program_options::variables_map variables;
  friend class command_line_argument_parser;

public:
  arguments(boost::program_options::variables_map variables)
      : variables(variables) {}

  bool no_arguments() { return variables.size() == 0; }


  string username() {
    return (variables.count(username_option_name) > 0)
               ? variables[username_option_name].as<string>()
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
    return (variables.count(files_update_file) > 0 ) 
        ?  variables[files_update_file].as<bool>()
        : false ;
  }
}; // end  arguments




// 
class command_line_argument_parser {
  // Opciobes 
  po::options_description desc;
  po::options_description config{"Configutacion"};
  po::options_description dpkg{"Create packages\n\tList of options to "
                                  "automate creating deb binary packages"};
  po::options_description automatitation{"Automatitation Options"};
public:
  command_line_argument_parser() {
    desc.add_options()
      (arguments::help_option, "Print this menu and leave")
      //(arguments::help_module_option, po::value<std::string>(),
      //   "produce a help for a given module")
      (arguments::version_option,"print version string")
      (arguments::username_option, po::value<std::string>(),
          "username to use")
      (arguments::files_options_path,po::value<vector<string>>(),
          "input patn")
      (arguments::files_option_name,po::value<vector<string>>(), 
          "input file");
      //  Start Config
      //  Start dpkg
      //  -----------------------
      //  Start automatitation
      //  ----------------------
       automatitation.add_options()
         (arguments::files_update_file,po::bool_switch()->default_value(true),
            "En contruccion");
  }

  arguments parse(int argc, const char *argv[]) {
    po::variables_map variables;

    po::positional_options_description positionalOptions;
    positionalOptions.add(arguments::files_option_name, -1);
  

    po::options_description All;
     All.add(desc)
        .add(config)
        .add(dpkg)
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



