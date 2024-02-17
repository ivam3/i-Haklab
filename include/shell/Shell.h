//  1) Leer comando de entrada  estandar  
//  2) Esperar cadena de comandos y argumentos  
//  3) Ejecutar comamdo
#include <iostream>
#include <cstdlib>

#define LSH_RL_BUFSIZE 1024



char *hak_read_line(void)
{
    int bufsize = LSH_RL_BUFSIZE;
    int position = 0;
    char *buffer = (char*)std::malloc(sizeof(char) * bufsize);
    int c;

    if (!buffer) {
        std::cerr << "hak: allocation error\n";
        std::exit(EXIT_FAILURE);
    }

    while (true) {
        // Leer  un caracter  
        c = std::getchar();

        // If we hit EOF, replace it with a null character and return.
        if (c == EOF || c == '\n') {
            buffer[position] = '\0';
            return buffer;
        }
        else {
            buffer[position] = c;
        }
        position++;

        // If we have exceeded the buffer, reallocate.
        if (position >= bufsize) {
            bufsize += LSH_RL_BUFSIZE;
            buffer = (char*)std::realloc(buffer, bufsize);
            if (!buffer) {
                std::cerr << "lsh: allocation error\n";
                std::exit(EXIT_FAILURE);
            }
        }
    }
}




class Shell{
   char *line;
   char **args;
   int *status;
  public:
  void  run(){
     do {
     printf(">");
     line = hak_read_line();
     args = hak_split_line(line);
     status = hak_execute(args);
     free(line);
     free(args);
     }while (status){
   };
  };
};
