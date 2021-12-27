# i-Haklab v.3.0 2021 by @Ivam3

	DISCLAIMER
We do NOT promote cyber crime!
These materials are for educational and research purposes only.

To get help about how to use it join to irc chat in i-Haklab command :

        $ i-Haklab weechat

To report some issues or get a personal help join to our [TELEGRAM BOT](https://t.me/ivam3_bot)

# What is Termux?

- Termux is a terminal emulator application that shares the same environment of the Android operating system by starting the command line of the program (shell) using the system call (execve) and redirecting the input, output and standard error flows to the screen. Termux has a vast number of packages under the APT|PKG manager compiled with Android NDK and patched for compatibility, generally available on GNU/Linux systems.

# What is i-Haklab ?

- i-Haklab is a hacking laboratory for Termux that contains open source tools for osint, pentesting, scan/find vulnerabilities, explotation and post-explotation recommended for me(Ivam3) with automation commands, a many guides, books and tutorials to learn how to use tools. i-Haklab use oh my fish insteractive shell to provide core infrastructure to allow you to install packages which extend or modify the look of your termux.
To get help about its use going to [OMF official site](https://fishshell.com/docs/current/tutorial.html).

# Process during installation

i-Haklab will ......
- Install the command [sudo], wich provides a real root enviroment if your android device has some root mannager otherwise it provides a fake root eviroment.
- check if termux has permission to access the external memory, cuz in there it will create a directory called 'tools' which in there will install the tools and/or frameworks. otherwise they will be installed in the directory /data/data/com.termux/files/home/.local/share/tools. By the way, in case of Termux is installed in a second partition of your external memory those will be in /data/sdext2/data/com.termux/files/home/.local/share/tools.
- i-Haklab has more than 100 tools of which only the main ones are installed (15) with a total weight of 3.9GB. -DoS-A-Tool -ExiF -Binchecker -Blackbox -Crunch -Torvpn -Tmate -Translate -Metasploit -Java -Wireshark -Nmap -H8mail -Objection So, you can see the list of all tools available under the command:

        ]> i-Haklab show alltools

- The rest of the tools can be installed or removed by:

        ]> i-Haklab install/remove <name of tools>

- Either install or uninstall all at once:

        ]> i-Haklab install/remove alltools

- Once tools/frameworks installation ended the OMF shell configuration will the next. on it, i-Haklab will activate the OMF shell, and you will notice it when a welcome message to the new shell appears ... when this happens you will have to wait 2min and execute the command "exit" for the continuation of its installation.

# COMMANDS

There are several commands in i-Haklab that facilitate the use of Termux:

- i-Haklab: it is the main command that helps to update and use i-Haklab with automations of various processes such as the installation/uninstallation of tools, visualization of user guides for the tools, download of hacking books, access to the community tutorials, payload creation automation, metaploit handler activation, brute force attacks among others.

- run: facilitates the execution of all external tools adapted to Termux by i-Haklab. Termux natives such as nmap run directly.

- LOCALHOST: returns the private ip of your local network

- omf theme name-of-theme: change the shell theme.

- tornvpn: enable tor connection by proxychains4.

- sudo some-commands: run commands as fake root user.

- serverphp: activates the php server.

- serverapache: activates the apache server.

- postgresql start / stop / restart: enables stops and restarts the metasploit database.

- traductor: init a shell to traslate any text.

- vncserver: init a GUI client-server.

- vncserver kill :1: kill the client-server.

- IbyC-fixer: we know that each Android is different and this can generate various errors in the installation processes of ruby gems, python modules, among others. And this command is the i-Haklab solver that automates the solving processes.

- lock: Block the termux screen and it will only be unlocked with said password or answering the security question. It is worth mentioning that these access codes are encrypted for your security.

# Desktop enviroment

i-Haklab automates the installation and configuration of a graphical environment with the xfce4 windows manager, which opens up the possibility of running tools such as wireshark and burpsuite. For this, the installation of the [Termux:Wayland](https://github.com/termux/termux-x11) application is required. Once installed it to run this enviroment just execute:

         ]> run Xwayland

# IRC CHAT Ivam3byCinderella

IRC (Internet Relay Chat) is an application layer protocol that facilitates communication in the form of text. The chat process works on a client/server networking model. Under the command <i-Haklab> we will find the <weechat> argument, with which you can join the official IRC Ivam3byCinderella where u can contact another i-Haklab.

If you want to suggest some tool, do it in the section of suggestions of our [Telegram BOT](https://t.me/Ivam3_Bot).

# BOOKS AVAILABLES

- Aprende html
- Chema alonso coleccion
- Comandos basicos linux
- Cracking sin secretos
- Conviertete en hacker by incube2
- Ethical hacking
- Hacking con python
- Hacking etico 101
- Hacking mexico seguridadofensiva nv.1
- Hacking the hacker
- Manual hacking dispositivos moviles
- Metasploit para pentesters
- My sql
- Nmap by computaxion
- Programa en C
- Programa en C++
- Programa en bash
- Programacion en perl
- Programacion en php
- Programacion en ruby
- Python para todos

If you want to suggest some book do it in the section of suggestions of our [Telegram BOT](https://t.me/Ivam3_Bot).

# UPDATE AT NEWEST VERSION 

i-Haklab is constantly updating tools and improvements. To stay updated you just have to run:

	 ]> i-Haklab update

- FOLLOW ME ON [ALL SOCIAL NETWORKS](https://wlo.link/@Ivam3)
