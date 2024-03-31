`rasm2`  es un ensamblador/desensamblador en línea. Inicialmente, rasmla herramienta fue diseñada para ser utilizada para parches binarios. Su función principal es obtener los bytes correspondientes al código de operación de la instrucción de la máquina dada.

# Ayuda
Usage: rasm2 [-ACdDehLBvw] [-a arch] [-b bits] [-o addr] [-s syntax] [-f file] [-F fil:ter] [-i skip] [-l len] 'code'|hex|- 

-a \[arch] Establecer arquitectura para ensamblar/desensamblar (see -L) 

-A Mostrar información de análisis de pares hexadecimales dados

-b \[bits] Establecer el tamaño de registro de la CPU (8, 16, 32, 64) (RASM2_BITS) 

-B Entrada/salida binaria (-l es obligatorio para la entrada binaria)

-c \[cpu] Select specific CPU (depends on arch) 

-C Salida en formato C
```bash
rasm2 -C 'mov rax,30' => "\xb8\x1e\x00\x00\x00"
```

-d, -D Disassemble from hexpair bytes (-D show hexpairs) 

-e Use big endian instead of little endian 

-E Display ESIL expression (same input as in -d) 

-f \[file] Read data from file 

-F \[in:out] Specify input and/or output filters (att2intel, x86.pseudo, ...) 

-h, -hh Show this help, -hh for long 

-i \[len] ignore/skip N bytes of the input buffer -j output in json format 

-k \[kernel] Select operating system (linux, windows, darwin, ..) 

-l \[len] Input/Output length 

-L List Asm plugins: (a=asm, d=disasm, A=analyze, e=ESIL) 

-o [offset] Set start address for code (default 0) -O [file] Output file name (rasm2 -Bf a.asm -O a) -p Run SPP over input for assembly -q quiet mode -r output in radare commands -s [syntax] Select syntax (intel, att) -v Show version information

# Ensamblado
Ensamblar es la acción de tomar una instrucción de computadora en forma legible por humanos (usando mnemónicos) y convertirla en un montón de bytes que puede ejecutar una máquina.

La siguiente línea está ensamblando esta instrucción mov para x86/32.
```bash
$ rasm2 -a x86 -b 32 'mov eax, 33'
b821000000
```
