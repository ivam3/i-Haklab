AQUATONE del alemán Michael Henriksen es un conjunto de herramientas escritas en Ruby para realizar reconocimientos de nombres de dominio. Puede descubrir subdominios usando fuentes abiertas o mediante fuerza bruta usando un diccionario.

Después del descubrimiento de subdominios, AQUATONE puede escanear los hosts para identificar puertos web comunes. Además puede reunir y consolidar en un informe los encabezados HTTP, cuerpos HTML y capturas de pantalla para un análisis rápido de la superficie de ataque.

Antes de su uso debemos añadir nuestras keys de las APIs de Shodan y Virustotal:

$ aquatone-discover --set-key shodan o1hyw8pv59vSVjrZU3Qaz6ZQqgM91ihQ
$ aquatone-discover --set-key virustotal 132d0h354bd538656ek435876567b1g757945342347654as548f3264a8724g19

AQUATONE se divide en tres comandos, según queramos o no descubrir subdominios, escanear los hosts y/o obtener información de los servicios (gathering), cada una representando distintas fases que vemos a continuación:

#Fase 1: descubrimiento (aquatone-discover)

Lo primero que hace AQUATONE es consultar los DNS con la autoridad para el dominio objetivo. De esta manera se asegura que la información obtenida está actualizada. Luego hace una prueba rápida para ver si el dominio de destino está configurado para ser un dominio wildcard, si lo es, identificará las posibles respuestas wildcard y las filtrará. Posteriormente, procede a preguntar a cada módulo de para recopilar los subdominios:

- Diccionario brute force (ver diccionario aquí)
- DNSDB.org http://dnsdb.org/
- Informe de Transparencia de Google
- HackerTarget
- Netcraft
- Shodan (requiere clave de API)
- ThreatCrowd
- VirusTotal (requiere clave de API)

El comando básico es el siguiente:

$ aquatone-discover --domain example.com

Por defecto tirará 5 hilos, si queremos aumentar el número para que vaya más rápido podemos usar el parámetro --threads:

$ aquatone-discover --domain example.com --threads 25

Si por el contrario no queremos hacer mucho ruido podemos espaciar cada consulta DNS cada el número de segundos que especifiquemos con --sleep y un retardo variable con --jitter para evadir posibles IDS:

$ aquatone-discover --domain example.com --sleep 5 --jitter 30

AQUATONE descubre los servidores DNS que resuelven los nombres de dominio objetivo y reparte las consultas entre ellos. Si las consultas hacia estos DNS fallan por defecto realizará las consultas a los DNS de Google para maximizar los resultados. Podemos especificar también otros DNS de "reserva" con:

$ aquatone-discover --domain example.com --fallback-nameservers 87.98.175.85,5.9.49.12

Una vez finalizado el descubrimiento de dominios y subdominios los resultados se almacenarán en el fichero hosts.txt y hosts.json para facilitar el parseo.

#Fase 2: escaneo (aquatone-scan)

La etapa de escaneo es donde AQUATONE enumera los servicios web/puertos TCP abiertos en los hosts descubiertos anteriormente:

$ aquatone-scan --domain example.com

De forma predeterminada, aquatone-scan buscará en cada host presente en el fichero hosts.json los siguientes puertos TCP: 80, 443, 8000, 8080 y 8443. Estos son puertos muy comunes para servicios web y proporcionan una cobertura razonable, pero si queremos especificar nuestra propia lista de puertos, podemos utilizar la opción --ports:

$ aquatone-scan --domain example.com --ports 80,443,3000,8080

En lugar de una lista de puertos separados por comas, también podemos especificar algunos alias predefinidos:

- small: 80, 443
- medium: 80, 443, 8000, 8080, 8443 (same as default)
- large: 80, 81, 443, 591, 2082, 2095, 2096, 3000, 8000, 8001, 8008, 8080, 8083, 8443, 8834, 8888, 55672
- huge: 80, 81, 300, 443, 591, 593, 832, 981, 1010, 1311, 2082, 2095, 2096, 2480, 3000, 3128, 3333, 4243, 4567, 4711, 4712, 4993, 5000, 5104, 5108, 5280, 5281, 5800, 6543, 7000, 7396, 7474, 8000, 8001, 8008, 8014, 8042, 8069, 80

80, 8081, 8083, 8088, 8090, 8091, 8118, 8123, 8172, 8222, 8243, 8280, 8281, 8333, 8337, 8443, 8500, 8834, 8880, 8888, 8983, 9000, 9043, 9060, 9080, 9090, 9091, 9200, 9443, 9800, 9981, 11371, 12443, 16080, 18091, 18092, 20720, 55672

Por ejemplo:

$ aquatone-scan --domain example.com --ports large

Al igual que aquatone-discover, puede hacer el escaneado más o menos agresivo con la opción --threads que acepta un número de subprocesos para escaneos de puertos concurrentes. El número predeterminado de subprocesos es 5.

$ aquatone-scan --domain example.com --threads 25

Como aquatone-scan está realizando el escaneo de puertos, obviamente puede ser detectado por IDS. Si bien tratará de reducir el riesgo de detección mediante la asignación al azar de hosts y puertos, se puede ajustar también más con las opciones --sleep y --jitter como anteriormente. Hay que tener en cuenta que el parámetro --sleep forzará los subprocesos a 1.

#Fase 3: Gathering (aquatone-gather)

La etapa final es la parte de recopilación de información y análisis de los servicios web descubiertos, donde se guardan los encabezados de respuesta HTTP y los cuerpos HTML, además de tomar capturas de pantalla de las páginas web para facilitar el análisis. La captura de pantalla se realiza con la biblioteca Nightmare.js de Node.js que se instalará automáticamente si no está presente en el sistema.

Eso sí, si trabajás con Kali u otra distro que tenga previamente Node.js tendréis que instalarlo previamente:

$ pkg install nodejs -y

Luego el último comando será:

$ aquatone-gather --domain example.com

Aquatone-gather buscará hosts.json y open_ports.txt en el directorio de AQUATONE del dominio correspondiente y solicitará una captura de pantalla de cada dirección IP para cada nombre de dominio.

Al igual que aquatone-discover y aquatone-scan, puede hacer la recopilación más o menos agresiva con la opción --threads que acepta un número de subprocesos para las solicitudes concurrentes. El número predeterminado de subprocesos es también 5.

$ aquatone-gather --domain example.com --threads 25
