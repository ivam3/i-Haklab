#include "../include/below_zero.h"



int Haklab::run(int argc,const char  *argv[]){
   command_line_argument_parser parser;
   try {
   auto args = parser.parse(argc, argv);
  
   if (args.no_arguments()) {
      	cout << "No arguments supplied on the command line" << endl;
   }

   if (args.help()){
        cout << getDesc() << endl;
   }

   if (std::strlen(args.about().c_str()) > 0){
     fs::path db = string(getenv("HOME")) + "/.local/etc/i-Haklab/Tools/Readme";  
     startSyntax(about(db , args.about().c_str()));
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
   return 0;
}


void Haklab::os_check(){
  #ifdef _WIN32 
    cerr << "Error " << endl;
  #elif _WIN64 
    cerr << "Erro " << endl;
  #endif // DEBUG 
}

void k_boom(int signum){
   std::string k_boom = R"(
                        _-^--^=-_
                   _.-^^          -~_
                _--                  --_
              (<                        >)
               |                         |
                \._                   _./
                   '..--. . , ; .--..'
                         | |   |
                      .-=||  | |=-.
                      '-=k-boom!!='
                         |;   :|
                _____.,-#########-,._____⏎)";
   // startSyntax(k_boom);
   exit(1);
}

template <typename Func>
void Haklab::Loading(Func func) {
    std::vector<std::string> spinner{"█■■■■", "■█■■■", "■■█■■", "■■■█■", "■■■■█"};
    int spinnerIndex = 0;
    boost::thread t([&]() {
        while (true) {
            std::cout << spinner[spinnerIndex] << "\r" << std::flush;
            spinnerIndex = (spinnerIndex + 1) % spinner.size();
            boost::this_thread::sleep_for(boost::chrono::milliseconds(100));
        }
        std::cout << std::endl;
    });
    t.detach();
    func();
}


void runCommand(const string &command){
  bp::child c(command, bp::std_out > "log.txt");
}


string Haklab::about(fs::path db, string command){
    if (!fs::is_directory(db)) {
      cerr << "[ERROR] No found " << db << endl;
    };
    string txtCommand{}; 
    db /= "/" +  std::string(1, std::toupper(command[0]));
    std::fstream fd(db.c_str() + string("/") + command.c_str() + ".md");
    if (fd.is_open()) {
      std::stringstream buffer;
      buffer << fd.rdbuf();
      fd.close();
      txtCommand = buffer.str();
    } else {
      cout << "Con la inicial " << command[0] << " tengo :" << endl;
      for (fs::directory_entry &entry : fs::directory_iterator(db)) {
        cout << entry.path().stem() << endl;
      }
   }
    return txtCommand;
} // about




/* main    
int haklab::Haklab::run() {
  try {
    auto args = parser.parse(m_argc, m_argv);
    if (args.no_arguments()) {
      fmt::print(fg(fmt::color::orange),
      cerr << "No argument provided on the command line" << endl;
    }

    if (args.CreateMkt().size() != 0) {
      redteam::ResTeamHakalb::mkt(args.CreateMkt());
    }

    if (args.FCheckInternet()) {
      cout << network.CheckInternet() << endl;
    }
    
    if (args.FAbout().size() != 0) {
       about(args.FAbout());
    }

    if (args.FInterface()) {
      for (const auto interface : network.ListAllInterfaces()) {
        cout << static_cast<string>(interface) << endl;
      };
      return 0;
    }

    if (args.WepStatusCode().size() != 0) {
      if (args.Fport() == 4) {
        cerr << "requeris '--port' " << endl;
        return false;
      };
      string port = std::to_string(args.Fport());
      string host = args.WepStatusCode();
      cout << network.GetStatusCode(host, port) << endl;
    }

    if (args.FGet_ip().size() != 0){
     string address =  network.GetIPaddress(args.FGet_ip());
      if(!address.empty()){
        std::cout << address << std::endl;
    } else {
        std::cerr << "No se pudo obtener la dirección IP para la interfaz '" << address << "'" << std::endl;
      }
    }
  
  } catch (po::error &ex) {
    cerr << "Usage: i-haklab [ options ] [ arg ]" << std::endl;
    cerr << ex.what() << endl;
    return false;
  } catch (...) {
    cerr << "Unknown error\n";
    return false;
  }
  return true;
}
*/

/*
 * Actualizar los archivos que cuisidan en el dir que este
 // */
/* bool updateFiles(vector<string> path_file) {
  std::set<string> filesHere; // -->
  if (path_file.size() == 0) {
    //  return false;
  };
  // Opciones de copy
  const auto copyOptions = fs::copy_options::update_existing |
                           fs::copy_options::recursive |
                           fs::copy_options::overwrite_existing;

  for (const auto &hereFile : fs::directory_iterator(fs::current_path())) {
    filesHere.insert(hereFile.path().filename().string().c_str());
  }
  return true;
};*/
// void hack::Haklab::directory_iterator(const char *path){

// namespace fs = std::filesystem;

//     fs::path directory = "./"; // Directorio actual, puedes cambiarlo por el
//     directorio que desees

//     for (const auto& entry : fs::directory_iterator(directory)) {
//         // Obtener el nombre del archivo
//         fs::path filePath = entry.path();
//         std::string fileName = filePath.filename().string();

//         // Verificar si el archivo no es oculto
//         if (!fileName.empty() && fileName[0] != '.') {
//             std::cout << fileName << "\n"
//         }
//     }
// }
/*
void haklab::Haklab::searchProcess(std::string process){
    DIR* dir;
    struct dirent* ent;
    if ((dir = opendir("/proc")) != NULL) {
        while ((ent = readdir(dir)) != NULL) {
            std::string entryName = ent->d_name;
            if (std::all_of(entryName.begin(), entryName.end(), ::isdigit)) {
                std::string statusFilePath = "/proc/" + entryName + "/comm";
                std::ifstream statusFile(statusFilePath);
                if (statusFile.is_open()) {
                    std::string processName;
                    statusFile >> processName;
                    if (processName == process) {
    //                     fmt::print("El proceso {0}  ha sido encontrado con
PID: {1}\n ",process,entryName);
                        // Aquí puedes realizar más acciones con el PID del
proceso encontrado
                    }
                }
            }
        }
        closedir(dir);
    } else {
    // //     fmt::print( "No se pudo abrir el directorio /proc\n" );
    }
}
*/
/*
void haklab::Haklab::ChangeEnvironmentVariable(std::string name, std::string
new_valor ){
    // Ruta del archivo
    std::string filePath = std::string(getenv("HOME")) + "/.zshenv";

    // Abrir el archivo
    std::ifstream inputFile(filePath);

    if (!inputFile.is_open()) {
    //     fmt::print(stderr,fg(fmt::color::red),"Error al abrir el
archivo.\n");
    }

    // Leer el contenido del archivo en una cadena
    std::string fileContent((std::istreambuf_iterator<char>(inputFile)),
std::istreambuf_iterator<char>()); inputFile.close();

    // Expresión regular para buscar la variable de entorno
    boost::regex expr("(" + name +"=)([^\n]+)");

    // Buscar la coincidencia en el contenido del archivo
    boost::smatch match;
    if (boost::regex_search(fileContent, match, expr)) {
        // Imprimir el valor actual
        std::cout << "Valor actual de USER: " << match[2] << "\n";

        // Modificar el valor (puedes establecer el nuevo valor según tus
necesidades) std::string nuevoValor = new_valor ; std::string nuevoContenido =
boost::regex_replace(fileContent, expr, "$1" + nuevoValor);

        // Escribir el nuevo contenido en el archivo
        std::ofstream outputFile(filePath);
        if (!outputFile.is_open()) {
    //         fmt::print(stderr, fg(fmt::color::red),"Error al abrir el archivo
para escritura.\n");
        }
        outputFile << nuevoContenido;
    //     fmt::print(fg(fmt::color::blue), "Valor de USER cambiado a: {} \n",
nuevoValor); } else {
    //     fmt::print(stderr, fg(fmt::color::red), "Variable de entorno USER no
encontrada en el archivo.\n");

    }
*/
