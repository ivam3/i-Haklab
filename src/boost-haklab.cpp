//-------------------------------------------------
//         Inportaciones 
//-------------------------------------------------
#include "below_zero.h"
#include <cstdio>
#include <cstdlib>
#include <fmt/color.h>
#include <sys/types.h>
#include <unistd.h>

//-------------------------------------------------
//       Nombre de espacio
//-------------------------------------------------
 namespace op = boost::program_options;
 namespace fs = boost::filesystem;
 // namespace io = boost::iostreams;
 using json = nlohmann::ordered_json;

//-------------------------------------------------
//      Declaraciones de algunas funciones 
//-------------------------------------------------
void about(std::string about);


//-------------------------------------------------
//         Funcion principal main
//-------------------------------------------------
int main(int argc, const char *argv[])
{
  hack::Haklab user;
  try
  {
  //-------------------------------------------------
  //      Variables de algunos parametros  
  //-------------------------------------------------
    string dir;
    
  //------------------------------------------------
  //             OPCIONES
  //-------------------------------------------------
    op::options_description options{"Options"};
    options.add_options()
      ("help,h", "Print this menu and leave")
      ("help-module", op::value<string>(),"produce a help for a given module")
      ("version,v","print version string")
      // nombre , typo , decripcion
      ("about", op::value<std::string>()->notifier(about ),"Show informations about tool/framework");

   //-------------------------------------------------
   //               Configutacion 
   //-------------------------------------------------
    op::options_description config("Configuration");
    config.add_options()
        ("include-path,I",op::value<vector<string>>(),"include path")
        ("input-file", op::value<vector<string>>(),"input file")
        ("name-user", op::value<vector<string>>(), "Change username default(USER=i-Haklab)");
     

   //-------------------------------------------------
   //                   dpkg
   //-------------------------------------------------
    op::options_description dpkg("Create packages\n \
      \tList of options to automate creating deb binary packages");
    dpkg.add_options()
      ("name-pkg", op::value<string>(&dir), "Create directory tree\n control: Where do the package maintainer scripts go?\n src: Your executable")
      ("what-file", op::value<string>(), "What does the file do?")
      ("manifies", op::value<vector<string>>(), "Package | Version | Architerture | Maintainer | Installed-Size | Homepage |  | Description");
            
   //-------------------------------------------------
   //-------------------------------------------------
    op::options_description automatitation("Automatitation Options");
    automatitation.add_options()
      ("chek-error,r","Manipulacion de errores")
      ("file-manager,m","Open the file manager in the termux directory");
        
   //-------------------------------------------------
   //-------------------------------------------------
    op::options_description all("All");
    all.add(options).add(config).add(dpkg).add(automatitation);

    
   //-------------------------------------------------
   //-------------------------------------------------
    options.add(config).add(automatitation);
    
   //-------------------------------------------------
   //-------------------------------------------------
    op::positional_options_description positionalOptions;
    positionalOptions.add("manifies", 8).add("name-user",2);

   //-------------------------------------------------
   //-------------------------------------------------
    op::variables_map vm;
    store(op::command_line_parser(argc, argv).options(all).positional(positionalOptions).run(), vm);
    notify(vm);

   //-------------------------------------------------
   //          HELP
   //-------------------------------------------------
    if (vm.count("help")){
       fmt::print("Usage: i-haklab [options]\n");
       std::cout << options;
      return 0;
    }
   //-------------------------------------------------
   //         VERCION
   //-------------------------------------------------
    if (vm.count("version")) {
       fmt::print("Beta\n");
       return 0;        
    }
  
   //-------------------------------------------------
   //               Configuracion
   //-------------------------------------------------
    if (vm.count("name-user")){
      const auto &Value = vm["name-user"].as<std::string>();
      if(Value.size() != 2){
        throw op::validation_error(op::validation_error::invalid_option_value,
        "name-user",std::to_string(Value.size()));
      }
      user.ChangeEnvironmentVariable( std::to_string(Value[0]), std::to_string(Value[1]));
    }
   //-------------------------------------------------
   //          Automatitation Options
   //------------------------------------------------
    if(vm.count("file-manager")){
      system("am start -a android.intent.action.VIEW -d 'content://com.android.externalstorage.documents/root/primary'");
     }

   if(vm.count("chek-error")){
      // Nuevo proceso
      pid_t pid = fork();

      // Verificar creacion
      if(pid < 0){
        fmt::print(stderr,fg(fmt::color::dark_red),"Error al creaer el proceso");
        exit(1);
      }

      // Si el padre termina
      if(pid > 0){
        exit(0);
      }

      // Establecer un nuevo grupo de procesos y desvincularse del terminal
      setsid();

    // 
    fs::path p{std::string(getenv("PREFIX")) + "/tmp/i-haklab-error.or"};
    FILE *errorFile = freopen(p.c_str(), "a", stderr);
    if (!errorFile) {
        fmt::print(stderr, fg(fmt::color::dark_red), "Error al abrir el archivo de errores");
        exit(1);
    }


   // Cerrar file 
    fclose(errorFile);
    }
   //-------------------------------------------------
   //-------------------------------------------------
    if (vm.count("name-pkg")){
      fs::current_path();
      fs::create_directories(dir + "/control" );
      fs::create_directories( dir + "/bin" );
      fmt::print(R"(
         // '{}
         //  ├── control
         //  └── bin')",dir);
      return 0;
    }
        
   //-------------------------------------------------
   //-------------------------------------------------
    if (vm.count("manifies")){
    const auto &inputValues = vm["manifies"].as<vector<string>>(); 
    // Vereficar el archivo de control
    if(!fs::exists("control")){
        fmt::print(stderr,fg(fmt::color::yellow), "[ Warning ] Use dentro del directorio creado por `--name-pkg` \n");
        return EXIT_FAILURE;
      }
      
    if (inputValues.size() != 8) {
        throw op::validation_error(op::validation_error::invalid_option_value,
        "namifies",std::to_string(inputValues.size()));
       }
      
   //-------------------------------------------------
    

      
   //-------------------------------------------------
    // Crear un objeto JSON
    json root;  
    root["control"]["Package"]       = inputValues[0];
    root["control"]["Version"]       = inputValues[1];
    root["control"]["Architecture"]  = inputValues[2];
    // Nombre, corro
    root["control"]["Maintainer"]    = inputValues[3];
    root["control"]["Installed-Size"]= inputValues[4];
    // Lista  de  paquetes  necesarios  para  que  el  paquete  ofrezca  una funcionalidad aceptable. 
    root["control"]["Depends"]       = {inputValues[5]};
    root["control"]["Suggests"]      = inputValues[6];
    // Url 
    root["control"]["Homepage"]      = inputValues[7];
    root["control"]["Description"]   = {inputValues[8]};
        
    root["control_files_dir"] = "control";
    root["deb_dir"] = "../";
        
    root["data_files"][" "]["source"] = " ";

      
    // Crear un archivo de salida y escribir el objeto JSON en él
    std::fstream archivo("manifiest.json" , std::ios_base::out);
    archivo << root.dump(2);

    // Cerrar el archivo
    archivo.close();
  
   fmt::print("Se ha creado el archivo 'manifiest.json'\n");
    }
    
    // Menu que no se muestran 
    if (vm.count("help-module")){
      const string& s = vm["help-module"].as<string>();
      if (s == "defaul"){
        // std::cout << visible
      } else if (s == "packages"){
        std::cout << dpkg;
      } else {
        fmt::print(stderr,fmt::fg(fmt::color::red),"Unknown module {}  in the --help-module options\n", s);
      }
      return 0;
    }
    if (vm.count("num-threads")) {
            std::cout << "The 'num-threads' options was set to "
                 << vm["num-threads"].as<int>() << "\n";            
    }   
  }
  catch (const op::error &ex){
  fmt::print(stderr,"{}\n", ex.what());
  }
} 
