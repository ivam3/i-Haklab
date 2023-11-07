#ifndef BELOW_ZERO
#define BELOW_ZERO

#include "optparse.h"
#include "bandit.h"
#include <iostream> // cout 
#include <string.h>
#include <vector>
#include <regex>
#include <thread>
#include <fstream>  //istream
#include <unistd.h>
#include <libssh/libssh.h>
#include <curl/curl.h>
#include <ncurses.h>



#define  iHETC  "/data/data/com.termux/files/home/.local/etc/i-Haklab"
#define  LIBEX  "/data/data/com.termux/files/home/.local/libexec/i-Haklab/"

//"2>&1" redirige los errores de salida de shell
using std::fstream;
using std::string ;
using std::vector;



// optparce 
class Check : public optparse::Callback 
{
 public:
    Check() : counter(0) {}
    void operator()(const optparse::Option &option, const std::string &opt, const std::string &val, const optparse::OptionParser &parser)
    {
        counter++;
     char mesg[]="Solo una cadena";  
     int row,col;
     initscr();                       /* Inicia el modo curses          */
     getmaxyx(stdscr,row,col);       /* obtiene el numero de filas y columnas */
     mvprintw(row/2,(col-strlen(mesg))/2,"%s",mesg);
     printw("Hello World !!!");      /* Imprime Hello World            */
     refresh();                      /* Imprimirlo en la pantalla real */
     getch();                        /* Esperar entrada de usuario     */
     endwin();                       /* Termina el modo cusrses */
    }
    int counter;
};



enum class Color 
{
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

namespace hack {
 
 class Haklab 
 {
   private: 
  // == Variables de entorno 
  std::string PRFIX{getenv("PREFIX")};
  std::string HOME{getenv("HOME")};
  // ===== Variables =====
  // Tiempo de star
  std::chrono::time_point<std::chrono::system_clock> startime;
  // Tiempo de end
  std::chrono::time_point<std::chrono::system_clock> endtime;
  // Tiempo de ejecucion en (millosegundo)
  long long elapsedTime;
  // Passwd de bandit
  std::vector<std::string> passwd_bandit{"NH2SXQwcBdpmTEzi3bvBHMM9H66vVXjL","rRGizSaX8Mk1RTb1CNQoXTcYZWU6lgzi"};
  
   // ===== Funciones privadas ====
  // Tiempo que se demora el program 
  long long getTime(){
    return elapsedTime;
   }  
   void clear_screen();   
  /*
   *
   */
  void hide_cursor();
  /*
   *
   */
  void show_cursor();
  
   public:
  
  /*
   * Contructor
   */
   Haklab();
   /*
    * Destructor 
    */
   ~Haklab();
  /*
   * Muestra informacion de una heramaienta
   */
  void about(std::string frenwor, std::string arg);   
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
       * Comprobar la velocidad del internet 
       */
  void internet_speet();
      /*
       * Muestra todos los archivos de un directorio
       */
  string directory_iterator(const char *path); 
      /*
       *
       */
  void install_pkg(std::string pkg);
      /*
       * Comprobar que todo esta bien 
       * 
       */
  void check_all();  
      /*
       * Descargar archivos 
       * url: URL del archivo que se desea descargar
       * filename: Nombre del archivo con el que se guardará 
       */
  bool download_file(std::string url, std::string outputFilename); 
         /*
          *  Comprimir 
          */
  bool compress_file(const string& inputFilePath, const string& outputFilePath);
       /*
          int total = 100
          for (int i = 0; i <= total; ++i)
    {
        progress_bar(total, i);
        std::this_thread::sleep_for(std::chrono::milliseconds(100));
    }
       */   
  void progress_bar(int total,int progress);
       /*
        *  
        */


// Función para mostrar un spinner mientras se ejecuta otra función en segundo plano
template<typename Func>
void loading(Func func) {
    hide_cursor();
    std::thread::id main_thread_id = std::this_thread::get_id();
    std::vector<std::string> spinner = { "█■■■■", "■█■■■", "■■█■■", "■■■█■", "■■■■█" };
    int spinnerIndex = 0;

    std::thread t([&]() {
        while (true) {
        /*std::cout << "\rSearching\t" */std::cout << spinner[spinnerIndex] << "\b\b\b\b\b\b\b\b" << std::flush;
        spinnerIndex = (spinnerIndex + 1) % spinner.size();
        std::this_thread::sleep_for(std::chrono::milliseconds(100));
        }     
    });

    t.detach();

    // Ejecuta la función proporcionada en segundo plano
    func();
   
    show_cursor();
}
       /*
        * Instalar shell de zsh
        */
  void zsh_inst();
};

};
#endif // !DEBUG
