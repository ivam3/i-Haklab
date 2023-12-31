#pragma once


#include <string>
#include <boost/beast/http.hpp>

namespace http = boost::beast::http;

using std::string;

namespace network {
  class NetworHakaklab {
    public:
      // Función que asigna el verbo HTTP basado en el argumento de la CLI
      boost::beast::http::verb getHttpVerb(const std::string& Request);
     // Download a file from url 
      bool DownloadFile(string URL);
      // Get status code of url 
      int GetStatusCode(const string &host, string port, http::verb request);
      // Send http post request with data 
      // date en formato json
      // Usr ejemplo : http://example.com/index.php  
      bool PostHttpReq(string URL, string date, int timeout);
      // List all network interfaces
      // null de retorno si hay error
      std::vector<string> ListAllInterfaces();
      // Get all information about an interface 
      string GetInterfaceInfo(string interface);
      // Check internet connection
      bool CheckInternet();
      // List active ports
      std::vector<int> ListPortOpen();
      // Get public ip
      int GetPublicIp();
  };
}
