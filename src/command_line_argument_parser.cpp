/* Autor:  @demon_rip 
 */
#include "../include/command_line_argument_parser.h"
#include "../include/network/NetworHaklab.h"

/*
 */
bool arguments::Fcheck(){
  
  return true; 
}
/* type --> bool  
 */
bool arguments::no_arguments() { return variables.size() == 0; }
 
/* type --> string   [arg]  
 */
//std::string arguments::username() {
//  return (variables.count(username_check) > 0)
//             ? variables[username_check].as<std::string>()
//             : "";
//} 
/* 
 */
int arguments::Fport() {
  return (variables.count(port) > 0) ? variables[port].as<int>() : 1;
}

bool arguments::FInterface() { return variables.count(Interface); }

string arguments::FGet_ip() {
  return (variables.count(Ip) > 0 ) ? variables[Ip].as<string>() : "";
}

string arguments::FRequest() {
  return (variables.count(Request) > 0) ? variables[Request].as<string>() : "";
}

string arguments::WepStatusCode() {
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

bool arguments::FCheckInternet(){
  return (variables.count(CheckInternet) > 0 );
}

const std::vector<string> arguments::filenames() {
  return (variables.count(files_option_name) > 0)
             ? variables[files_option_name].as<std::vector<string>>()
             : std::vector<string>();
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
