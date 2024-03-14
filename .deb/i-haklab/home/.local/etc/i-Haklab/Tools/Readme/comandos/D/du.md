du:     Es un comando en Linux (abreviatura de uso del disco) que lo ayuda a identificar qué archivos/directorios consumen cuánto espacio. Si ejecuta un simple comando du en la terminal

banderas importantes

BanderaDescripción

-aTambién mostrará una lista de archivos con la carpeta.

-h Enumerará los tamaños de archivo en formato legible por humanos (B, MB, KB, GB)-CEl uso de esta bandera imprimirá el tamaño total al final. Jic, desea encontrar el tamaño del directorio que estaba enumerando

-d <número>Indicador para especificar la profundidad de un directorio para el que desea ver los resultados (por ejemplo, -d 2)

--time Para obtener los resultados con la marca de tiempo de la última modificación.


-  Buscar archivo que pesan mas de 30m  

`du -h --threshold=30M ~/ | sort -n`
