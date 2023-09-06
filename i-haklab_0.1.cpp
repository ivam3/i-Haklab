#include "include/below_zero_v_0.1.h"
#include "include/optparse.h" 
#include <cstdlib>
#include <filesystem>
#include <utility>



int main(int argc, char **argv){
   
  hack::Haklab user;

  const std::string usage = "usage: %prog command [OPTION]... ";
  const std::string version  = " %prog 3.7 " + user.showArchitecture();
  const std::string desc     = "i-Haklab v.3.7 (c) 2023 by @Ivam3 - Is a hacking laboratory that contains open source tools recommended by Ivam3. If the law is violated with it's use, this would be the responsibility of the user who handled it.";
  // const std::string epilog   = "";
  
  optparse::OptionParser parser =
        optparse::OptionParser()
        .usage(usage)
        .version(version)
        .description(desc)
// los tratara prog -a -b arg1 arg2  
#ifdef DISABLE_INTERSPERSED_ARGS
        .disable_interspersed_args() 
#endif
  ;
  
// Opciones y argumentos 
    parser.add_option("-i", "--install")
          .dest("install_pkg")
          .metavar("pkg")
          .help("install packet");
    parser.add_option("-r", "--remove")
          .dest("remove_pgk")
          .metavar("pkg")
          .help("remove packet");
    parser.add_option("--check")
          .dest("check")
          .action("store_true")
          .help("Check all");
// Group  (1) 
  optparse::OptionGroup group = optparse::OptionGroup(
    "Setting Options",
    ""  
    );
  group.add_option("--about")
    .metavar("framework")
    .help("Show informations about tool/framework");
  
  parser.add_option_group(group);  
// Group (2)
   optparse::OptionGroup group1 = optparse::OptionGroup(
        "Automatitation Options:",
        "Caution: use these options at your own risk. "
        "It is believed that some of them bite.");
    group1.add_option("--run")
      .action("append")
      .dest("run")
      .help("Run script ");
    parser.add_option_group(group1); 
  

    const optparse::Values options = parser.parse_args(argc, argv);
    const std::vector<std::string> args = parser.args();

    // Argumentos sobrantes 
    std::string arg;
    for (std::vector<std::string>::const_iterator it = args.begin(); it != args.end(); ++it)
    {
      arg =  *it;
    }

    user.about(arg.c_str());
  
  return 0;
}


