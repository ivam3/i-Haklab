# Xerosploit

## ¿Qué es Xerosploit?

Xerosploit es un **framework de pruebas de penetración** enfocado en la ejecución de **ataques Man-in-the-Middle (MITM)**. Su objetivo es hacer que la realización de estos ataques sea más fácil y accesible, incluso para usuarios que no son expertos en redes.

Actúa como una navaja suiza que combina las capacidades de otras herramientas populares (como Nmap y Bettercap) en una única interfaz de línea de comandos, interactiva y basada en menús.

## ¿Para qué es útil?

Xerosploit se utiliza para interceptar y manipular el tráfico de una red local. Es una herramienta de ataque muy potente para auditorías de seguridad en redes internas.

Sus módulos más destacados incluyen:
*   **Escaneo de Red:** Mapea la red para encontrar todos los hosts activos y sus direcciones IP.
*   **Envenenamiento ARP (ARP Spoofing):** Es el núcleo de su funcionalidad MITM. Engaña a los dispositivos de la red para que envíen su tráfico a través de la máquina del atacante.
*   **Sniffing de Paquetes:** Una vez en medio, puede capturar el tráfico en tiempo real, mostrando imágenes o extrayendo URLs visitadas.
*   **DNS Spoofing:** Redirige a la víctima a sitios web falsos cuando intenta acceder a sitios legítimos (por ejemplo, redirigir `facebook.com` a una página de phishing).
*   **Inyección de HTML/JS:** Permite inyectar código HTML o JavaScript en las páginas web que visita la víctima, lo que puede usarse para mostrar mensajes falsos, robar cookies o realizar otros ataques.
*   **Reemplazo de Imágenes:** Sustituye todas las imágenes en las páginas web por una imagen elegida por el atacante.
*   **Ataques de Denegación de Servicio (DoS):** Puede lanzar ataques DoS contra un objetivo en la red local.

## ¿Cómo se usa? (Ejemplo conceptual)

Xerosploit es conocido por su interfaz amigable y fácil de usar.

**Flujo de trabajo típico:**

1.  **Ejecutar la herramienta:**
    ```bash
    sudo xerosploit
    ```

2.  **Escanear la red:** La herramienta primero escanea la red para encontrar objetivos. Te presentará una lista de dispositivos encontrados.
    ```
    Gateway: 192.168.1.1
    [1] 192.168.1.101 (Dispositivo-Juan)
    [2] 192.168.1.105 (PC-Maria)
    ...
    ```

3.  **Seleccionar el objetivo:** Escribes el número o la IP del dispositivo que quieres atacar.

4.  **Elegir un módulo:** A continuación, Xerosploit te muestra un menú con todos los ataques disponibles.
    ```
    (dos)      Denial of service
    (inject)   Inject html/js
    (sniff)    Sniff packets
    (dns)      Dns spoofer
    ...
    ```
    Escribes el nombre del módulo que quieres usar, por ejemplo, `inject`.

5.  **Ejecutar el ataque:** La herramienta te pedirá los parámetros necesarios (por ejemplo, el código HTML a inyectar) y luego iniciará el ataque con solo presionar Enter.

## Consideraciones Adicionales

*   **Facilidad de Uso:** La principal ventaja de Xerosploit es su simplicidad. Abstrae la complejidad de los ataques MITM, haciéndolos accesibles para principiantes.
*   **Herramienta Agresiva:** Es una herramienta de ataque activo. Su uso en una red es muy "ruidoso" y puede causar interrupciones.
*   **Legalidad y Ética:** Interceptar y manipular el tráfico de red de otras personas sin su consentimiento explícito es un delito grave. Xerosploit solo debe ser utilizado en redes de laboratorio o en pruebas de penetración profesionales con la debida autorización por escrito.

---
*Nota: Xerosploit es una herramienta extremadamente poderosa y peligrosa. Su simplicidad la hace tentadora, pero su uso indebido puede tener consecuencias legales y técnicas muy serias.*
