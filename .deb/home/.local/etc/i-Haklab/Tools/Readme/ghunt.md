
# GHunt

## ¿Qué es GHunt?

GHunt (pronunciado como "G-Hunt" o "Google Hunt") es una herramienta de OSINT (Inteligencia de Fuentes Abiertas) que se especializa en investigar cuentas de Google. A partir de una dirección de correo electrónico, GHunt puede extraer una cantidad sorprendente de información pública asociada a esa cuenta, aprovechando las APIs y las huellas digitales que los usuarios dejan en los servicios de Google.

## ¿Para qué es útil la herramienta?

GHunt es una herramienta poderosa para investigadores, periodistas y profesionales de la seguridad (pentesters, red teamers). Sus usos principales incluyen:

-   **OSINT y Recopilación de Información:** Es su propósito fundamental. Permite construir un perfil detallado de una persona o entidad basándose en su presencia en el ecosistema de Google.
-   **Investigación de Personas:** Puede revelar el nombre del propietario de una cuenta, su foto de perfil, canales de YouTube, reseñas en Google Maps, y posibles lugares de trabajo o estudio.
-   **Análisis de Seguridad:** Ayuda a entender qué información personal está expuesta públicamente a través de una cuenta de Google, permitiendo a los usuarios fortalecer su privacidad.
-   **Investigación Forense Digital:** Puede descubrir metadatos de documentos de Google Drive, como el autor y las fechas de creación/modificación.

## ¿Cómo se usa?

GHunt es una herramienta de línea de comandos que requiere autenticación con una cuenta de Google para funcionar.

### 1. Instalación

Se recomienda instalar GHunt usando `pipx` para evitar conflictos de dependencias.

```bash
# Instalar pipx
python3 -m pip install --user pipx
python3 -m pipx ensurepath

# Instalar GHunt
pipx install ghunt
```

### 2. Autenticación (Login)

GHunt necesita cookies de una sesión de Google válida para realizar sus consultas.

```bash
# Iniciar el proceso de login
ghunt login
```

El método más sencillo es usar la extensión **GHunt Companion** para Firefox o Chrome. Una vez instalada en el navegador, esta extensión facilita la exportación de las cookies necesarias.

Si no usas la extensión, deberás obtener manualmente las cookies `__Secure-3PSID`, `__Secure-3PSIDCC`, `__Secure-3PAPISID` y `HSID` desde las herramientas de desarrollador de tu navegador después de iniciar sesión en `accounts.google.com`.

### 3. Módulos de Investigación

Una vez autenticado, puedes usar los diferentes módulos de GHunt.

-   **Investigar por correo electrónico:**
    Este es el uso más común. Intenta encontrar toda la información posible a partir de un email.
    ```bash
    ghunt email test@gmail.com
    ```

-   **Investigar un documento de Google Drive/Docs:**
    Extrae metadatos del propietario de un archivo compartido públicamente.
    ```bash
    ghunt drive <ID_del_documento_o_URL>
    ```

-   **Investigar por ID de Gaia:**
    El "Gaia ID" es el identificador numérico único de una cuenta de Google. Si ya lo conoces, puedes usarlo directamente.
    ```bash
    ghunt gaia 118200258141978259231
    ```

### Información que puede revelar

-   **Nombre** del propietario de la cuenta.
-   **ID de Gaia** único.
-   **Foto de perfil** (y fotos de perfil anteriores).
-   Fecha de la **última edición del perfil**.
-   Los **servicios de Google que utiliza** (YouTube, Maps, Fotos, etc.).
-   Posibles **canales de YouTube**.
-   **Reseñas** escritas en Google Maps y la actividad de Local Guide.
-   Posible **ubicación física y lugares frecuentados**.
-   **Modelo de teléfono** usado (a través de metadatos de fotos).

## Otras consideraciones

-   **Legalidad y Ética:** GHunt solo accede a información públicamente visible. No "hackea" nada. Sin embargo, su uso debe ser ético y legal. Utilízalo solo en cuentas para las que tengas autorización de investigar.
-   **Evolución Constante:** Google cambia sus APIs y la forma en que muestra la información con frecuencia. Esto significa que GHunt requiere actualizaciones constantes por parte de su desarrollador para seguir funcionando correctamente.
