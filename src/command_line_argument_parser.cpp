
#include "../include/command_line_argument_parser.h"
#include "../include/network/NetworHaklab.h"

bool arguments::no_arguments() { return variables.size() == 0; }

std::string arguments::username() {
  return (variables.count(username_option) > 0)
             ? variables[username_option].as<std::string>()
             : "";
}

int arguments::port() {
  return (variables.count(port_option) > 0) ? variables[port_option].as<int>()
                                            : 4;
}

bool arguments::FInterface() { return variables.count(Interface); }

string arguments::FGet_ip() {
  return (variables.count(Ip) > 0 ) ? variables[Ip].as<string>() : "";
}

string arguments::FRequest() {
  return (variables.count(Request) > 0) ? variables[Request].as<string>() : "";
}
std::string arguments::WepStatusCode() {
  return (variables.count(WepStatus) > 0)
             ? variables[WepStatus].as<std::string>()
             : "";
}

string arguments::CreateMkt() {
  return (variables.count(ctf_mkt) > 0) ? variables[ctf_mkt].as<string>() : "";
}

string arguments::FAbout() {
  return (variables.count(About) > 0) ? variables[About].as<string>() : "";
};

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
