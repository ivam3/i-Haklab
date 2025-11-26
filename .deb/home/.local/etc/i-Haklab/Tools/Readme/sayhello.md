
# SayHello

## ¿Qué es SayHello?

SayHello es una herramienta de código abierto basada en Linux, diseñada para realizar ataques de phishing con el objetivo de capturar imágenes de la cámara web o grabar audio del micrófono de un dispositivo objetivo. Es una evolución de herramientas similares como SayCheese, mejorando la estabilidad y simplificando el proceso de ataque.

La herramienta genera un enlace malicioso que, al ser visitado por la víctima y si esta concede los permisos necesarios (engaño mediante ingeniería social), permite al atacante activar de forma remota la cámara web o el micrófono del dispositivo y obtener el contenido. SayHello suele integrar servicios de reenvío de puertos como `ngrok` para exponer la página de phishing a Internet.

## ¿Para qué es útil la herramienta?

SayHello es una herramienta ofensiva utilizada en escenarios controlados de hacking ético y pruebas de penetración. Sus principales utilidades son:

-   **Simulación de Ataques de Phishing:** Permite a los profesionales de la seguridad simular ataques para evaluar la concienciación de los usuarios sobre los permisos de acceso a la cámara/micrófono y los riesgos asociados a los enlaces maliciosos.
-   **Concienciación de Seguridad:** Ayuda a educar a los usuarios sobre cómo los atacantes pueden explotar el acceso a los periféricos de sus dispositivos a través de técnicas de ingeniería social.
-   **Evaluación de la Susceptibilidad:** Sirve para probar la susceptibilidad de los usuarios a otorgar permisos sensibles en páginas web desconocidas o falsas.

## ¿Cómo se usa?

SayHello se opera a través de la línea de comandos en un entorno Linux o similar (como Termux en Android).

### 1. Instalación

1.  **Instalar Python y Git:** Asegúrate de tener Python y Git instalados en tu sistema.

2.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/thelinuxchoice/sayhello.git
    cd sayhello
    ```

3.  **Instalar dependencias:**
    ```bash
    pip install -r requirements.txt
    ```

### 2. Ejecución

1.  **Iniciar SayHello:**
    ```bash
    python3 sayhello.py
    ```
    (El nombre del script principal puede variar ligeramente).

2.  **Configuración del Reenvío de Puertos:**
    La herramienta te preguntará qué servicio de reenvío de puertos deseas usar (ej. `ngrok`, `serveo`). Selecciona uno, y SayHello generará una URL pública.

3.  **Ingeniería Social:**
    El enlace generado por SayHello debe ser entregado a la víctima utilizando técnicas de ingeniería social. Por ejemplo, un mensaje en redes sociales, un correo electrónico con un pretexto convincente.

4.  **Captura de Imágenes/Audio:**
    Cuando la víctima haga clic en el enlace y otorgue el permiso a la cámara o al micrófono (generalmente después de que la página web muestre un diseño creíble), SayHello activará el periférico del dispositivo y guardará las fotos o grabaciones de audio capturadas en tu máquina local (normalmente en un subdirectorio `captured` o similar).

## Consideraciones muy Importantes

-   **ÉTICA Y LEGALIDAD:** SayHello es una herramienta ofensiva. **Su uso para capturar imágenes o audio de personas sin su consentimiento explícito, informado y por escrito es ILEGAL y puede tener graves consecuencias legales y éticas.**
-   **Finalidad:** Esta herramienta está destinada **exclusivamente para fines educativos y de concienciación sobre ciberseguridad**, y solo debe utilizarse en entornos de prueba controlados y con el permiso explícito de las personas involucradas.
-   **Protección de la Privacidad:** Es fundamental recordar que el acceso no autorizado a la cámara o micrófono de un dispositivo es una grave violación de la privacidad.
-   **Detección:** Los navegadores web modernos tienen mecanismos para alertar a los usuarios sobre solicitudes de permisos de cámara/micrófono, y el tráfico de `ngrok` o `serveo` puede ser detectado por sistemas de seguridad de red.
