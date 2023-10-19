#include <libssh/libssh.h>
#include <iostream>

int main(){
ssh_key srv_pubkey = NULL;
ssh_session session = ssh_new();
if (session == NULL) {
    std::cerr << "Error al crear la sesion SSH" << std::endl;
    return EXIT_FAILURE;
}

ssh_options_set(session, SSH_OPTIONS_HOST, "127.0.0.1");
ssh_options_set(session, SSH_OPTIONS_USER, "u0_a167");
ssh_options_set(session, SSH_OPTIONS_PORT, "2220");

int rc = ssh_connect(session);
if (rc != SSH_OK) {
    fprintf(stderr, "Error al conectar : %s\n", ssh_get_error(session));
    ssh_free(session);
    return EXIT_FAILURE;
}

// Verificar la clave del servidor después de una conexión exitosa
// ssh_key srv_pubkey = ssh_get_publickey(session,srv);
// if (srv_pubkey == NULL) {
//     std::cerr << "Error al obtener la clave pública del servidor" << std::endl;
//     ssh_disconnect(session);
//     ssh_free(session);
//     return EXIT_FAILURE;
// }

unsigned char *hash = NULL;
size_t hlen;
ssh_get_publickey_hash(srv_pubkey, SSH_PUBLICKEY_HASH_SHA1, &hash, &hlen);
std::cout << "Clave del servidor: " << hash << std::endl;

rc = ssh_userauth_password(session, NULL, "bandit0");
if (rc != SSH_AUTH_SUCCESS) {
    std::cerr << "Error al autenticar: " << ssh_get_error(session) << std::endl;
    ssh_key_free(srv_pubkey); // Liberar la clave pública del servidor
    ssh_disconnect(session);
    ssh_free(session);
    return EXIT_FAILURE;
}

std::cout << "Conexión SSH exitosa" << std::endl;

// Realizar otras operaciones

// Liberar recursos
ssh_key_free(srv_pubkey);
ssh_disconnect(session);
ssh_free(session);
}
