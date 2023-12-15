#ifndef FILE_HAKLAB
#define FILE_HAKLAB

#include <algorithm>
#include <iostream>
#include <vector>
#include <set> // Librería set para evitar repeticiones
#include <boost/filesystem.hpp> // para trabajar con Archivos
#include <fstream>



namespace fs = boost::filesystem;


class Files {
public:
    // Constructor
    Files(const fs::path iWuant, const fs::path whereAmI = fs::current_path()) 
      : m_in{iWuant} , m_hare{whereAmI}
    {
        try {
            for (const auto &inFile : fs::directory_iterator(iWuant)) {
                filesIn.insert(inFile.path().filename().string());
            }
            for (const auto &hereFile : fs::directory_iterator(whereAmI)) {
                filesHere.insert(hereFile.path().filename().string());
            }
        } catch (fs::filesystem_error const &ex) {
            std::cout << "🔧 Ha ocurrido un error al acceder al directorio: " << ex.what() << std::endl;
        }

        for (const auto &n : filesHere) {
            if (filesIn.count(n) == 0) {
                nonMatchingFiles.push_back(n);
            } else {
                matchingFiles.push_back(n);
            }
        }
    }

    void showNonMatchingFiles() {
        std::cout << "Archivos que no coinciden en ambas rutas:\n";
        for (const auto &file : nonMatchingFiles) {
            std::cout << file << std::endl;
        }
    }
    
    void showMatchingFiles() {
        std::cout << "Archivos que coinciden en ambas rutas:\n";
        for (const auto &file : matchingFiles) {
            std::cout << file << std::endl;
        }
    }


void updateFiles(const std::vector<std::string>& filesNonUpdate = std::vector<std::string>()) {
        // Comprobar si está vacío el vector 
  std::vector<std::string>files = filesNonUpdate.empty() ? matchingFiles : filesNonUpdate;

        std::vector<std::string> newListFiles;
        const auto copyOptions = fs::copy_options::update_existing 
          | fs::copy_options::recursive 
          | fs::copy_options::overwrite_existing;

    for(const auto &filesUpdate : files){ 
        fs::path source  = m_in  / filesUpdate;
        fs::path destination = m_hare / filesUpdate  ; 
        std::cout << "Se actualizo: " << filesUpdate << std::endl;
        try{
        fs::copy(source,destination,copyOptions);
        } catch (fs::filesystem_error const &ex) {
            std::cout << "🔧 Ha ocurrido un error al copiar los archivos: " << ex.what() << std::endl; }}};

private:
    fs::path m_in , m_hare;
    std::set<std::string> filesIn, filesHere; 
    std::vector<std::string> matchingFiles, nonMatchingFiles;
};


#endif // DEBUG
