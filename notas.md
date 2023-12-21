# Compilas

```sh
cd i-haklab
cmake -H. -Bbuild 
cmake --build build
cmake -DCMAKE_INSTALL_MANDIR="${PREFIX}/share/man/" build  
cmake --install build --prefix=$PREFIX
```

# boost
- `https://www.boost.org/doc/libs/1_84_0/doc/html/program_options/howto.html` 
- Dar valores por defecto a opciones que no son abligatorias 

- el archivo de man no se esta poniendo en su ruta esta dando error 
- Usar evitar usar rutas relativas para compativilidad con linux  (getenv)
- `~/.local/share/apli...` La imagen para el escritorio 
- descargar key en automatico 
- error - convertir una clase a string
- pendiente agreagar a nvim `https://github.com/dinhhuy258/git.nvim` 

# Regisito
https://hackingcpp.com/cpp/libs/fmt.html#terminal-styles
https://theboostcpplibraries.com/boost.program_options
https://github.com/mmdjiji/makefile-learning 
https://curl.se/docs/manpage.html
https://www.google.com/amp/s/www.geeksforgeeks.org/regex-regular-expression-in-c/amp/
https://cplusplus.com/reference/thread/thread/
