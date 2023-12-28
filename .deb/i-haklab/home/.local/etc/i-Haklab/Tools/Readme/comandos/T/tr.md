
# Comando tr en Unix/Linux con ejemplos


El comando tr en UNIX es una utilidad de línea de comandos para traducir o eliminar caracteres. Admite una variedad de transformaciones que incluyen mayúsculas a minúsculas, exprimir caracteres repetidos, eliminar caracteres específicos y funciones básicas de búsqueda y reemplazo. Se puede usar con tuberías UNIX para admitir traducciones más complejas. **tr significa traducir.**

**Sintaxis:**

**$ tr [OPCIÓN] SET1 [SET2]**

**Opciones**

-c: complementa el conjunto de caracteres en string.ie, las operaciones se aplican a los caracteres que no están en el conjunto dado  
-d: elimina los caracteres en el primer conjunto de la salida.  
-s: reemplaza los caracteres repetidos enumerados en el conjunto1 con una sola ocurrencia  
-t: trunca el conjunto1

**Comandos de muestra**

**1. Cómo convertir minúsculas a mayúsculas**  
Para convertir de minúsculas a mayúsculas se pueden utilizar los conjuntos predefinidos en tr.

**$cat archivo griego**

Producción:

BIENVENIDO A
GeeksforGeeks

**$cat archivo griego | tr “[az]” “[AZ]”**

Producción:

BIENVENIDO A
GEEKSFORGEEKS

o

**$gato geekfile | tr “[:inferior:]” “[:superior:]”**

Producción:

BIENVENIDO A
GEEKSFORGEEKS

**2. Cómo traducir espacios en blanco a pestañas**  
El siguiente comando traducirá todos los espacios en blanco a pestañas

**$ echo "Bienvenido a GeeksforGeeks" | tr [:espacio:] '\t'**

Producción:

Bienvenido a GeeksforGeeks    

**3. Cómo traducir llaves a paréntesis**  
También puede traducir desde y hacia un archivo. En este ejemplo traduciremos llaves en un archivo con paréntesis.

**$cat archivo griego**

Producción:

{BIENVENIDO A}
GeeksforGeeks

**$ tr '{}' '()' nuevoarchivo.txt**

Producción:

(BIENVENIDO A)
GeeksforGeeks

El comando anterior leerá cada carácter de "geekfile.txt", lo traducirá si es una llave y escribirá la salida en "newfile.txt".

**4. Cómo usar la repetición comprimida de caracteres usando -s**  
Para apretar las ocurrencias repetidas de caracteres especificados en un conjunto, use la opción -s. Esto elimina las instancias repetidas de un carácter.  
O podemos decir que puede convertir múltiples espacios continuos con un solo espacio

**$ echo "Bienvenido a GeeksforGeeks" | tr -s [:espacio:] ' '**

Producción:

Bienvenido a GeeksforGeeks

**5. Cómo eliminar caracteres específicos utilizando la opción -d**  
Para eliminar caracteres específicos, utilice la opción -d. Esta opción elimina los caracteres del primer conjunto especificado.

**$ echo "Bienvenido a GeeksforGeeks" | tr -d 'w'**

Producción:

Bienvenido a GeeksforGeeks

**6. Para eliminar todos los dígitos de la cadena, use**

**$ echo "mi ID es 73535" | tr -d [:dígito:]**

Producción:

mi identificacion es

**7. Cómo complementar los conjuntos usando la opción -c**  
Puedes complementar el SET1 usando la opción -c. Por ejemplo, para eliminar todos los caracteres excepto los dígitos, puede usar lo siguiente.

**$ echo "mi ID es 73535" | tr -cd [:dígito:]**

Producción:

73535