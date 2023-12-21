// Autor: @demon_rip 
#include <complex>
#pragma one

#include "command_line_argument_parser.h"

using namespace std;

class application {
public:
  int run(int argc, const char* argv[]) {
    command_line_argument_parser parser;
    try {
      auto args = parser.parse(argc, argv);
    
      auto filenames  = args.filenames();

      if (args.no_arguments()) {
        cout << "No arguments supplied on the command line" << endl;
      }
    
      if (args.file_update()) {
        std::cout << "stoy" << std::endl;
        for(const auto &file : args.filenames()){
          std::cout << file << std::endl;
        }
      }
  

     // cout << "Username set to '" << args.username() << "'" << endl;
    /*

      cout << filenames.size() << " Filenames supplied" << endl;
    */
     
    } catch (std::logic_error e) {
      cerr << e.what() << endl;
    }
    return true;
  }
};
