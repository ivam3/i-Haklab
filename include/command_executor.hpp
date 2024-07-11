//  autor :  @demonr_rip
// @demonr_rip
#ifndef COMMAND_EXECUTOR_HPP
#define COMMAND_EXECUTOR_HPP

#include <boost/date_time/posix_time/posix_time.hpp>
#include <boost/filesystem.hpp>
#include <boost/process.hpp>
#include <fstream>
#include <string>

class CommandExecutor {
 public:
  CommandExecutor(const std::string& logFilePath);
  void executeCommand(const std::string& command,
                      const std::vector<std::string>& args);

 private:
  std::string logFilePath;
  void logError(const std::string& errorMessage);

  std::string getCurrentDateTime();
};

#endif  // COMMAND_EXECUTOR_HPP
