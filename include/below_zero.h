// Fichero : below_zero.h
// Autor: @demon_rip

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

//------------------------------------------
//------------------------------------------
#define PORT_SHH "8022"
#define PORT_WEP "808O"
#define PORT_FTP "8021"
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
  // // fmt::print(highlightedCode);
  std::cout << highlightedCode << std::endl;
};


/*
 *
 */
namespace haklab { 
  /*
   *  Salir con estilo jjj
   */
  static void k_boom(int signum);
  /*
   *
   */
  void runCommand(const string &command);
}




/*
 * Clase principal
 */
class Haklab {
private: // ---> Variables privadas
  // Ususario de  sistema  
  string _userName;
  // Shell  a urilizar  
  const char _shellName;
  fs::path IHETC{string(getenv("HOME")) + "/.local/etc/i-Haklab"};
  fs::path LIBEX{string(getenv("HOME")) + "/.local/libexec/i-Haklab"};
  /*
   *  Comprobar systema 
   */
  void os_check();
  /*
   *  
   */
  void setUserName();
  /*
   *
   */
  void setShell(shell sh);
public:
  /*
   *  
   */

  /*
   * Atrapa el CONTROL+c
   */
  void ctrl_c() { signal(SIGINT, k_boom); }
  /*
   * Algo para ver mientra se espera
   */
  template <typename Func> void Loading(Func func) {
    //    hide_cursor();
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
    //   show_cursor();
  } // loading

  void about(string about) {
    fs::path fren = IHETC /= std::basic_string("/Tools/Readme/") +
                             std::string(1, std::toupper(about[0]));
    // Directorio base
    if (!fs::is_directory(fren)) {
      cerr << "[ERROR] No found " << IHETC << endl;
    };

    std::fstream fd(fren.c_str() + string("/") + about.c_str() + ".md");
    if (fd.is_open()) {
      std::stringstream buffer;
      buffer << fd.rdbuf();
      fd.close();
      syntax_highlight(buffer.str());
    } else {
      cout << "Con la inicial " << about[0] << " tengo :" << endl;
      for (fs::directory_entry &entry : fs::directory_iterator(fren)) {
        cout << entry.path().stem() << endl;
      }
    }
  } // about
};  // end  class

#endif //  BELOW_ZERO_
