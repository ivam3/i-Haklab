#pragma once

#include "network/NetworHaklab.h"
#include "../include/below_zero.h"
#include <charconv>
#include <complex>
#include <iostream>
#include <string> 
namespace po = boost::program_options;

using std::string;

// clang-format off 
//a, b, c, d, e, f, g, h, i, j, k, l, m, n, ñ, o, p, q, r, s, t, u, v, w, x, y, z.
//



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
  constexpr static auto WepStatus             = "wep-status";


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


  int  WepStatusCode(){
    const string  &URL = variables[WepStatus].as<string>();
    return (variables.count(WepStatus) > 0 )
      ? network::NetworHakaklab::GetStatusCode(URL)
      : 0 ;
  }

  void CreateMkt(){
     string name = variables[ctf_mkt].as<string>();
     if (variables.count(ctf_mkt)){
         hak::Haklab::Haklab::mkt(name);
    }   
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
       std::cerr << "Error: 'update-file' option requires 'input-path' option to be specified." << std::endl;
        return false;
    } else if (variables.count("update-file")  && variables.count(files_options_path)) {
       return true; 
    }
    return false;
  }
 
}; // end arguments




class command_line_argument_parser {
  // Opciobes  
  po::options_description desc{"Options"};
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
        (arguments::info_about,po::value<std::string>(),
         "Show informations about tool/framework");
      //  =============
      //  Servers
      //  =============
      server.add_options()
        (arguments::WepStatus, po::value<std::string>())
        (arguments::port_option, po::value<int>(),
         "Create specified port")
        (arguments::host_options, po::value<int>(),
         "Create specified host")
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



