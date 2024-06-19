// Autor : @demon_rip
//-------------------------------------------------
//         Importaciones
//-------------------------------------------------
#include "include/below_zero.h"


//-------------------------------------------------
//         Funcion principal main
//-------------------------------------------------
int main(int argc, const char *argv[]) {
  
  Haklab haklab("Demon");
  // Controlar la salida  ...
  haklab.ctrl_c();
  try {
    po::options_description desc{"Options"};
    po::options_description net{"C2"};
    po::options_description automatitation{"Automatitation Options"};
    po::options_description server{"Servers"};
    po::options_description ctf{"CTF"};
    po::options_description info{"Info"};
    /*
     *
     */
    desc.add_options()
      ("port",po::value<int>()->default_value(4444)->value_name("num"), "Port to connect ")
      ("interface", po::value<string>()->default_value("wlan0"),"....? ")
      ("help", "Produce help message");
    /*
     *
     */
    info.add_options()
      ("about", po::value<string>()->value_name("name"),"Show informations about tool/framework");
    /*
     *
     */

    po::variables_map vm;
    // -1 todo lo que sobra
    po::positional_options_description positionalOPtions;
    // positionalOPtions.add();
    po::options_description All;
    All.add(desc).add(info);

    po::store(po::command_line_parser(argc, argv)
                  .options(All)
                  .positional(positionalOPtions)
                  .run(),
              vm);

    po::notify(vm);

    // Logica de menu
    //
    if (vm.count("help")) {
      cout << All << endl;
    } else if (vm.count("about")) {
      haklab.about(vm["about"].as<string>());
    }
  
  } catch (po::error &ex) {
    cerr << ex.what() << endl;
    return EXIT_FAILURE;
  } catch (std::exception &e){
    cerr << e.what() << endl;
  } catch (...) {
    cerr << "Unknown error" << endl;
    return EXIT_FAILURE;
  }
  // captura "app"  por referencia y ejecuta "app.run"
  // app.Loading([&]() { app.run(argc, argv); });

  return 0;
}
