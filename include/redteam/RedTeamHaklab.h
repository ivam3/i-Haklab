#pragma once 


#include <boost/filesystem.hpp>
#include <string>

using std::string;

namespace fs = boost::filesystem;


namespace redteam {
  class ResTeamHakalb{
    public:
      //
      static void mkt(string machineName);
     // First way (using SAM and SYSTEM)
      std::string DumpSamHashes(fs::path path);
  };
} 
