H8Mail: OSINT para Encontrar Direcciones Email Hackeadas

H8Mail es una herramienta de OSINT y buscador de contraseñas potente y fácil de usar. Puedes usarlo para encontrar contraseñas a través de diferentes servicios de violación y reconocimiento.

#Características de H8Mail

Coincidencia de patrones de correo electrónico (reg exp), útil para la lectura de las salidas de otras herramientas
Pasar URLs para encontrar y apuntar directamente a los correos electrónicos en las páginas
Patrones sueltos para búsquedas locales (“john.smith”, “evilcorp”)
Instalación sin complicaciones. Disponible a través de pip, sólo requiere solicitudes
Lectura masiva de archivos para la fijación de objetivos
Salida a archivo CSV o JSON
Compatible con los scripts torrent de “Breach Compilation”.
Búsqueda de archivos de texto claro y comprimidos .gz localmente usando multiprocesamiento
Obtener correos electrónicos relacionados
Persigue correos electrónicos relacionados añadiéndolos a la búsqueda en curso
Admite servicios de búsqueda premium para usuarios avanzados
Consulta personalizada de las APIs premium. Soporta nombre de usuario, hash, ip, dominio y contraseña y más
Reagrupa los resultados de las infracciones para todos los objetivos y métodos
Incluye la opción de ocultar las contraseñas para las demostraciones

#APIs

Servicio	Funciones	Estado
HaveIBeenPwned(v3) - Número de filtraciones de correo electrónico
HaveIBeenPwned Pastes(v3)	- URL de los archivos de texto que mencionan los objetivos
Hunter.io – Público	Número de correos electrónicos relacionados
Hunter.io – Servicio(nivel gratuito)	Correos electrónicos relacionados con texto claro	
Snusbase – Servicio	Contraseñas en texto claro, hashs y sales, nombres de usuario, IPs – Rápido 
Leak-Lookup – Público	Número de resultados de filtraciones que se pueden buscar
Leak-Lookup – Servicio	Contraseñas en texto claro, hashs y sales, nombres de usuario, IPs, dominio
Emailrep.io – Servicio(gratis)	Lo último que se ha visto en las filtraciones, los perfiles de las redes sociales
scylla.so – Servicio (gratis)	Contraseñas en texto claro, hashs y sales, nombres de usuario, IPs, dominios	
Dehashed.com – Servicio	Contraseñas en texto claro, hashs y sales, nombres de usuario, IPs, dominios
IntelX.io – Servicio (prueba gratuita)	Contraseñas en texto claro, hashs y sales, nombres de usuario, IPs, dominio, billeteras Bitcoin, IBAN
Breachdirectory.tk – Servicio (gratis)	Contraseñas en texto claro, hashs y sales, nombres de usuario, dominio

Consulta para un único objetivo
h8mail -t objetivo@dominio.com


Buscar email hackeado
Ver cuentas y contraseñas hackeadas con H8Mail 

Consulta de la lista de objetivos, indicando el archivo de configuración para las claves de la API, salida a pwned_targets.csv
h8mail -t targets.txt -c config.ini -o pwned_targets.csv

Consulta sin realizar llamadas a la API mediante una copia local de Breach Compilation
h8mail -t targets.txt -bc ../Downloads/BreachCompilation/ -sk

Buscar en todos los archivos .gz los objetivos encontrados en targets.txt localmente
h8mail -t targets.txt -gz /tmp/Collection1/ -sk

Comprobar un volcado de texto claro para el objetivo. Agregar los siguientes 10 correos electrónicos relacionados a los objetivos que deseas comprobar. Lectura de claves desde la CLI.
h8mail -t admin@evilcorp.com -lb /tmp/4k_Combo.txt -ch 10 -k "hunterio=ABCDE123"

Para más detalles de su uso, puedes visitar el repositorio en GitHub o escribir el siguiente comando:
h8mail -h



-----

##  :tangerine: Usage

