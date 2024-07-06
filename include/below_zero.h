// Fichero : below_zero
// Autor: @demonr_rip

#ifndef BELOW_ZERO_
#define BELOW_ZERO_

//------------------------------------------
//
//-----------------------------------------
#include "command_line_argument_parser.h"
#include "syntax.h"
#include <boost/asio.hpp>
#include <boost/filesystem.hpp>
#include <boost/iostreams/stream.hpp>
#include <boost/process.hpp>
#include <boost/thread.hpp>

//------------------------------------------
#include <fstream>
#include <iostream>
//------------------------------------------
//------------------------------------------
namespace po = boost::program_options;
namespace fs = boost::filesystem;
namespace bp = boost::process;

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

// Shell que se pueden configurar
typedef enum {
  ZSH,
} shell;

/*
 *  Salir con estilo jjj
 */
static void k_boom(int signum);
/*
 *
 */
void runCommand(const string &command);

class Haklab : public command_line_argument_parser {
private:
  void os_check();
public:
  Haklab() = default;
  int run(int argc, const char *argv[]);
  // void ctrl_c() { signal(SIGINT, k_boom); }
  string about(fs::path db, string commad);
  template <typename Func> void Loading(Func func);
}; // end  class

#endif //  BELOW_ZERO_
