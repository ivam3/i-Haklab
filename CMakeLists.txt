# Vercion minima requerida
cmake_minimum_required(VERSION 3.10)

# Nombre del proyecto
project(i-haklab)

# Agrega el directorio de encabezados
include_directories(${CMAKE_SOURCE_DIR}/include)

# Carga bibliotecas
add_subdirectory(src)


# Código fuente
set(SRC "main-haklab.cpp")

# Crea el ejecutable
add_executable(${PROJECT_NAME} ${SRC})

# Enlazar biblioteca
target_link_libraries(${PROJECT_NAME} PUBLIC below_zero
    -lboost_program_options 
    -ljsoncpp
    -lboost_system
    -lboost_filesystem
    -lboost_thread
    -lboost_chrono
    -lfmt
    -lcurl
    -Wall
    -std=c++20
    -lboost_json 
    -lssl 
    -lcrypto
    )

#########    Instalación  ############
install(TARGETS i-haklab below_zero
    RUNTIME DESTINATION ${CMAKE_INSTALL_BINDIR}
    LIBRARY DESTINATION ${CMAKE_INSTALL_LIBDIR}
)

install(FILES "man/i-haklab.1" DESTINATION "${CMAKE_INSTALL_MANDIR}/man1")

