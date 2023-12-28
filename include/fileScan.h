#pragma once

#include <any>
#include <boost/filesystem.hpp>
#include <set>


using std::string;
using std::set;

namespace fs = boost::filesystem;

class fileScan {
  public:
  fileScan(fs::path from,string fileSeared,set<string> * matchFile,set<string>, set<string> * matchNonFile,set<string>)
  :m_from{from},
    m_fileShared{fileSeared},
    m_matchFile{matchFile},
    m_matchNonFile{matchNonFile}
  {

  };
  private:
  fs::path m_from;
  string m_fileShared;
  set<string> * m_matchFile;
  set<string> * m_matchNonFile;
};
