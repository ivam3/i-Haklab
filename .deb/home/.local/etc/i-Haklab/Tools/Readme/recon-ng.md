
# Recon-ng

## ¿Qué es Recon-ng?

Recon-ng es una potente herramienta de reconocimiento web y de inteligencia de fuentes abiertas (OSINT) desarrollada en Python. Su interfaz de línea de comandos está diseñada para ser similar a la de Metasploit Framework, lo que facilita su uso para aquellos familiarizados con frameworks de pentesting.

El objetivo principal de Recon-ng es automatizar el proceso de recopilación de información de fuentes públicas durante las fases de reconocimiento en auditorías de seguridad, hacking ético y pruebas de penetración. No está diseñada para explotación, sino para la recolección exhaustiva de datos.

## ¿Para qué es útil la herramienta?

Recon-ng es una herramienta indispensable para profesionales de la ciberseguridad, pentesters, investigadores de seguridad y analistas de OSINT. Sus principales utilidades son:

-   **Recopilación Automatizada de OSINT:** Reúne datos disponibles públicamente sobre un objetivo, como dominios, subdominios, direcciones IP, perfiles de redes sociales, direcciones de correo electrónico, registros WHOIS y más.
-   **Análisis de la Superficie de Ataque:** Ayuda a construir una imagen completa de la presencia digital de una organización, identificando todos los activos expuestos en Internet.
-   **Organización de Datos:** Almacena toda la información recopilada en una base de datos local (SQLite por defecto), lo que facilita la consulta, el filtrado y el análisis posterior de los datos.
-   **Modularidad y Extensibilidad:** Permite la integración con numerosas APIs de terceros (ej. Shodan, Hunter.io) a través de su sistema de módulos, ampliando enormemente sus capacidades de recopilación de datos.
-   **Gestión de Proyectos:** Utiliza el concepto de "espacios de trabajo" (`workspaces`) para mantener los datos de diferentes proyectos organizados y separados.

## ¿Cómo se usa?

Recon-ng se opera a través de su interfaz de línea de comandos.

### 1. Instalación

Recon-ng suele venir preinstalado en distribuciones de seguridad como Kali Linux. Si no lo está, puedes instalarlo clonando su repositorio de GitHub e instalando las dependencias.

```bash
# En Kali Linux, simplemente inicia:
recon-ng
```

### 2. Uso Básico y Flujo de Trabajo

Una vez iniciado `recon-ng`, verás un prompt interactivo.

1.  **Gestionar Espacios de Trabajo:**
    -   `workspaces create <nombre_workspace>`: Crea un nuevo espacio de trabajo para tu proyecto.
    -   `workspaces select <nombre_workspace>`: Carga un espacio de trabajo existente.
    -   `workspaces list`: Muestra todos los espacios de trabajo.
    -   `workspaces delete <nombre_workspace>`: Elimina un espacio de trabajo.

    ```
    recon-ng > workspaces create mi_proyecto
    recon-ng > workspaces select mi_proyecto
    ```

2.  **Añadir Dominios Objetivo:**
    Para empezar el reconocimiento, necesitas añadir el dominio objetivo a la base de datos.

    ```
    recon-ng [mi_proyecto] > add domains example.com
    ```
    Puedes ver los dominios añadidos con `show domains`.

3.  **Gestionar Módulos:**
    Recon-ng utiliza módulos para realizar diferentes tipos de reconocimiento.

    -   `marketplace refresh`: Actualiza la lista de módulos disponibles.
    -   `marketplace search <palabra_clave>`: Busca módulos (ej. `marketplace search subdomain`).
    -   `marketplace install <nombre_modulo>`: Instala un módulo (ej. `marketplace install recon/domains-hosts/google_site_web`).
    -   `modules load <nombre_modulo>`: Carga un módulo para usarlo.
    -   `info`: Muestra información sobre el módulo cargado y sus opciones.

4.  **Configurar Opciones del Módulo:**
    Cada módulo puede tener opciones configurables. Usa `show options` para verlas y `set <opcion> <valor>` para configurarlas.
    Muchos módulos toman `SOURCE` como el dominio objetivo.

    ```
    recon-ng [mi_proyecto][google_site_web] > show options
    recon-ng [mi_proyecto][google_site_web] > set SOURCE example.com
    ```

5.  **Ejecutar Módulos:**
    Una vez configurado el módulo, ejecútalo con `run`.

    ```
    recon-ng [mi_proyecto][google_site_web] > run
    ```

6.  **Gestionar Claves API:**
    Muchos módulos requieren API keys para servicios de terceros (ej. Shodan, VirusTotal).

    -   `keys add <nombre_servicio> <clave_api>`: Añade una clave API.
    -   `keys list`: Muestra las claves API configuradas.

7.  **Ver y Exportar Datos Recopilados:**
    Una vez ejecutados los módulos, puedes ver los datos recopilados en la base de datos.

    -   `show hosts`: Muestra los hosts descubiertos.
    -   `show contacts`: Muestra los contactos descubiertos.
    -   `show vuln`: Muestra las vulnerabilidades descubiertas.
    -   `db dump`: Muestra todo el contenido de la base de datos.
    -   `loot add <tipo> <valor>`: Para añadir datos manualmente.
    -   `loot list`: Lista los datos manuales.

    También puedes exportar los datos a diferentes formatos:
    -   `recon-ng [mi_proyecto] > dashboard`: Muestra un resumen del workspace.
    -   `recon-ng [mi_proyecto] > reporting generate html`: Genera un informe HTML.

8.  **Salir:**
    ```
    exit
    ```

## Otras Consideraciones

-   **Ética y Legalidad:** Recon-ng es una herramienta de OSINT. Solo accede a información públicamente disponible. Sin embargo, el uso de la información obtenida debe ser **ético y legal**. Utilízala únicamente para fines de seguridad autorizados, investigación legítima o en tus propios proyectos.
-   **Velocidad:** La velocidad del reconocimiento puede depender de las limitaciones de tasa de las APIs de terceros y de la cantidad de módulos ejecutados.
-   **Recursos:** Es una herramienta potente que puede requerir una cantidad considerable de tiempo y recursos para un análisis exhaustivo.
