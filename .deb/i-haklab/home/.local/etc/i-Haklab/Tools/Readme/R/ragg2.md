[Wep](https://book.rada.re/tools/ragg2/ragg2.html)

## Shellcode generator, C/opcode compiler

# Ayuda

 -a arch: Configure architecture 
 
 -b bits: Specify architecture bits (32/64) 
 
 -i shellcode: Especificar shellcode para generar
 
 -e encoder: Specify encoder

`-P` \[tamaño\] anteponer patrón de debruijn

`-r`  muestra bytes sin procesar en lugar de pares hexadecimales

# Ejemplos

Genere un shellcode ejecutivo x86 de 32 bits
`ragg2 -a x86 -b 32 -i exec`

```bash
$ ragg2 -P 100 -r
AAABAACAADAAEAAFAAGAAHAAIAAJAAKAALAAMAANAAOAAPAAQAARAASAATAAUAAVAAWAAXAAYAAZAAaAAbAAcAAdAAeAAfAAgAAh
```

