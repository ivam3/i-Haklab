#include "../src/below_zero.h"
#include <malloc.h>


using namespace filema;
/* Parameters   
 * 
 */
FilesManipulation::FilesManipulation(const fs::path &from, const fs::path &to = fs::current_path()) 
      : m_from{from} , m_to{to}
    {
        try {
            for (const fs::directory_entry &fromFile : fs::directory_iterator(from)) {
                filesFrom.insert(fromFile.path().string());
            }
            for (const fs::directory_entry &toFile : fs::directory_iterator(to)) {
                filesTo.insert(toFile.path().string());
            }
        } catch (fs::filesystem_error const &ex) {
            std::cout << "🔧 Ha ocurrido un error al acceder al directorio: " << ex.what() << std::endl;
        }
   }


// 
void FilesManipulation::updateFiles(const std::vector<std::string>& filesNonUpdate = std::vector<std::string>()) {
          
        const auto copyOptions = fs::copy_options::update_existing 
          | fs::copy_options::recursive 
          | fs::copy_options::overwrite_existing;

          std::cout << "Se actualizo: " << std::endl;
        try{
        // fs::copy(source,destination,copyOptions);
        } catch (fs::filesystem_error const &ex) {
            std::cout << "🔧 Ha ocurrido un error al copiar los archivos: " << ex.what() << std::endl; }
};



