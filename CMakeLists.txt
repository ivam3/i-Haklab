# Vercion minima requerida
cmake_minimum_required(VERSION 3.10)

# Nombre del proyecto
project(i-haklab)

# Variables 
set(SRC "src/boost-haklab.cpp")
set(LIB_SRC "lib/below_zero.cpp")
  
# Bibloteca dinamica 
add_library(below_zero SHARED ${LIB_SRC})

# codigo fuente
add_executable(i-haklab ${SRC})


# En lazar bibloteca
target_link_libraries(i-haklab below_zero   
 -lboost_program_options
 -lfmt 
 -ljsoncpp 
 -lboost_system 
 -lboost_filesystem)


# Intalcion 
# Ejecutables
install(TARGETS i-haklab DESTINATION bin/)

# Bibliotecas
install(TARGETS below_zero LIBRARY DESTINATION lib/)

