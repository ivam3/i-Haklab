
#include "../include/network/NetworHaklab.h"
#include <boost/beast/core.hpp>
#include <boost/beast/http.hpp>
#include <boost/beast/version.hpp>
#include <boost/asio/connect.hpp>
#include <boost/asio/ip/tcp.hpp>
#include <iostream>
#include <ifaddrs.h>   // 
#include <netinet/in.h> //  


// sing std::cout;
using std::endl;
using std::cerr;

namespace beast = boost::beast; // from <boost/beast.hpp>
namespace http = beast::http;   //  from <boost/beast/http.hpp>
namespace net = boost::asio;    // from <boost/asio.hpp>
using tcp = net::ip::tcp;       // from <boost/asio/ip/tcp.hpp>



std::set<std::string> network::NetworHakaklab::ListAllInterfaces(){ 
    std::set<std::string> interfaces;  // Conjunto para almacenar nombres únicos
    struct ifaddrs *ifaddr, *ifa;
    if (getifaddrs(&ifaddr) == -1) {
        perror("getifaddrs");
        //return 1;
    }

  for (ifa = ifaddr; ifa != nullptr; ifa = ifa->ifa_next) {
        if (ifa->ifa_addr == nullptr)
            continue;

        int family = ifa->ifa_addr->sa_family;
        if (family == AF_INET || family == AF_INET6) {
            interfaces.insert(ifa->ifa_name);  // Inserta el nombre en el conjunto
        }
    }
  freeifaddrs(ifaddr);
  return interfaces;
}



// Función que asigna el verbo HTTP basado en el argumento de la CLI
boost::beast::http::verb network::NetworHakaklab::getHttpVerb(const std::string& Request) {
    if (Request == "GET") {
        return boost::beast::http::verb::get;
    } else if (Request == "POST") {
        return boost::beast::http::verb::post;
    } else if (Request == "PUT") {
        return boost::beast::http::verb::put;
    } else if (Request == "DELETE") {
        return boost::beast::http::verb::delete_;
    } else {
        // Manejar cualquier otro caso o devolver un valor predeterminado
        cerr << "[ Warning ]: Invalide HTTP method using GET default..." << endl;
        return boost::beast::http::verb::get;
    }
}





// host :
// port :
int network::NetworHakaklab::GetStatusCode(const string &host, string port ) {
  try {
    //  El io_context es necesario para todas las E/S
    net::io_context io_context;
    // Realizar la resolución directa de una consulta, a una lista de entradas
    net::ip::tcp::resolver resolver(io_context);
    // Busca el nombre del dominio
    tcp::resolver::results_type endpoints =
        resolver.resolve(host, port);

    // Para realizar operaciones de E/S
    net::ip::tcp::socket socket(io_context);

    //  inicia la operación de conexión llamando al objeto de E/S
    net::connect(socket, endpoints);

    // Configurar un mensaje de solicitud HTTP GET
    http::request<http::string_body> req{http::verb::get, host, 11};
    req.set(beast::http::field::host, host);
    req.set(beast::http::field::user_agent,
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 "
            "(KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36");
    req.set(beast::http::field::accept, "application/x-www-form-urlencoded");

    http::write(socket, req);

    beast::flat_buffer buffer;
    beast::http::response<beast::http::dynamic_body> resp;
    beast::http::read(socket, buffer, resp);

    return resp.result_int();
  } catch (const std::exception &ex) {
    cerr << "Exception: " << ex.what() << std::endl;
    return 0;
  }
}
