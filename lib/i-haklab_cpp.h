#ifndef HAKLAB
#define HAKLAB

#include <iostream>
#include <string>
#include <vector>
#include <signal.h> // Atrapar señales 
#include <regex.h> // Explreciones regulares
#include <unistd.h>
#include <filesystem> 

//"2>&1" redirige los errores de salida de shell
using namespace std;
using std::fstream;
using std::string ;
using std::vector;



namespace hak {
   class haklab{ 
   public:
    /*
     * shell a utilizar ( default fish )   
     * 
     */
    haklab(std::string shell="fish"){
    };
    /*
     *  Detructor 
     */

   private:
     // Variables de entorno 
     std::string iHETC;
     std::string iHLIBEXEC;
     // Linux   
     std::string HOME{std::getenv("HOME")};
     std::string SHELL{std::getenv("SHELL")};
    /*
     * URL |  url de lo que seva a descsrgar
     * filename | Nombre q va a tener lo decargado 
     */
    void  download(std::string URL, std::string_view filename);
    /*
     * para ejecutar script de la shel
     *
     * path | Ruta el escript a ejecutar
     * atgs | Algumento de ser nesezario 
     */
    void runScript(const std::filesystem::path& path, const std::vector<std::string>&args) { 
    if (std::filesystem::exists(path)) {
        std::string command = path.string();//+ " 2>&1";
        const char* argA[args.size() + 2];
        argA[0] = "bash";
        argA[1] = command.c_str();
        for(size_t i = 0; i < args.size();i++){
         argA[i+2] = args[i].c_str();
        }
         argA[args.size() + 2] = NULL;
         execv("/bin/bash",(char **)argA);
    } else {
        std::cerr << "No se encuentra " << path << std::endl;
    }

    };
  };
};

#endif // !DEBUG
