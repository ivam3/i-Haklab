// Fichero : below_zero
// Autor: @demonr_rip

#ifndef BELOW_ZERO_
#define BELOW_ZERO_

//-----------------------------------------
#include "command_line_argument_parser.h"
#include "syntax.h"
#include <boost/filesystem.hpp>
#include "command_executor.h"
//------------------------------------------
//------------------------------------------
namespace fs = boost::filesystem;

//------------------------------------------
//------------------------------------------
#define PORT_SHH "8022"
#define PORT_WEP "808O"
#define PORT_FTP "8021"

#define SHOW_CURSOL_ANSI "\e[?25h"
#define HIDE_CURSOR_ANSI "\e[?25l"
#define CLEAR_SCREEN_ANSI "\e[1;1H\e[2J"
//------------------------------------------
//------------------------------------------
using namespace std;
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
  bool check_command(std::string command);
  void intall_nvim();
  CommandExecutor executor{string(getenv("PREFIX")) + "/var/log/i-haklb.log"};
public:
  Haklab() = default;
  int run(int argc, const char *argv[]);
  // void ctrl_c() { signal(SIGINT, k_boom); }
  string about(fs::path db, string commad);
  template <typename Func> void Loading(Func func);
}; // end  class

#endif //  BELOW_ZERO_
