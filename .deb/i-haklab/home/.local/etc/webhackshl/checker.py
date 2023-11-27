#!/usr/bin/python2
# encoding: utf-8
#    This program is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program.  If not, see <http://www.gnu.org/licenses/>.

import os
isgzip=os.path.isfile("/data/data/com.termux/files/usr/bin/gzip") or os.path.isfile("/data/data/com.termux/files/usr/bin/gzip")
isjohn=os.path.isfile("/data/data/com.termux/files/usr/bin/john") or os.path.isfile("/data/data/com.termux/files/usr/sbin/john")
istor=os.path.isfile("/data/data/com.termux/files/usr/bin/tor")
isrb=os.path.isfile("/data/data/com.termux/files/usr/bin/ruby")
isnm=os.path.isfile("/data/data/com.termux/files/usr/bin/nmap")
isfierce=os.path.isfile("/data/data/com.termux/files/usr/bin/fierce") or os.path.isfile("/data/data/com.termux/files/usr/bin/fierce.pl")
ismap=os.path.isfile("/data/data/com.termux/files/usr/bin/sqlmap")
isenum=os.path.isfile("/data/data/com.termux/files/usr/bin/dnsenum")
isnikto=os.path.isfile("/data/data/com.termux/files/usr/bin/nikto")
iswhatw=os.path.isfile("/data/data/com.termux/files/usr/bin/whatweb")
iswp=os.path.isfile("/data/data/com.termux/files/usr/bin/wpscan")
iscurl=os.path.isfile("/data/data/com.termux/files/usr/bin/curl")
isgit=os.path.isfile("/data/data/com.termux/files/usr/bin/git")

def distribucion():
    global DISTRO
    if os.path.isfile("/data/data/com.termux/files/usr/libexec/termux/command-not-found") or os.path.isfile("/data/data/com.termux/files/usr/etc/apt/sources.list"):
        print ("Usted está usando una distribución basada en Linux!\n")
        DISTRO="kalideb"
    elif os.path.isfile("/etc/arch-release") or os.path.isfile("/etc/pacman.conf"):
        print ("Usted está usando una distribución basada en ArchLinux!'\n")
        DISTRO="ArchLinux"
    else:
        print ("Distribución Linux desconocida.")


def cRojo(prt): print("\033[91m {}\033[00m" .format(prt))
def cVerde(prt): print("\033[92m {}\033[00m" .format(prt))
def cAmarillo(prt): print("\033[93m {}\033[00m" .format(prt))
def cMoradoclaro(prt): print("\033[94m {}\033[00m" .format(prt))
def cMorado(prt): print("\033[95m {}\033[00m" .format(prt))
def cCian(prt): print("\033[96m {}\033[00m" .format(prt))
def cGrisclaro(prt): print("\033[97m {}\033[00m" .format(prt))
def cNegro(prt): print("\033[98m {}\033[00m" .format(prt))

def bspc():
    print("")

def checkarch():
    global archb
    cCian("verificando si existen los repositorios de BlackArch")
    archb=os.system("cat /etc/pacman.conf | grep 'blackarch'")
    if archb == 0:
        cRojo("Los repositorios de BlackArch Existen")
    else:
        cRojo("Los Repositorios de BlackArch No existen y se añadiran para continuar")
        os.system("sudo echo -e '\n[blackarch]\nSigLevel = Never\nServer = https://www.blackarch.org/blackarch/$repo/os/$arch' | sudo tee -a /etc/pacman.conf")


def checkali():
    cCian("verificando si existen los repositorios de Termux")
    global kalic
    kalic=os.system("cat /data/data/com.termux/files/usr/etc/apt/sources.list | grep 'deb https://termux.net stable main'")
    if kalic == 0:
        cRojo("Los repositorios de Termux Existen")
    else:
        cRojo("Los Repositorios de Termux NO existen y se añadiran para continuar")
        os.system("echo -e '\n# The main termux repository:\ndeb https://termux.net stable main | tee -a /data/data/com.termux/files/usr/etc/apt/sources.list")
#        cAmarillo("Importando las claves de Termux/Linux para ejecutar la instalacion...")
#        os.system("wget -q -O - archive.kali.org/archive-key.asc | sudo apt-key add")

def updatetools(DISTRO):
    respuesta=input("Introduce tu opcion y=continua con la instalación, n=anula la instalación. y/n: ")
    if respuesta=="y" and DISTRO== "kalideb":
