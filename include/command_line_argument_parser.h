#ifndef COMMAN_LINE
#define COMMAN_LINE

#include <boost/program_options.hpp>
#include <vector>

using namespace std;

class arguments {
  constexpr static auto help_option       = "help";
  constexpr static auto about_option_name = "about";

  boost::program_options::variables_map variables;
  friend class command_line_argument_parser;

public:
  arguments(boost::program_options::variables_map variables)
      : variables(variables) {}

  bool no_arguments() { return variables.size() == 0; }

  bool help() { return variables.count(help_option) > 0; }


  string about() {
    return (variables.count(about_option_name) > 0)
               ? variables[about_option_name].as<string>()
               : "";
  }

};

class command_line_argument_parser {
private:  
  boost::program_options::options_description desc{"Options"};
  boost::program_options::options_description info{"Info"};
  boost::program_options::options_description All;
public:
  command_line_argument_parser() {
    // Options   
    desc.add_options()
      (arguments::help_option, "Show message and exit" );
    // Info   
    info.add_options()
      (arguments::about_option_name, boost::program_options::value<string>()->value_name("commd"),
       "Show informations about tool/framework");
    
    All.add(desc).add(info);
  }

  arguments parse(int argc, const char *argv[]) {
    boost::program_options::variables_map variables;

    boost::program_options::positional_options_description p;
    // p.add(arguments::files_option_name, -1);


    boost::program_options::store(
        boost::program_options::command_line_parser(argc, argv)
            .options(All)
            .positional(p)
            .run(),
        variables);

    boost::program_options::notify(variables);

    return arguments(variables);
  } 

 const  boost::program_options::options_description getDesc() const {
    return All;
  }
};

#endif // !COMMAN_LINE
