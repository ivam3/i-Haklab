#pragma once



#include <sstream>
#include <string>
#include <vector>

using std::string;

namespace process {
  class ProcessHaklab {
    public:
      // List all processes
      std::vector<std::string> GetProcesses(); //
     // Find name by pid
      string  FindNameByPid(int pid);
     // Find pid(s) by name
      string FindPidByName(string namePid);
  };
}
