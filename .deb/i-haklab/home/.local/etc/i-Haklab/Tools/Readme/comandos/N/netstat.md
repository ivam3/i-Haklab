  
[netstat](https://translate.google.com/website?sl=auto&tl=es&u=http://manpages.ubuntu.com/manpages/precise/en/man8/netstat.8.html) : imprime conexiones de red, tablas de enrutamiento, estadísticas de interfaz, conexiones de enmascaramiento y membresías de multidifusión

--route  ,  -r 

    Muestra las tablas de enrutamiento del kernel. Consulte la descripción en la [ruta](https://translate.google.com/website?sl=auto&tl=es&u=http://manpages.ubuntu.com/manpages/precise/en/man8/route.8.html) (8) para obtener más detalles.  netstat  -r y route  -e 

    producen el mismo resultado.

--groups  ,  -g 

    Muestra información de pertenencia a grupos de multidifusión para IPv4 e IPv6.

--interfaces,  -i 

    Muestra una tabla de todas las interfaces de red.

--masquerade  ,  -M 

    Muestra una lista de conexiones enmascaradas.

--statistics  ,  -s 

    Muestra estadísticas resumidas para cada protocolo.

--verbose  ,  -v

    Dígale al usuario lo que está pasando siendo detallado. Especialmente imprima alguna información útil sobre

    familias de direcciones no configuradas.

--ancho  ,  -W

    No trunque las direcciones IP utilizando una salida tan amplia como sea necesario. Esto es opcional por ahora para no romper

    guiones existentes.

--numeric  ,  -n 

    Muestra direcciones numéricas en lugar de intentar determinar nombres simbólicos de host, puerto o usuario.

--numeric-hosts 

    muestra direcciones de host numéricas pero no afecta la resolución del puerto o los nombres de usuario.

--numeric-ports 

    muestra números de puerto numéricos pero no afecta la resolución de los nombres de usuario o de host.

--numeric-users 

    muestra ID de usuario numéricos pero no afecta la resolución de los nombres de puerto o host.

--protocolo = familia , -A

    Especifica las familias de direcciones (quizás mejor descritas como protocolos de bajo nivel) para las que las conexiones

    se mostrarán.  family es una lista separada por comas (',') de palabras clave de familias de direcciones como inet , unix , ipx ,

     ax25 , netrom y ddp . Esto tiene el mismo efecto que usar las   opciones --inet ,   --unix   ( -x ),   --ipx ,   --ax25 ,

     --netrom y --ddp .

    La familia de direcciones inet incluye sockets de protocolo raw, udp y tcp.

-c,  --continuous 

    Esto hará que netstat imprima la información seleccionada cada segundo de forma continua.

-e,  --extend 

    Muestra información adicional. Utilice esta opción dos veces para obtener el máximo detalle.

-o,  --timers 

    Incluye información relacionada con los temporizadores de red.

-p,  --program 

    Muestra el PID y el nombre del programa al que pertenece cada conector.

-l,  --listening 

    Muestra solo enchufes de escucha. (Estos se omiten de forma predeterminada).

-a,  --todos 

    Muestra las tomas de escucha y no escucha. Con la opción --interfaces , muestra interfaces que son

    no hacia arriba

-F 

    Imprimir información de enrutamiento de la FIB. (Este es el valor predeterminado).

-C 

    Imprime información de enrutamiento desde la caché de ruta.