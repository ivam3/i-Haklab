//  autor :  @demonr_rip
// @demonr_rip 
#ifndef COMMAND_EXECUTOR_HPP
#define COMMAND_EXECUTOR_HPP

#include <boost/filesystem.hpp>
#include <boost/process.hpp>
#include <string>

namespace belowzero {
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
} // belowzero
#endif  // COMMAND_EXECUTOR_HPP
