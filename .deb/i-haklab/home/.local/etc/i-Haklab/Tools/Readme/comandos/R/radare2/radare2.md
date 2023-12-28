## Configuracion para la depuración
```
$ cat ~/.radare2rc
e scr.wheel=false
e stack.bytes=false
e stack.size=114

$ cat ./<programName>.rr2
#!/usr/bin/env rarun2
program=<programName>
arg0=”./<programName>”
stdio=/dev/pts/<##>
```

# Basic command
**A**nalyze **F**unctions **L**ist  
`afl`
`pdf` Imprimir **D** **isensamblar** F  **unción**
`dc` **d**ebug **c**ontinue

`db`es el comando _d_ ebug _breakpoint ;_ `dc`es el comando _d_ ebug _c_ ontue

`dr`es el comando _debug_ _r_ egister; `dso`es el comando _paso_ _a_ paso de _depuración_

pxQ

/R

## Registros

Los registros son parte de un área de usuario almacenada en la estructura de contexto utilizada por el planificador. Esta estructura se puede manipular para obtener y establecer los valores de esos registros y, por ejemplo, en hosts Intel, es posible manipular directamente los registros de hardware DR0-DR7 para establecer puntos de interrupción de hardware.

Hay diferentes comandos para obtener valores de registros. Para los de Propósito General utilizar:

`[0x4A13B8C0]> dr r15 = 0x00000000 r14 = 0x00000000 r13 = 0x00000000 r12 = 0x00000000 rbp = 0x00000000 rbx = 0x00000000 r11 = 0x00000000 r10 = 0x00000000 r9 = 0x00000000 r8 = 0x00000000 rax = 0x00000000 rcx = 0x00000000 rdx = 0x00000000 rsi = 0x00000000 rdi = 0x00000000 oeax = 0x0000003b rip = 0x7f20bf5df630 rsp = 0x7fff515923c0 [0x7f0f2dbae630]> dr rip ; get value of 'rip' 0x7f0f2dbae630 [0x4A13B8C0]> dr rip = esp   ; set 'rip' as esp`

La interacción entre un complemento y el núcleo se realiza mediante comandos que devuelven instrucciones de radare. Esto se usa, por ejemplo, para establecer banderas en el núcleo para establecer valores de registros.

`[0x7f0f2dbae630]> dr*      ; Appending '*' will show radare commands f r15 1 0x0 f r14 1 0x0 f r13 1 0x0 f r12 1 0x0 f rbp 1 0x0 f rbx 1 0x0 f r11 1 0x0 f r10 1 0x0 f r9 1 0x0 f r8 1 0x0 f rax 1 0x0 f rcx 1 0x0 f rdx 1 0x0 f rsi 1 0x0 f rdi 1 0x0 f oeax 1 0x3b f rip 1 0x7fff73557940 f rflags 1 0x200 f rsp 1 0x7fff73557940 [0x4A13B8C0]> .dr*  ; include common register values in flags`

Una copia antigua de los registros se almacena todo el tiempo para realizar un seguimiento de los cambios realizados durante la ejecución de un programa que se analiza. Se puede acceder a esta copia antigua con `oregs`.

`[0x7f1fab84c630]> dro r15 = 0x00000000 r14 = 0x00000000 r13 = 0x00000000 r12 = 0x00000000 rbp = 0x00000000 rbx = 0x00000000 r11 = 0x00000000 r10 = 0x00000000 r9 = 0x00000000 r8 = 0x00000000 rax = 0x00000000 rcx = 0x00000000 rdx = 0x00000000 rsi = 0x00000000 rdi = 0x00000000 oeax = 0x0000003b rip = 0x7f1fab84c630 rflags = 0x00000200 rsp = 0x7fff386b5080`

Estado actual de los registros

`[0x7f1fab84c630]> dr r15 = 0x00000000 r14 = 0x00000000 r13 = 0x00000000 r12 = 0x00000000 rbp = 0x00000000 rbx = 0x00000000 r11 = 0x00000000 r10 = 0x00000000 r9 = 0x00000000 r8 = 0x00000000 rax = 0x00000000 rcx = 0x00000000 rdx = 0x00000000 rsi = 0x00000000 rdi = 0x7fff386b5080 oeax = 0xffffffffffffffff rip = 0x7f1fab84c633 rflags = 0x00000202 rsp = 0x7fff386b5080`

Los valores almacenados en eax, oeax y eip han cambiado.

Para almacenar y restaurar valores de registro, simplemente puede volcar la salida del comando 'dr*' en el disco y luego volver a interpretarlo:

`[0x4A13B8C0]> dr* > regs.saved ; save registers [0x4A13B8C0]> drp regs.saved ; restore`

EFLAGS se puede modificar de manera similar. Por ejemplo, establecer banderas seleccionadas:

`[0x4A13B8C0]> dr eflags = pst [0x4A13B8C0]> dr eflags = azsti`

Puede obtener una cadena que represente los últimos cambios de registros usando `drd`el comando (registros de diferencias):

`[0x4A13B8C0]> drd oeax = 0x0000003b was 0x00000000 delta 59 rip = 0x7f00e71282d0 was 0x00000000 delta -418217264 rflags = 0x00000200 was 0x00000000 delta 512 rsp = 0x7fffe85a09c0 was 0x00000000 delta -396752448`



##  Run





