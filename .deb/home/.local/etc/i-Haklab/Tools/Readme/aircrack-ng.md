# Aircrack-ng

## ¿Qué es Aircrack-ng?

Aircrack-ng es una suite completa de herramientas de línea de comandos para la auditoría y seguridad de redes Wi-Fi. Es una de las herramientas más conocidas y utilizadas por profesionales de la seguridad y entusiastas para probar la robustez de las redes inalámbricas.

La suite no es una sola herramienta, sino un conjunto de utilidades que trabajan juntas para realizar diferentes tareas, desde la captura de paquetes hasta el "cracking" de contraseñas.

## ¿Para qué es útil la suite Aircrack-ng?

Aircrack-ng se utiliza para una variedad de propósitos relacionados con la seguridad Wi-Fi:

*   **Auditoría de seguridad:** Permite a los administradores de red y a los profesionales de la seguridad probar sus propias redes para encontrar y corregir vulnerabilidades.
*   **Monitoreo de red:** Captura el tráfico de una red inalámbrica para un análisis posterior.
*   **Recuperación de contraseñas:** Puede recuperar claves de redes WEP y WPA/WPA2-PSK. Esto es útil si has olvidado tu propia contraseña, pero también es la funcionalidad que la hace popular para ataques.
*   **Pruebas de penetración (Pentesting):** Es una herramienta estándar en el arsenal de cualquier pentester para evaluar la seguridad de la capa inalámbrica de una organización.
*   **Ataques:** Puede ser utilizada para realizar ataques de desautenticación (desconectar a un usuario de una red), crear puntos de acceso falsos, y otros ataques avanzados.

## Herramientas principales y su uso

La suite Aircrack-ng incluye varias herramientas. Aquí están las más importantes y su flujo de trabajo típico para un ataque a WPA/WPA2:

### 1. `airmon-ng` - Habilitar el modo monitor

Antes de que puedas capturar tráfico, necesitas poner tu tarjeta de red inalámbrica en "modo monitor". Este modo permite que la tarjeta escuche todo el tráfico Wi-Fi en el aire, no solo el que va dirigido a ella.

```bash
# Poner la interfaz wlan0 en modo monitor
sudo airmon-ng start wlan0
```
Esto creará una nueva interfaz, a menudo llamada `wlan0mon`.

### 2. `airodump-ng` - Capturar el tráfico

Esta herramienta se utiliza para escanear las redes Wi-Fi cercanas y capturar el tráfico. Para crackear una clave WPA/WPA2, el objetivo principal es capturar el "handshake" de 4 vías, que ocurre cuando un dispositivo se conecta a la red.

```bash
# Escanear redes en la interfaz wlan0mon
sudo airodump-ng wlan0mon

# Una vez que identificas tu objetivo (BSSID y canal),
# enfoca la captura en esa red para capturar el handshake.
sudo airodump-ng --bssid [BSSID_del_AP] -c [canal] -w captura wlan0mon
```
* `[BSSID_del_AP]` es la dirección MAC del punto de acceso.
* `[canal]` es el canal en el que opera la red.
* `-w captura` guarda los paquetes en archivos que empiezan con "captura".

### 3. `aireplay-ng` - Acelerar la captura (Opcional)

Si no hay dispositivos conectándose a la red, no habrá un handshake que capturar. Puedes usar `aireplay-ng` para forzar la desconexión de un cliente, lo que le obligará a volver a conectarse y así podrás capturar el handshake.

```bash
# Enviar paquetes de desautenticación a un cliente específico
sudo aireplay-ng -0 5 -a [BSSID_del_AP] -c [MAC_del_cliente] wlan0mon
```
* `-0 5` envía 5 paquetes de desautenticación.

### 4. `aircrack-ng` - Crackear la contraseña

Una vez que has capturado un handshake (airodump-ng te lo indicará), puedes usar `aircrack-ng` para intentar descifrar la contraseña. Esto se hace mediante un ataque de diccionario.

```bash
# Atacar el archivo de captura con una lista de contraseñas
aircrack-ng -w /ruta/a/tu/diccionario.txt -b [BSSID_del_AP] captura-01.cap
```
* `-w /ruta/a/tu/diccionario.txt` especifica la lista de palabras (diccionario) a utilizar.
* `captura-01.cap` es el archivo que contiene el handshake.

## Consideraciones Adicionales

*   **Hardware compatible:** No todas las tarjetas de red inalámbrica soportan el modo monitor y la inyección de paquetes. Es un requisito fundamental para que la suite funcione correctamente.
*   **Legalidad:** Usar Aircrack-ng en redes para las que no tienes permiso explícito es ilegal.
*   **Ataques WEP:** Crackear claves WEP es mucho más rápido y no requiere un ataque de diccionario, ya que el protocolo WEP tiene fallos criptográficos fundamentales. Aircrack-ng puede romper claves WEP en minutos una vez que se ha capturado suficiente tráfico.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. No la utilices para actividades maliciosas.*
