//  autor :  @demonr_rip
// @demonr_rip
#ifndef COMMAN_LINE
#define COMMAN_LINE

#include <boost/program_options.hpp>

namespace po = boost::program_options;
using namespace std;

class arguments {
  constexpr static auto help_option = "help";
  constexpr static auto about_option_name = "about";
  constexpr static auto language_option_name = "language";

  po::variables_map variables;
  friend class command_line_argument_parser;

 public:
  arguments(po::variables_map variables) : variables(variables) {}

  bool no_arguments() { return variables.size() == 0; }

  bool f_help() { return variables.count(help_option) > 0; }

  string f_about() {
    return (variables.count(about_option_name) > 0)
               ? variables[about_option_name].as<string>()
               : "";
  }

  string f_language() {
    return (variables.count(language_option_name) > 0)
               ? variables[about_option_name].as<string>()
               : "";
  }
};

class command_line_argument_parser {
 private:
  po::options_description desc{"Options"};
  po::options_description info{"Info"};
  po::options_description All;

 public:
  command_line_argument_parser() {
    // Options
    desc.add_options()(arguments::help_option, "Show message and exit")(
        arguments::language_option_name,
        po::value<string>()->value_name("<language>"),
        "Explicitly set the language");
    // Info
    info.add_options()(arguments::about_option_name,
                       po::value<string>()->value_name("<command>"),
                       "Show informations about tool/framework");

    All.add(desc).add(info);
  }

  arguments parse(int argc, const char* argv[]) {
    po::variables_map variables;

    po::positional_options_description p;
    // p.add(arguments::files_option_name, -1);

    po::store(
        po::command_line_parser(argc, argv).options(All).positional(p).run(),
        variables);

    po::notify(variables);

    return arguments(variables);
  }

  const po::options_description getDesc() const { return All; }
};

#endif  // !COMMAN_LINE
