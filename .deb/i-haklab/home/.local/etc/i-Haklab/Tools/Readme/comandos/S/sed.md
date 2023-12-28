**Es un `editor de flujo `(==s==tream  ==ed==itor**)

### Sintaxis
`sed opciónes "comando_ed" archivo `

### Nota 
Las comillas "" son generalmente indispensables debido a los metas caracteres (evitar expansiones )

### Opciones 
* `-n:` indica que se suprima la salida estándar 
* `-e script :` indica que se ejecute un script   qué viene a continuación
* `-f archivo :` indica a los comandos se tomarán del archivo 

**Los  comandos son de forma￼￼ \/patreon\/ acción  
- `patron:` es una expresión regular 
- `accion:` es uno de los siguientes comandos (hay mas)
`p`  Imprimir línea 
`d` Borrar la línea 
`s/p1/p2` Sustitución la primera ocurrencia de `p1` con `p2`

## Ejemplo de uso 
**Comportamiento por defecto: imprime la entrada a STDOUT**

1. `sed /^E/ archivo ` # Devuelve todas las líneas qué empresa con "E"
2. `sed '2d' archivo ` # Borra tres línea del archivo 
3. `sed s/mas/más/g` # Renplaso global 
4. `sed '1,3s/sa/Sa/g' ` # Salo para las 3 primeras lineas 

**Comandos múltiples**
`sed - e 'comando' -e 'comamdo'..ect`


