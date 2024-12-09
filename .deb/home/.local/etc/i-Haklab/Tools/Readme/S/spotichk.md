# SpotiChk v5.0.1

## Introducción

Checkea cuentas de Spotify desde tu celular. Este proyecto tiene fines educativos y/o demostrativos.

Tenemos un grupo en facebook > https://www.facebook.com/groups/303634613546969/

Video de instalacion > https://www.youtube.com/watch?v=pzISUIWEuMw

## Novedades
> - API cambiada.
> - Mejora en la velocidad de checkeo.
> - Guardado de cuentas en un archivo *.txt.
> - Mejora en la interfaz cli.
> - Checkeo de version.

## Instalación

Checker De SPOTIFY [TERMUX]

Como todos preguntan "¿Qué es Termux?"
Bueno *Termux* es un emulador de terminal linux para android... lo mismo que en la pc pero mas barato.... [Termux está en la play store (gratis)]

Hay que tener un combo [Nulled Foro (o otros foros/paginas) para Descargar combos] (deben de registrarse y ya)
Tambien el Es File Explorer para encontrar la ruta del archivo.

Una ves descargado TERMUX y el CHECKER de Spotify y el COMBO hay que actualizar paquetes... De Termux
Y darle permiso a termux en nuestro terminal...

A los que no les pide actualizar paquetes ponen directo el 2do comando y aceptar (enter). 
1. apt update&&apt upgrade -y

2. termux-setup-storage

INSTALAMOS PHP y GIT para clonar el repositorio...

3. pkg install php git -y

4. git clone https://github.com/Juni0r007/SpotiChk.git

5. ls

6. cd SpotiChk

Ejecutamos el archivo *.php 

Antes de eso hay que darle permisos de ejecución al script

7. chmod +x spotichk.php

8. php spotichk.php

Les sale el Checker de spotify

## Uso

Si descargaron el combo, ahi lo unico que se debe hacer es poner la ruta completa del COMBO que estará en la carpeta de Download 
> Van con el Es File hasta donde esta en combo y presionan un rato sobre el archivo -> Propiedades -> Copiar ruta completa y se van a termux y pegan esa ruta.

Y lo pegan, empezara el checkeo  y esperar a que les muestre una premiun.[Autopay].

> Una vez terminado el proceso de chekeo o cuando cancele manualmente el mismo, el script le pedira si quiere guardar las cuentas obtenidas en un archivo de texto (dentro de su memoria interna) si quiere guardar escriba la letra "s" y consiguiente escriba solo el nombre el archivo a crear, de lo contrario solo escriba la letra "n".

No es necesario utilizar proxys ni una vpn activa.

¿Que es una cuenta Auto Pagable o AutoPay? 

Son cuentas  obtenidas con Sentry MBA y PasteBin [Termux pero no todas] en si estas son 100% reales por lo cual las paga una persona y si cambias la contraseña el dueño va cancelar la cuenta.

## Anexos

- Generador de combos en Termux > https://github.com/Juni0r007/PasTerm
