
# Osintgram

## ¿Qué es Osintgram?

Osintgram es una herramienta de código abierto basada en Python, diseñada para la Inteligencia de Fuentes Abiertas (OSINT) en perfiles públicos de Instagram. Permite a los investigadores, analistas de seguridad y entusiastas recopilar y analizar una gran variedad de información disponible públicamente en la plataforma.

Ofrece una interfaz de línea de comandos interactiva que permite a los usuarios extraer datos como información del perfil, listas de seguidores y seguidos, publicaciones, hashtags utilizados, ubicaciones geoetiquetadas, e incluso descargar contenido como fotos, videos y historias.

## ¿Para qué es útil la herramienta?

Osintgram es una herramienta valiosa para la fase de reconocimiento en diversas investigaciones:

-   **Investigación de OSINT:** Para recopilar información sobre personas o entidades, mapeando su actividad y presencia en Instagram.
-   **Análisis de Seguridad:** Ayuda a entender qué tipo de información personal o corporativa se está exponiendo inadvertidamente a través de perfiles de Instagram.
-   **Análisis Forense Digital:** En algunos casos, puede ser útil para documentar o extraer evidencia digital de perfiles públicos.
-   **Inteligencia de Amenazas:** Monitorear perfiles públicos para identificar amenazas potenciales o patrones de actividad.

## ¿Cómo se usa?

Osintgram se ejecuta desde la línea de comandos y requiere credenciales de una cuenta de Instagram para funcionar, ya que simula una sesión de usuario.

### 1. Instalación

1.  **Instalar Python y Git:** Asegúrate de tener Python 3 y Git instalados en tu sistema.

2.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/Datalux/Osintgram.git
    cd Osintgram
    ```

3.  **Crear un entorno virtual (recomendado):**
    ```bash
    python3 -m venv venv
    source venv/bin/activate # En Linux/macOS
    # .\venv\Scripts\activate.ps1 # En Windows PowerShell
    ```

4.  **Instalar dependencias:**
    ```bash
    pip install -r requirements.txt
    ```

### 2. Configurar Credenciales de Instagram

Osintgram necesita iniciar sesión en Instagram para recopilar datos. **Es altamente recomendable NO usar tu cuenta personal principal**. Crea una cuenta de Instagram dedicada para OSINT y úsala con Osintgram.

1.  **Obtener el `sessionid`:**
    Inicia sesión en Instagram en tu navegador. Una vez iniciada la sesión, abre las herramientas de desarrollador (F12), ve a la pestaña "Application" o "Storage", busca las cookies y copia el valor de la cookie llamada `sessionid`.

2.  **Configurar `credentials.json`:**
    Crea un archivo llamado `config/credentials.json` dentro del directorio `Osintgram` con el siguiente contenido, reemplazando `TU_SESSIONID` con el valor que copiaste:

    ```json
    {
        "sessionid": "TU_SESSIONID"
    }
    ```
    Algunas versiones también pueden usar un archivo `config/credentials.ini` con `username` y `password`. Consulta la documentación específica de la versión que estés utilizando.

### 3. Ejecución y Comandos

1.  **Iniciar Osintgram:**
    Puedes iniciar la herramienta en modo interactivo especificando el nombre de usuario del objetivo.

    ```bash
    python3 main.py <nombre_de_usuario_objetivo>
    ```
    (Reemplaza `<nombre_de_usuario_objetivo>` con el perfil de Instagram que deseas investigar).

2.  **Comandos en el Shell Interactivo:**
    Una vez dentro del shell interactivo de Osintgram, puedes usar varios comandos:

    -   `info`: Muestra la información general del perfil del objetivo.
    -   `followers`: Lista los usuarios que siguen al objetivo.
    -   `following`: Lista los usuarios que el objetivo sigue.
    -   `posts`: Lista las publicaciones del usuario.
    -   `download_photos`: Descarga las fotos del perfil.
    -   `download_stories`: Descarga las historias del perfil.
    -   `hashtags`: Muestra los hashtags utilizados por el usuario.
    -   `captions`: Obtiene los subtítulos de las publicaciones.
    -   `locations`: Obtiene las ubicaciones geoetiquetadas de las publicaciones.
    -   `help`: Muestra la lista completa de comandos.

## Otras Consideraciones

-   **Privacidad y Ética:** Osintgram solo puede acceder a información pública. **No puede acceder a perfiles privados**. Su uso debe ser ético y legal, respetando siempre la privacidad de las personas y las leyes aplicables. No debe utilizarse para acosar, espiar o acceder a información privada.
-   **Riesgo de Bloqueo de Cuenta:** El uso intensivo o la actividad sospechosa por parte de la cuenta utilizada por Osintgram puede llevar a la detección y bloqueo temporal o permanente por parte de Instagram. Por eso, usa siempre una cuenta dedicada y no tu cuenta principal.
-   **Cambios en Instagram:** Instagram actualiza constantemente su plataforma y APIs. Es posible que Osintgram necesite actualizaciones frecuentes para seguir funcionando correctamente.
