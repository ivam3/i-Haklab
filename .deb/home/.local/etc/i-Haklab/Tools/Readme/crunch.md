# Crunch

## ¿Qué es Crunch?

Crunch es un generador de listas de palabras (wordlists) para ataques de fuerza bruta, altamente personalizable y basado en línea de comandos. A diferencia de descargar listas de contraseñas pre-hechas de internet, Crunch te permite crear tus propias listas de palabras basadas en criterios específicos, como la longitud, los caracteres a utilizar y patrones concretos.

Es una herramienta estándar en el arsenal de cualquier pentester o profesional de la seguridad, y viene preinstalada en distribuciones como Kali Linux.

## ¿Para qué es útil la herramienta?

La principal utilidad de Crunch es generar listas de contraseñas muy específicas y dirigidas para su uso en ataques de fuerza bruta. Esto es mucho más eficiente que usar listas genéricas de gigabytes.

*   **Ataques de Fuerza Bruta Dirigidos:** Si tienes información sobre los requisitos de contraseña de un sistema (por ejemplo, "debe tener 8 caracteres, incluir al menos una mayúscula y un número"), puedes usar Crunch para generar una lista que solo contenga contraseñas que cumplan con ese patrón, ahorrando tiempo y recursos.
*   **Creación de Listas Basadas en OSINT:** Si has recopilado información sobre un objetivo (nombres de mascotas, fechas de nacimiento, aficiones, etc.), puedes usar Crunch para generar permutaciones y combinaciones de esas palabras clave.
*   **Integración con Herramientas de Cracking:** Las listas generadas por Crunch se pueden pasar directamente a herramientas de cracking de contraseñas como [John the Ripper](johntheripper.md), [Hashcat](hashcat.md), o herramientas de ataque en línea como [Hydra](hydra-gtk.md).

## ¿Cómo se usa? (Ejemplos básicos)

Crunch se ejecuta desde la terminal con varios argumentos que definen cómo se generará la lista de palabras.

**Sintaxis básica:**
```bash
crunch <min> <max> [caracteres] -o [archivo_de_salida] -t [patrón]
```

### Ejemplo 1: Generar todas las combinaciones numéricas

Generar todas las contraseñas numéricas de 4 a 6 dígitos y guardarlas en `numeros.txt`.

```bash
crunch 4 6 0123456789 -o numeros.txt
```
*   `4`: Longitud mínima.
*   `6`: Longitud máxima.
*   `0123456789`: El juego de caracteres a utilizar.
*   `-o numeros.txt`: El archivo de salida.

### Ejemplo 2: Generar combinaciones de letras minúsculas

Generar todas las palabras de 3 letras usando solo el alfabeto en minúsculas.

```bash
crunch 3 3 abcdefghijklmnopqrstuvwxyz
```
*   Si no se especifica `-o`, la salida se imprime directamente en la consola.

### Ejemplo 3: Usar un patrón específico (`-t`)

Esta es una de las funciones más potentes. El patrón utiliza símbolos especiales:
*   `@`: Representa letras minúsculas.
*   `,`: Representa letras mayúsculas.
*   `%`: Representa números.
*   `^`: Representa símbolos.

Supongamos que sabemos que la contraseña empieza con `Test`, va seguida de 4 números y termina con un símbolo.

```bash
crunch 9 9 -t Test%%%%^ -o passwords.txt
```
*   `9 9`: La longitud es fija (9 caracteres).
*   `-t Test%%%%^`: Define el patrón. Crunch sustituirá los `%%%%` por todas las combinaciones numéricas posibles y el `^` por todos los símbolos posibles.

### Ejemplo 4: Redirigir la salida a otra herramienta

Crunch puede generar listas de palabras enormes. En lugar de guardarlas en un archivo (lo que podría ocupar gigabytes), puedes redirigir su salida directamente a otra herramienta.

```bash
# Probar una lista de palabras generada por Crunch directamente con Aircrack-ng
crunch 8 8 0123456789 | aircrack-ng -w - -b 00:11:22:33:44:55 handshake.cap
```
*   El `-o START` le dice a Crunch que imprima en la salida estándar, y el `-w -` en `aircrack-ng` le dice que lea la lista de palabras desde la entrada estándar.

