# Suite de Análisis Forense Móvil: `androforensic` 🕵️‍♂️🔍

La herramienta **`androforensic`** es un módulo de análisis forense digital y recolección de telemetría para dispositivos Android integrado de forma nativa en la suite **i-HakLab**. 

El script automatiza múltiples comandos avanzados de **ADB (Android Debug Bridge)** para extraer artefactos del sistema, registros de red, historial de hardware y datos de usuario de manera segura y no destructiva, sin necesidad de que el celular objetivo tenga permisos de superusuario (Root).

---

## ⚙️ Requisitos Previos

Antes de ejecutar la herramienta, asegúrate de cumplir con lo siguiente:
1. **ADB Activo**: i-HakLab comprueba automáticamente la existencia de `adb` (del paquete `android-tools`) y lo iniciará de fondo si es necesario.
2. **Conexión del Objetivo**: El dispositivo celular debe estar conectado físicamente a Termux (mediante cable USB y adaptador OTG) o de forma inalámbrica mediante la misma red de Wi-Fi (ver guía de [Depuración Inalámbrica](../../android/wireless-debugging.md)).
3. **Depuración USB**: Debes habilitar las *Opciones de Desarrollador* y activar la *Depuración por USB* en el dispositivo objetivo, aceptando la ventana emergente de confirmación de huella digital de la clave.

---

## 🚀 Sintaxis de Ejecución y Subcomandos

La suite se ejecuta mediante el comando principal seguido del subcomando de diagnóstico deseado:

```bash
androforensic <subcomando> [opciones]
```

### 1. `androforensic airscope` (Radar Wi-Fi)
Este comando actúa como un radar pasivo de redes inalámbricas locales aprovechando la tarjeta Wi-Fi del celular conectado.
* **Funcionamiento**: Desactiva temporalmente el Wi-Fi del dispositivo y lo vuelve a habilitar de forma inmediata para forzar un escaneo de red.
* **Procesamiento**: Captura las métricas de `dumpsys wifi`, aísla las tramas filtradas por SSID y BSSID, y las formatea en una tabla ordenada por potencia de señal (RSSI) en dBm:
  * **Verde (>= -70 dBm)**: Excelente señal.
  * **Amarillo (>= -85 dBm)**: Señal moderada.
  * **Rojo (< -85 dBm)**: Señal débil.
* **Salida**: Se imprime de forma colorida y tabulada en tiempo real en la pantalla.

### 2. `androforensic dumpsys [device_serial]`
Realiza un volcado masivo y ordenado de los servicios internos del sistema operativo Android.
* **Parámetro**: Opcionalmente, puedes pasar el número de serie del dispositivo si hay más de un móvil conectado.
* **Resultados**: Crea un directorio timestamp en la ruta de trabajo (`DumpSysReport_AAAAMMDD_HHMMSS/`) y genera **21 archivos de texto individuales** con la salida de diagnósticos específicos:
  * `meminfo.txt`: Estadísticas de uso y fragmentación de memoria RAM.
  * `sensorservice.txt`: Estado y actividad de sensores físicos (giroscopio, acelerómetro, luz).
  * `location.txt`: Historial y uso del servicio de geolocalización GPS.
  * `account.txt` / `persona.txt`: Cuentas registradas (Google, WhatsApp, etc.) y perfiles multiusuario.
  * `netstats.txt`: Consumo de datos detallado por aplicación.
  * `wifi.txt` / `usb.txt`: Historial y estados de conexiones de red Wi-Fi y periféricos USB.
  * `notification.txt` / `clipboard.txt`: Historial de notificaciones activas/leídas y del portapapeles.
  * `dropbox.txt`: Reportes detallados de cuelgues (crashes) y fallos del sistema.
  * `telecom.txt` / `fingerprint.txt`: Registros telefónicos del operador y configuraciones de biométricos.

### 3. `androforensic extract` (Extracción de Datos de Usuario)
Lanza un script exhaustivo de adquisición forense y triage digital que extrae datos de identidad y registros de comunicación personales.
* **Salida**: Los archivos se guardan en la carpeta `ADB_Report_AAAAMMDD_HHMMSS/` e incluyen:
  * `device_info.txt`: Modelo, fabricante, número de serie y versión de compilación de Android.
  * `registered.txt` / `emails.txt`: Listado de aplicaciones con cuentas activas y direcciones de correo electrónico registradas.
  * `contacts.txt` / `numbers.txt`: Volcado completo de contactos y números telefónicos.
  * `call_logs.txt` / `sms.txt`: Historial de llamadas realizadas/recibidas y mensajes SMS almacenados.
  * `packages_all.txt` / `packages_thirdparty.txt`: Aplicaciones instaladas (sistema y de terceros).
  * `logcat_snapshot.txt`: Captura de las últimas 1000 líneas del log del sistema.
  * **Reporte de Fallos (`bugreport.zip`)**: Lanza en segundo plano un `bugreportz` completo del dispositivo que tarda unos minutos en guardarse de forma desatendida.
* > ⚠️ **Nota de Seguridad**: En dispositivos con Android 11 o superior, las consultas de Content Providers (SMS, Contactos, Registro de llamadas) vía shell de ADB estándar están fuertemente restringidas por políticas del sistema, a menos que el dispositivo objetivo cuente con permisos de root.

### 4. `androforensic secretCodes` (Códigos Secretos de Marcado)
Realiza un escaneo del manifiesto y la configuración interna de todas las aplicaciones del sistema en busca de códigos de marcado telefónico secretos (Dialer/USSD codes, del tipo `*#*#...#*#*`).
* **Funcionamiento**: Extrae la lista de paquetes del sistema y hace un dump de cada app buscando filtros de intención asociados al esquema `"android_secret_code"`.
* **Salida**: Muestra los códigos en texto claro ordenados por paquete en el archivo de reporte `Secret_Codes_AAAAMMDD_HHMMSS.txt`.

---

## 🗃️ Directorio de Trabajo y Logs
Todos los reportes e imágenes generadas durante la ejecución de las herramientas se guardan de forma organizada en la ruta local:
`~/.local/share/androforensic/`

---

## 👥 Créditos
* **Douglas Habian**: Autor original de los scripts de recolección de dumpsys, extracción de datos y búsqueda de códigos secretos integrados en este módulo de i-HakLab.
