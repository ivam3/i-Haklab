// Autor : @demon_rip  
//-------------------------------------------------
//         Inportaciones
//-------------------------------------------------
#include "include/below_zero.h"


//-------------------------------------------------
//         Funcion principal main
//-------------------------------------------------
int main(int argc, const char *argv[]){ 
   signal(SIGINT, haklab::k_boom);  
   haklab::Haklab app;
   app.Shell("zsh");
   // captura "app"  por referencia y ejecuta "app.run"  
//   app.Loading([&]() { app.run(argc, argv); });
   app.run(argc,argv);
}
