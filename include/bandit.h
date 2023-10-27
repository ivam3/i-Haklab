#ifndef BANDIT_H
#define BANDIT_H

#include <iostream>
#include <libssh/libssh.h>
#include <unistd.h>

// #define HOST  "bandit.labs.overthewire.org"

class Bandit {
   private:
    // Puerto 
    int port{2220};
    ssh_session session;
    ssh_channel channel;
   public:

int show_remote_processes()
{
  // ssh_channel channel;
  int rc;
  char buffer[256];
  int nbytes;
 
  channel = ssh_channel_new(session);
  if (channel == NULL)
    return SSH_ERROR;
 
  rc = ssh_channel_open_session(channel);
  if (rc != SSH_OK)
  {
    ssh_channel_free(channel);
    return rc;
  }
 
  rc = ssh_channel_request_exec(channel, "ls -la && printf \"\n Flag: `cat readme`\"");
  if (rc != SSH_OK)
  {
    ssh_channel_close(channel);
    ssh_channel_free(channel);
    return rc;
  }
 
  nbytes = ssh_channel_read(channel, buffer, sizeof(buffer), 0);
  while (nbytes > 0)
  {
    if (write(1, buffer, nbytes) != (unsigned int) nbytes)
    {
      ssh_channel_close(channel);
      ssh_channel_free(channel);
      return SSH_ERROR;
    }
    nbytes = ssh_channel_read(channel, buffer, sizeof(buffer), 0);
  }
 
  if (nbytes < 0)
  {
    ssh_channel_close(channel);
    ssh_channel_free(channel);
    return SSH_ERROR;
  }
 
  ssh_channel_send_eof(channel);
  ssh_channel_close(channel);
  ssh_channel_free(channel);
 
  return SSH_OK;
}
  
Bandit(){
    // Crear sesión SSH
    session = ssh_new();
    if (session == nullptr) {
        std::cerr << "Error al crear la sesión SSH\n";
        return ;
    }

    // Establecer opciones de conexión
    ssh_options_set(session, SSH_OPTIONS_HOST,"bandit.labs.overthewire.org");
    ssh_options_set(session, SSH_OPTIONS_PORT, &port);
    ssh_options_set(session, SSH_OPTIONS_USER, "bandit0");

    // Conectar al servidor SSH
    int rc = ssh_connect(session);
    if (rc != SSH_OK) {
        std::cerr << "Error al establecer la conexión SSH: " << ssh_get_error(session) << "\n";
        ssh_free(session);
        return ;
    } 

  
  // Autenticarse  
  rc = ssh_userauth_password(session, NULL, "bandit0");
  if (rc != SSH_AUTH_SUCCESS)
  {
    std::cerr << "Error al autenticarse en el servidor SSH." << std::endl;
    ssh_get_error(session);
    ssh_disconnect(session);
    ssh_free(session);
    return ;
  }
  
    // Abre una shell interactiva
    ssh_channel channel = ssh_channel_new(session);
    if (!channel) {
        std::cerr << "Error al crear un canal SSH." << std::endl;
        ssh_disconnect(session);
        ssh_free(session);
        return ;
    }

  
    rc = ssh_channel_open_session(channel);
    if (rc != SSH_OK) {
        std::cerr << "Error al abrir la sesión de shell: " << ssh_get_error(session) << std::endl;
        ssh_disconnect(session);
        ssh_free(session);
        return ;
    }
  }

// Detructor 
~Bandit(){
    // Cerrar la sesión SSH
    ssh_channel_send_eof(channel);
    ssh_channel_free(channel);
    ssh_disconnect(session);
    ssh_free(session);
  }
};// end


#endif // BANDIT_H
