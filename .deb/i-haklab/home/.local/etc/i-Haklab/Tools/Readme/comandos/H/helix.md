# Wep

```Copy code 
https://docs.helix-editor.com
```

# Intalacion

```Copy code 
apt install helix
```


# Para ver que todo esta bien 

```Copy code 
hx --headth
```

# Tutorial 

============================
1.1  ELIMINACION
============================

La tecla (d) para eliminar el caracter debajo del cursor 

============================
1.2  MODO INSERTAR
============================

Escriba la tecla (i) para ingresar al modo insertar 

Nota: La barra de estado mostara su modo actual.

============================
1.3 GUARDAR UN ARCHIVO
============================

Escriba :w / o :write para quardar un archivo
 
============================
1.4 MAS  COMANDOS DE INSERTAR
============================

i - Insertar antes de la  seleccion.
a - Insertar despues de la seleccion (a sinnifica "anadir")
I - Insertar al inicio de la linea 
A - Insertar al final de la linea 

============================
1.5 LINEAS DE APERTURA
============================

Escriba (o) para agregar una linea debajo del curso

============================
1.6 MOCIONES Y SEKECCIONES
============================

w -  Para avanzar hasta el comienzo de la sigiente palabra 
e -  Para avanzar asta ek fin de la palabra actual 
b -  Paara retroceder asta el principio de la palabra actual   

============================
1.7 EL COMANDO DE CAMBIO
============================

c - para cambiar la seleccion actual (elimina lo seleccionado)
  
============================
1.8 CUENTAS CON MOVIMIENTO
============================

2b - Para mover dos palabras 2 hscia tras  
5w - Para avanzar 5 palabras 
3e - Para avanzar asta el final de la  3 palabra 

============================
1.9 MODO SELECCIONAR / EXTENDER
============================

v - ingresar al modo seleccionar 
v2w - para seleccionar 2 palabras 


============================
2.0 SELECCION DE LINEA 
============================

x - Para seleccionar una linea 
2x -  Para seleccionar mas de una linea 

============================
2.1 SELECCION COLAPSADAS
============================

; -  Anular la seleccion sin tener que mover el cursor 

============================
2.2 COPIAR Y PAGAR TEXTO 
============================

p - Para pegar 

============================
2.3 BUSQUEDA EN ARCHIVO 
============================

/ -  Para buscar hacia adelante en el archivo 
n - Para ir a la sigiente coincidencia  y (N) anterior

============================
2.4 MULTIPLES CURSORES
==========================

c - Para duplicar el cursor 
, - Para eliminar el segunde cursor

============================
2.5 EL COMANDO SELECCIONAR 
==========================

s - Para seleccionar coincidencias en la seleccion 
% - Seleccioma todo el archivo 
x - Selecciona una linea

Nota: Al igual que la busqueda, el comando de seleccion selecciona expresiones regulares 

============================
2.6 ALINEAR SELECCIONES
==========================

& -  Para alinear el la seccion 

============================
2.7 DIVIDIR LA SELECCION EN LINEAS
==========================

ALT-s para dividir la seleccion en varias lineas 

============================
2.8 REGISTRO 
==========================

"ay- Tira la selección actual para registrarte a.
"op- Pegar el texto en el registro odespués de la selección.


============================
2.8 RODEAR
==========================

ms<char>(después de seleccionar el texto)	- Agregar caracteres envolventes a la selección
mr<char_to_replace><new_char> -	Reemplazar los caracteres envolventes más cercanos
md<char_to_delete> -	Eliminar los caracteres envolventes más cercanos


