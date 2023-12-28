# Compilar prollecto 

1. `cmake -H. -Bbuild` CMake crea el directorio donde “construirá” el proyecto llamado build y dentro crea los archivos de configuración del proyecto.
2. `cmake --build build` Para construir proyecto 


# Archivo CMakeLists.txt 


![[5711424973651594747.png]]
## Usar bicicleta estáticas 

```cmake
PROJECT(MiProyecto C CXX)
# Podemos marcar opcionalmente los lenguajes para que CMake busque los compiladores
CMAKE_MINIMUM_REQUIRED(VERSION 2.8)

SET(MiProyecto_SRC "src/main.cpp")
SET(Lib_SRC "lib/lib.cpp")

ADD_LIBRARY(Lib STATIC ${Lib_SRC})
# El comando es exactamente igual que ADD_EXECUTABLE, pero marcamos si STATIC o SHARED
ADD_EXECUTABLE(MiProyecto ${MiProyecto_SRC})
TARGET_LINK_LIBRARIES(MiProyecto ${Lib})
# Necesitamos "unir" la librería con nuestro ejecutable
# Si necesitamos una librería tal cual usamos su nombre
# TARGET_LINK_LIBRARIES(MiProyecto pthread)
# Se pueden hacer las llamadas que se quiera a TARGET_LINK_LIBRARIES
```
## Usar librería dinámica
```cmake
PROJECT(MiProyecto)
CMAKE_MINIMUM_REQUIRED(VERSION 2.8)

SET(MiProyecto_SRC "src/main.cpp")
SET(Lib_SRC "lib/lib.cpp")

ADD_LIBRARY(Lib SHARED ${Lib_SRC})
ADD_EXECUTABLE(MiProyecto ${MiProyecto_SRC})
TARGET_LINK_LIBRARIES(MiProyecto ${MiProyecto_SRC})
```






#### 

`set() `: