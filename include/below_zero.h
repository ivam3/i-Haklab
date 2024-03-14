// Fichero : below_zero.h
// Autor: @demon_rip

#ifndef BELOW_ZERO_
#define BELOW_ZERO_

//------------------------------------------
//
//------------------------------------------
#include "../include/admin/AdminHaklab.h"
#include "../include/command_line_argument_parser.h"
#include "../include/network/NetworHaklab.h"
#include <boost/beast/http/status.hpp>
#include <boost/filesystem.hpp>
#include <boost/filesystem/path.hpp>
#include <boost/thread.hpp>
#include <csignal>
#include <cstdlib>
#include <curl/curl.h>
#include <fmt/color.h> // Un  mundo sin colores es  feo  .....
#include <fstream>
#include <iostream>
//------------------------------------------
//------------------------------------------
namespace fs = boost::filesystem;
namespace po = boost::program_options;
//------------------------------------------
//------------------------------------------
#define PORT_SHH 8022
#define PORT_WEP 808O
#define PORT_FTP 8021
#define LOCALHOST 127.0.0.1
#define ROOT_DIR getenv("PREFIX")

#define SHOW_CURSOL_ANSI "\e[?25h\n";
#define HIDE_CURSOR_ANSI "\e[?25l";
#define CLEAR_SCREEN_ANSI "\e[1;1H\e[2J";
//------------------------------------------
//------------------------------------------
using std::cerr;
using std::cout;
using std::endl;
using std::fstream;
using std::string;
using std::vector;
//------------------------------------------
//------------------------------------------

// Enumeracion con alcanse
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

namespace haklab {

// Shell que se pueden configurar
typedef enum {
  ZSH, // Default
  FISH,
} shell;


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

/*
 *  Salir con estilo jjj
 */
void k_boom(int signum);
/*
 *
 */
std::string setColor(Color color);
/*
 *
 */
void syntax_highlight(const std::string &code);

/*
 * Clase principal
 */
class Haklab {
private: // ---> Variables privadas
  const char *m_file_name;
  string m_user_name;
  int m_argc;
  const char **m_argv;
  std::string m_shell;
  network::NetworHakaklab network;
  admin::AdminHaklab admin;
  fs::path IHETC{string(getenv("HOME")) + "/.local/etc/i-Haklab"};
  fs::path LIBEX{string(getenv("HOME")) + "/.local/libexec/i-Haklab"};
public:
  // (nombre de shell, shell a usar)
  Haklab(string user_name, shell sh) : m_user_name(std::move(user_name)) {
    switch (sh) {
    case FISH:
      m_shell = "fish";
      break;
    case ZSH:
      m_shell = "zsh";
      break;
       }
  }
  // Obtener shell 
  string getShell() { return m_shell; };
  /*
   * Atrapa el CONTROL+c
   */
  void ctrl_c() { signal(SIGINT, k_boom); }
  /*
   * Algo para ver mientra se espera
   */
  template <typename Func> void Loading(Func func) {
    hide_cursor();
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
    // Hilo de spinner
    t.detach();
    // Ejecuta la función proporcionada en segundo plano
    func();
    show_cursor();
  } // loading
  
  void about(std::string about) {
     fs::path fren = IHETC /= std::basic_string("/Tools/Readme/") + about;
     cout << fren << endl;
     // Buscar en
     if (!fs::exists(fren)) {
      fren = IHETC /= std::basic_string("/Tools/Readme/command/") + about + ".md";
     } else {
       std::cerr << fren << endl;
     }
     std::ifstream file(fren.c_str());
     // Comprobar si se abrio el arcivo
     if (file.is_open()) {
       std::stringstream buffer;
       buffer << file.rdbuf();
       file.close();
       // Lo muetro 
       syntax_highlight(buffer.str());
     }
   }
};  // end  class
};  // namespace haklab

#endif //  BELOW_ZERO_
