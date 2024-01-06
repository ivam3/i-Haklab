#include "../include/below_zero.h"
#include "../include/command_line_argument_parser.h"
#include "../include/network/NetworHaklab.h"
#include "../include/redteam/RedTeamHaklab.h"
#include <boost/filesystem.hpp>
#include <boost/memory_order.hpp>
#include <fstream>

// Nombres de espacio de Boost
namespace fs = boost::filesystem;
namespace po = boost::program_options;

using std::cerr;
using std::cout;
using std::endl;

// ======= ABAUT =============
void hak::about(std::string about) {
  // Donde esta todo
  std::string fren =
      hak::Haklab::IHETC + std::basic_string("/Tools/Readme/") + about;
  // Buscar en
  if (!fs::exists(fren)) {
    fren = hak::Haklab::IHETC + std::basic_string("command/") + about + ".md";
  }
  std::ifstream file;
  file.open(fren);
  // Comprobar si se abrio
  if (!file.is_open()) {
    std::cout << "No found  " << about << std::endl;
    exit(1);
  }
  // obtener la longitud del archivo:
  file.seekg(0, file.end);
  int length = file.tellg();
  file.seekg(0, file.beg);
  // asigna memoria
  std::unique_ptr<char[]> buffer(new char[length]);
  // leer datos como un bloque:
  file.read(buffer.get(), length);
  // serar archivo
  file.close();
  // Resaltado de sintax
  syntax_highlight(buffer.get());
}

// main
int hak::Haklab::run(int argc, const char *argv[]) {
  command_line_argument_parser parser;
  network::NetworHakaklab network;
  try {
    auto args = parser.parse(argc, argv);

    if (args.no_arguments()) {
      cout << "No arguments supplied on the command line" << endl;
    }

    if (args.CreateMkt().size() != 0) {
      redteam::ResTeamHakalb::mkt(args.CreateMkt());
    }

    if (args.FAbout().size() != 0) {
      hak::about(args.FAbout());
    }

    if (args.FInterface()) {
      for (const auto interface : network.ListAllInterfaces()) {
        cout << static_cast<string>(interface) << endl;
      };
      return 0;
    }

    if (args.WepStatusCode().size() != 0) {
      if (args.port() == 4) {
        cerr << "requeris '--port' " << endl;
        return false;
      };
      string port = std::to_string(args.port());
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
    cout << "Unknown error\n";
    return false;
  }
  return true;
}

/*
 * Actualizar los archivos que cuisidan en el dir que este
 */
bool updateFiles(vector<string> path_file) {
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
};

// Selector de color
std::string setColor(Color color) {
  std::string code = "\033[";
  switch (color) {
  case Color::Default:
    code += "0";
    break;
  case Color::Black: // Negro
    code += "30";
    break;
  case Color::Red: // Rojo
    code += "31";
    break;
  case Color::Green: // Verde
    code += "32";
    break;
  case Color::Yellow: // Amarillo
    code += "33";
    break;
  case Color::Blue: // Azul
    code += "34";
    break;
  case Color::Magenta: // Magenta
    code += "35";
    break;
  case Color::Cyan: // cian
    code += "36";
    break;
  case Color::White: // Blanco
    code += "37";
    break;
  default:
    code += "0";
  }

  code += "m";
  return code;
};

void syntax_highlight(const std::string &code) {
  std::string highlightedCode = "";
  // Colores para cada parte del código
  std::string colorKeywords = setColor(Color::Blue);
  std::string colorStrings = setColor(Color::Green);
  std::string colorComments = setColor(Color::Magenta);
  std::string colorDefault = setColor(Color::Default);

  std::size_t pos = 0;
  std::size_t start = 0;
  std::size_t end = 0;

  while (pos < code.size()) {
    // Buscar en la cadena
    if (code.find("#", pos) == pos) {
      // Comentario
      start = pos;
      end = code.find("\n", pos);
      // Si no hay coincidencias
      if (end == std::string::npos) {
        end = code.size();
      }
      pos = end;
      highlightedCode +=
          colorComments + code.substr(start, end - start) + colorDefault;
    } else if (std::isalpha(code[pos])) {
      // Palabra clave
      start = pos;
      while (std::isalnum(code[pos]) || code[pos] == '_') {
        pos++;
      }
      std::string keyword = code.substr(start, pos - start);
      highlightedCode += colorKeywords + keyword + colorDefault;
    } else if (code[pos] == '"' || code[pos] == '\'') {
      // Cadena de caracteres
      char delimiter = code[pos++];
      start = pos;
      while (pos < code.size() && code[pos] != delimiter) {
        pos++;
      }
      if (pos < code.size()) {
        pos++;
      }
      std::string str = code.substr(start, pos - start);
      highlightedCode += colorStrings + str + colorDefault;
    } else {
      // Otros caracteres
      highlightedCode += code[pos++];
    }
  }
  // // fmt::print(highlightedCode);
  std::cout << highlightedCode << std::endl;
};

void hak::Haklab::Haklab::k_boom(int signum) {
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
  syntax_highlight(k_boom);
  exit(1);
}

void clear_screen() {
  // Se coloca en la pocicion (1 1) y borra la pantalla
  const char *CLEAR_SCREEN_ANSI = "\e[1;1H\e[2J";
  write(STDOUT_FILENO, CLEAR_SCREEN_ANSI, 12);
}

void hide_cursor() {
  const char *HIDE_CURSOR_ANSI =
      "\e[?25l"; // Send escape sequence to hide cursor
  write(STDOUT_FILENO, HIDE_CURSOR_ANSI, 7);
}

void show_cursor() {
  const char *SHOW_CURSOL_ANSI = "\033[?25h";
  write(STDOUT_FILENO, SHOW_CURSOL_ANSI, 7);
}

std::string show_architecture() {
#ifdef __x86_64__
  return "(x86_64)";
#elif __i386__
  return "x86 (32-bit)";
#elif __arm__
  return "(ARM)";
#elif __aarch64__
  return "aarch64 ";
#elif
  return "(Desconocida)";
#endif
}

// bool hack::Haklab::download_file(std::string url, std::string
// outputFilename){
//         CURL *curl;
//         FILE *fp;
//         CURLcode result;
//         curl = curl_easy_init();
//         if (curl) {
//           fp = fopen(outputFilename.c_str(),"wb");
//           curl_easy_setopt(curl, CURLOPT_URL, url.c_str());
//           curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, NULL);
//           curl_easy_setopt(curl, CURLOPT_WRITEDATA, fp);
//           result = curl_easy_perform(curl);
//           curl_easy_cleanup(curl);
//           fclose(fp);
//           // Verifica si la descarga se realizó correctamente
//         if (result != CURLE_OK)
//         {
//             return EXIT_FAILURE;
//         }
//     }
//             return EXIT_SUCCESS;
// };

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
void hak::Haklab::searchProcess(std::string process){
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
void hak::Haklab::ChangeEnvironmentVariable(std::string name, std::string
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
