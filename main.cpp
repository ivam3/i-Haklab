// Autor : @demonr_rip
//-------------------------------------------------
//         Importaciones
//-------------------------------------------------
#include <cstring>
#include <iostream>
#include <boost/filesystem.hpp>
#include "below_zero/command_line_argument_parser.hpp"
#include "below_zero/config/config.hpp"

namespace bz = belowzero;
namespace fs = boost::filesystem;
using namespace std;

//-------------------------------------------------
//         Funcion principal main
//-------------------------------------------------
int main(int argc, const char *argv[]) {  
  command_line_argument_parser parser; 
  try {
    auto args = parser.parse(argc, argv);
    if (args.no_arguments()) {
      cerr << "Usage: " << "i-Haklab" << "[ options ] [ arg ]" << std::endl; 
    }

    if (args.f_help()) {
       cout << parser.getDesc() << endl;
    }

    if (args.f_about().empty()) {
      fs::path db =
          string(getenv("HOME")) + "/.local/etc/i-Haklab/Tools/Readme";
     // startSyntax(about(db, args.f_about().c_str()));
    }
    if (!args.f_server().empty()){
      string a (args.f_server()); 
      if(a == "vnc"){
        bz::funcion::gui_vnc();
      }
  }}
  catch (po::error& ex) {
    cerr << ex.what() << endl;
    return EXIT_FAILURE;
  } catch (std::exception& e) {
    cerr << e.what() << endl;
  } catch (...) {
    cerr << "Unknown error" << endl;
    return EXIT_FAILURE;
  }
  return 0;
}

