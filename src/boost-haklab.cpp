//-------------------------------------------------
//         Inportaciones 
//-------------------------------------------------
#include "below_zero.h"
//-------------------------------------------------
//       Nombre de espacio
//-------------------------------------------------
namespace po = boost::program_options;
namespace fs = boost::filesystem;
using json = nlohmann::ordered_json;
using namespace hack::hak_help;
//-------------------------------------------------
//         Funcion principal main
//-------------------------------------------------
int main(int argc, const char *argv[])
{ 
  try
  { 
  //------------------------------------------------
  //             OPCIONES
  //-------------------------------------------------
    Haklab_Menu_Help  cli_options{"Options"};
    cli_options.add_options()
      ("help,h", "Print this menu and leave")
      ("help-module", po::value<string>(),"produce a help for a given module")
      ("version,v","print version string")
      // nombre , typo , decripcion
      ("include-path,P",po::value<vector<string>>(),"include path")
      ("input-file,I", po::value<vector<string>>(),"input file")
      ("host", "Name the hos")
      ("port","Name the port");

   //-------------------------------------------------
   //               Configutacion 
   //-------------------------------------------------
    Haklab_Menu_Help  cli_config{"Configutacion"};
    cli_config.add_options()
        ("name-user", po::value<vector<string>>(), "Change username default(USER=i-Haklab_Menu_Help )");
     
    
   //-------------------------------------------------
   //                   dpkg
   //-------------------------------------------------
   Haklab_Menu_Help  cli_dpkg{"Create packages\n\tList of options to automate creating deb binary packages"};
   cli_dpkg.add_options()
   ("update_file,u","Actualizar los archivos del .deb con los locales")
   ("name-pkg", po::value<string>(&cli_config.m_dir), "Create directory tree\n control: Where do the package maintainer scripts go?\n src: Your executable")
   ("what-file", po::value<string>(), "What does the file do?")
   ("manifies", po::value<vector<string>>(), "Package | Version | Architerture | Maintainer | Installed-Size | Homepage |  | Description");
            
   //-------------------------------------------------
   //              Automatitation
   //-------------------------------------------------
   Haklab_Menu_Help  cli_automatitation{"Automatitation Options"};
   cli_automatitation.add_options()
      ("chek-error,r","Manipulacion de errores")
      ("file-manager,m","Open the file manager in the termux directory")
      ("list-frenwor,l", po::value<string>(), "Lista de herramientas dispomibles")
     ("about", po::value<string>(), "Show informations about tool/framework");

  Haklab_Menu_Help  cli_cryptography{"Cryptography"};
  cli_cryptography.add_options()
  ("rsa","prueva");

  Haklab_Menu_Help  cli_all{"All"}; 
   //-------------------------------------------------
   //-------------------------------------------------
   cli_all.add(cli_options).add(cli_config).add(cli_dpkg).add(cli_automatitation);
 
   //-------------------------------------------------
   //-------------------------------------------------
  cli_options.add(cli_config).add(cli_automatitation).add(cli_cryptography);
    
  //-------------------------------------------------
  //-------------------------------------------------
    po::positional_options_description positionalOptions;
    positionalOptions.add("manifies", 8).add("name-user",2);  
  
  //-------------------------------------------------
  //
  //
 //-------------------------------------------------
    po::variables_map vm;
    store(po::command_line_parser(argc, argv).options(cli_all).positional(positionalOptions).run(), vm);
    notify(vm);

    
   //-------------------------------------------------
   //          HELP
   //-------------------------------------------------
   Files file{"/"};
   hack::Haklab  funtion;
   
   funtion.Help(vm,cli_options);
    
   //-------------------------------------------------
   //         VERCION
   //-------------------------------------------------
    /* Operador termario
     * condicion ? exprecion1 : exprecion2 
     */
    fmt::print((vm.count("version") ?  "%s\n" : "" ), "Beta");
   //-------------------------------------------------
   //                name-user
   //-------------------------------------------------
    if (vm.count("name-user")){
      const auto &Value = vm["name-user"].as<std::string>();
      if(Value.size() != 2){
        throw po::validation_error(po::validation_error::invalid_option_value,
        "name-user",std::to_string(Value.size()));
      }
     // user.ChangeEnvironmentVariable( std::to_string(Value[0]), std::to_string(Value[1]));
    }
   //-------------------------------------------------
   //          file-mamager
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
   //------------------------------------------------
  //           name-pkg
   //-------------------------------------------------
    /*if (vm.count("name-pkg")){
      fs::current_path();
      fs::create_directories( dir + "/control" );
      fs::create_directories( dir + "/bin" );
      fmt::print(R"(
         // '{}
         //  ├── control
         //  └── bin')",dir);
      return 0;
    }
   */     
   //-------------------------------------------------
  //             manifies 
   //-------------------------------------------------
    if (vm.count("manifies")){
    const auto &inputValues = vm["manifies"].as<vector<string>>(); 
    // Vereficar el archivo de control
    if(!fs::exists("control")){
        fmt::print(stderr,fg(fmt::color::yellow), "[ Warning ] Use dentro del directorio creado por `--name-pkg` \n");
        return EXIT_FAILURE;
      }
      
    if (inputValues.size() != 8) {
        throw po::validation_error(po::validation_error::invalid_option_value,
        "namifies",std::to_string(inputValues.size()));
       }   

      
   //-------------------------------------------------
    // Crear un objeto JSON
    json root;  
    root["control"]["Package"]       = inputValues[0];
    root["control"]["Version"]       = inputValues[1];
    root["control"]["Architecture"]  = inputValues[2];
    root["control"]["Maintainer"]    = inputValues[3];
    root["control"]["Installed-Size"]= inputValues[4];
    root["control"]["Depends"]       = {inputValues[5]};
    root["control"]["Suggests"]      = inputValues[6];
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
        std::cout << cli_dpkg;
      } else {
        fmt::print(stderr,fmt::fg(fmt::color::red),"Unknown module {}  in the --help-module options\n", s);
      }
      return 0;
    }
   
     
   //-------------------------------------------------
   //                what-file
   //-------------------------------------------------
   /*if (vm.count("what-file")) {
      fs::path path(fs::current_path() /= dir);
      if(!fs::exists(path)){
          fmt::print(stderr,fg(fmt::color::indian_red), "Error file no existe ");
      }
    if (dir == "prerm") {
      }
    } */ 
   //-------------------------------------------------
  }
  catch (const po::error &ex){
  fmt::print(stderr,"{}\n", ex.what());
  }
} 
