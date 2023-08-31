#include "below_zero_v_0.1.h"
#include <cstddef>
#include <cstdlib>
#include <curl/curl.h>
#include <curl/easy.h>
#include <filesystem>
#include <iostream>
#include <linux/sched.h>
#include <regex>
#include <string>
#include <unistd.h>


void hack::Haklab::ctrl_c()
{
    
}


void hack::Haklab::progress_bar(int total, int progress)
{
    const int barWidth = 50;

    float percent = static_cast<float>(progress) / total;
    int progressWidth = static_cast<int>(percent * barWidth);

    std::cout << "[";
    for (int i = 0; i < barWidth; ++i)
    {
        if (i < progressWidth)
        {
            std::cout << "=";
        }
        else if (i == progressWidth)
        {
            std::cout << ">";
        }
        else
        {
            std::cout << " ";
        }
    }
    std::cout << "] " << static_cast<int>(percent * 100.0) << "%\r";
    std::cout.flush();

    if (progress == total)
    {
        std::cout << std::endl;
    }
}


void  hack::Haklab::internet_speet()
{
    // URL de la página a scrapear 
    const char *wepsite{"https://fast.com/es/"};
    // Opjeto curl 
    CURL *curl = curl_easy_init();
    if (curl) {
       CURLcode res_code;
       curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, NULL);
       curl_easy_setopt(curl, CURLOPT_URL ,wepsite );
       res_code = curl_easy_perform(curl);
    if (res_code  != CURLE_OK) {
       std::cerr << "Error al hacer la peticion " << curl_easy_strerror(res_code) << std::endl;  
    }
       std::string s = std::to_string(res_code);
       std::regex r("speed-value");
       std::smatch m;
       std::regex_search(s,m ,r);
       for (auto x : m)
            std::cout << x << " ";
       // std::cout << res << std::endl;
       curl_easy_cleanup(curl);
    }
}


std::string hack::Haklab::showArchitecture() 
{
    #ifdef __x86_64__
        return "(x86_64)";
    #elif __i386__
        return "x86 (32-bit)";
    #elif __arm__
        return "(ARM)";
    #elif __aarch64__
        return  "(ARM 64-bit)";
    #elif 
        return "(Desconocida)";
    #endif
}

void hack::Haklab::runScript(const std::vector<std::string> &args )
{    
    const char **argv = new const char* [args.size()+2];   // extra room for program name and sentinel
    argv [0] = "bash";         // by convention, argv[0] is program name
    for (int j = 0;  j < args.size()+1;  ++j)     // copy args
            argv [j+1] = args[j] .c_str();

    argv [args.size()+1] = NULL;  // end of arguments sentinel is NULL 
    execv("/bin/bash", (char **) argv);
}; 


bool hack::Haklab::downloadFile(std::string url, std::string outputFilename){
        CURL *curl;
        FILE *fp;
        CURLcode result;
        curl = curl_easy_init();
        if (curl) 
    {
          fp = fopen(outputFilename.c_str(),"wb");
          curl_easy_setopt(curl, CURLOPT_URL, url.c_str());
          curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, NULL);
          curl_easy_setopt(curl, CURLOPT_WRITEDATA, fp);
          result = curl_easy_perform(curl);
          curl_easy_cleanup(curl);
          fclose(fp);
          // Verifica si la descarga se realizó correctamente
        if (result != CURLE_OK) 
        {
            return EXIT_FAILURE;
        }
    }     
            return EXIT_SUCCESS;
};
        
    
void hack::Haklab::install_zsh(){
    for(std::string &pkg : shell_zsh)
    {
        std::cout << pkg << std::endl;
        runScript(shell_zsh);
        }
};

