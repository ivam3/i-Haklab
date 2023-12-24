// Fichero : below_zero
// Autor: @demon_rip

#ifndef BELOW_ZERO
#define BELOW_ZERO

//------------------------------------------
//    Redes 
//------------------------------------------
#include "command_line_argument_parser.h"
#include <boost/asio.hpp>
//----------------------------------------
#include <boost/array.hpp>
#include <boost/filesystem.hpp>
#include <boost/iostreams/device/file.hpp>
#include <boost/iostreams/stream.hpp>
#include <boost/program_options.hpp>
#include <boost/regex.hpp>
#include <complex>
#include <cstdlib>
#include <dirent.h> // para explorar el directorio /proc/
#include <iostream>
#include <nlohmann/json.hpp>
#include <set>
#include <thread>
#include <unistd.h>
#include <vector>
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
//------------------------------------------
//------------------------------------------

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


namespace hak {
/*
 *  Contructor 
 */
class Haklab : public command_line_argument_parser  {
public:
  Haklab()
  : command_line_argument_parser()
  {
   if(getgid() == 0){
     std::cerr << "[Error] Please run as unprivileged user" << std::endl;
  }
};    
  /*
   *  to -
   */
  bool updateFiles(vector<string> filespath);
  /*
   *  Crear dir  equipo rojo y azul 
   */ 
  void directRedTeam(std::string opjName);
   /*
    * Crear dir 
    */
  void mkt(string machineName);
  /*
   *
   */
  void extractPorts();
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