```bash
usage: h8mail [-h] [-t USER_TARGETS [USER_TARGETS ...]]
              [-u USER_URLS [USER_URLS ...]] [-q USER_QUERY] [--loose]
              [-c CONFIG_FILE [CONFIG_FILE ...]] [-o OUTPUT_FILE]
              [-bc BC_PATH] [-sk] [-k CLI_APIKEYS [CLI_APIKEYS ...]]
              [-lb LOCAL_BREACH_SRC [LOCAL_BREACH_SRC ...]]
              [-gz LOCAL_GZIP_SRC [LOCAL_GZIP_SRC ...]] [-sf]
              [-ch [CHASE_LIMIT]] [--power-chase] [--hide] [--debug]
              [--gen-config]
              
Email information and password lookup tool

optional arguments:
  -h, --help            show this help message and exit
  -t USER_TARGETS [USER_TARGETS ...], --targets USER_TARGETS [USER_TARGETS ...]
                        Either string inputs or files. Supports email pattern
                        matching from input or file, filepath globing and
                        multiple arguments
  -u USER_URLS [USER_URLS ...], --url USER_URLS [USER_URLS ...]
                        Either string inputs or files. Supports URL pattern
                        matching from input or file, filepath globing and
                        multiple arguments. Parse URLs page for emails.
                        Requires http:// or https:// in URL.
  -q USER_QUERY, --custom-query USER_QUERY
                        Perform a custom query. Supports username, password,
                        ip, hash, domain. Performs an implicit "loose" search
                        when searching locally
  --loose               Allow loose search by disabling email pattern
                        recognition. Use spaces as pattern seperators
  -c CONFIG_FILE [CONFIG_FILE ...], --config CONFIG_FILE [CONFIG_FILE ...]
                        Configuration file for API keys. Accepts keys from
                        Snusbase, WeLeakInfo, Leak-Lookup, HaveIBeenPwned,
                        Emailrep, Dehashed and hunterio
  -o OUTPUT_FILE, --output OUTPUT_FILE
                        File to write CSV output
  -bc BC_PATH, --breachcomp BC_PATH
                        Path to the breachcompilation torrent folder. Uses the
                        query.sh script included in the torrent
  -sk, --skip-defaults  Skips HaveIBeenPwned and HunterIO check. Ideal for
                        local scans
  -k CLI_APIKEYS [CLI_APIKEYS ...], --apikey CLI_APIKEYS [CLI_APIKEYS ...]
                        Pass config options. Supported format: "K=V,K=V"
  -lb LOCAL_BREACH_SRC [LOCAL_BREACH_SRC ...], --local-breach LOCAL_BREACH_SRC [LOCAL_BREACH_SRC ...]
                        Local cleartext breaches to scan for targets. Uses
                        multiprocesses, one separate process per file, on
                        separate worker pool by arguments. Supports file or
                        folder as input, and filepath globing
  -gz LOCAL_GZIP_SRC [LOCAL_GZIP_SRC ...], --gzip LOCAL_GZIP_SRC [LOCAL_GZIP_SRC ...]
                        Local tar.gz (gzip) compressed breaches to scans for
                        targets. Uses multiprocesses, one separate process per
                        file. Supports file or folder as input, and filepath
                        globing. Looks for 'gz' in filename
  -sf, --single-file    If breach contains big cleartext or tar.gz files, set
                        this flag to view the progress bar. Disables
                        concurrent file searching for stability
  -ch [CHASE_LIMIT], --chase [CHASE_LIMIT]
                        Add related emails from hunter.io to ongoing target
                        list. Define number of emails per target to chase.
                        Requires hunter.io private API key if used without
                        power-chase
  --power-chase         Add related emails from ALL API services to ongoing
                        target list. Use with --chase
  --hide                Only shows the first 4 characters of found passwords
                        to output. Ideal for demonstrations
  --debug               Print request debug information
  --gen-config, -g      Generates a configuration file template in the current
                        working directory & exits. Will overwrite existing
                        h8mail_config.ini file
```

-----

## :tangerine: Usage examples

###### Query for a single target

```bash
$ h8mail -t target@example.com
```

###### Query for list of targets, indicate config file for API keys, output to `pwned_targets.csv`
```bash
$ h8mail -t targets.txt -c config.ini -o pwned_targets.csv
```

###### Query a list of targets against local copy of the Breach Compilation, pass API key for [Snusbase](https://snusbase.com/) from the command line
```bash
$ h8mail -t targets.txt -bc ../Downloads/BreachCompilation/ -k "snusbase_token=$snusbase_token"
```

###### Query without making API calls against local copy of the Breach Compilation
```bash
$ h8mail -t targets.txt -bc ../Downloads/BreachCompilation/ -sk
```

###### Search every .gz file for targets found in targets.txt locally, skip default checks

```bash
$ h8mail -t targets.txt -gz /tmp/Collection1/ -sk
```

###### Check a cleartext dump for target. Add the next 10 related emails to targets to check. Read keys from CLI

```bash
$ h8mail -t admin@evilcorp.com -lb /tmp/4k_Combo.txt -ch 10 -k "hunterio=ABCDE123"
```
###### Query username. Read keys from CLI

```bash
$ h8mail -t JSmith89 -q username -k "dehashed_email=user@email.com" "dehashed_key=ABCDE123"
```

###### Query IP. Chase all related targets. Read keys from CLI


```bash
$ h8mail -t 42.202.0.42 -q ip -c h8mail_config_priv.ini -ch 2 --power-chase
```

###### Fetch URL content (CLI + file). Target all found emails


```bash
$ h8mail -u "https://pastebin.com/raw/kQ6WNKqY" "list_of_urls.txt"
```


-----
