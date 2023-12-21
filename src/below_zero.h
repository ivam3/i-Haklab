// Fichero : below_zero
// Autor: @demon_rip

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
#include <dirent.h> // para explorar el directorio /proc/
#include <iostream>
#include <nlohmann/json.hpp>
#include <set>
#include <thread>
#include <unistd.h>
//------------------------------------------
//------------------------------------------
#define PORT_SHH 8022
#define PORT_WEP 808O
#define PORT_FTP 8021
#define LOCALHOST 127.0.0.1
//------------------------------------------
//------------------------------------------
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
  string m_input_path;
  string m_input_file;
  bool m_update_files;
  int error_level;

  bool parse(int argc, char *argv[]) {
    // clang-format off
    po::options_description cli_options;
    cli_options.add_options()
    
            // nombre , typo , decripcion
      ("input-path,I", po::value(&m_input_path), "input path")
      ("input-file", po::value< string >(&m_input_file), "input file")
      ("output,o", po::value<std::string>(), "output path")
      ("language", po::value<std::string>()->default_value("es"),"UI language")
      ("error-level", po::value<int>(&error_level)->default_value(true),"error level")
      ("verbose", po::bool_switch()->default_value(false),"show verbose log");

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
      ("update-files,u", po::bool_switch(&m_update_files)->default_value(false),"En contruccion")      
      ("name-pkg", po::value<string>(),"Create directory tree\n control: Where do the package maintainer scripts go?\n src: Your executable")
      ("what-file", po::value<string>(),"What does the file do?")
      ("manifies", po::value<vector<string>>(),
       "| Package \n"
       "| Version \n"
       "| Architerture \n"
       "| Maintainer \n"
       "| Installed-Size \n"
       "| Homepage \n"
       "| Description ");

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
    positionalOptions
      .add("manifies", 8)
      .add("name-user", 1)
      .add("input-path", 1);
    
    po::variables_map vm;
    try {
      po::store(po::command_line_parser(argc, argv)
          .options(cli_all)
          .positional(positionalOptions)
          .run(),
          vm);
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
      std::cout << "Usage: i-haklab [options] [arg]" << std::endl;
      std::cout << cli_options << '\n';
      return false;
    } else if (vm.count("help-module")) {
      const std::string  &s = vm["help-module"].as<string>();
      if (s == "dpkg") {
       std::cout << cli_dpkg;
    } else {
     std::cout  << "Unknown module" <<s<<" in the --help-module options" << std::endl;
      return false;
      }
    }
    // --------
  
    return true;
  }
};  // class 
}; // namespace cli




namespace hak {
/*
 *  Contructor 
 */
class Haklab  {
public:
  Haklab(){
   if(getgid() == 0){
    //fmt::print(stderr,fg(fmt::color::indian_red),"[Error] Please run as unprivileged user");
  }
};    
  /*
   * 
   */
 // Haklab getUser();
  /*
   *  from -
   *  to   - (ddfault)  direcorio actual 
   */
  void updateFiles(std::string from, std::string to = fs::current_path().string()){
      if(from == to){exit(1);};
      std::set<string>filesFrom, filesTo;
      std::vector<string> con , no_con;
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
           std::cout << " Ha ocurrido un error al acceder al directorio: \n" << ex.what();
        }

        for (const auto &n : filesTo) {
            if (filesFrom.count(n) == 0) {
              
              std::cout << "No coinsiden :" << n << std::endl;
            } else {
              
              std::cout << "Coinciden :" << n << std::endl;
              try {
                fs::copy(n,to,copyOptions);    
              }
              catch (const  fs::filesystem_error &ex) {
                 
              }  
            }
        }
  };

private: // Specificador de acceso (pribado)
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
    std::vector<std::string> spinner = {"█■■■■", "■█■■■", "■■█■■", "■■■█■", "■■■■█"};
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
  } // loading 
};

}; // namespace hak

#endif // !DEBUG
