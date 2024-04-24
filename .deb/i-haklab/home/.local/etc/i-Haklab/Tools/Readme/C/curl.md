Opciones comunes

-#, --progress-bar Haga que la pantalla curl sea una simple barra de progreso en lugar del medidor estándar más informativo.

-b, --[[Cookies]] <name=data> Suministrar cookie con solicitud. Si no =, entonces especifica el archivo de cookies a usar (ver -c).

-c, --cookie-jar <file name> Archivo para guardar las cookies de respuesta.

- `-d`, `--data <data>` Envía los datos especificados en la solicitud POST. Detalles proporcionados a continuación.

- `-f`, `--fail` Falla silenciosamente (no muestre el formulario de error HTML si se devuelve).

-F, --form <name=content> Enviar datos del formulario.

-H, --header <[[header]]> Cabeceras a suministrar con pedido.

-i, --include Incluya encabezados HTTP en la salida.

- `-I`, --head Obtener encabezados solamente.

- `-k`, --insecure Permita que las conexiones inseguras tengan éxito.

- `-L`, --location Seguir redireccionamientos.

-o, --output <file> Escribir salida en . Se puede usar --create-dirsjunto con esto para crear cualquier directorio especificado en la -oruta.

-O, --remote-name Escribe la salida en un archivo con el mismo nombre que el archivo remoto (solo escribe en el directorio actual).

-s, --silent Modo silencioso (silencioso). Use with -Spara obligarlo a mostrar errores.

-v, --verbose Proporcione más información (útil para la depuración).

-w, --write-out <format> Haga que la información de visualización de curl en stdout después de una transferencia completa. Consulte la página del manual para obtener más detalles sobre las variables disponibles. Manera conveniente de forzar a curl a agregar una nueva línea a la salida: -w "\n"(puede agregar a ~/.curlrc).

-X, --request El método de solicitud a utilizar.
[[Metodos HTTP]]



CORREO

Al enviar datos a través de una solicitud POST o PUT, dos formatos comunes (especificados a través del Content-Typeencabezado) son:

application/json

application/x-www-form-urlencoded

Muchas API aceptarán ambos formatos, por lo que si está utilizando curlen la línea de comando, puede ser un poco más fácil usar el formato de formulario codificado en urlen en lugar de json porque

el formato json requiere un montón de citas adicionales

curl enviará el formulario urlencoded de forma predeterminada, por lo que para json, el Content-Typeencabezado debe configurarse explícitamente

Esta esencia proporciona ejemplos para usar ambos formatos, incluido cómo usar archivos de datos de muestra en cualquiera de los formatos con sus curlsolicitudes.

uso de rizos

Para enviar datos con solicitudes POST y PUT, estas son curlopciones comunes:

tipo de solicitud

-X POST

-X PUT

encabezado de tipo de contenido

-H "Content-Type: application/x-www-form-urlencoded"

-H "Content-Type: application/json"

datos

formulario urlencodificado: -d "param1=value1&param2=value2"o-d @data.txt

json: -d '{"key1":"value1", "key2":"value2"}'o-d @data.json

Ejemplos

Aplicación POST/x-www-form-urlencoded

application/x-www-form-urlencodedes el predeterminado:

curl -d "param1=value1&param2=value2" -X POST http://localhost:3000/data 

explícito:

curl -d "param1=value1&param2=value2" -H "Content-Type: application/x-www-form-urlencoded" -X POST http://localhost:3000/data 

con un archivo de datos

curl -d "@data.txt" -X POST http://localhost:3000/data 

Aplicación POST/json

curl -d '{"key1":"value1", "key2":"value2"}' -H "Content-Type: application/json" -X POST http://localhost:3000/data 

con un archivo de datos

curl -d "@data.json" -X POST http:/

