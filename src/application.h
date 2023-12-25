// Autor: @demon_rip 
#pragma once

#include "below_zero.h"

using namespace std;

class application {
public:
  int run(int argc, const char* argv[]) {
   // command_line_argument_parser parser;
    hak::Haklab parser;
    try {
      auto args = parser.parse(argc, argv);
    

      if (args.no_arguments()) {
        cout << "No arguments supplied on the command line" << endl;
      }
      if (args.redTeam(true)) {
      //  hak::directRedTeam(args.redTeam());
      }
      if (args.mkt(true)) {
     //    haklab.mkt(args.mkt());
      }
      if (args.file_update()) {
    //   haklab.updateFiles(args.filepath());
      }
  
      if (args.server()) {
        std::cout << "A" << std::endl;
      }     
    } catch (po::error &ex) {
      std::cerr << "Usage: i-haklab [ options ]" << std::endl;
      cerr << ex.what() << endl;
      return false;
    } catch (...) {
      std::cout << "Unknown error\n";
      return false;
    }
 
    return true;
  }
};
