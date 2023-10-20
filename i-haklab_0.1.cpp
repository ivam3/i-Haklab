#include "include/below_zero_v_0.1.h"
#include "include/optparse.h" 

 
int main(int argc, char **argv){
   
  hack::Haklab user;
  Check check;
  const std::string usage = "usage: %prog [OPTION]... script";
  const std::string version  = " %prog 3.7 " + user.showArchitecture();
  const std::string desc     = "i-Haklab v.3.7 (c) 2023 by @Ivam3 - Is a hacking laboratory that contains open source tools recommended by Ivam3. If the law is violated with it's use, this would be the responsibility of the user who handled it.";
  const std::string epilog   = "              [--] DIRECT COMMANDS [--] ";
  
  optparse::OptionParser parser =
        optparse::OptionParser()
        .usage(usage)
        .version(version)
        .description(desc)
        .epilog(epilog)
// los tratara prog -a -b arg1 arg2  
#ifdef DISABLE_INTERSPERSED_ARGS
        .disable_interspersed_args() 
#endif
  ;
//A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z.
// Opciones y argumentos 
    parser.add_option("--screen-size")
          .action("store_true")
          .help("Show size screen");
    parser.add_option("-r", "--remove")
          .dest("remove_pgk")
          .metavar("pkg")
          .help("remove packet");
    parser.add_option("--headth")
          .action("store_false")
          .action("callback")
          .callback(check)
          .help("Checks for potential errors");
    parser.add_option("-q", "--quiet")
          .action("store_false")
          .dest("verbose")
          .set_default("1")
          .help("don't print status messages to stdout");
    parser.add_option("-t", "--time")
          .action("store_false")
          .dest("time")
          .set_default("1")
          .help("(defaul) Shows the execution time");
    parser.add_option("--host")
          .type("string")
          .help("host");
          
// ==========  Group  (1)  ==========
  optparse::OptionGroup group = optparse::OptionGroup(
    "Setting Options",
    ""  
    );
//A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z.
  group.add_option("--about")
    .metavar("framework")
    .help("Show informations about tool/framework");
   group.add_option("--aptup")
    .help("Update termux manually, packages by packages");
   group.add_option("--passwd")
    .help("Set and change the login termux");
   group.add_option("--setbanner")
    .help("Enable, disable and custom the i-Haklab wall banner");
   group.add_option("--setuser")
    .help("Show informations about tool/framework");
   group.add_option("--show")
    .help("List all tools/frameworks available on i-Haklab");
   group.add_option("--speedtest")
    .help("Run a speed test of your network");
   group.add_option("--weechat")
    .help("Connect with irc Ivam3byCinderella chat");
   group.add_option("--Xwayland")
    .help("Run xserver over TermuXwayland app with xfce4 as window manager");
  
  parser.add_option_group(group);  
// ==========  Group (2) ============
   optparse::OptionGroup group1 = optparse::OptionGroup(
        "Automatitation Options:",
        "Caution: use these options at your own risk. "
        "It is believed that some of them bite.");
  // A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z.
   group1.add_option("--run")
      .action("store_true")
      .dest("run")
      .help("Run script ");
   group1.add_option("--bandit")
      .action("store_true")
      .help("conexcion por ssh a los servidores de bandit ");
   parser.add_option_group(group1); 
  
  

    const optparse::Values options = parser.parse_args(argc, argv);
    const std::vector<std::string> args = parser.args();
 
    
    // Argumentos sobrantes 
    std::string arg;
    for (std::vector<std::string>::const_iterator it = args.begin(); it != args.end(); ++it)
    {
      arg =  *it;
    };
     
    //Atrapar señal de (CTRL + C)
    signal(SIGINT,hack::Haklab::k_boom);

    // ============== RUN ===================
    if (options.get("screen-size")) {
      user.ScreenSise();
    }

    
    if (options.get("run")) {
      std::string command = "bash  " LIBEX + arg;
      int result =  std::system(command.c_str());
      if (result == -1) {
        std::cerr << "Error al ejecutar el comando en Bash" << std::endl;
    } else {
        std::cout << "Comando ejecutado exitosamente" << std::endl;
       }
     }

    
    user.about(options["about"]);
      
}
