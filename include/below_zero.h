// Fichero : below_zero.h
// Autor: @demon_rip

#pragma once
//------------------------------------------
//
//------------------------------------------
#include "../include/command_line_argument_parser.h"
#include "../include/network/NetworHaklab.h"
#include <boost/beast/http/status.hpp>
#include <boost/filesystem.hpp>
#include <boost/thread.hpp>
#include <csignal>
#include <cstdlib>
#include <fmt/color.h> // Un  mundo sin colores es  feo  .....
#include <fmt/core.h>
#include <fstream>
#include <iostream>
//------------------------------------------
//------------------------------------------
namespace fs = boost::filesystem;

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
using std::cout;
using std::endl;
using std::fstream;
using std::string;
using std::vector;
//------------------------------------------
//------------------------------------------

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
enum class Shell {
  zsh,
  fish,
};

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
class Haklab {
private: // ---> Variables privadas
  const char *_shell;
  command_line_argument_parser parser;
  network::NetworHakaklab network;
  string IHETC{string(getenv("HOME")) + "/.local/etc/i-Haklab"};
  string LIBEX{string(getenv("HOME")) + "/.local/libexec/i-Haklab"};

public:
  // contructor
  Haklab() {}
  /*
   * Atrapa el control c
   */
  void ctrl_c() { signal(SIGINT, k_boom); }
  /*
   *
   */
/*  Haklab &Shell(shell::Shell &sh) {
    switch (sh) {
    default:
      break;
    }
    return *this;
  }*/
  /*
   * inisializar
   */
  int run(int argc, const char *argv[]);
  /*
   * Algo para ver mientra se espera
   */
  template <typename Func> void Loading(Func func) {
    hide_cursor();
    std::vector<std::string> spinner{"█■■■■", "■█■■■", "■■█■■", "■■■█■",
                                     "■■■■█"};
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
  }      // loading
private: // ---> Funciones pribada
  /*  Comprueba la existencia de la key
   *  - advierte en auto si no existe   (HAKLAB-APT-OFF )   para    quitar
   *  - descarga en auto matico ( HAKLAB-APT-AUTO >> .zshrc)
   */
  void apt_source() {
    string source = std::string(getenv("PREFIX")) + "/etc/apt/sources.list.d";
    if (!fs::exists(source)) {
      if (true) {
        cout << "[ WARNING ] No found" << source << endl;
      }
      exit(1);
    }
    cout << "Se creo" << source << endl;
  };
  /*
   * arg (name)
   */
  void about(std::string about) {
    if (fs::is_directory(IHETC)) {
      std::cerr << "[Warning] " + IHETC + "No found" << std::endl;
    }
    // Donde esta todo
    std::string fren = IHETC + std::basic_string("/Tools/Readme/") + about;
    // Buscar en
    if (!fs::exists(fren)) {
      fren = IHETC + std::basic_string("command/") + about + ".md";
    }
    std::ifstream file(fren);
    // Comprobar si se abrio el arcivo
    if (file.is_open()) {
      std::stringstream buffer;
      buffer << file.rdbuf();
      file.close();
      // Resaltado de sintax
      syntax_highlight(buffer.str());
    } else {
      // algo de color
      // fmt::print(fmt::fg(fmt::color::dark_red),"Error\n");
      std::cerr << "No found " + about << std::endl;
    }
  }

}; // end  class
}; // namespace haklab
