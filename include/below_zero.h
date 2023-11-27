#ifndef BELOW_ZERO
#define BELOW_ZERO

//------------------------------------------
//------------------------------------------
#include <iostream>
#include <nlohmann/json.hpp>
#include <boost/array.hpp>
// Color de terminal y estilo de texto
#include <fmt/color.h>
// Formateo 
#include <fmt/printf.h>
#include <dirent.h> // para explorar el directorio /proc/ 
// Para obciones de linea de comando
#include <boost/program_options.hpp> 
//  Proporciona funciones para manipular archivos y directorios, y las rutas que los identifican.
#include <boost/filesystem.hpp>
// Lectura y escritura de archivos 
#include <boost/iostreams/device/file.hpp>
#include <boost/iostreams/stream.hpp>
#include <boost/regex.hpp>

//------------------------------------------
//------------------------------------------
#define  IHETC  "/data/data/com.termux/files/home/.local/etc/i-Haklab"
#define  LIBEX  "/data/data/com.termux/files/home/.local/libexec/i-Haklab/"


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
   private: 
  // == Variables de entorno 
  std::string PRFIX{getenv("PREFIX")};
  std::string HOME{getenv("HOME")};
  std::string PWD{getenv("PWD")};
  std::string TOOLS{getenv("TOOLS")};
  std::string USER{getenv("USER")};
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
  //----------------------------------------------
   public:
  /*
   * Cambia el valos de una variable de entornl 
   * name: Deve ser en mayuscula
   */
  void 
  ChangeEnvironmentVariable(std::string name,  std::string new_valor);  
  /*
   * Contructor
   */
   Haklab();
   /*
    * Destructor 
    */
   ~Haklab();
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
// template<typename Func>
// void loading(Func func) {
//     hide_cursor();
//     // std::thread::id main_thread_id = std::this_thread::get_id();
//     std::vector<std::string> spinner = { "█■■■■", "■█■■■", "■■█■■", "■■■█■", "■■■■█" };
//     int spinnerIndex = 0;

//     std::thread t([&]() {
//         while (true) {
//         /*std::cout << "\rSearching\t" */std::cout << spinner[spinnerIndex] << "\b\b\b\b\b\b\b\b" << std::flush;
//         spinnerIndex = (spinnerIndex + 1) % spinner.size();
//         std::this_thread::sleep_for(std::chrono::milliseconds(100));
//         }     
//     });

//     t.detach();

//     // Ejecuta la función proporcionada en segundo plano
//     func();
   
//     show_cursor();
// }
};

};

#endif // !DEBUG
