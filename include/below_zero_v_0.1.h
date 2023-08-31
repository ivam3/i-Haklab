#ifndef BELOW_ZERO
#define BELOW_ZERO

#include <iostream>
#include <string.h>
#include <vector>


//"2>&1" redirige los errores de salida de shell
using std::fstream;
using std::string ;
using std::vector;


namespace hack {
    class Haklab {
    public:
      void ctrl_c();      
      /*
       *
       */      
      void k_boom();
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
       * Ejecutar comandos
       * 
       */
      void runScript(const std::vector<std::string>& args);  
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


       void install_zsh();    
       
      
   private:
       /*
        * Variables 
        */
        string iHETC     ="/data/data/com.termux/files/home/.local/etc/i-Haklab";
        string iHLIBEXEC ="/data/data/com.termux/files/home/.local/libexec/i-Haklab";  
     /*
      * Shell dependencias 
      */
       vector<string> shell_zsh{"zsh"};
       /*
        * Lista de pkg
        */
       vector<string> list_pkg{"helix","nvim"};
   };
};
#endif // !DEBUG
