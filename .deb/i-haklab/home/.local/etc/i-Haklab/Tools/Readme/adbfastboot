¿Qué es ADB y Fasboot?
Las siglas ADB significan Android Debug Bridge y se corresponden con una herramienta de software que nos permite interactuar con nuestro smartphone Android. Así, por ejemplo, a través de ADB podemos ejecutar comandos para copiar archivos desde termux al teléfono, del teléfono a Termux o reiniciar el dispositivo en el modo bootloader.

El Fastboot también es una herramienta de software con la que podemos comunicarnos y modificar partes de un smartphone Android (conectado a través de un cable USB). Con Fastboot vamos a poder desbloquear el bootloader, flashear un recovery, flashear el firmware completo o reiniciar el dispositivo en modo recovery.

(i-Haklab)-(~)
└──┤ adb flash all bat

Flasheando por completo el software.
Básicamente, desde Termux con ADB podemos comunicarnos con un smartphone Android que está encendido y su sistema Android funcionando, con Fastboot podemos cominicarnos con el dispositivo Android cuando lo hemos arrancado en modo bootloader.

Con estas dos herramientas vamos a poder cambiar profundamente el software de nuestro smartphone o por lo menos acceder a él y realizar la sustraccion de datos. Por supuesto, todo esto se hace posible a través de un cable USB para conectar el smartphone a nuestro Termux.

Activar la depuración USB
Para que nuestro android reconozca el dispositivo necesitamos activar la depuración por USB. En Ajustes > Información del teléfono pulsaremos varias veces sobre 'Número de compilación' hasta que aparezcan las opciones de desarrollo. Ahora entraremos en estas opciones y activaremos la 'Depuración por USB'.

ADB es una parte fundamental de Android Studio, el software para desarrollar aplicaciones en Android. Para obtener ADB en nuestro Termux solo debemos ejecutar los siguientes 5 comandos :

Primero vamos a crear un directorio adbfiles en $HOME. 
mkdir -p $HOME/adbfiles

Posteriormente descargamos los ejecutables :
wget https://raw.githubusercontent.com/ivam3/i-Haklab/master/.set/bin/adb -P $PREFIX/bin/adb 
wget https://raw.githubusercontent.com/ivam3/i-Haklab/master/.set/bin/adb.bin -P $PREFIX/bin/adb.bin
wget https://raw.githubusercontent.com/ivam3/i-Haklab/master/.set/bin/fastboot -P $PREFIX/bin/fastboot
wget https://raw.githubusercontent.com/ivam3/i-Haklab/master/.set/bin/fastboot-armeabi -P $PREFIX/bin/fastboot-armeabi

Primeros Pasos:
1.-Conecta tu dispositivo Android y Termux con adb a una red Wi-Fi común a la que ambos puedan acceder. Ten en cuenta que no todos los puntos de acceso son adecuados; quizá necesites usar un punto de acceso cuyo firewall esté configurado correctamente para admitir adb.

2.-Conecta el Android a Termux con adb con un cable USB.

3.-Configura el dispositivo de destino para que busque una conexión TCP/IP en el puerto 5555 con:
(Victima)-(~)
└──┤ adb tcpip 5555
Si no se tiene adb en el dispositivo victima utilizamos la aplicación Bugjaeger.

4.-Desconecta el cable USB del dispositivo de destino.

5.-Busca la dirección IP del dispositivo Android. Por ejemplo, puedes encontrar la dirección IP en Configuración > Acerca del dispositivo > Estado > Dirección IP. O desde la aplicacion Bugjaeger ennla opcion "Get wifi IP address".

6.-Realiza la conexion via adb de Termux con el dispositivo Android.
(i-Haklab)-(~)
└──┤ adb connect <ip del dispositivo>:5555

LISTO NUESTRA CONEXION ADB.....

Comandos ADB más importantes :
(i-Haklab)-(~)
└──┤ adb devices
Con este comando obtenemos una lista de todos los dispositivos conectados. Esto es muy útil para saber que nuestro dispositivo ha sido reconocido y en el caso de que conectemos más de un dispositivo a la vez.

