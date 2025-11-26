
# Nexphisher

## ¿Qué es Nexphisher?

Nexphisher es una herramienta de phishing de código abierto diseñada para simplificar la creación y el lanzamiento de ataques de phishing. Escrita en Bash, esta herramienta es popular entre los profesionales de la ciberseguridad (para fines éticos) y los entusiastas, ya que proporciona una interfaz sencilla para generar páginas de inicio de sesión falsas de diversas plataformas populares, como redes sociales, servicios de correo electrónico y otros sitios web.

Se centra en la facilidad de uso y la automatización, permitiendo a los usuarios configurar rápidamente un servidor de phishing y generar un enlace malicioso que puede ser utilizado en ataques de ingeniería social.

## ¿Para qué es útil la herramienta?

Nexphisher es utilizada principalmente para:

-   **Simulación de Ataques de Phishing:** Para que los equipos de seguridad realicen simulacros de ataques de phishing controlados, evaluando la resistencia de los empleados a las estafas de ingeniería social.
-   **Concienciación y Entrenamiento:** Ayuda a educar a los usuarios sobre cómo identificar y evitar los ataques de phishing, mostrando lo fácil que puede ser crear una página de login falsa.
-   **Evaluación de la Seguridad:** Para probar la eficacia de los sistemas de detección de phishing y las políticas de seguridad de una organización.
-   **Investigación:** Para analizar las técnicas y metodologías utilizadas en los ataques de phishing reales.

## ¿Cómo se usa?

Nexphisher se ejecuta desde la línea de comandos en entornos Linux o Termux (para Android).

### 1. Instalación

1.  **Actualizar el sistema (Recomendado):**
    ```bash
    sudo apt update && sudo apt upgrade -y
    ```
    (Para Termux, usa `pkg update && pkg upgrade -y`).

2.  **Instalar Git:**
    ```bash
    sudo apt install git -y
    ```
    (Para Termux, usa `pkg install git`).

3.  **Clonar el repositorio de Nexphisher:**
    ```bash
    git clone https://github.com/htr-tech/nexphisher.git
    ```

4.  **Navegar al directorio:**
    ```bash
    cd nexphisher
    ```

5.  **Ejecutar el script de configuración:**
    Este script instalará las dependencias necesarias.
    ```bash
    bash setup
    ```
    (Si estás en Termux, podrías necesitar `bash tmux_setup` o adaptar las instrucciones de instalación de dependencias).

### 2. Ejecución y Configuración de un Ataque

1.  **Iniciar Nexphisher:**
    ```bash
    bash nexphisher
    ```
    Se presentará un menú con una lista de plantillas de phishing disponibles (ej. Facebook, Instagram, Google, etc.).

2.  **Seleccionar una Plantilla:**
    Introduce el número correspondiente a la plantilla de phishing que deseas usar (ej. `1` para Facebook).

3.  **Elegir un Servicio de Reenvío de Puertos:**
    Nexphisher te preguntará cómo quieres exponer tu servidor de phishing local a Internet. Las opciones comunes incluyen:
    -   `Ngrok`
    -   `Serveo`
    -   `localhost.run`
    Selecciona la opción deseada. Estas herramientas crean un túnel seguro a tu máquina local.

4.  **Entrega del Enlace:**
    Una vez configurado, Nexphisher te proporcionará un enlace de phishing. Este enlace debe ser entregado al objetivo utilizando técnicas de ingeniería social. Por ejemplo, podrías enviarlo a través de un mensaje, un correo electrónico falso, etc.

5.  **Captura de Credenciales:**
    Cuando la víctima haga clic en el enlace y introduzca sus credenciales en la página de inicio de sesión falsa, Nexphisher las capturará y las mostrará en tu terminal, además de guardarlas en un archivo de registro.

## Otras Consideraciones

-   **Ética y Legalidad:** Nexphisher es una herramienta ofensiva. **Su uso para atacar a individuos o sistemas sin consentimiento mutuo y por escrito es ILEGAL y puede tener graves consecuencias legales.** Está destinado exclusivamente para fines educativos, de investigación y de pruebas de penetración éticas con autorización explícita.
-   **Detección:** Las páginas de phishing generadas por estas herramientas pueden ser detectadas por navegadores web, filtros de spam y software de seguridad.
-   **Actualización:** Es importante mantener la herramienta actualizada (`git pull`) ya que los sitios web y sus diseños cambian constantemente, lo que puede afectar la efectividad de las plantillas de phishing.
-   **Dependencias:** Nexphisher depende de otras herramientas y servicios para funcionar, como `ngrok` o `serveo` para el reenvío de puertos.
