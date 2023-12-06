#ifndef BELOW_ZERO
#define BELOW_ZERO

//------------------------------------------
//------------------------------------------
#include <fmt/core.h>
#include <fmt/color.h>
#include <fmt/format.h>
#include <nlohmann/json.hpp>
#include <boost/array.hpp>
#include <dirent.h> // para explorar el directorio /proc/ 
#include <boost/program_options.hpp> 
#include <boost/filesystem.hpp>
#include <boost/iostreams/device/file.hpp>
#include <boost/iostreams/stream.hpp>
#include <boost/regex.hpp>
#include <string>
#include <string_view>
#include <thread>
#include <iostream>


//------------------------------------------
//------------------------------------------

//------------------------------------------
//------------------------------------------
//"2>&1" redirige los errores de salida de shell
using std::fstream;
using std::string ;
using std::vector;





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
   private: // ....... 
 static inline string  // una variable estática inlínea se puede definir e inicializar directamente
  IHETC{ string(getenv("HOME")) + "/.local/etc/i-Haklab"};
 static inline  string  
  LIBEX{ string(getenv("HOME")) + "/.local/libexec/i-Haklab"};
   /*
    *
    */    
  void 
  clear_screen();   
  /*
   *
   */
  void 
  hide_cursor();
  /*
   *
   */
  void 
  show_cursor();
   public: // ..............
  string
  get_IHETC();
   /*
    *
    */
   static  void 
   about(std::string about);
   /*
    * Contructor 
    */
   Haklab();
  /*
   * Cambia el valos de una variable de entorno 
   * name: Deve ser en mayuscula
   */
  void 
  ChangeEnvironmentVariable(std::string name,  std::string new_valor);  
      /*
       * Muestra un baner de salida 
       */      
  static 
  void k_boom(int signum);
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
       * Descargar archivos 
       * url: URL del archivo que se desea descargar
       * filename: Nombre del archivo con el que se guardará 
       */
  bool download_file(std::string url, std::string outputFilename); 

// Función para mostrar un spinner mientras se ejecuta otra función en segundo plano
template<typename Func>
void loading(Func func) {
    hide_cursor();
    // std::thread::id main_thread_id = std::this_thread::get_id();
    
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
};

};

#endif // !DEBUG
