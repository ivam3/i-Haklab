#pragma once

namespace exec {
  class ExecHaklab {
      public:
       void ExecuteCommand(const char *command, const char *argv[]);
       void ExecutePowershell(const char *command);
  };
}
