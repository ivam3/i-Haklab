// Autor : @demon_rip  
//-------------------------------------------------
//         Importaciones
//-------------------------------------------------
#include "include/below_zero.h"


//-------------------------------------------------
//         Funcion principal main
//-------------------------------------------------
int main(int argc, const char *argv[]){ 
   haklab::Haklab app; 
   app.ctrl_c();

   haklab::Shell shell{haklab::Shell::zsh};
   app.Shell(shell);
   app.Editor():
   // captura "app"  por referencia y ejecuta "app.run"  
   // app.Loading([&]() { app.run(argc, argv); });
   app.run(argc,argv);
}
