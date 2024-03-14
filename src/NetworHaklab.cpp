
#include "../include/network/NetworHaklab.h"
#include <boost/asio/connect.hpp>
#include <boost/asio/io_context.hpp>
#include <boost/asio/ip/tcp.hpp>
#include <boost/beast/core.hpp>
#include <boost/beast/http.hpp>
#include <boost/beast/version.hpp>
#include <ifaddrs.h> //
#include <iostream>
#include <curl/curl.h>
#include <boost/filesystem.hpp>
// sing std::cout;
using std::cerr;
using std::endl;

namespace beast = boost::beast; // from <boost/beast.hpp>
namespace http = beast::http;   //  from <boost/beast/http.hpp>
namespace net = boost::asio;    // from <boost/asio.hpp>
namespace fs = boost::filesystem; // from 
using tcp = net::ip::tcp;       // from <boost/asio/ip/tcp.hpp>
using nethak = network::NetworHakaklab;



// Descargar  arcivos   
bool nethak::DownloadFile(string URL) {
    CURL *curl;
    FILE *fp;
    CURLcode result;
    curl = curl_easy_init();
    if (curl) {
      fs::path outputFilename;
      // Optener  el  nombre    del  archivo   
      fp = fopen(outputFilename.filename().c_str(), "wb");
      curl_easy_setopt(curl, CURLOPT_URL, URL.c_str());
      curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, NULL);
      curl_easy_setopt(curl, CURLOPT_WRITEDATA, fp);
      result = curl_easy_perform(curl);
      // Verifica si la descarga se realizó correctamente
      if (result != CURLE_OK) {
        std::cerr << "Error a descargar archivo " << endl;
        curl_easy_cleanup(curl);
        fclose(fp);
        return EXIT_FAILURE;
      }
      curl_easy_cleanup(curl);
      fclose(fp);
    }
    return EXIT_SUCCESS;
};


std::set<std::string> // type
nethak::ListAllInterfaces() {
  std::set<std::string> interfaces; // Conjunto para almacenar nombres únicos
  struct ifaddrs *ifaddr, *ifa;
  if (getifaddrs(&ifaddr) == -1) {
    perror("getifaddrs");
    exit(1);
  }

  for (ifa = ifaddr; ifa != nullptr; ifa = ifa->ifa_next) {
    if (ifa->ifa_addr == nullptr)
      continue;

    int family = ifa->ifa_addr->sa_family;
    if (family == AF_INET || family == AF_INET6) {
      interfaces.insert(ifa->ifa_name); // Inserta el nombre en el conjunto
    }
  }
  freeifaddrs(ifaddr);
  return interfaces;
}

std::string
nethak::GetIPaddress(const string &nombreInterfaz) {
  struct ifaddrs *ifaddr, *ifa;

  if (getifaddrs(&ifaddr) == -1) {
    perror("getifaddrs");
    return "";
  }

  for (ifa = ifaddr; ifa != nullptr; ifa = ifa->ifa_next) {
    if (ifa->ifa_addr == nullptr)
      continue;

    int family = ifa->ifa_addr->sa_family;
    if (family == AF_INET || family == AF_INET6) {
      if (nombreInterfaz == ifa->ifa_name) {
        char host[NI_MAXHOST];
        int s = getnameinfo(ifa->ifa_addr,
                            (family == AF_INET) ? sizeof(struct sockaddr_in)
                                                : sizeof(struct sockaddr_in6),
                            host, NI_MAXHOST, nullptr, 0, NI_NUMERICHOST);
        if (s == 0) {
          freeifaddrs(ifaddr);
          return host;
        }
      }
    }
  }

  freeifaddrs(ifaddr);
  return "";
}
/*
// Función que asigna el verbo HTTP basado en el argumento de la CLI
boost::beast::http::verb
network::NetworHakaklab::getHttpVerb(const std::string &Request) {
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
*/
/*
   host :
   port :
*/
int nethak::GetStatusCode(const string &host, const string &port) {
  try {
    //  El io_context es necesario para todas las E/S   
    net::io_context io_context;
    // Realizar la resolución directa de una consulta, a una lista de entradas
    tcp::resolver resolver(io_context);
    // Busca el nombre del dominio
    tcp::resolver::results_type endpoints = resolver.resolve(host, port);

    // Para realizar operaciones de E/S
    tcp::socket socket(io_context);

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
// Comprobar si tenemos internet  
bool nethak::CheckInternet(){
  CURL *curl;
  CURLcode res;
  curl = curl_easy_init();
  if (curl) {
     curl_easy_setopt(curl, CURLOPT_URL, "https://google.com");
     // Solicitar descsrga sin cuerpo  
     curl_easy_setopt(curl, CURLOPT_NOBODY, 1);
      res = curl_easy_perform(curl);
        if(res == CURLE_OK) {
            long response_code;
            curl_easy_getinfo(curl, CURLINFO_RESPONSE_CODE, &response_code);
            if(response_code == 200) { 
            // Si la respuesta es 200, hay conexión a internet
            // "¡Hay conexión a internet!\n";
                curl_easy_cleanup(curl);
                return true;
            }
        }
        curl_easy_cleanup(curl);
    }
  // "No hay conexión a internet.\n";
  return false;
}
