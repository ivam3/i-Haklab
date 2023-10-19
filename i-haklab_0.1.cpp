#include "include/below_zero_v_0.1.h"
#include "include/optparse.h" 

 
int main(int argc, char **argv){
   
  hack::Haklab user;
  Check check;
  const std::string usage = "usage: %prog [OPTION]... script";
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
   
    // Establecer tiempo de inicio
    std::chrono::time_point<std::chrono::system_clock> startime;
    startime = std::chrono::system_clock::now();

    //Atrapar señal de (CTRL + C)
    signal(SIGINT,hack::Haklab::k_boom);

    //Run
    if (options.get("screen-size")) {
      user.ScreenSise();
    }

    if (std::filesystem::exists(LIBEX + arg )) {
      std::string command = LIBEX + arg;
      std::system(command.c_str());
     }

    //run_end...............................
  
   //Reto conexion........................................
    if (options.get("bandit")) {
      ssh_key srv_pubkey = NULL;
      size_t hlen;
      //Crear sesion SSH
      ssh_session session = ssh_new();
      if (session == NULL) {
         std::cerr << "Error al crear la sesion SSH" << std::endl;
         return EXIT_FAILURE;
      }
    // Obciones de conexion 
    ssh_options_set(session,SSH_OPTIONS_HOST , "bandit.labs.overthewire.org");
    ssh_options_set(session,SSH_OPTIONS_USER , "bandit0");
    ssh_options_set(session,SSH_OPTIONS_PORT,  "2220");
    
    //Conectar al servidor
    int  rc = ssh_connect(session);
    if (rc != SSH_OK) {
      fprintf(stderr, "Error al conectar : %s\n" ,
      ssh_get_error (session));
      ssh_free (session);
    return EXIT_FAILURE;
    }
  }
  //End........................................
    std::cout << options["run"] << std::endl;
    user.about(options["about"]);
      

    // Establecer el timestamp de end
    std::chrono::time_point<std::chrono::system_clock> endtime;
    endtime = std::chrono::system_clock::now();

   //Optener el tiempo de ejecucion en (millisegundo)
    if (options.get("time")) {
    long long elapsedTime = std::chrono::duration_cast<std::chrono::milliseconds>
    (endtime - startime).count();

    user.syntax_highlight("#took");        
    std::cout << "took " <<  elapsedTime << "ms" << std::endl;
    }

  return EXIT_SUCCESS;
}


