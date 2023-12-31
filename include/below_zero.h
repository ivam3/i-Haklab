// Fichero : below_zero.h  
// Autor: @demon_rip

#pragma once
//------------------------------------------
//     
//------------------------------------------
#include <iostream>
//------------------------------------------
//------------------------------------------
#define PORT_DEF 4444
#define PORT_SHH 8022
#define PORT_WEP 808O
#define PORT_FTP 8021
#define LOCALHOST 127.0.0.1
//------------------------------------------
//------------------------------------------
using std::fstream;
using std::string;
using std::vector;
using std::cout;
using std::endl;
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



namespace hak {
/*
 *  Contructor 
 */
class Haklab  {
 private:
  static inline string  IHETC{string(getenv("HOME")) + "/.local/etc/i-Haklab"};
  static inline string LIBEX = string(getenv("HOME"))+ "/.local/libexec/i-Haklab";
public:
  /*
   * inisializar linea Cli
   */
  int run(int argc , const char *argv[]); 
  /*
   *  Salir con estilo jjj
   */
  static void k_boom(int signum);
  /*
  template <typename Func> 
  void loading(Func func) {
    hide_cursor();
    std::vector<std::string> spinner = {"█■■■■", "■█■■■", "■■█■■", "■■■█■", "■■■■█"};
    int spinnerIndex = 0;

    std::thread t([&]() {
      while (true) {
             std::cout
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
    // */
};
}; // namespace hak

