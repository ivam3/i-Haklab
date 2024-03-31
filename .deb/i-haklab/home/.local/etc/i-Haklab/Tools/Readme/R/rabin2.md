Rabin2 es capaz de encontrar exportaciones. Por ejemplo:
```bash
rabin2 -E /usr/lib/libr_bin.so | head
```

Enumerar las bibliotecas utilizadas por un binario con la `-l` opción:

`` $ rabin2 -l `which r2` ``

`z` Mostrar cadenas dentro de la seccion 
`r`Mostrar salida en formato radare 
```$ rabin2 -zr```

``rabin2 -I <binary>``  Nos proporciona información básica del binario, como arquitectura, y las protecciones del binario como (nx,dep,aslr...)

``rabin2 -i <bynari>``  Nos muestra los imports del binario.

``rabin2 -e <bynari>``  Dirección del Entry point. (Dirección virtual y raw offset en el executable)

``rabin2 -zz <bynari>`` Muestra las strings

``rabin2 -g <bynari> `` Este comando nos muestra una gran cantidad de información como secciones,segmentos,entrypoint,constructores, main, import,simbolos, strings, estructura del header, Realocaciones, etc

``rabin2 -S <bynary>``  Muestra las secciones del ejecutable, incluidos los permisos que tiene.


`rabin2 -I <binary>` Nos muestra información del binario 

 `rabin2 -s` Simbolos