Es tan sencillo como decirle la cantidad de caracteres que estamos buscando seguido de alguna opcion, vamos a lanzarlo de una forma basica a ver que tal, probemos con generar todas las posibles combinaciones para una palabra de 4 caracteres:

$crunch 4 4

Como se aprecia crunch avisa de una froma muy educada cuantas lineas seran generadas y cuanto espacio ocupara, a continuacion les comparto las primeras lineas de la salida en pantalla:

aaaa
aaab
aaac
aaad
aaae
aaaf
aaag
aaah
aaai
aaaj
aaak
aaal
aaam
aaan
aaao
aaap
aaaq
aaar
aaas
aaat
aaau
aaav
aaaw
aaax
aaay
aaaz
aaba
aabb
aabc
aabd
aabe
aabf
aabg
aabh
aabi
aabj
aabk
aabl
aabm
aabn
aabo
aabp
aabq
aabr
aabs
aabt
aabu
aabv
aabw
aabx

Vamos a analizar esto unos segundos...

Tenemos que crunch ha generado todas las posibles combinaciones para una palabra de 4 caracteres, pero notan alguna particularidad?

No se han usado números, símbolos, mayúsculas ni espacios en blanco. La razón se explica a continuación:

Crunch utiliza una variable llamada charset (character setting) y es como el conjunto de caracteres que serán usados para la generación del diccionario/wordlist, por defecto el charset es lalpha (lower alphabet) pero que tal si probamos a configurar otro charset.

$crunch 4 4 -f .charset.lst numeric

Como siempre, al presionar enter crunch nos indicara cuantas lineas y cuanto espacio sera usado, analicemos las primeras lineas:

0000
0001
0002
0003
0004
0005
0006
0007
0008
0009
0010
0011
0012
0013
0014
0015
0016
0017
0018
0019
0020
0021
0022
0023
0024
0025
0026
0027
0028
0029
0030
0031
0032
0033
0034
0035
0036
0037
0038
0039
0040
0041
0042
0043
0044
0045
0046
0047
0048
0049

Todo ha ido bien, pero ahora notamos una pequeña diferencia, y es que solo ha generado números, pero eso es justo lo que queríamos no? Y como lo hemos logrado pues con la opción -f y listo!! 

Esta opción le indica dónde buscar el fichero de variables, es decir, donde están preestablecidas todos los charset, es decir que debemos especificar la ruta al archivo así como nuestra selección dentro del mismo, en mi caso tengo el charset.lst en mi directorio home, por ello no específico ruta hasta el mismo. 

Cuantos charset podemos elegir además de lalpha y de numeric?

Miren por ustedes mismo

hex-lower                     = [0123456789abcdef]
hex-upper                     = [0123456789ABCDEF]

numeric                       = [0123456789]
numeric-space                 = [0123456789 ]

