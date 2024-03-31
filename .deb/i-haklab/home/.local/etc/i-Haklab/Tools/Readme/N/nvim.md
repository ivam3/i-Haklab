
Modo normal: permite navegar por el  archivo 
---

Modo insert: permite editar el texto del archivo, añadir nuevo contenido o eliminarlo
---
- Se accede a este modo presionando la tecla `i` desde el modo *NORMAL*.

- Si queremos salir de este modo basta con presionar `ESC` .

Modo visual: es utilizado para seleccionar texto.
---
- Se accede a este modo con la tecla `v`  desde el modo *NORMAL*.

- Si queremos salir de este modo basta con presionar `ESC` .

# Operadores 

`{Operador}{Contador}{Motion}` 

- Operador: es la acción a realizar como puede ser editar, borrar, etcétera.
- Contador: establece cuántas veces se va a realizar una acción.
- Motion: representa una fracción de texto al que se le aplicará la acción definida por el operador.

Por ejemplo: `d5j`  borra las siguientes cinco lineas hacia abajo desde la posición del cursor.

# Combinaciones 

## Modo normal 
- `da'` para borrar algo entre comillas dobles.
- `ci"`  para cambiar algo entre comillas dobles.
- `0` desplaza el cursor al primer carácter de una línea.
- `$` desplaza el cursor al final de la línea
- `^` desplaza el cursor al primer caracter que no sea vacío de una línea.
- `g_` desplaza el cursos al último caracter que no sea vacío de una línea.
