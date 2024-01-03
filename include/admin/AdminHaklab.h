#pragma once

#include <bits/ctype_inlines.h>
#include <boost/filesystem.hpp>
#include <set>
#include <string>

namespace fs = boost::filesystem;


namespace admin {
  class AdminHaklab{
     public:
       AdminHaklab(fs::path from, fs::path to = fs::current_path())
       : from_(from), to_(to)
       {};
     private:
       fs::path from_;
       fs::path to_;
       std::set<std::string> *fileMatch_;
       std::set<std::string> *fileNoMatch_;
  };
}


