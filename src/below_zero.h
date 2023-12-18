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
#include <thread>
#include <iostream>
#include <set>

//------------------------------------------
//------------------------------------------

//------------------------------------------
//------------------------------------------
//"2>&1" redirige los errores de salida de shell
using std::fstream;
using std::string ;
using std::vector;

namespace fs = boost::filesystem;
namespace po = boost::program_options;


// Shell que se pueden configurar
namespace shell {
enum Shell {
  zsh,
  fish,};};


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

namespace filema {
// Nombre de espacio general 
  class FilesManipulation {
      public:   // Especificador de acceso
      /* Parameters
       *
       * arg1   from - ruta al archivo fuente 
       * arg2   to  - ruta al archivo de destino
       */
        FilesManipulation(const fs::path &from, const fs::path &to);
      /*
       *
       */
      void  
      updateFiles(const std::vector<std::string> &filesNonUpdate); 
      private: // Especificador de acceso
      /*
       * Variables mienbros 
       */
      fs::path m_from , m_to;
      std::set<std::string>filesFrom, filesTo; 
  };
};


namespace hak { 
  /*
   *
   */
 class Haklab : public filema::FilesManipulation 
 {
   public:
     /* Parameters 
      *  @arg1 from - ruta al archivo fuente
      *  @arg2 to   - ruta al archivo de destino
      *  @arg3 vm   -  ...? 
      *  @arg4 desc -  ...?
      */
     Haklab(const fs::path &from, const fs::path &to, po::variables_map vm)
     : filema::FilesManipulation{from, to},
     m_vm(vm)
     {};
     /*
      * 
      */
     void getHelp(po::options_description desc);
   private: // Specificador de acceso (pribado)
    po::variables_map m_vm;
   //  po::options_description m_desc;
    int m_port;
    string m_host;
    string m_shell;
    /*
     *
     */
   static inline string  // una variable estática inlínea se puede definir e inicializar directamente
   IHETC{ string(getenv("HOME")) + "/.local/etc/i-Haklab"};
 static inline  string  
   LIBEX{ string(getenv("HOME")) + "/.local/libexec/i-Haklab"};
   /*
    * borra la pantalla 
    */    
  void 
  clear_screen();   
  /*
   * Ocultar el cursor 
   */
  void 
  hide_cursor();
  /*
   * Muestra el cursor
   */
  void 
  show_cursor();
   
  public: // Specificador de acceso (publico) 
   /*
    * ufff
    */
  
   
  /*
   * "/.local/etc/i-Haklab"
   */
  string
  get_IHETC();
  /*
   * "/.local/libexec/i-Haklab"
   */
  string
  get_LIBEX();
   /*
    * Muestra informacion sobre herramientas 
    */
   static  void 
   about(std::string about);
    /*
   * Cambia el valos de una variable de entorno 
   */
  void 
  ChangeEnvironmentVariable(std::string name ,  std::string new_valo );  
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
   *
   */
  void update_haklab();
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
