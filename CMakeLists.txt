# Vercion minima requerida
cmake_minimum_required(VERSION 3.10)
# Nombre del proyecto
project(i-haklab)
# Para hacer uso de la biblotecas
add_subdirectory(include)
# codigo fuente
add_executable(i-haklab boost-haklab.cpp)
# Vincular bibloteca
target_link_libraries(i-haklab PUBLIC below_zero )
# Ubicasion del archivo de encabesado
target_include_directories( i-haklab PUBLIC
  "${PROJECT_BINARY_DIR}"
  "${PROJECT_SOURCE_DIR}/include"
)
set(CMAKE_CXX_FLAGS "-lboost_program_options -lboost_system  -lboost_filesystem \
  -ljsoncpp  -lfmt")
