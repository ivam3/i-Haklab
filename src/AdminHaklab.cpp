#include "../include/admin/AdminHaklab.h"
#include <boost/filesystem.hpp>
#include <iostream>
#include <set>
#include <string>

namespace fs = boost::filesystem;

std::set<std::string>
admin::AdminHaklab::matchingFile(const std::string &from) {
  std::set<std::string> matching{};
  try {
    for (const auto &entrada : fs::directory_iterator(from)) {
      if (fs::is_regular_file(entrada.path())) {
        matching.insert(entrada.path().filename().string());
      }
    }
  } catch (const std::exception &e) {
    std::cerr << "Error al obtener archivos: " << e.what() << std::endl;
  }

  return matching;
}
