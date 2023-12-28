#pragma once

#include <boost/program_options.hpp>
#include <complex>
#include <string>
#include <vector>
#include <iostream>
#include "arguments.h"

// clang-format off 
//a, b, c, d, e, f, g, h, i, j, k, l, m, n, ñ, o, p, q, r, s, t, u, v, w, x, y, z.
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
        (arguments::info_about,po::value<std::string>(),
         "Show informations about tool/framework");
      //  =============
      //  Servers
      //  =============
      server.add_options()
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



