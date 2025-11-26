
# Lockphish

## ¿Qué es Lockphish?

Lockphish es una herramienta de phishing de código abierto diseñada para capturar credenciales de inicio de sesión de diversos dispositivos. Su principal función es crear páginas web falsas que simulan las pantallas de bloqueo de sistemas operativos como Android (PIN), iOS (código de acceso) y Windows (credenciales de usuario). La herramienta detecta automáticamente el tipo de dispositivo del objetivo y genera una página de phishing adaptada.

La herramienta a menudo utiliza `ngrok` para exponer el servidor de phishing local a Internet, creando un enlace HTTPS único que luego se utiliza en ataques de ingeniería social.

## ¿Para qué es útil la herramienta?

Lockphish es una herramienta ofensiva utilizada en el ámbito del hacking ético y las pruebas de penetración para demostrar cómo las técnicas de ingeniería social pueden ser empleadas para obtener acceso a dispositivos y sistemas. Sus usos incluyen:

-   **Simulación de Ataques de Ingeniería Social:** Permite a los profesionales de la seguridad simular ataques de phishing altamente dirigidos para evaluar la conciencia de seguridad de los usuarios y la eficacia de las defensas.
-   **Captura de Credenciales:** Su objetivo es capturar PINs, códigos de acceso o credenciales de Windows, lo que puede dar acceso no autorizado a dispositivos.
-   **Evaluación de la Resistencia al Phishing:** Ayuda a las organizaciones a entender cómo sus usuarios reaccionan a páginas de login falsas y a educarlos sobre los riesgos.
-   **Rastreo de IP:** La herramienta puede rastrear la dirección IP de la víctima, lo que puede ser útil en ciertos escenarios de investigación.

## ¿Cómo se usa?

Lockphish es una herramienta de línea de comandos que se ejecuta en entornos Linux.

### 1. Instalación

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/thelinuxchoice/lockphish.git
    ```
    (Nota: Busca el repositorio más actualizado, ya que algunos pueden estar descontinuados).

2.  **Navegar al directorio:**
    ```bash
    cd lockphish
    ```

3.  **Dar permisos de ejecución:**
    ```bash
    chmod +x lockphish.sh
    ```

### 2. Ejecución

1.  **Iniciar la herramienta:**
    ```bash
    ./lockphish.sh
    ```

2.  **Configuración:**
    La herramienta te guiará a través de un menú donde seleccionarás el tipo de página de bloqueo a simular (Android PIN, iPhone Passcode, Windows Credentials) y te pedirá una URL de redirección (después de que la víctima introduzca las credenciales). La redirección a un vídeo de YouTube es una opción común para hacer el ataque más creíble.

3.  **Generación del Enlace de Phishing:**
    Lockphish utilizará `ngrok` para crear un túnel y te proporcionará una URL HTTPS pública única.

4.  **Ingeniería Social:**
    Este enlace debe ser entregado al objetivo utilizando alguna técnica de ingeniería social (por ejemplo, un mensaje en redes sociales, un correo electrónico).

5.  **Captura de Credenciales:**
    Cuando el objetivo haga clic en el enlace y, tras una posible página de redirección, introduzca sus credenciales en la pantalla de bloqueo falsa, Lockphish las capturará y las mostrará en tu terminal, además de guardarlas en un archivo de registro.

## Otras Consideraciones

-   **Legalidad y Ética:** Lockphish es una herramienta ofensiva. Su uso para atacar a individuos o sistemas sin consentimiento mutuo y por escrito es **ilegal y puede tener graves consecuencias legales**. Está destinado a fines educativos y de pruebas de penetración éticas con autorización explícita.
-   **Eficacia y Obsolescencia:** Es importante destacar que herramientas como Lockphish pueden volverse obsoletas rápidamente. Las interfaces de las pantallas de bloqueo de los sistemas operativos cambian con frecuencia, y los navegadores web modernos y los sistemas de seguridad tienen mejores protecciones contra el phishing. Algunos repositorios de Lockphish están marcados como descontinuados, lo que sugiere que puede no funcionar eficazmente contra las últimas versiones de los sistemas operativos.
-   **Dependencia de `ngrok`:** La herramienta suele depender de `ngrok` o servicios similares para exponer el servidor de phishing.

**No utilices esta herramienta con fines maliciosos.**
