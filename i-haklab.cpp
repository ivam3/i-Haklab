#include "lib/i-haklab_cpp.h"
#include "lib/optparse.h"

int main (int argc, char *argv[]) {
  
  optparse::OptionParser parser = 
    optparse::OptionParser()
    .description("Hola es ");

  parser.add_option("-sh","--sharch")
    .help("Busca contenido en el directorio actual");
  

  const optparse::Values options = parser.parse_args(argc, argv);
  const std::vector<std::string> args = parser.args();

  //
  hak::haklab user{}; 

  return 0;
}
