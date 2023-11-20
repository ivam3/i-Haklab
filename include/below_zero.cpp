#include "below_zero.h"


using namespace boost::filesystem;


// Selector de color 
std::string setColor(Color color) {
 std::string code = "\033[";
 switch (color) {
        case Color::Default:
            code += "0";
            break;
        case Color::Black: // Negro
            code += "30";
            break;
        case Color::Red:   // Rojo
            code += "31";
            break;
        case Color::Green: // Verde
            code += "32";
            break;
        case Color::Yellow:// Amarillo
            code += "33";
            break;
        case Color::Blue:  // Azul
            code += "34";
            break;
        case Color::Magenta:// Magenta
            code += "35";
            break;
        case Color::Cyan:  // cian
            code += "36";
            break;
        case Color::White: // Blanco 
            code += "37";
            break;
        default:
            code += "0";
    }

    code += "m";
    return code;
};

void print_markdown(const std::string &txt){
  std::string output_txt = "";
  // Color para cada texto    
  std::string Keywords = setColor(Color::Blue);
  std::string Strings = setColor(Color::Green);
  std::string Title = setColor(Color::Magenta);
  std::string colorDefault = setColor(Color::Default);


  std::size_t pos = 0;
  std::size_t start = 0;
  std::size_t end = 0;

  while (pos < txt.size()){ 
    // Buscar cadena
    if (txt.find("#",pos) == pos) {
     start = pos;
     end = txt.find("\n",pos);
    // Si no hay coincidencias
    if(end == std::string::npos){
      end = txt.size();            
    }
      pos = end;
            
    }
  }

}


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
        // Buscar en la cadena 
        if (code.find("#", pos) == pos) {
            // Comentario
            start = pos;
            end = code.find("\n", pos);
            // Si no hay coincidencias
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
    // fmt::print(highlightedCode);
    std::cout << highlightedCode << std::endl;
};

void hack::Haklab::k_boom(int signum)
{    
    std::string k_boom = R"(
                        _-^--^=-_
                   _.-^^          -~_
                _--                  --_
              (<                        >)
               |                         |
                \._                   _./
                   '..--. . , ; .--..'
                         | |   |
                      .-=||  | |=-.
                      '-=k-boom!!='
                         |;   :|
                _____.,-#########-,._____⏎)"; 
    syntax_highlight(k_boom);
    exit(1); 
}


void hack::Haklab::clear_screen(){
 //Se coloca en la pocicion (1 1) y borra la pantalla
  const char *CLEAR_SCREEN_ANSI = "\e[1;1H\e[2J";
  write(STDOUT_FILENO, CLEAR_SCREEN_ANSI, 12);
}

void hack::Haklab::hide_cursor() {
    const char *HIDE_CURSOR_ANSI = "\e[?25l";  // Send escape sequence to hide cursor
    write(STDOUT_FILENO,HIDE_CURSOR_ANSI,7);
}

void hack::Haklab::show_cursor() {
    const char *SHOW_CURSOL_ANSI = "\e[?25h" ;
}


std::string hack::Haklab::show_architecture() {
    #ifdef __x86_64__
        return "(x86_64)";
    #elif __i386__
        return "x86 (32-bit)";
    #elif __arm__
        return "(ARM)";
    #elif __aarch64__
        return  "🐧 aarch64 ";
    #elif 
        return "(Desconocida)";
    #endif
}



// bool hack::Haklab::download_file(std::string url, std::string outputFilename){
//         CURL *curl;
//         FILE *fp;
//         CURLcode result;
//         curl = curl_easy_init();
//         if (curl) {
//           fp = fopen(outputFilename.c_str(),"wb");
//           curl_easy_setopt(curl, CURLOPT_URL, url.c_str());
//           curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, NULL);
//           curl_easy_setopt(curl, CURLOPT_WRITEDATA, fp);
//           result = curl_easy_perform(curl);
//           curl_easy_cleanup(curl);
//           fclose(fp);
//           // Verifica si la descarga se realizó correctamente
//         if (result != CURLE_OK) 
//         {
//             return EXIT_FAILURE;
//         }
//     }     
//             return EXIT_SUCCESS;
// };
        
// ======= ABAUT =============    
void about(std::string about){
    std::string fren = IHETC + std::basic_string("/Tools/Readme/") + about;   
    // Elegir donde buscar 
    if (!exists(fren)) {
        fren =  IHETC + std::basic_string("/Tools/Readme/command/") + about + ".md";       
    } 
    std::ifstream  file;
    // Abrir archivo    
    file.open(fren);      
    // Comprobar si se abrio 
    if(!file.is_open()){
       // fmt::print(fmt::emphasis::bold | fg(fmt::color::red),"No found\n");
       exit(1);
    }
    // obtener la longitud del archivo:
    file.seekg(0,file.end);
    int length = file.tellg();
    file.seekg(0,file.beg);
    // asigna memoria:
    char *buffer = new char [length];
    // leer datos como un bloque:
    file.read(buffer,length);
    // serar archivo 
    file.close();
    // Resaltado de sintax
    syntax_highlight(buffer);
    // borrar memoria
    delete[] buffer;
}


// void hack::Haklab::directory_iterator(const char *path){

// namespace fs = std::filesystem;

//     fs::path directory = "./"; // Directorio actual, puedes cambiarlo por el directorio que desees

//     for (const auto& entry : fs::directory_iterator(directory)) {
//         // Obtener el nombre del archivo
//         fs::path filePath = entry.path();
//         std::string fileName = filePath.filename().string();

//         // Verificar si el archivo no es oculto
//         if (!fileName.empty() && fileName[0] != '.') {
//             std::cout << fileName << "\n"
//         }
//     }
// }

void hack::Haklab::searchProcess(std::string process){
    DIR* dir;
    struct dirent* ent;
    if ((dir = opendir("/proc")) != NULL) {
        while ((ent = readdir(dir)) != NULL) {
            std::string entryName = ent->d_name;
            if (std::all_of(entryName.begin(), entryName.end(), ::isdigit)) {
                std::string statusFilePath = "/proc/" + entryName + "/comm";
                std::ifstream statusFile(statusFilePath);
                if (statusFile.is_open()) {
                    std::string processName;
                    statusFile >> processName;
                    if (processName == process) {
    //                     fmt::print("El proceso {}  ha sido encontrado con PID: {1}\n ",process,entryName);
                        std::cout << "El proceso " << process << " ha sido encontrado con PID: " << entryName << std::endl;
                        // Aquí puedes realizar más acciones con el PID del proceso encontrado
                    }
                }
            }
        }
        closedir(dir);
    } else {
    //     fmt::print( "No se pudo abrir el directorio /proc\n" );
    }
}    
