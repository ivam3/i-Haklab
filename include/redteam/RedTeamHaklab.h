#pragma once 


#include <boost/filesystem.hpp>
#include <string>

namespace fs = boost::filesystem;


namespace redteam {
  class ResTeamHakalb{
    public:
     // First way (using SAM and SYSTEM)
      std::string DumpSamHashes(fs::path path);
  };
} 
