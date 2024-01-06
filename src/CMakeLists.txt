#Crea la biblioteca compartida
add_library(below_zero SHARED
                below_zero.cpp 
                NetworHaklab.cpp 
                command_line_argument_parser.cpp 
                RedTeamHaklab.cpp 
                AdminHaklab.cpp
                ExecHaklab.cpp)
