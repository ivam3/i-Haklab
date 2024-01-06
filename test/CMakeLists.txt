# Configurar las pruebas
enable_testing()

add_executable(test no_arguments_test.cpp) 

add_test(NAME no_arguments_test COMMAND i-haklab)