#        cAmarillo("Para realizar esta instalación necesitas privilegios root o sudo, por favor introduzca tus credenciales cuando se le soliciten.")
        cAmarillo("Añadiendo el repositorio temporal de Termux a tu lista de repositorios ...")
        print ("")
        cAmarillo("Actualizando tu lista de paquetes ...")
        os.system("apt update")
        cAmarillo("actualizando Herramientas del sistema...")
        correctinstall=os.system("apt install nmap ruby git curl tor gzip python && cd modules/tplmap/ && git pull && cd ../../joomlavs/ && git pull")
        if correctinstall==0:
            print ("")
            cVerde("La actualizacion se realizo correctamente.")
            cVerde("Todo lo necesario esta actualizado, procediendo.")
        else:
            cVerde("Ha ocurrido un error.")

    elif respuesta=="y" and DISTRO== "ArchLinux":
        cAmarillo("Para realizar esta instalación necesitas privilegios root o sudo, por favor introduzca tus credenciales cuando se le soliciten.")
        print ("")
        cAmarillo("Actualizando tu lista de paquetes ...")
        os.system("sudo pacman -Syu")
        cAmarillo("Actualizando Herramientas del sistema...")
        correctinstall=os.system("sudo pacman --needed --asdeps -Syu nmap fierce sqlmap dnsenum nikto whatweb wpscan ruby git curl tor gzip john python2  python2-requests  python2-yaml  python2-flask && cd modules/tplmap/ && git pull && cd ../../joomlavs && git pull")
        if correctinstall==0:
            print ("")
            cVerde("La actualizacion se realizo correctamente.")
            cVerde("Todo lo necesario esta actualizado, procediendo.")
        else:
            cRojo("Ha ocurrido un error.")
    elif respuesta == "n":
        cAmarillo("Actualizacion abortada, saliendo ...")
        os._exit(0)
    else:
        cRojo("Opcion incorrecta.")
        updatetools(DISTRO)

def repokali():
    respuesta=input("Introduce tu opcion y=continua con la instalación, n=anula la instalación. y/n: ")
    if respuesta=="y":
#        cAmarillo("Para realizar esta instalación necesitas privilegios root o sudo, por favor introduzca tus credenciales cuando se le soliciten.")
        print ("")
        cAmarillo("Actualizando tu lista de paquetes ...")
        os.system("apt update")
        cAmarillo("actualizando Herramientas del sistema...")
        installcorrect=os.system("apt install nmap ruby git curl tor gzip python")
        if installcorrect == 0:
            print ("")
            cRojo("La actualizacion se realizo correctamente.")
            cRojo("Todo lo necesario esta actualizado, procediendo.")
        else:
            print ("Ha ocurrido un error, intentando nuevamente.")
            repokali()
    elif respuesta == "n":
        cAmarillo("Actualizacion abortada, saliendo ...")
        os._exit(0)
    else:
        cRojo("Opcion incorrecta.")
        updatetools(DISTRO)

def repoarch():
    respuesta=input("Introduce tu opcion y=continua con la instalación, n=anula la instalación. y/n: ")
    if respuesta=="y":
        cAmarillo("Para realizar esta instalación necesitas privilegios root o sudo, por favor introduzca tus credenciales cuando se le soliciten.")
        print ("")
        cAmarillo("Actualizando tu lista de paquetes ...")
        os.system("sudo pacman -Syu")
        cAmarillo("Actualizando herramientas del sistema...")
        installcorrect=os.system("sudo pacman --needed --asdeps -Syu nmap fierce sqlmap dnsenum nikto whatweb wpscan ruby git curl tor gzip john python2  python2-requests  python2-yaml  python2-flask")
        if installcorrect == 0:
            print ("")
            cRojo("La actualizacion se realizo correctamente.")
            cRojo("Todo lo necesario esta actualizado, procediendo.")
        else: 
            print ("Ha ocurrido un error, intentandolo de nuevo.")
            repoarch()
    elif respuesta == "n":
        cAmarillo("Actualizacion abortada, saliendo ...")
        os._exit(0)
    else:
        cRojo("Opcion incorrecta.")
        updatetools(DISTRO)

def installall(DISTRO):
    cRojo("""Para que este framework funcione correctamente, necesitas tener instaladas las siguientes herramientas:
    nmap, fierce, sqlmap, dnsenum, nikto, john, gzip, tor, curl, ruby, whatweb & wpscan. Al parecer hay herramientas faltantes en tu sistema!.
    """)
    decision=input("Introduce tu opcion y=continua con la instalación, n=anula la instalación. y/n: ")
    if decision=="y" and DISTRO == "kalideb":
