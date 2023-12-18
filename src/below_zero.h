#ifndef BELOW_ZERO
#define BELOW_ZERO

//------------------------------------------
//------------------------------------------
#include <boost/array.hpp>
#include <boost/filesystem.hpp>
#include <boost/iostreams/device/file.hpp>
#include <boost/iostreams/stream.hpp>
#include <boost/program_options.hpp>
#include <boost/regex.hpp>
#include <cstdlib>
#include <cwchar>
#include <dirent.h> // para explorar el directorio /proc/
#include <fmt/color.h>
#include <fmt/core.h>
#include <fmt/printf.h>
#include <iostream>
#include <nlohmann/json.hpp>
#include <set>
#include <thread>

//------------------------------------------
//------------------------------------------

//------------------------------------------
//------------------------------------------
//"2>&1" redirige los errores de salida de shell
using std::fstream;
using std::string;
using std::vector;

namespace fs = boost::filesystem;
namespace po = boost::program_options;

// Shell que se pueden configurar
namespace shell {
enum Shell {
  zsh,
  fish,
};
};

enum class Color {
  Default,
  Black,
  Red,
  Green,
  Yellow,
  Blue,
  Magenta,
  Cyan,
  White
};

std::string setColor(Color color);
void syntax_highlight(const std::string &code);

namespace cli {
class comanLineOpcion {
public:
  fs::path input_path;
  string output_path;
  string lang;
  int error_level{0};
  bool verbose{false};
  bool gold{false};
  bool updateFile{false};

  bool parse(int argc, char *argv[]) {
    // clang-format off
    po::options_description cli_options{"Options"};
    cli_options.add_options()
      ("help,?", "Print this menu and leave")
      ("help-module", po::value<string>(),"produce a help for a given module")
      ("version,v","print version string")
      // nombre , typo , decripcion
      ("input,i", po::value<std::string>(), "input path")
     // ("output,o", po::value<std::string>()->required(), "output path")
      ("language", po::value<std::string>()->default_value("es"),"UI language")
      ("error-level", po::value<int>()->default_value(0),"error level")
      ("verbose,v", po::bool_switch()->default_value(false),"show verbose log");

    //-------------------------------------------------
    //               Configutacion
    //-------------------------------------------------
    po::options_description cli_config{"Configutacion"};
    cli_config.add_options()
      ("name-user", po::value<vector<string>>(),"Change username default(USER=i-Haklab");

    //-------------------------------------------------
    //                   dpkg
    //-------------------------------------------------
    po::options_description cli_dpkg{"Create packages\n\tList of options to "
                                     "automate creating deb binary packages"};
    cli_dpkg.add_options()
      ("update_files,u", po::bool_switch()->default_value(true),"En contruccion")      
      ("name-pkg", po::value<string>(),"Create directory tree\n control: Where do the package maintainer scripts go?\n src: Your executable")
      ("what-file", po::value<string>(),"What does the file do?")
      ("manifies", po::value<vector<string>>(),
       "| Package"
       "| Version"
       "| Architerture "
       "| Maintainer "
       "| Installed-Size "
       "| Homepage "
       "| Description");

    //-------------------------------------------------
    //              Automatitation
    //-------------------------------------------------
    po::options_description cli_automatitation{"Automatitation Options"};
    cli_automatitation.add_options()
      ("chek-error,r", "Manipulacion de errores")
      ("file-manager,m", "Open the file manager in the termux directory")
      ("list-frenwor,l", po::value<string>(),"Lista de herramientas dispomibles")
      ( "about", po::value<string>(), "Show informations about tool/framework");
    
    po::options_description cli_cryptography{"Cryptography"};
    cli_cryptography.add_options()
      ("rsa", "prueva");
    // clang-format on 
    po::options_description cli_all{"All"};
    //-------------------------------------------------
    //-------------------------------------------------
    cli_all.add(cli_options)
        .add(cli_config)
        .add(cli_dpkg)
        .add(cli_automatitation);

    //-------------------------------------------------
    //-------------------------------------------------
    cli_options.add(cli_config).add(cli_automatitation).add(cli_cryptography);

    //-------------------------------------------------
    //  Argumento pocicionales
    //-------------------------------------------------
    po::positional_options_description positionalOptions;
    positionalOptions.add("manifies", 8).add("name-user", 2);

    po::variables_map vm;
    try {
      po::store(po::command_line_parser(argc, argv).options(cli_all).run(), vm);
      po::notify(vm);
    } catch (po::error &e) {
      std::cout << e.what() << '\n';
      std::cout << cli_options << '\n';
      return false;
    } catch (...) {
      std::cout << "Unknown error\n";
      std::cout << cli_options << '\n';
      return false;
    }

    if (vm.count("help")) {
      std::cout << cli_options << '\n';
      return false;
    } else if (vm.count("help-module")) {
      const string s = vm["help-module"].as<string>();
      if (s == "dpkg") {
       std::cout << cli_dpkg;
    } else {
      fmt::print(fmt::fg(fmt::color::red),"Unknown module {}  in the --help-module options\n", s);
      return false;
      }
    }

    input_path = vm["input"].as<std::string>();
    output_path = vm["output"].as<std::string>();
    lang = vm["language"].as<std::string>();
    // error_level = vm["error-level"].as<int>();
    // verbose = vm["verbose"].as<bool>();
    updateFile = vm["update_files"].as<bool>();
    return true;
  }
};
}; // namespace cli



