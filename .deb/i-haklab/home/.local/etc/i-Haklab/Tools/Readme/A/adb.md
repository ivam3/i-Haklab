I
https://developer.android.com/studio/command-line/adb



Configura el dispositivo de destino para que busque una conexión TCP/IP en el puerto 5555.    

adb tcpip 5555


`adb -s emulator-5555 shell`

``` bash
adb kill-server
```

```bash
adb start-server
```

``` bash
adb tcpip 5555 
```

``` bash
adb connect localhost:5555
``` 

```bash
adb devices
```
# Instalar apk 



```bash
$ adb -s $DEVICE_ID instalar -r  name.apk
```
