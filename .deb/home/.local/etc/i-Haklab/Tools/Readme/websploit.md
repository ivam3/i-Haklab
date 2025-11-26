# WebSploit Framework

## ¿Qué es WebSploit Framework?

WebSploit es un framework de código abierto, escrito en Python, para automatizar el escaneo y análisis de sistemas remotos. Es especialmente conocido por sus módulos enfocados en la ejecución de **ataques Man-in-the-Middle (MITM)**.

Al igual que Metasploit, WebSploit proporciona una consola interactiva con una colección de módulos que pueden ser configurados y ejecutados contra un objetivo.

## ¿Para qué es útil?

WebSploit es una herramienta de pentesting que simplifica la ejecución de varios ataques de red y de ingeniería social.

Sus módulos más importantes permiten:
*   **Ataques a Redes Wi-Fi:**
    *   Crear puntos de acceso falsos (Fake AP) para capturar el tráfico de los usuarios que se conecten.
    *   Realizar ataques de desautenticación para desconectar a un cliente de una red Wi-Fi.
*   **Ataques Man-in-the-Middle (MITM):**
    *   Realizar envenenamiento ARP (ARP Spoofing) para posicionarse en medio de la comunicación entre la víctima y el router.
    *   Una vez en medio, puede diseccionar el tráfico, capturar contraseñas no cifradas, e inyectar código malicioso en las páginas web que visita la víctima.
*   **Ingeniería Social:** Incluye módulos para generar páginas de phishing y otros ataques que requieren la interacción del usuario.
*   **Escaneo y Reconocimiento:** Contiene utilidades para escanear la red, descubrir hosts y obtener información de los sistemas.

## ¿Cómo se usa? (Ejemplo conceptual)

WebSploit funciona a través de una consola interactiva similar a la de Metasploit.

**Flujo de trabajo típico:**

1.  **Iniciar el framework:**
    ```bash
    websploit
    ```

2.  **Mostrar los módulos disponibles:** El comando `show modules` te listará todas las herramientas disponibles dentro del framework.
    ```
    wsf > show modules
    ```
    Verás una lista como `network/fake_ap`, `arp_poisoner`, `web/phishing`, etc.

3.  **Seleccionar un módulo:** Usas el comando `use` seguido del nombre del módulo.
    ```
    wsf > use network/arp_poisoner
    ```

4.  **Configurar las opciones:** Cada módulo tiene sus propias opciones. El comando `show options` te mostrará qué necesitas configurar.
    ```
    wsf:arp_poisoner > show options
    ```
    Aquí configurarías la interfaz de red, la IP del objetivo, y la IP del router.

5.  **Ejecutar el ataque:** El comando `run` o `exploit` inicia el módulo.
    ```
    wsf:arp_poisoner > run
    ```

## Consideraciones Adicionales

*   **Enfoque en MITM:** La verdadera fortaleza de WebSploit radica en sus módulos para ataques de red local y Man-in-the-Middle.
*   **Interfaz Familiar:** Si ya has usado Metasploit, la interfaz de WebSploit te resultará muy familiar e intuitiva.
*   **Mantenimiento:** Al igual que otros proyectos de código abierto, la efectividad de WebSploit depende de su estado de mantenimiento. Algunas de sus técnicas pueden ser detectadas por sistemas de seguridad modernos.
*   **Legalidad:** La ejecución de ataques MITM y otros módulos de WebSploit en una red sin el permiso explícito de su propietario es ilegal y puede causar interrupciones graves en el servicio.

---
*Nota: WebSploit es una herramienta poderosa para practicar y ejecutar ataques de red en un entorno de laboratorio controlado. Su uso en redes productivas sin autorización es un delito.*
