// Autor : @demonr_rip
//-------------------------------------------------
//         Importaciones
//-------------------------------------------------
#include <cstring>
#include <iostream>
#include <boost/filesystem.hpp>
#include "below_zero/command_line_argument_parser.hpp"
#include "below_zero/config/config.hpp"
#include "below_zero/syntax.hpp"

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
      cerr << "Usage: " << "i-Haklab " << "[ options ] [ arg ]" << std::endl; 
    }

    if (args.f_help()) {
       cout << parser.getDesc() << endl;
       return 0;
    }

    if (!args.f_about().empty()) {
      fs::path db = fs::path(string(getenv("HOME"))) / "/.local/etc/i-Haklab/Tools/Readme";
      string   name = args.f_about().c_str();
      startSyntax(bz::funcion::about(name, db));
    }

    if (args.f_vnc_start()){
        bz::funcion::vnc_start();
        return 0;
      }
    if (args.f_vnc_stop()) {
       bz::funcion::vnc_stop();
       return 0;
    }
    if (args.f_xwayland()) {
      bz::Desktop::start_xwayland();
    }
  }
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

