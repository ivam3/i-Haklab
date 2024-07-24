#Crea la biblioteca compartida
add_library(below_zero SHARED
                below_zero/below_zero.cpp
                below_zero/syntax.cpp
                below_zero/config/config.cpp
                below_zero/command_executor.cpp)
