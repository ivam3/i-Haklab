# Vercion minima requerida
cmake_minimum_required(VERSION 3.10)

# Nombre del proyecto
project(i-haklab)


# Variables 
set(SRC "main-haklab.cpp")


# Bibloteca dinamica 
add_subdirectory(src)

# codigo fuente
add_executable(${PROJECT_NAME} ${SRC})


# En lazar bibloteca
target_link_libraries(${PROJECT_NAME} below_zero   
 -lboost_program_options
 -lfmt 
 -ljsoncpp 
 -lboost_system 
 -lboost_filesystem)

# incluir archivos de encabezados 
target_include_directories( ${PROJECT_NAME} PUBLIC 
  "${PROJECT_BINARY_DIR}"
  "${PROJECT_SOURCE_DIR}/include"
      )


#########    Intalcion  ############ 
install(TARGETS i-haklab   
  RUNTIME DESTINATION ${CMAKE_INSTALL_BINDIR}
  LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR})

install(FILES "man/i-haklab.1" DESTINATION "${CMAKE_INSTALL_MANDIR}/man1")


