
#include "../include/command_line_argument_parser.h"
#include "../include/network/NetworHaklab.h"

bool arguments::no_arguments() { return variables.size() == 0; }

std::string arguments::username() {
  return (variables.count(username_option) > 0)
             ? variables[username_option].as<std::string>()
             : "";
}

int arguments::WepStatusCode() {
  const string &URL = variables[WepStatus].as<string>();
  return (variables.count(WepStatus) > 0)
             ? network::NetworHakaklab::GetStatusCode(URL)
             : 0;
}

void arguments::CreateMkt() {
  string name = variables[ctf_mkt].as<string>();
  if (variables.count(ctf_mkt)) {
    cout << variables[ctf_mkt].as<string>() << endl;
  }
}

const std::vector<std::string> arguments::filenames() {
  return (variables.count(files_option_name) > 0)
             ? variables[files_option_name].as<std::vector<std::string>>()
             : std::vector<std::string>();
}

const std::vector<std::string> arguments::filepath() {
  return (variables.count(files_options_path) > 0)
             ? variables[files_options_path].as<std::vector<std::string>>()
             : std::vector<std::string>();
}

bool arguments::file_update() {
  if (variables.count("update-file") && !variables.count(files_options_path)) {
    std::cerr << "Error: 'update-file' option requires 'input-path' option to "
                 "be specified."
              << std::endl;
    return false;
  } else if (variables.count("update-file") &&
             variables.count(files_options_path)) {
    return true;
  }
  return false;
}
