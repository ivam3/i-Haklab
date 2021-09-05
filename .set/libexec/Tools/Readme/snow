El programa de esteganografía SNOW
Sinopsis
nieve [ -CQS ] [ -p passwd ] [ -l línea-largo ] [ -f archivo | -m mensaje ] [ infile [ outfile ]]
Descripción
snow es un programa para ocultar mensajes en archivos de texto agregando tabulaciones y espacios al final de las líneas, y para extraer mensajes de archivos que contienen mensajes ocultos. Las pestañas y los espacios son invisibles para la mayoría de los lectores de texto, de ahí la naturaleza esteganográfica de este esquema de codificación.

Los datos se ocultan en el archivo de texto agregando secuencias de hasta 7 espacios, intercalados con pestañas. Esto generalmente permite almacenar 3 bits cada 8 columnas. Se rechazó un esquema de codificación alternativo, que usaba espacios y tabulaciones alternas para representar ceros y unos, porque, aunque usaba menos bytes, requería más columnas por bit (4.5 vs 2.67).

El inicio de los datos se indica mediante un carácter de tabulación adjunto, que permite la inserción de encabezados de correo y noticias sin dañar los datos.

snow proporciona una compresión rudimentaria, utilizando tablas de Huffman optimizadas para texto en inglés. Sin embargo, si los datos no son texto, o si hay muchos datos, no se recomienda el uso de la compresión incorporada, ya que un programa de compresión externo como compress o gzip hará un trabajo mucho mejor.

También se proporciona cifrado, utilizando el algoritmo de cifrado ICE en modo de retroalimentación de cifrado (CFB) de 1 bit. Debido al tamaño de clave arbitrario de ICE, se admiten contraseñas de cualquier longitud de hasta 1170 caracteres (dado que solo se utilizan 7 bits de cada carácter, se admiten claves de hasta 1024 bytes).

Si una cadena de mensaje o archivo de mensajes se especifican en la línea de comandos, la nieve va a tratar de ocultar el mensaje en el archivo de archivo de entrada si se especifica, o la entrada estándar de otro modo. El archivo resultante será escrito al archivo de salida si se especifica, o la salida estándar si no.

Si no se proporciona una cadena de mensaje, snow intenta extraer un mensaje del archivo de entrada. El resultado se escribe en el archivo de salida o en la salida estándar.

Opciones
-C
Comprima los datos si los oculta o descomprímalos si los extrae.

-Q
Modo silencioso. Si no se configura, el programa informa estadísticas como los porcentajes de compresión y la cantidad de espacio de almacenamiento disponible utilizado.

-S
Informe sobre la cantidad aproximada de espacio disponible para mensajes ocultos en el archivo de texto. Se tiene en cuenta la longitud de la línea, pero se ignoran otras opciones.

-p contraseña
Si se establece, los datos se cifrarán con esta contraseña durante el ocultamiento o se descifrarán durante la extracción.

-l longitud de la línea
Al agregar espacios en blanco, la nieve siempre producirá líneas más cortas que este valor. De forma predeterminada, está establecido en 80.

-f archivo-mensaje
El contenido de este archivo se ocultará en el archivo de texto de entrada.

-m cadena-mensaje
El contenido de esta cadena se ocultará en el archivo de texto de entrada. Tenga en cuenta que, a menos que se incluya de alguna manera una nueva línea en la cadena, no se imprimirá una nueva línea cuando se extraiga el mensaje.
Ejemplos de
El siguiente comando ocultará el mensaje "Estoy mintiendo" en el archivo infile , con compresión y encriptado con la contraseña "hola mundo". El texto resultante se almacenará en un archivo de salida .

snow -C -m "I am lying" -p "hello world" infile outfile
Para extraer el mensaje, el comando sería
snow -C -p "hello world" outfile
Tenga en cuenta que el mensaje resultante no terminará con una nueva línea.

Para evitar el ajuste de línea si es probable que los lectores de correo o noticias sangren el texto con espacios en blanco ocultos, se puede utilizar una longitud de línea de 72 o menos.

snow -C -l 72 -m "I am lying" infile outfile
La capacidad de almacenamiento aproximada de un archivo se puede determinar con la opción -S .

snow -S -l 72 infile
