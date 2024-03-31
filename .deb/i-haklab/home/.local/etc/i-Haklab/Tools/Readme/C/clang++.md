
https://wiki.archlinux.org/title/Clang

`clang -print-resource-dir`
`$PREFIX/usr/lib/clang/16`

## Formateo de Diagnósticos 
``-f[no-]show-column``  Imprime el número de columna en el diagnóstico.

``-arch <arch>``

`-m`

`clang++ -target x86_64-<...>`

`clang++ -Wno-error <tu_archivo.cpp> -o <nombre_ejecutable>`

```bash
clang++ -fno-stack-protector -z execstack archivo.cpp -o archivo
```
Los flags `-fno-stack-protector` y `-z execstack` desactivan las protecciones de overflow de pila y de segmento de código, respectivamente.


`# clang++ -c` compila los archivos fuente sin vincularlos.

### Sintaxis
```
clang++ -c  opciones  
```

### Salida 
La compilación generó el archivo de objeto myfile.o


# Binary

- `-E`
- `-P`

## La fase de compilación

- `-S`
- `-masm=Intel`

Qenera un archivo de ensamblado `.s`

## La fase de montaje

¡En la fase de ensamblaje, finalmente puedes generar un código de máquina real!
 La entrada de la fase ensamblador es el conjunto de archivos en lenguaje ensamblador generados.
 erated en la fase de compilación, y la salida es un conjunto de archivos de objetos, algunos
 tiempos también conocidos como módulos.  Los archivos de objetos contienen instrucciones de máquina.
 ciones que en principio son ejecutables por el procesador.  pero como te explico
 en un minuto, necesita hacer un poco más de trabajo antes de tener una lista para usar.
 ejecutar el archivo ejecutable binario.  Por lo general, cada archivo fuente corresponde a uno
 archivo de ensamblaje, y cada archivo de ensamblaje corresponde a un archivo de objeto.  para generar
 Para borrar un archivo objeto, pasa el indicador `-c` a gcc o clang++
```sh
	$ clang++ -c compilation_example.c
$ file compilation_example.o
compilation_example.o: ELF 64-bit LSB relocatable, x86-64, version 1 (SYSV), not stripped
```

 `clang++ -I` Para especificar un directorio de inclusión alternativo:
 
`clang++ -L`

