# SlowHTTPTest

## ¿Qué es SlowHTTPTest?

SlowHTTPTest es una herramienta de línea de comandos para realizar pruebas de denegación de servicio (DoS) en la capa de aplicación. Su propósito es simular **ataques "Slow HTTP"**, que buscan agotar los recursos de un servidor web manteniendo las conexiones HTTP abiertas durante el mayor tiempo posible.

A diferencia de los ataques DoS volumétricos (que inundan al objetivo con tráfico), los ataques "slow" son sigilosos, utilizando muy poco ancho de banda y un número limitado de conexiones para derribar servidores web potentes.

## ¿Para qué es útil?

Esta herramienta es utilizada tanto por profesionales de la seguridad como por administradores de sistemas:

*   **Pentesters:** Para probar si un servidor web es vulnerable a ataques de denegación de servicio de bajo ancho de banda. Es una herramienta estándar para evaluar la resiliencia de los servidores web.
*   **Administradores de Sistemas:** Para auditar sus propios servidores (Apache, Nginx, etc.) y ajustar su configuración para mitigar este tipo de ataques (por ejemplo, ajustando los valores de `timeout`).
*   **Desarrolladores:** Para entender cómo su aplicación maneja las conexiones lentas y los timeouts.

SlowHTTPTest puede simular varios tipos de ataques lentos, incluyendo:
*   **Slowloris:** Envía cabeceras HTTP muy lentamente, manteniendo la conexión abierta.
*   **Slow HTTP POST:** Envía una cabecera `Content-Length` que promete una gran cantidad de datos, pero luego envía el cuerpo del mensaje muy lentamente.
*   **Slow Read:** Envía una petición legítima pero luego lee la respuesta del servidor de forma extremadamente lenta, ocupando un buffer en el servidor.

## ¿Cómo se usa? (Ejemplos básicos)

SlowHTTPTest es altamente configurable. Aquí están algunos de los modos de ataque más comunes.

**Sintaxis genérica:**

```bash
slowhttptest -c <conexiones> -H/-B/-R -g -o <archivo_salida> -i <intervalo> -r <rate> -t <verbo> -u <URL>
```

**Ejemplo 1: Ataque tipo Slowloris (Cabeceras lentas)**

Este comando inicia un ataque de cabeceras lentas con 1000 conexiones contra `http://example.com`. Generará estadísticas y las guardará en un archivo HTML.

```bash
slowhttptest -c 1000 -H -g -o mi_ataque_slowloris -i 10 -r 200 -t GET -u http://example.com
```
*   `-c 1000`: Número de conexiones.
*   `-H`: Modo de ataque Slowloris (cabeceras lentas).
*   `-g`: Genera estadísticas en un archivo.
*   `-o mi_ataque_slowloris`: Nombre del archivo de salida (se creará `.csv` y `.html`).
*   `-i 10`: Intervalo en segundos entre el envío de datos.
*   `-r 200`: Conexiones por segundo.
*   `-u http://example.com`: URL del objetivo.

**Ejemplo 2: Ataque tipo Slow POST**

Este comando simula un ataque de POST lento.

```bash
slowhttptest -c 1000 -B -g -o mi_ataque_slowpost -i 110 -r 200 -t POST -u http://example.com
```
*   `-B`: Modo de ataque Slow POST. Los otros parámetros funcionan de manera similar.

Durante la ejecución, SlowHTTPTest te mostrará el estado de las conexiones (abiertas, cerradas, pendientes). Si el número de conexiones cerradas permanece bajo y el servidor deja de responder, es probable que el ataque haya tenido éxito.

## Consideraciones Adicionales

*   **Mitigación:** Los servidores web modernos y los balanceadores de carga tienen módulos y configuraciones para mitigar estos ataques, como `mod_reqtimeout` para Apache, que establece límites de tiempo estrictos para recibir cabeceras y cuerpos de peticiones.
*   **Legalidad:** Realizar un ataque DoS (incluso uno "lento") contra un sistema sin permiso explícito es ilegal. Solo debes usar esta herramienta para auditar sistemas de tu propiedad o para los que tengas autorización.
*   **Herramienta de Prueba, no de Ataque Anónimo:** SlowHTTPTest está diseñada para pruebas. No incluye funciones de anonimato como la integración con Tor, por lo que tus ataques serán directamente atribuibles a tu dirección IP.

---
*Nota: La denegación de servicio es una actividad disruptiva e ilegal si no se realiza en un entorno controlado y autorizado.*
