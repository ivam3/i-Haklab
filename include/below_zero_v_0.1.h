#ifndef BELOW_ZERO
#define BELOW_ZERO

#include "termio.h"
#include "optparse.h"
#include <iostream> // cout 
#include <string.h>
#include <vector>
#include <regex>
#include <thread>
#include <fstream>  //istream
#include <unistd.h>
#include <libssh/libssh.h>
#include <curl/curl.h>

#define  iHETC  "/data/data/com.termux/files/home/.local/etc/i-Haklab"
#define  LIBEX  "/data/data/com.termux/files/home/.local/libexec/i-Haklab/"

//"2>&1" redirige los errores de salida de shell
using std::fstream;
using std::string ;
using std::vector;



// optparce 
class Check : public optparse::Callback {
 public:
    Check() : counter(0) {}
    void operator()(const optparse::Option &option, const std::string &opt, const std::string &val, const optparse::OptionParser &parser)
    {
        counter++;
        std::cout << "--- MyCallback --- " << counter << ". time called" << std::endl;
        std::cout << "--- MyCallback --- option.action(): " << option.action() << std::endl;
        std::cout << "--- MyCallback --- opt: " << opt << std::endl;
        std::cout << "--- MyCallback --- val: " << val << std::endl;
        std::cout << "--- MyCallback --- parser.usage(): " << parser.usage() << std::endl;
        std::cout << std::endl;
    }
    int counter;
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


namespace hack {
// Cliente ssh
 class SSH_Clien {
     private:
 };


 
 class Haklab {
   private: 
  void clearScreen();   
  /*
   *
   */
  void hideCursor();
  /*
   *
   */
  void showCursor();
  
   public:
  
  /*
   * Resaltado de syntax
   */
   /*
    * 
    */
  /*
   * Muestra informacion de una heramaienta
   */
  void about(std::string frenwor);   
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
  std::string showArchitecture();
      /*
       * Comprobar la velocidad del internet 
       */
  void internet_speet();
      /*
       *
       */
  bool checkInternetConnection();
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
  bool downloadFile(std::string url, std::string outputFilename); 
         /*
          *  Comprimir 
          */
  bool compressFile(const string& inputFilePath, const string& outputFilePath);
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
void running(Func func) {
    hideCursor();
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
   
    showCursor();
}
       /*
        * Muestra el tamaño de la pantalla  
        */
  void ScreenSise();
};

};
#endif // !DEBUG
