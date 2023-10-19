#include "../include/below_zero_v_0.1.h"


//?\e ⇒ 27 ; carácter de escape, ESC,C-[
// Octal:\033
// Unicódigo:\u001b 
// Hexadecimal:\x1B


namespace  fs  = std::filesystem;


std::string setColor(Color color) {
 std::string code = "\033[";
 switch (color) {
        case Color::Default:
            code += "0";
            break;
        case Color::Black:
            code += "30";
            break;
        case Color::Red:
            code += "31";
            break;
        case Color::Green:
            code += "32";
            break;
        case Color::Yellow:
            code += "33";
            break;
        case Color::Blue:
            code += "34";
            break;
        case Color::Magenta:
            code += "35";
            break;
        case Color::Cyan:
            code += "36";
            break;
        case Color::White:
            code += "37";
            break;
        default:
            code += "0";
    }

    code += "m";
    return code;
};

void syntax_highlight(const std::string &code){
    std::string highlightedCode = "";
        // Colores para cada parte del código
    std::string colorKeywords = setColor(Color::Blue);
    std::string colorStrings = setColor(Color::Green);
    std::string colorComments = setColor(Color::Magenta);
    std::string colorDefault = setColor(Color::Default);

    std::size_t pos = 0;
    std::size_t start = 0;
    std::size_t end = 0;

    while (pos < code.size()) {
        if (code.find("#", pos) == pos) {
            // Comentario
            start = pos;
            end = code.find("\n", pos);
            if (end == std::string::npos) {
                end = code.size();
            }
            pos = end;
            highlightedCode += colorComments + code.substr(start, end - start) + colorDefault;
        } else if (std::isalpha(code[pos])) {
            // Palabra clave
            start = pos;
            while (std::isalnum(code[pos]) || code[pos] == '_') {
                pos++;
            }
            std::string keyword = code.substr(start, pos - start);
            highlightedCode += colorKeywords + keyword + colorDefault;
        } else if (code[pos] == '"' || code[pos] == '\'') {
            // Cadena de caracteres
            char delimiter = code[pos++];
            start = pos;
            while (pos < code.size() && code[pos] != delimiter) {
                pos++;
            }
            if (pos < code.size()) {
                pos++;
            }
            std::string str = code.substr(start, pos - start);
            highlightedCode += colorStrings + str + colorDefault;
        } else {
            // Otros caracteres
            highlightedCode += code[pos++];
        }
    }

    std::cout << highlightedCode ;
};

void hack::Haklab::k_boom(int signum)
{    
    std::cerr << " Hooooo\n";  
    exit(1); 
}


void hack::Haklab::clearScreen(){
 //Se coloca en la pocicion (1 1) y borra la pantalla
  const char *CLEAR_SCREEN_ANSI = "\e[1;1H\e[2J";
  write(STDOUT_FILENO, CLEAR_SCREEN_ANSI, 12);
}

void hack::Haklab::hideCursor() {
    const char *HIDE_CURSOR_ANSI = "\e[?25l";  // Send escape sequence to hide cursor
    write(STDOUT_FILENO,HIDE_CURSOR_ANSI,7);
}

void hack::Haklab::showCursor() {
    std::cout << "\033[?25h";  // Send escape sequence to show cursor
    std::cout.flush();
}


void hack::Haklab::progress_bar(int total, int progress)
{
    const int barWidth = 50;

    float percent = static_cast<float>(progress) / total;
    int progressWidth = static_cast<int>(percent * barWidth);

    std::cout << "[";
    for (int i = 0; i < barWidth; ++i)
    {
        if (i < progressWidth){
            std::cout << "=";
        }
        else if (i == progressWidth){
            std::cout << ">";
        }
        else{
            std::cout << " ";
        }
    }
    std::cout << "] " << static_cast<int>(percent * 100.0) << "%\r";
    std::cout.flush();

    if (progress == total){
        std::cout << std::endl;
    }
}

void hack::Haklab::check_all(){
    if (fs::exists(string(getenv("PREFIX")) + "/etc/apt/sources.list.d")) {
      std::cout << "sourlist" << std::endl; 
    }
}


void  hack::Haklab::internet_speet(){
    // URL de la página a scrapear 
    const char *wepsite{"https://fast.com/es/"};
    FILE *fp;
    // Opjeto curl 
    CURL *curl = curl_easy_init();
    if (curl) {
       CURLcode res_code;
       curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, NULL);
       curl_easy_setopt(curl, CURLOPT_URL ,wepsite );
       curl_easy_setopt(curl,CURLOPT_WRITEDATA ,fp );
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
       fclose(fp);
    }
}

std::string hack::Haklab::showArchitecture() {
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



bool hack::Haklab::downloadFile(std::string url, std::string outputFilename){
        CURL *curl;
        FILE *fp;
        CURLcode result;
        curl = curl_easy_init();
        if (curl) {
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
        
    
void hack::Haklab::about(std::string freanwor){
    std::string fren = iHETC + std::basic_string("/Tools/Readme/") + freanwor;
    std::ifstream file;
    file.open(fren);
    // get char
    char c = file.get();
   // check 
    while (file.good()) {
       std::cout << c;
       c = file.get();    
    } 
    file.close();   
}

void hack::Haklab::ScreenSise(){    
    struct winsize w;
    ioctl(STDOUT_FILENO, TIOCGWINSZ, &w);

    int rows{w.ws_row};
    int columns{w.ws_col};

    std::cout << "Las dimensiones de la pantalla son: " << rows << " filas por " << columns << " columnas." << std::endl;

}

