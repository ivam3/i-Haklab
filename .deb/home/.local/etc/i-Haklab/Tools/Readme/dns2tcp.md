# dns2tcp

## ¿Qué es dns2tcp?

dns2tcp es una herramienta de red diseñada para **crear un túnel de tráfico TCP a través de consultas y respuestas DNS**. Su propósito principal es eludir firewalls y restricciones de red que bloquean la mayoría del tráfico de internet, pero que casi siempre permiten el paso del tráfico DNS (puerto 53).

Es una técnica de **tunelización de protocolos**, donde un protocolo (TCP) se encapsula dentro de otro (DNS) para pasar desapercibido o para aprovechar un canal de comunicación permitido.

## ¿Para qué es útil la herramienta?

dns2tcp es una herramienta poderosa en escenarios donde la conectividad a internet está fuertemente restringida. Sus principales casos de uso son:

*   **Burlar Firewalls y Portales Cautivos:** Es su uso más común. En redes de empresas, aeropuertos, u hoteles, a menudo se bloquea todo el tráfico excepto el DNS y el HTTP/S. dns2tcp permite establecer una conexión (por ejemplo, una sesión SSH) a un servidor externo encapsulando todo el tráfico como si fueran simples consultas DNS.
*   **Exfiltración de Datos Sigilosa:** En un escenario de post-explotación, un atacante puede usar dns2tcp para sacar datos de una red comprometida de forma sigilosa. Dado que el tráfico parece ser DNS normal, es menos probable que active las alarmas de los sistemas de monitoreo de red.
*   **Creación de Canales de Mando y Control (C2):** Un atacante puede usarlo para mantener un canal de comunicación encubierto con una máquina comprometida dentro de una red, enviando comandos y recibiendo resultados a través del túnel DNS.

## ¿Cómo funciona?

dns2tcp tiene dos componentes: un **cliente** (`dns2tcpc`) y un **servidor** (`dns2tcpd`).

1.  **Configuración del Servidor (`dns2tcpd`):**
    *   Necesitas un **servidor que controles** y un **nombre de dominio** que apunte a ese servidor.
    *   En el servidor, se ejecuta el demonio `dns2tcpd`. Este demonio escucha las consultas DNS entrantes dirigidas a tu dominio.
    *   Se configura para asociar un subdominio con un servicio local. Por ejemplo, se puede configurar para que el tráfico que llegue para `ssh.tunel.com` se reenvíe al servicio SSH del propio servidor en `localhost:22`.

2.  **Ejecución del Cliente (`dns2tcpc`):**
    *   En la máquina cliente (que está detrás del firewall), se ejecuta `dns2tcpc`.
    *   Se le dice al cliente que escuche en un puerto local (por ejemplo, el puerto 8888).
    *   Cuando el cliente recibe tráfico en ese puerto local (por ejemplo, de un cliente SSH que intenta conectarse a `localhost:8888`), `dns2tcpc` lo intercepta.

3.  **El Túnel:**
    *   `dns2tcpc` **codifica** los datos TCP en una serie de nombres de subdominio y realiza consultas DNS (generalmente de tipo TXT o CNAME) al servidor `dns2tcpd` (ej: `data1.ssh.tunel.com`, `data2.ssh.tunel.com`).
    *   El servidor `dns2tcpd` recibe estas consultas, **decodifica** los datos, los reensambla y los envía al servicio de destino (el servidor SSH).
    *   La respuesta del servicio SSH se codifica de nuevo en una respuesta DNS y se envía de vuelta al cliente.
    *   `dns2tcpc` recibe la respuesta DNS, la decodifica y la entrega al cliente SSH local.

![Diagrama de dns2tcp](https://www.aldeid.com/wiki/images/Dns2tcp-diagram.png)
*(Fuente: aldeid.com)*

## ¿Cómo se usa? (Ejemplo conceptual)

**En el servidor (IP: 1.2.3.4, Dominio: tunel.com):**

1.  **Configurar DNS:**
    *   Crear un registro `A` para `ns.tunel.com` que apunte a `1.2.3.4`.
    *   Crear un registro `NS` para `ssh.tunel.com` que apunte a `ns.tunel.com`.

2.  **Crear archivo de configuración `dns2tcpd.conf`:**
    ```
    listen = 0.0.0.0
    port = 53
    user = nobody
    chroot = /tmp
    domain = ssh.tunel.com
    resources = ssh:127.0.0.1:22
    ```

3.  **Iniciar el servidor:**
    ```bash
    sudo dns2tcpd -f dns2tcpd.conf
    ```

**En el cliente (detrás del firewall):**

1.  **Iniciar el cliente:**
    ```bash
    sudo dns2tcpc -c -l 8888 -r ssh -z ssh.tunel.com 1.2.3.4
    ```
    *   `-l 8888`: Escucha en el puerto local 8888.
    *   `-r ssh`: Utiliza el recurso "ssh" definido en el servidor.
    *   `-z ssh.tunel.com 1.2.3.4`: Especifica el dominio del túnel y la IP del servidor dns2tcp.

2.  **Conectarse a través del túnel:**
    Ahora, en otra terminal del cliente, puedes iniciar una sesión SSH a través del túnel:
    ```bash
    ssh usuario@localhost -p 8888
    ```
    Esta conexión será encapsulada en tráfico DNS y saldrá de la red restringida.

## Consideraciones Adicionales

*   **Lentitud:** La tunelización a través de DNS es **extremadamente lenta** en comparación con una conexión directa. Es adecuada para sesiones de shell interactivas (SSH) y tareas de bajo ancho de banda, pero no para transferir archivos grandes o navegar por la web de forma intensiva.
*   **No es Cifrado:** dns2tcp **no cifra el tráfico** que pasa por el túnel. Si necesitas confidencialidad, debes usar un protocolo cifrado *dentro* del túnel (como SSH, que ya es cifrado por naturaleza).
*   **Detección:** Aunque puede pasar desapercibido para firewalls simples, los sistemas de seguridad de red más avanzados (IDS/IPS) pueden detectar patrones anómalos de tráfico DNS (como un volumen muy alto de consultas TXT a un mismo dominio) y alertar sobre la posible existencia de un túnel.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad. El uso de esta herramienta puede violar las políticas de uso aceptable de una red.*
