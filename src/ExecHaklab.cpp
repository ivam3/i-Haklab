#include "../include/exec/ExecHaklab.h"
#include <unistd.h>


void exec::ExecHaklab::ExecuteCommand(const char *command, const char *argv[]){
  execl("/bin","",",",(char*)NULL);
}
