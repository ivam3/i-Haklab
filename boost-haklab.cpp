#include "include/below_zero.h"
#include <iostream>
#include <vector>

using namespace boost::program_options;


// Declaraciones 
void about(std::string about);


int main(int argc, const char *argv[])
{
  // CLI
  try
  {
    // Describir comandos ( Titulo )
    options_description options{"Options"};
    // para cada opcion
    options.add_options()
      ("help,h", "Print this menu and leave")
      ("help-module", value<string>(),"produce a help for a given module")
      ("version,v","print version string")
      // nombre , typo , decripcion
      ("about", value<std::string>()->notifier(about ),"Show informations about tool/framework");

    // Declarar grupo de opciones que 
    // se permitiran tanto en la linea de comandos como en 
    // el archivo de configuracion
    options_description config("Configuration");
    config.add_options()
        ("include-path,I",value<vector<string>>(),"include path")
        ("input-file", value<vector<string>>(),"input file");

    

    options_description automa("Automatitation Options");
    automa.add_options()
      ("num-threads", value<int>(), "the initial number of threads");
            

        
   // Instancia de descripción de opciones que incluirá
   // todas las opciones
    options_description all("All");
    all.add(options).add(config).add(automa);

    
    // Los menu para el publico 
    options_description visible("Opciones y configuracion del sistema");
    visible.add(options).add(config);

    
    variables_map vm;
    store(parse_command_line(argc, argv, all), vm);
    notify(vm);

    // Los menu visibles 
    if (vm.count("help")){
      std::cout << "Usage: i-haklab [options]\n";
      std::cout << options;
      return 0;
    }
    // Vercion 
    if (vm.count("version")) {
       std::cout << "Beta";
       return 0;        
    }
    // Menu que no se muestran 
    if (vm.count("help-module")){
      const string& s = vm["help-module"].as<string>();
      if (s == "defaul"){
        std::cout << visible;
      } else if (s == "automa"){
        std::cout << automa;
      } else {
        std::cout << "Unknown module '"  << s << "' in the --help-module [ defaul | automa]\n";
        return 1;
      }
      return 0;
    }
    if (vm.count("num-threads")) {
            std::cout << "The 'num-threads' options was set to "
                 << vm["num-threads"].as<int>() << "\n";            
    }   
  }
  catch (const error &ex){
    // fmt::print(stderr,ex.what());
    std::cerr << ex.what() << '\n';
  }
} 