namespace hak {
/*
 *  Contructor 
 */
class Haklab : public cli::comanLineOpcion {
public:
  Haklab()
      : cli::comanLineOpcion{} {};
  /*
   *  from -
   *  to   - (ddfault)  direcorio actual 
   */
  void updateFiles(fs::path &from, fs::path to = fs::current_path()){
      std::set<string>filesFrom, filesTo;
      const auto copyOptions = fs::copy_options::update_existing 
          | fs::copy_options::recursive 
          | fs::copy_options::overwrite_existing;
      try{
for (const fs::directory_entry &inFile : fs::directory_iterator(from)) {
                filesFrom.insert(inFile.path().filename().string());
            }
            for (const auto &hereFile : fs::directory_iterator(to)) {
                filesTo.insert(hereFile.path().filename().string());
            }
        } catch (fs::filesystem_error const &ex) {
            fmt::printf(" Ha ocurrido un error al acceder al directorio: \n {} ",  ex.what());
        }

        for (const auto &n : filesTo) {
            if (filesFrom.count(n) == 0) {
              std::cout << "Coinsuden :" << n << std::endl;
            } else {
              std::cout << "No coinsiden :" << n << std::endl;
            }
        }
        try {
          
        }
        catch (const fs::filesystem_error &ex) {
        // fs::copy(source,destination,copyOptions);     
        }
     
  };

private: // Specificador de acceso (pribado)
  int m_port;
  string m_host;
  string m_shell;
  /*
   *
   */
  static inline string // una variable estática inlínea se puede definir e
                       // inicializar directamente
                           IHETC{string(getenv("HOME")) +
                                 "/.local/etc/i-Haklab"};
  static inline string LIBEX{string(getenv("HOME")) +
                             "/.local/libexec/i-Haklab"};
  /*
   * borra la pantalla
   */
  void clear_screen();
  /*
   * Ocultar el cursor
   */
  void hide_cursor();
  /*
   * Muestra el cursor
   */
  void show_cursor();

public: // Specificador de acceso (publico)
        /*
         * ufff
         */

  /*
   * "/.local/etc/i-Haklab"
   */
  string get_IHETC();
  /*
   * "/.local/libexec/i-Haklab"
   */
  string get_LIBEX();
  /*
   * Muestra informacion sobre herramientas
   */
  static void about(std::string about);
  /*
   * Cambia el valos de una variable de entorno
   */
  void ChangeEnvironmentVariable(std::string name, std::string new_valo);
  /*
   * Muestra un baner de salida
   */
  static void k_boom(int signum);
  /*
   */
  void baner();
  /*
   * Arquitectura del sistema
   */
  std::string show_architecture();
  /*
   * Busca un oroceso en el systema
   * arg: nombre de proseso
   */
  void searchProcess(std::string process);
  /*
   *
   */
  void update_haklab();
  /*
   * Descargar archivos
   * url: URL del archivo que se desea descargar
   * filename: Nombre del archivo con el que se guardará
   */
  bool download_file(std::string url, std::string outputFilename);

  // Función para mostrar un spinner mientras se ejecuta otra función en segundo
  // plano
  template <typename Func> void loading(Func func) {
    hide_cursor();
    // std::thread::id main_thread_id = std::this_thread::get_id();

    std::vector<std::string> spinner = {"█■■■■", "■█■■■", "■■█■■", "■■■█■",
                                        "■■■■█"};
    int spinnerIndex = 0;

    std::thread t([&]() {
      while (true) {
        /*std::cout << "\rSearching\t" */ std::cout
            << spinner[spinnerIndex] << "\b\b\b\b\b\b\b\b" << std::flush;
        spinnerIndex = (spinnerIndex + 1) % spinner.size();
        std::this_thread::sleep_for(std::chrono::milliseconds(100));
      }
    });

    t.detach();

    // Ejecuta la función proporcionada en segundo plano
    func();

    show_cursor();
  }
};

}; // namespace hak

#endif // !DEBUG
