// Autor : @demon_rip  
//-------------------------------------------------
//         Inportaciones
//-------------------------------------------------
#include "include/below_zero.h"
#include <signal.h>


using hak::Haklab;
//-------------------------------------------------
//         Funcion principal main
//-------------------------------------------------
int main(int argc, const char *argv[]){ 
   signal(SIGINT, hak::Haklab::Haklab::k_boom);  
   Haklab app;
   app.run(argc,argv);
}
