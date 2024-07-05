// Fichero : below_zero   
// Autor: @demonr_rip  

#ifndef BELOW_ZERO_
#define BELOW_ZERO_

//------------------------------------------
//
//-----------------------------------------
#include <boost/asio.hpp>
#include <boost/process.hpp>
#include <boost/filesystem.hpp>
#include <boost/iostreams/stream.hpp>
#include <boost/json.hpp>
#include <boost/program_options.hpp>
#include <boost/thread.hpp>
#include <fmt/color.h> // Un  mundo sin colores es  feo  .....
//------------------------------------------
#include <fstream>
#include <iostream>
//------------------------------------------
//------------------------------------------
namespace po = boost::program_options;
namespace fs = boost::filesystem;
namespace bp  = boost::process;

//------------------------------------------
//------------------------------------------
#define PORT_SHH  "8022"
#define PORT_WEP  "808O"
#define PORT_FTP  "8021"
#define LOCALHOST "127.0.0.1"

#define SHOW_CURSOL_ANSI "\e[?25h"
#define HIDE_CURSOR_ANSI "\e[?25l"
#define CLEAR_SCREEN_ANSI "\e[1;1H\e[2J"
//------------------------------------------
//------------------------------------------
using std::cerr;
using std::cout;
using std::endl;
using std::fstream;
using std::string;
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

// Shell que se pueden configurar
typedef enum {
  ZSH,
} shell;


string setColor(Color color) {
  string code = "\033[";
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

/*
 *
 */
void syntax_highlight(const string &code) {
  string highlightedCode = "";
  // Colores para cada parte del código
  string colorKeywords = setColor(Color::Blue);
  string colorStrings = setColor(Color::Green);
  string colorComments = setColor(Color::Magenta);
  string colorDefault = setColor(Color::Default);

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
  std::cout << highlightedCode << std::endl;
};


/*
 *
 */

  /*
   *  Salir con estilo jjj
   */
static  void k_boom(int signum);
  /*
   *
   */
void runCommand(const string &command);



/*
 * Clase principal
 */
class Haklab {
private: 
  string m_userName{};
  string m_shellUsage{};
  /*
   *  Comprobar systema 
   */
  void os_check();
  /*
   *
   */
public:
  Haklab();  
  void setShell(shell sh);
  void setUserName(std::string_view &name);
  // void ctrl_c() { signal(SIGINT, k_boom); }
  void about(fs::path db, string commad);
  template<typename Func> void Loading(Func func);

};  // end  class

#endif //  BELOW_ZERO_
