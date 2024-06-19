
# Crear un fichero fuente en lenguaje ensamblador 

- `-f` : Formato de salida 
- `-o` : Nombre de salida

```sh
nasm -f elf64 hello.asm -o hello.o
ld hello.o -o hello
```