#        cRojo("Para realizar esta instalación necesitas privilegios root o sudo, por favor introduzca tus credenciales cuando se le soliciten.")
        print ("")
        cAmarillo("Actualizando tu lista de paquetes ...")
        os.system("apt update")
        os.system("clear")
        cAmarillo("Instalando los paquetes ...")
        os.system("apt install nmap ruby git curl tor gzip python")

        print ("")
        os.system("clear")
        cVerde("La instalacion se realizo correctamente.")
        cVerde("Todo lo necesario esta instalado, procediendo.")
    elif decision == "y" and DISTRO == "ArchLinux":
        cRojo("Para realizar esta instalación necesitas privilegios root o sudo, por favor introduzca tus credenciales cuando se le soliciten.")
        print ("")
        cAmarillo("Actualizando tu lista de paquetes ...")
        os.system("sudo pacman -Syu")
        os.system("clear")
        cAmarillo("Instalando los paquetes ...")
        correctinstall=os.system("sudo pacman --needed --asdeps -Syu nmap fierce sqlmap dnsenum nikto whatweb wpscan ruby git curl tor gzip john python2  python2-requests  python2-yaml  python2-flask")
        if correctinstall == 0:
            print ("")
            os.system("clear")
            cVerde("La instalacion se realizo correctamente.")
            cVerde("Todo lo necesario esta instalado, procediendo.")
        else:
            cRojo("Ha ocurrido un error, intentando de nuevo.")
            installall(DISTRO)
    elif decision == "n":
        print ("Instalación abortada, saliendo ...")
        os._exit(0)
    else:
        print ("Opcion incorrecta.")
        installall(DISTRO)

def check():
    if isnm and isfierce and ismap and isenum and isnikto and iswhatw and iswp and isrb and isgit and iscurl and istor and isgzip and isjohn:
        cVerde("Todo lo necesario esta instalado, procediendo.")
    else:
        distribucion()
        if DISTRO == "kalideb":
            checkali()
            if kalic == 0:
                repokali()
            else:
                installall(DISTRO)
        elif DISTRO == "ArchLinux":
            checkarch()
            if archb == 0:
                repoarch()
            else:
                installall(DISTRO)

#def checklogs():
#    toolsdirs=['whatweb', 'nikto', 'nmap-full', 'nmap-rapido', 'nmap-servhost', 'nmap-serviciosver', 'nmap-puertorango', 'nmap-so-host', 'dnsenum', 'bypass']
#    for dtool in toolsdirs:
#        if os.path.isdir("./modules/logs/"+dtool):
#            pass
#        else:
#            os.makedirs("./modules/logs/"+dtool)
#            pass

def dtor():
    cVerde("Verificando que el servicio TOR esté activo...")
    tor=os.system("netstat -ant | grep -oE 9050 > /dev/null")
    if tor == 0:
        cVerde("0K - TOR")
        pass
    else:
        cRojo("Necesitas iniciar TOR")
        resp = input("¿Deseas ininiciar el servicio ahora? y/n : ")
        if resp=="y":
            cAmarillo("Iniciando TOR...")
            os.system("tor & > /dev/null")
            dtor()
        elif resp=="n":
            cRojo("Algunas opciones no funcionaran.")
            pass
        else:
            print ("Opción invalida.\n")
            dtor()

def gems():
    os.system("PATH=`ruby -e 'puts Gem.user_dir'`/bin:$PATH")
    cVerde("Verificando que Bundler está en el sistema, esto puede tomar varios minutos la primera vez...")
    gem=os.system("bundle | grep -q 'Bundle complete!'")
    if gem == 0:
        cVerde("0K - Bundler")
        pass
    else:
        def gemsinstall():
            cRojo("""Necesitas instalar Bundler, procediendo a la instalación.
    Bundler es requerido por un escanner de vulnerabilidades.
    Esto puede tomar un tiempo.""")
            inst = input("Deseas continuar con la instalación? y/n : ")
            if inst=="y":
                os.system("PATH=`ruby -e 'puts Gem.user_dir'`/bin:$PATH")
                cAmarillo("Instalando bundler...")
                correctgem=os.system("gem install bundler && bundle install")
                if correctgem==0:
                    pass
                else:
                    cRojo("Las gemas no se instalaron correctamente, por favor asegurate de estar dentro de la carpeta de webhackshl. esto traera problemas en la opcion d) del menú usando joomlavs. Continuando...")
                    pass
            elif inst=="n":
                cRojo("Instalacion cancelada, esto traera problemas en la opcion d) del menú usando joomlavs. Continuando...")
                pass
            else:
                print ("Opción incorrecta.\n")
                gemsinstall()
        gemsinstall()

def utools():
    distribucion()
    updatetools(DISTRO)