symbols14                     = [!@#$%^&*()-_+=]
symbols14-space               = [!@#$%^&*()-_+= ]

symbols-all                   = [!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/]
symbols-all-space             = [!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/ ]

ualpha                        = [ABCDEFGHIJKLMNOPQRSTUVWXYZ]
ualpha-space                  = [ABCDEFGHIJKLMNOPQRSTUVWXYZ ]
ualpha-numeric                = [ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789]
ualpha-numeric-space          = [ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 ]
ualpha-numeric-symbol14       = [ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+=]
ualpha-numeric-symbol14-space = [ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+= ]
ualpha-numeric-all            = [ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/]
ualpha-numeric-all-space      = [ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/ ]

lalpha                        = [abcdefghijklmnopqrstuvwxyz]
lalpha-space                  = [abcdefghijklmnopqrstuvwxyz ]
lalpha-numeric                = [abcdefghijklmnopqrstuvwxyz0123456789]
lalpha-numeric-space          = [abcdefghijklmnopqrstuvwxyz0123456789 ]
lalpha-numeric-symbol14       = [abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_+=]
lalpha-numeric-symbol14-space = [abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_+= ]
lalpha-numeric-all 	      = [abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/]
lalpha-numeric-all-space      = [abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/ ]

mixalpha                   = [abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ]

mixalpha-space             = [abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ]

mixalpha-numeric           = [abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789]

mixalpha-numeric-space     = [abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 ]

mixalpha-numeric-symbol14  = [abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+=]

mixalpha-numeric-symbol14-space = [abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+= ]

mixalpha-numeric-all       = [abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/]

mixalpha-numeric-all-space = [abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/ ]

########################
# Higercase             #
#########################
ualpha-sv                        = [ABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ]

ualpha-space-sv                  = [ABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ ]

ualpha-numeric-sv                = [ABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789]

ualpha-numeric-space-sv          = [ABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789 ]

ualpha-numeric-symbol14-sv       = [ABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789!@#$%^&*()-_+=]

ualpha-numeric-symbol14-space-sv = [ABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789!@#$%^&*()-_+= ]

ualpha-numeric-all-sv            = [ABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/]

ualpha-numeric-all-space-sv      = [ABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/ ]

#########################
# Lowercase             #
#########################
lalpha-sv                        = [abcdefghijklmnopqrstuvwxyzåäö]

lalpha-space-sv                  = [abcdefghijklmnopqrstuvwxyzåäö ]

lalpha-numeric-sv                = [abcdefghijklmnopqrstuvwxyzåäö0123456789]

lalpha-numeric-space-sv          = [abcdefghijklmnopqrstuvwxyzåäö0123456789 ]

lalpha-numeric-symbol14-sv       = [abcdefghijklmnopqrstuvwxyzåäö0123456789!@#$%^&*()-_+=]

lalpha-numeric-symbol14-space-sv = [abcdefghijklmnopqrstuvwxyzåäö0123456789!@#$%^&*()-_+= ]

lalpha-numeric-all-sv            = [abcdefghijklmnopqrstuvwxyzåäö0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/]

lalpha-numeric-all-space-sv      = [abcdefghijklmnopqrstuvwxyzåäö0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/ ]

#########################
# Mixcase               #
#########################
mixalpha-sv                   = [abcdefghijklmnopqrstuvwxyzåäöABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ]

mixalpha-space-sv             = [abcdefghijklmnopqrstuvwxyzåäöABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ ]

mixalpha-numeric-sv           = [abcdefghijklmnopqrstuvwxyzåäöABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789]

mixalpha-numeric-space-sv     = [abcdefghijklmnopqrstuvwxyzåäöABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789 ]

mixalpha-numeric-symbol14-sv  = [abcdefghijklmnopqrstuvwxyzåäöABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789!@#$%^&*()-_+=]

mixalpha-numeric-symbol14-space-sv = [abcdefghijklmnopqrstuvwxyzåäöABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789!@#$%^&*()-_+= ]

mixalpha-numeric-all-sv       = [abcdefghijklmnopqrstuvwxyzåäöABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/]

mixalpha-numeric-all-space-sv = [abcdefghijklmnopqrstuvwxyzåäöABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ0123456789!@#$%^&*()-_+=~`[]{}|\:;"'<>,.?/ ]


Si no quieren especificar ningun charset pueden simplemente pasarle a crunch cuales caracteres desean usar en la generacion, por ejemplo:

$crunch 4 4 ab12

Y la salida seria:

aaaa
aaab
aaa1
aaa2
aaba
aabb
aab1
aab2
aa1a
aa1b
aa11
aa12
aa2a
aa2b
aa21
aa22
abaa
abab
aba1
aba2
abba
abbb
abb1
abb2
ab1a
ab1b
ab11
ab12
ab2a
ab2b
ab21
ab22
a1aa
a1ab
a1a1
a1a2
a1ba
a1bb
a1b1
a1b2
a11a
a11b
a111
a112
a12a
a12b
a121
a122
a2aa
a2ab
a2a1
a2a2
a2ba
a2bb
a2b1
a2b2
a21a
a21b
a211
a212
a22a
a22b
a221
a222
baaa
baab
baa1
baa2
baba

Empiezan a entender el sentido de la palabra "Flexibilidad" para referirse a crunch, bueno sigamos adelante aprendiendo más trucos para esta maravillosa tool.


CÓMO USAR CRUNCH NIVEL 2

Hasta ahora hemos aprendido a usar crunch al nivel basico, es decir solo sabemos generar diccionarios especificandole el tamaño y el conjunto de caracteres a usarse, y muchos pensaran que esa es toda la magia de generar diccionarios y la verdad es que esta cortos, siganme y veremos que otras cosas podemos hacer.

Recuerdan aquella película de hackers en la que el estelar mira el teclado del administrador de sistemas y logra ver la clave digitada en el teclado? Pues en la vida real quizás no sea tan sencillo ver toda la clave digitada y solo logramos recordar parte de la misma y quizás su tamaño (si su tamaño, yo suelo contar las pulsaciones en el teclado asi me hago una idea del tamaño) pues supongamos que queremos generar una clave que inicia con "Und......" pero no sabemos el resto, pues podríamos decirle a crunch:

$crunch 9 9 -t und@@@@@@

Y esto generara:

undaaoerv
undaaoerw
undaaoerx
undaaoery
undaaoerz
undaaoesa
undaaoesb
undaaoesc
undaaoesd
undaaoese
undaaoesf
undaaoesg
undaaoesh
undaaoesi
undaaoesj
undaaoesk
undaaoesl
undaaoesm
undaaoesn
undaaoeso
undaaoesp
undaaoesq
undaaoesr
undaaoess
undaaoest
undaaoesu
undaaoesv
undaaoesw
undaaoesx
undaaoesy
undaaoesz
undaaoeta
undaaoetb
undaaoetc
undaaoetd
undaaoete
undaaoetf
undaaoetg
undaaoeth
undaaoeti
undaaoetj
undaaoetk
undaaoetl
undaaoetm
undaaoetn
undaaoeto
undaaoetp
undaaoetq
undaaoetr
undaaoets
undaaoett
undaaoetu
undaaoetv
undaaoetw
undaaoetx
undaaoety
undaaoetz
undaaoeua
undaaoeub
undaaoeuc
undaaoeud
undaaoeue
undaaoeuf
undaaoeug
undaaoeuh
undaaoeui
undaaoeuj
undaaoeuk
undaaoeul
undaaoeum
undaaoeun
undaaoeuo
undaaoeup
undaaoeuq
undaaoeur
undaaoeus
undaaoeut
undaaoeuu
undaaoeuv
undaaoeuw
undaaoeux
undaaoeuy
undaaoeuz
undaaoeva
undaaoevb
undaaoevc
undaaoevd
undaaoeve
undaaoevf
undaaoevg
undaaoevh

Y si nos fijamos crunh ha generado palabras sin modificar los 3 primeros caracteres, con lo cual si la palabra clave es "undercode" eventualmente sera generada, pero que pasaria si el admin del sitio ha querido complicarla y ha puesto "underc0de" como password? pues podemos hacerlo de dos formas, una sencilla y otra un poco mas compleja, para la forma compleja podriamos hacerlo al especificar un charset alfanumerico escribiendo:

$crunch 9 9 -f .charset.lst lalpha-numeric -t und@@@@@@

ó bien podriamos especificar los caracteres que queremos usar:

$crunch 9 9 abcefghijklmnopqrstuwxyz1234567890 -t und@@@@@@

Con ambos comandos tendriamos el mismo resultado, simplemente son dos formas de hacer lo mismo

undaaaz1u
undaaaz1v
undaaaz1w
undaaaz1x
undaaaz1y
undaaaz1z
undaaaz10
undaaaz11
undaaaz12
undaaaz13
undaaaz14
undaaaz15
undaaaz16
undaaaz17
undaaaz18
undaaaz19
undaaaz2a
undaaaz2b
undaaaz2c
undaaaz2d
undaaaz2e
undaaaz2f
undaaaz2g
undaaaz2h
undaaaz2i
undaaaz2j
undaaaz2k
undaaaz2l
undaaaz2m
undaaaz2n
undaaaz2o
undaaaz2p
undaaaz2q
undaaaz2r
undaaaz2s
undaaaz2t
undaaaz2u
undaaaz2v
undaaaz2w
undaaaz2x
undaaaz2y
undaaaz2z
undaaaz20
undaaaz21
undaaaz22
undaaaz23
undaaaz24
undaaaz25
undaaaz26
undaaaz27
undaaaz28
undaaaz29
undaaaz3a
undaaaz3b
undaaaz3c
undaaaz3d
undaaaz3e
undaaaz3f
undaaaz3g
undaaaz3h
undaaaz3i
undaaaz3j
undaaaz3k
undaaaz3l
undaaaz3m
undaaaz3n
undaaaz3o
undaaaz3p
undaaaz3q
undaaaz3r
undaaaz3s
undaaaz3t
undaaaz3u
undaaaz3v
undaaaz3w
undaaaz3x
undaaaz3y
undaaaz3z
undaaaz30
undaaaz31
undaaaz32
undaaaz33
undaaaz34
undaaaz35
undaaaz36
undaaaz37
undaaaz38
undaaaz39
undaaaz4a
undaaaz4b
undaaaz4c
undaaaz4d
undaaaz4e
undaaaz4f
undaaaz4g
undaaaz4h
undaaaz4i
undaaaz4j
undaaaz4k
undaaaz4l
undaaaz4m
undaaaz4n
undaaaz4o
undaaaz4p
undaaaz4q
undaaaz4r
undaaaz4s
undaaaz4t
undaaaz4u
undaaaz4v
und.....

Ahora viene la forma sencilla que es simplemente cambiar el símbolo "@" por el tipo de carácter que queremos insertar en la generación del diccionario, recuerden que con la opción -t, podemos especificar un patrón de caracteres que serán los únicos en cambiar al generar el diccionario, así los caracteres que podemos especificar para el patrón son:

              @  insertara minúsculas 
              ,    insertara mayúsculas 
              %  insertara números 
              ^   insertara símbolos 

Sabiendo esto vamos a suponer que queremos generar un diccionario donde la primera letra sea en mayúscula, pero que a lo largo del mismo, tanto el 2do como el 3er caracter se queden fijos, pues para hacerlo agregamos una "," que tal como explique anteriormente insertará mayúsculas, pero recordemos que había un número en el password, asi que tambien necesitamos insertar un solo número en el 7mo carácter de nuestra palabra, pues sólo contamos hasta el lugar número 7 e insertamos un "%" que como también expliqué anteriormente solo inserta números, el comando final quedaría como esto: 

$crunch 9 9 -t ,nd@@@%@@

generando lo siguiente :

Andaaw2fn
Andaaw2fo
Andaaw2fp
Andaaw2fq
Andaaw2fr
Andaaw2fs
Andaaw2ft
Andaaw2fu
Andaaw2fv
Andaaw2fw
Andaaw2fx
Andaaw2fy
Andaaw2fz
Andaaw2ga
Andaaw2gb
Andaaw2gc
Andaaw2gd
Andaaw2ge
Andaaw2gf
Andaaw2gg
Andaaw2gh
Andas....

Todo esta flexibilidad la hemos logrado con la opción -t, espero la hayan entendido y les sea muy práctica en un futuro.

Veamos, vamos a generar un diccionario concatenando palabras, a imaginarse por cual razón algunas personas usan como password una serie de palabras unidas, por ejemplo alguien que le guste harry potter podría usar los nombres de Harry, Hermione y Ron como password y en ese caso generar simplemente por caracteres sería casi imposible dada la longitud final "harryhermioneron" así que en crunch existe una opción que nos permite concatenar palabras, veamos como:

$crunch 1 1 -p Harry Hermione Ron

generando esto:

HarryHermioneRon
HarryRonHermione
HermioneHarryRon
HermioneRonHarry
RonHarryHermione
RonHermioneHarry

Como se habran fijado con la opcio -p es posible lograr concatenar palabras, pero hay una particularidad y es que fijense que en la parte donde se especifican la longitud menor y la mayor yo he colocado "1 1" y pues la verdad es que cuando se usa la opcion -p los numeros no son procesados, pero son necesarios para el argumento, es decir que podremos colocar cualquier cosa y sera irrelevante para la salida.


CÓMO USAR CRUNCH NINEL 3

Pues llegados a este punto ya sabemos generar diccionarios con distintos charset, sabemos aplicar patrones en la generación, concatenar palabras, así como especificar con cuales caracteres queremos generar, así que considero que estamos avanzando en la tarea de desnudar a crunch.

Al inicio del taller decia que crunch puede mandar los resultados a la pantalla, puede crear un archivo ó pasarle la salida a otro programa (generalmente un crackeador como aircrack) pero hasta ahora solamente hemos sacado los resultados en pantalla, es decir no se han creado ningun archivo ni nada parecido, asi que vamos a ello.

Enviando el output de crunch a un archivo.txt ó a un comprimido.

Pues la idea basica de crear un diccionario es poder usarse posteriormente para dar con el hash valido en una prueba de fuerza bruta, asi que de alguna forma debemos poder generar un fichero a partir de la salida, esto es posible usando la opcion -o (output) seguido del nombre del archivo, tomemos como ejemplo el ejercicio de Harry Hermione y Ron y creemos un fichero, el comando seria:

$crunch 1 1 -o NombresPotter.txt -p Harry Hermione Ron

Opcionalmente tambien podriamos especificar la ruta donde queremos volcar el diccionario, por ejemplo:

crunch 1 1 -o /sdcard/diccionarios/NombresPotter.txt -p Harry Hermione Ron

Vamos a avanzar un poco más profundo y hagamos que cada 5000 líneas crunch nos genero 1 fichero, pues para que, dependiendo el entorno en el que se vaya a auditar necesitamos seccionar el ataque, es decir dividir el diccionario en una cantidad específica, para lograr mejor acoplamiento con los temporizadores de los crackeadores, para lograr esa división de un diccionario en varios ficheros de menor tamaño usamos la opción -c (esta opción solo funciona si el -o START está presente en la linea) por ejemplo:

crunch 1 1 -o /sdcard/diccionarios/START -c 5000

Esto inicia el proceso de crear multiples ficheros con 5000 lineas cada uno.

Y si me fuera a la carpeta diccionarios me encontraría con diversos archivos en extensión .txt los cuales tendrían un límite de líneas a 5000.

Ven que sencillo?

NOTA: 

[].- El START funciona como nombre de archivo para el primer fichero a crear, a partir de ahi los ficheros tomaran el nombre de la ultima linea del archivo anterior + la primera linea del archivo posterior

[].- Aunque debo aclarar que en algunos caso es posible llenar el disco duro al generar un diccionario, todo depende de lo que le digamos a crunch, por ejemplo si yo dijese:

$crunch 15 25 -o demasiado.txt
$crunch will now generate approximately the following amount of data: 2744 PB

Se fijan en el tamaño del fichero?

2744 PB !!!

Eso seria demasiado para cualquier disco duro.

Pero entre tanta generacion que tal si creamos un fichero y lo comprimimos a bzip, de un solo golpe, suena complicado pero seria simplemente agregar la opcion -z seguido del tipo de compresion deseado, por ejemplo:

$crunch 4 5 -o /sdcard/diccionarios/START -c 5000 -z gzip

De esta forma se iniciaria el mismo proceso anterior solo que en comprimidos gzip u en cualquier otro formato soportado por crunch (gzip, bzip2, lzma, y 7z )

Pues como podran ver no es tan complicado mandar la salida a un fichero txt, gzip, bzip2, lzma ó 7z.

## Consideraciones Adicionales

*   **Tamaño de la Wordlist:** ¡Ten mucho cuidado! El número de combinaciones puede crecer exponencialmente. Generar "todas las combinaciones posibles de 8 caracteres con letras, números y símbolos" creará un archivo de un tamaño astronómico que llenará tu disco duro y tardará una eternidad en procesarse. La clave de Crunch es **restringir** las posibilidades, no generarlas todas.
*   **Rendimiento:** Crunch es una herramienta que consume bastante CPU, ya que está constantemente calculando combinaciones.
*   **Legalidad:** La creación de listas de palabras no es ilegal, pero usarlas para intentar acceder a sistemas para los que no tienes autorización sí lo es. Utiliza Crunch de forma responsable y ética.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. La eficacia de un ataque de fuerza bruta depende de la calidad de la lista de palabras; Crunch te da el poder de crear listas de alta calidad y muy específicas.*
