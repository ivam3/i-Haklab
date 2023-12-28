  
 [ls (1)](https://translate.google.com/website?sl=auto&tl=es&u=http://manpages.ubuntu.com/manpages/precise/en/man1/ls.1.html) : muestra el contenido del directorio

Muestra información sobre los ARCHIVOS (el directorio actual por defecto). Ordene las entradas alfabéticamente si ninguna

de -cftuvSUX ni --sort se especifica.

-a , --todos 

       no ignoran las entradas que comienzan con.

-A , - casi todos 

       no se enumeran implícitos. y ..

--author 

       con -l , imprime el autor de cada archivo

-b , --escape 

       print escapes de estilo C para caracteres no gráficos

--block-size = TAMAÑO

       tamaños de escala por TAMAÑO antes de imprimirlos. Por ejemplo, `--block-size = M 'imprime tamaños en unidades de

       1.048.576 bytes. Consulte el formato TAMAÑO a continuación.

-B , --ignore-backups 

       no enumera las entradas implícitas que terminan en ~

-c      con -lt : ordenar y mostrar ctime (hora de la última modificación de la información de estado del archivo) con -l :

       mostrar ctime y ordenar por nombre de lo contrario: ordenar por ctime, el más nuevo primero

-C      lista entradas por columnas

--color [= CUANDO ]

       colorear la salida. CUANDO está predeterminado en "siempre" o puede ser "nunca" o "automático". Más información a continuación

-d , --directorio 

       enumera las entradas del directorio en lugar de los contenidos, y no desreferencia los enlaces simbólicos

-D , --dired 

       genera salida diseñada para el modo dired de Emacs

-f      no ordenar, habilitar -aU , deshabilitar -ls  --color

-F , --clasifica el 

       indicador de anexar (uno de * / => @ |) a las entradas

--file-type 

       igualmente, excepto que no agregue `* '

--format = WORD a 

       través de -x , comas -m , horizontal -x , long -l , single-column -1 , verbose -l , vertical -C

- full-time 

       like -l  --time-style = full-iso

-g      como -l , pero no incluye propietario

--group-directory-first 

       agrupa los directorios antes de los archivos.

-G , --no-group 

       en una lista larga, no imprime los nombres de los grupos

-h , - legible por humanos 

       con -l , tamaños de impresión en formato legible por humanos (p. ej., 1K 234M 2G)

--si lo    mismo, pero usa potencias de 1000 no 1024

-H , --dereference-command-line 

       sigue los enlaces simbólicos enumerados en la línea de comando

--dereference-command-line-symlink-to-dir 

       sigue cada enlace simbólico de la línea de comando que apunta a un directorio

--hide = PATTERN 

       no enumera las entradas implícitas que coinciden con el PATTERN de shell (anulado por -a o -A )

--indicator-style = WORD 

       añadir indicador con estilo WORD a los nombres de las entradas: ninguno (predeterminado), barra ( -p ), tipo de archivo

       ( - tipo de archivo ), clasificar ( -F )

-i , --inode 

       imprime el número de índice de cada archivo

-I , --ignore = PATTERN 

       no enumera las entradas implícitas que coinciden con el PATTERN de shell

-k      como --block-size = 1K

-Utilizo      un formato de lista larga

-L , --dereferencia

       al mostrar información de archivo para un enlace simbólico, muestre información para el archivo el enlace

       referencias en lugar del enlace en sí

-m      ancho de relleno con una lista de entradas separadas por comas

-n , --numeric-uid-gid 

       como -l , pero enumera los ID numéricos de usuarios y grupos

-N , --nombres de 

       entrada sin formato de impresión literal (no trate, por ejemplo, los caracteres de control de manera especial)

-o      como -l , pero no enumera la información del grupo

-p , --indicator-style = barra inclinada 

       anexar / indicador a directorios

-q , --hide-control-chars 

       print? en lugar de caracteres no gráficos

--show-control-chars 

       muestra los caracteres no gráficos tal cual (por defecto, a menos que el programa sea 'ls' y la salida sea una terminal)

-Q , --quote-name 

       encierra los nombres de las entradas entre comillas dobles

--quoting-style = WORD 

       usa el estilo de comillas WORD para los nombres de entrada: literal, locale, shell, shell-always, c, escape

-r , - 

       revertir el orden inverso al ordenar

-R , - 

       subdirectorios de lista recursiva de forma recursiva

-s , --size 

       imprime el tamaño asignado de cada archivo, en bloques

-S      ordenar por tamaño de archivo

--sort = WORD 

       ordenar por WORD en lugar del nombre: ninguno -U , extensión -X , tamaño -S , tiempo -t , versión -v

--time = WORD 

       con -l , muestra la hora como WORD en lugar de la hora de modificación: atime -u , access -u , use -u , ctime -c , o

       estado -c ; use el tiempo especificado como clave de clasificación si --sort = time

--time-style = STYLE 

       con   -l , muestra los tiempos usando el estilo STYLE: full-iso, long-iso, iso, locale, + FORMAT. FORMAT es

       interpretado como 'fecha'; si FORMAT es FORMAT1 <newline> FORMAT2, FORMAT1 se aplica a archivos no recientes

       y FORMAT2 a archivos recientes; si ESTILO tiene el prefijo `posix- ', ESTILO sólo tiene efecto fuera de

       la configuración regional POSIX

-t      ordenar por hora de modificación, el más nuevo primero

-T , --tabsize = COLS 

       asumen pestaña se detiene en cada COLS en lugar de 8

-u      con -lt : ordena y muestra el tiempo de acceso con -l : muestra el tiempo de acceso y ordena por nombre de lo contrario:

       ordenar por tiempo de acceso

-U      no clasifica; enumerar entradas en orden de directorio

-v      tipo natural de números (de versión) dentro del texto

-w , --width = COLS 

       asumen ancho de la pantalla en lugar del valor actual

-x      enumera las entradas por líneas en lugar de por columnas

-X      ordena alfabéticamente por extensión de entrada

-Z , --context 

       imprime cualquier contexto de seguridad SELinux de cada archivo

-1      lista un archivo por línea

: ayuda a mostrar esta ayuda y salir

--version 

       informa de la versión de salida y sale