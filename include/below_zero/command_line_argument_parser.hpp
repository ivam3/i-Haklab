#ifndef COMMAN_LINE
#define COMMAN_LINE

#include <boost/program_options.hpp>
#include <boost/program_options/value_semantic.hpp>

namespace po = boost::program_options;
using namespace std;

class arguments {
  constexpr static auto help_option = "help";
  constexpr static auto about_option_name = "about";
  constexpr static auto language_option_name = "language";
  constexpr static auto install_option_name = "install";
  constexpr static auto vncstart_option = "vncstar";
  constexpr static auto xwaylan_option = "xwayland";
  constexpr static auto conf_option_name = "config";
  
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
  

  bool f_vnc_start(){return variables.count(vncstart_option) > 0;};
 

  bool f_xwayland(){return variables.count(xwaylan_option) > 0;};
  
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
  po::options_description conf{"Config"};
  po::options_description gui{"Desktop"};
  po::options_description pkg{"CreatePkg"};
  po::options_description All;

 public:
  command_line_argument_parser() {
    // Options
    desc.add_options()(arguments::help_option, "Muestra este mensage y sale")(
        arguments::language_option_name,
        po::value<string>()->value_name("<language>"),
        "Explicitly set the language")
      (arguments::conf_option_name, po::value<string>()->value_name("<file>"), "Archivo de configuracion");
    // Info
    info.add_options()(arguments::about_option_name,
                       po::value<string>()->value_name("<tool>"),
                       "Muestra informacion sobre una herramienta ");
    // Config 
    conf.add_options()(arguments::install_option_name,
                       po::value<string>(),
                       "Instalar i-haklab (Full, medium, light)");
    // GUI  
  gui.add_options()(arguments::vncstart_option, "Inicia vnc  ");
  gui.add_options()(arguments::xwaylan_option,  "Inicia Xwaylan");

  //
  //pkg.add_options()()
  All.add(desc).add(info).add(conf).add(gui).add(pkg);
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

   po::options_description getDesc() const { return All; }
};

#endif  // !COMMAN_LINE
