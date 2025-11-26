
# SayCheese

## ¿Qué es SayCheese?

SayCheese es una herramienta de código abierto diseñada para realizar ataques de phishing con el objetivo de capturar fotos de la cámara frontal (o trasera) de un dispositivo objetivo. Funciona creando una página web falsa que, mediante ingeniería social, intenta engañar a la víctima para que otorgue permisos de acceso a su cámara. Si la víctima concede dichos permisos, la herramienta puede tomar fotos de forma discreta y enviarlas al atacante.

La herramienta utiliza servicios de reenvío de puertos como `ngrok` o `serveo` para exponer una página web maliciosa generada localmente a Internet, permitiendo que la víctima acceda a ella desde cualquier lugar.

## ¿Para qué es útil la herramienta?

SayCheese es una herramienta ofensiva utilizada en escenarios controlados de hacking ético y pruebas de penetración para demostrar la vulnerabilidad de los usuarios a ataques de ingeniería social:

-   **Simulación de Ataques de Phishing:** Permite a los profesionales de la seguridad simular ataques para evaluar la concienciación de los usuarios sobre los permisos de acceso a la cámara y los riesgos asociados a los enlaces maliciosos.
-   **Concienciación de Seguridad:** Ayuda a educar a los usuarios sobre cómo los atacantes pueden explotar el acceso a la cámara de sus dispositivos a través de técnicas de ingeniería social.
-   **Evaluación de la Susceptibilidad:** Sirve para probar la susceptibilidad de los usuarios a otorgar permisos de cámara en páginas web desconocidas.

## ¿Cómo se usa?

SayCheese se opera a través de la línea de comandos en un entorno Linux o similar (como Termux en Android).

### 1. Instalación

1.  **Instalar Python y Git:** Asegúrate de tener Python y Git instalados en tu sistema.

2.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/thelinuxchoice/saycheese.git
    cd saycheese
    ```

3.  **Instalar dependencias:**
    ```bash
    pip install -r requirements.txt
    ```

### 2. Ejecución

1.  **Iniciar SayCheese:**
    ```bash
    python3 saycheese.py
    ```
    (El nombre del script principal puede variar ligeramente).

2.  **Configuración del Reenvío de Puertos:**
    La herramienta te preguntará qué servicio de reenvío de puertos deseas usar (ej. `ngrok`, `serveo`). Selecciona uno, y SayCheese generará una URL pública.

3.  **Ingeniería Social:**
    El enlace generado por SayCheese debe ser entregado a la víctima utilizando técnicas de ingeniería social. Por ejemplo, un mensaje en redes sociales, un correo electrónico con un pretexto convincente.

4.  **Captura de Imágenes:**
    Cuando la víctima haga clic en el enlace y otorgue el permiso a la cámara (generalmente después de que la página web muestre un diseño creíble), SayCheese activará la cámara del dispositivo y guardará las fotos capturadas en tu máquina local (normalmente en un subdirectorio `captured` o similar).

## Consideraciones muy Importantes

-   **ÉTICA Y LEGALIDAD:** SayCheese es una herramienta ofensiva. **Su uso para capturar imágenes de la cámara de personas sin su consentimiento explícito, informado y por escrito es ILEGAL y puede tener graves consecuencias legales y éticas.**
-   **Finalidad:** Esta herramienta está destinada **exclusivamente para fines educativos y de concienciación sobre ciberseguridad**, y solo debe utilizarse en entornos de prueba controlados y con el permiso explícito de las personas involucradas.
-   **Protección de la Privacidad:** Es fundamental recordar que el acceso no autorizado a la cámara de un dispositivo es una grave violación de la privacidad.
-   **Detección:** Los navegadores web modernos tienen mecanismos para alertar a los usuarios sobre solicitudes de permisos de cámara, y el tráfico de `ngrok` o `serveo` puede ser detectado por sistemas de seguridad de red.
