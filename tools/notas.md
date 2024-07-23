#box 
[WEP](https://www.matematicas18.com/es/tutoriales/geometria/figuras-geometricas/cuadrilatero/rectangulo/)

- Geometria basica. 

> El código utiliza conceptos básicos de geometría como coordenadas, intersección de figuras y la determinación de si un punto está dentro de una figura.

$PREFIX/usr/lib/clang/16/include

1. struct
2. operator
3. referencia


Se utilisaran algunas llamadas al sistema para ejecutar comando pero no es el opjetivo de este proyecto 


# Error en el modulo 

El uso de `fmt::print()` esta dando error a la hora de ejecuatar el binario 

# Compilas

```sh
cd i-haklab
cmake -H. -Bbuild 
cmake --build build
cmake -DCMAKE_INSTALL_MANDIR="${PREFIX}/share/man/" build  
cmake --install build --prefix=$PREFIX
```

# Flujo de trabajo
`https://docs.github.com/en/actions/using-workflows/about-workflows#about-workflows`

- Sintaxi
`https://docs.github.com/en/actions/using-workflows/workflow-syntax-for-github-actions#about-yaml-syntax-for-workflows`


# Instalar boost y fmt en termux 
apt install boost boost-headers  boost-static fmt 

# boost.asio 

- Para gestionar la comunicasion de red 

# libpcap 

-  permite capturar paquetes directamente desde la red 

## wep

`https://www.tcpdump.org/`

```
git clone https://github.com/the-tcpdump-group/tcpdump
git clone https://github.com/the-tcpdump-group/libpcap
```

# boost_program_options 
- `https://www.boost.org/doc/libs/1_84_0/doc/html/program_options/howto.html` 

- hay funciones declarsdas a un no definidas que los tipos de datos no pueden cambiar 



- Usar evitar usar rutas relativas para compativilidad con linux  (getenv)
- `~/.local/share/apli...` La imagen para el escritorio 
- descargar key en automatico 
- pendiente agreagar a nvim `https://github.com/dinhhuy258/git.nvim` 
- `no` usae **new** ni **delete**  -> Smart point 

# Nvim tener en cuenta 

## Linux / Macos (unix)
rm -rf ~/.config/nvim
rm -rf ~/.local/share/nvim

## Windows
rd -r ~\AppData\Local\nvim
rd -r ~\AppData\Local\nvim-data

## Instalar a la primera 

tmux , zsh 


std::vector<std::string> args = {"-l", "/non_existent_directory"};
executor.executeCommand("ls", args);


# Regisito
https://www.doxygen.nl/manual/grouping.html  
https://shields.io/
https://docs.libcpr.org/ 
https://hackingcpp.com/cpp/libs/fmt.html#terminal-styles
https://theboostcpplibraries.com/boost.program_options
https://github.com/mmdjiji/makefile-learning 
https://curl.se/docs/manpage.html
https://www.google.com/amp/s/www.geeksforgeeks.org/regex-regular-expression-in-c/amp/
https://cplusplus.com/reference/thread/thread/
pendiente para nvim 
https://nvchad.com/docs/features#nvcheatsheet
