El uso básico de AWK es:

 `awk [condicion] { comandos }`

Donde:

- **[condicion]** representa una condición de matcheo de líneas o parámetros.
    
- **comandos** : una serie de comandos a ejecutar:
    
    - $0 → Mostrar la línea completa
        
    - $1-$N → Mostrar los campos (columnas) de la línea especificados.
        
    - FS → Field Separator (Espacio o TAB por defecto)
        
    - NF → Número de campos (fields) en la línea actual
        
    - NR → Número de líneas (records) en el stream/fichero a procesar.
        
    - OFS → Output Field Separator (" ").
        
    - ORS → Output Record Separator ("\n").
        
    - RS → Input Record Separator ("\n").
        
    - BEGIN → Define sentencias a ejecutar antes de empezar el procesado.
        
    - END → Define sentencias a ejecutar tras acabar el procesado.
        
    - length → Longitud de la línea en proceso.
        
    - FILENAME → Nombre del fichero en procesamiento.
        
    - ARGC → Número de parámetros de entrada al programa.
        
    - ARGV → Valor de los parámetros pasados al programa.
        

Las funciones utilizables en las condiciones y comandos son, entre otras:

- close(fichero_a_reiniciar_desde_cero)
    
- cos(x), sin(x)
    
- index()
    
- int(num)
    
- lenght(string)
    
- substr(str,pos,len)
    
- tolower()
    
- toupper()
    
- system(orden_del_sistema_a_ejecutar)
    
- printf()
    

Los operadores soportados por awk son los siguientes:

- *, /, %, +, -, =, ++, --, +=, -=, *=, /=, %=.
    

El control de flujo soportado por AWK incluye:

- if ( expr ) statement
    
- if ( expr ) statement else statement
    
- while ( expr ) statement
    
- do statement while ( expr )
    
- for ( opt_expr ; opt_expr ; opt_expr ) statement
    
- for ( var in array ) statement
    
- continue, break
    
- (condicion)? a : b → if(condicion) a else b;
    

Las operaciones de búsqueda son las siguientes:

- **/cadena/** → Búsqueda de cadena.
    
- **/^cadena/** → Búsqueda de cadena al principio de la línea.
    
- **/cadena$/** → Búsqueda de cadena al final de la línea.
    
- **$N ~ /cadena/** → Búsqueda de cadena en el campo N.
    
- **$N !~ /cadena/** → Búsqueda de cadena NO en el campo N.
    
- **/(cadena1)|(cadena2)/** → Búsqueda de cadena1 OR cadena2.
    
- **/cadena1/,/cadena2>/** → Todas las líneas entre cadena1 y cadena2.