(i-Haklab)-(~)
└──┤ adb reboot
Con esta instrucción reiniciaremos nuestro teléfono.

(i-Haklab)-(~)
└──┤ adb reboot-recovery
Para reiniciar en modo recovery, por si necesitamos instalar algún archivo zip desde aquí.

(i-Haklab)-(~)
└──┤ adb reboot-bootloader
Para reiniciar nuestro dispositivo en modo bootloader, para poder usar el fastboot.

(i-Haklab)-(~)
└──┤ adb logcat > logcat.txt
Con este comando vamos a poder guardar el logcat por si tenemos problemas y necesitamos ayuda. Este es el registro de todas las operaciones que realiza el dispositivo.

(i-Haklab)-(~)
└──┤ adb push $HOME/cualquier-archivo.txt /sdcard/downloads
Este comando copia el archivo especificado desde nuestro termux hacia el smartphone. Las rutas de archivo del comando son a modo de ejemplo, por tanto se tienen que adaptar en cada caso. Primero la ruta del archivo que está en termux y luego la ruta donde lo quieres copiar en el smartphone.

(i-Haklab)-(~)
└──┤ adb pull /sdcard/downloads/document.pdf $HOME/carpeta
Con este comando conseguimos lo contrario que con el anterior, esto es, cargar un archivo desde nuestro smartphone/tablet a Termux. De nuevo, las rutas se tienen que adaptar a cada caso. Ahora ponemos primero la ruta del archivo en el smartphone y detrás la ruta en Termux.

(i-Haklab)-(~)
└──┤ adb shell screencap -p /sdcard/screenshot.png
(i-Haklab)-(~)
└──┤ adb pull /sdcard/screenshot.png
(i-Haklab)-(~)
└──┤ adb shell rm /sdcard/screenshot.png
Estos comandos sirven para crear una captura de pantalla de nuestro teléfono que quedará almacenada en la ruta que elijamos del smartphone.

(i-Haklab)-(~)
└──┤ adb sideload update.zip
A través de este comando conseguimos actualizar oficialmente de forma manual nuestro smartphone.

(i-Haklab)-(~)
└──┤ adb install "$HOME/WhatsApp.apk"
Como puedee deducir, éste sirve para instalar una APK, una aplicación, en nuestro smartphone. Para ello tenemos que indicar la ruta completa de donde se encuentra la aplicación. Las comillas son necesarias si los nombre de las carpetas o archivos tienen espacios, si no los tienen las puedes omitir.

(i-Haklab)-(~)
└──┤ adb backup -f FullBackup.ab -apk -all
Con este comando vamos hacer una copia de seguridad de todas las aplicaciones con sus datos. En la práctica no todas las aplicaciones son compatibles con la copia de seguridad a través de ADB, así que la restauración puede ser un poco tortuosa y llena de sorpresas.

(i-Haklab)-(~)
└──┤ adb help
Muestra en pantalla todos y cada uno de los comandos que se pueden ejecutar con ADB junto a una descripción general.


Comandos Fastboot más importantes

(i-Haklab)-(~)
└──┤ fastboot devices
Con este comando obtenemos una lista de todos los dispositivos conectados. Esto es muy útil para saber que nuestro dispositivo ha sido reconocido y en el caso de que conectemos más de un dispositivo a la vez.

(i-Haklab)-(~)
└──┤ fastboot oem unlock
Con esta instrucción vamos a poder desbloquear el bootloader del dispositivo. En algunos casos vamos a tener que añadir a esta instrucción un código de desbloqueo que nos va a facilitar el fabricante de nuestro smartphone.

(i-Haklab)-(~)
└──┤ fastboot reboot
Para reiniciar el dispositivo de forma normal.

(i-Haklab)-(~)
└──┤ fastboot reboot-bootloader
Para volver a reiniciar en modo bootloader y seguir usando Fastboot.

(i-Haklab)-(~)
└──┤ fastboot flash "partición" "archivo.img"
Para flashear una partición del dispositivo como: recovery, boot, radio o system. Con esta instrucción podemos instalar un custom recovery o flashear una nuevo firmware al completo.

#	@Ivam3
