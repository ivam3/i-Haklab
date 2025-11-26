
# h8mail

## ¿Qué es h8mail?

`h8mail` es una herramienta de código abierto escrita en Python, diseñada para la **Inteligencia de Fuentes Abiertas (OSINT)** y la búsqueda de filtraciones de datos relacionadas con direcciones de correo electrónico. Su función principal es determinar si una dirección de correo electrónico ha sido comprometida en brechas de seguridad conocidas y, si es posible, encontrar información asociada como contraseñas filtradas, nombres de usuario o correos electrónicos relacionados.

`h8mail` puede interactuar con varias APIs de servicios de búsqueda de filtraciones en línea (como Have I Been Pwned, LeakIX, Snusbase, etc.) o puede buscar directamente en compilaciones de filtraciones de datos locales que el usuario pueda tener (como Collection #1 o Breach Compilation).

## ¿Para qué es útil la herramienta?

`h8mail` es una herramienta valiosa para profesionales de la seguridad, investigadores y usuarios preocupados por su privacidad:

-   **Auditorías de Seguridad:** Ayuda a las organizaciones a verificar si las cuentas de correo electrónico de sus empleados han sido expuestas en filtraciones de datos, lo que puede ser un riesgo para la seguridad corporativa.
-   **Investigación Forense Digital:** En un incidente de seguridad, puede ayudar a identificar posibles credenciales comprometidas que podrían haber sido utilizadas en un ataque.
-   **Análisis de Riesgos:** Permite a los usuarios individuales y a las empresas evaluar su exposición en línea a través de la verificación de correos electrónicos.
-   **Reconocimiento (Reconnaissance):** En un contexto de pentesting, puede proporcionar información útil para la fase de reconocimiento, identificando credenciales para posibles ataques de relleno de credenciales o ingeniería social.

## ¿Cómo se usa?

`h8mail` es una herramienta de línea de comandos. Para aprovechar al máximo sus capacidades, se recomienda configurar un archivo de configuración (`h8mail_config.ini`) con las claves API de los servicios en línea que se deseen utilizar.

### 1. Instalación

`h8mail` requiere Python 3 (versión 3.6 o superior).

```bash
# Instalación global vía pip
pip3 install h8mail

# En Kali Linux, también puede estar disponible via apt
sudo apt install h8mail
```

### 2. Configuración de APIs (Opcional, pero recomendado)

Crea un archivo `h8mail_config.ini` (o similar) y añade tus claves API para servicios como Have I Been Pwned, LeakIX, Snusbase, etc.

Ejemplo `h8mail_config.ini`:
```ini
[haveibeenpwned]
api_key=TU_API_KEY_HIBP

[leakix]
api_key=TU_API_KEY_LEAKIX
```

### 3. Ejemplos de Uso

-   **Buscar una única dirección de correo electrónico:**
    ```bash
    h8mail -t target@example.com -c /ruta/a/h8mail_config.ini
    ```
    Si no especificas un archivo de configuración, `h8mail` intentará buscar en las bases de datos públicas que no requieren API Key o en bases de datos locales si se le indica.

-   **Buscar múltiples correos electrónicos desde un archivo:**
    Crea un archivo `emails.txt` con una dirección de correo por línea.
    ```bash
    h8mail -f emails.txt -c /ruta/a/h8mail_config.ini
    ```

-   **Buscar en compilaciones de filtraciones de datos locales:**
    Si tienes descargado el torrent "Breach Compilation" o "Collection #1", puedes especificar la ruta.
    ```bash
    h8mail -t target@example.com -lb /ruta/a/BreachCompilation/
    ```
    O para múltiples objetivos:
    ```bash
    h8mail -f emails.txt -lb /ruta/a/BreachCompilation/
    ```

-   **Guardar los resultados en un archivo:**
    Puedes guardar la salida en formato JSON o CSV.
    ```bash
    h8mail -t target@example.com -o resultados.json --output-format json
    ```

-   **Ocultar contraseñas en la salida:**
    Útil para compartir informes sin exponer directamente las contraseñas.
    ```bash
    h8mail -t target@example.com --hide-passwords
    ```

## Otras consideraciones

-   **Privacidad:** Al usar `h8mail` con APIs en línea, las direcciones de correo electrónico que consultas pueden ser enviadas a esos servicios. Ten en cuenta las implicaciones de privacidad.
-   **Legalidad y Ética:** Utiliza `h8mail` de manera ética y legal. No utilices esta herramienta para acosar o investigar a individuos sin el consentimiento adecuado o sin una base legal sólida.
-   **Actualización de Bases de Datos:** Si utilizas bases de datos locales, asegúrate de mantenerlas actualizadas para obtener los resultados más recientes.
