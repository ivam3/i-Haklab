
# ovh-ttyrec

## ¿Qué es ovh-ttyrec?

`ovh-ttyrec` es una versión mejorada y compatible de la herramienta clásica `ttyrec`, un grabador de terminal (TTY). Su función principal es registrar sesiones de terminal de forma precisa, capturando toda la salida de la TTY de un programa en modo texto, junto con marcas de tiempo, para su posterior reproducción.

Esta herramienta es útil para documentar sesiones de trabajo, depurar scripts, crear tutoriales o grabar interacciones con la línea de comandos con fines forenses o de análisis.

## ¿Para qué es útil la herramienta?

`ovh-ttyrec` es una utilidad de nicho pero muy efectiva para:

-   **Documentación de Sesiones:** Grabar y archivar sesiones de terminal para referencia futura, auditorías o para compartir con otros usuarios.
-   **Debugging:** Reproducir la ejecución de comandos o scripts complejos para analizar su comportamiento paso a paso y diagnosticar problemas.
-   **Creación de Tutoriales:** Generar grabaciones que pueden ser reproducidas como demos o tutoriales para enseñar el uso de herramientas de línea de comandos.
-   **Análisis Forense:** Capturar la actividad de un usuario en una terminal para fines de investigación de seguridad o forenses.
-   **Compartir Interacciones:** Compartir con precisión interacciones complejas de línea de comandos sin tener que copiar y pegar extensos logs de texto.

## ¿Cómo se usa?

`ovh-ttyrec` se utiliza desde la línea de comandos para iniciar y detener la grabación, y luego una herramienta como `ttyplay` para reproducir las grabaciones.

### 1. Instalación

`ovh-ttyrec` puede estar disponible en los repositorios de tu distribución o se puede compilar desde el código fuente.

-   **En sistemas basados en Debian/Ubuntu:**
    Podría estar disponible en los repositorios como `ttyrec` o un paquete similar.

-   **Desde el código fuente (si lo obtienes de un repositorio como GitHub):**
    ```bash
    git clone https://github.com/OVHcloud/ttyrec.git
    cd ttyrec
    make
    sudo make install
    ```

### 2. Grabación de una Sesión

Para iniciar una grabación, simplemente ejecuta `ttyrec` en tu terminal. Por defecto, creará un archivo llamado `ttyrecord` en el directorio actual.

```bash
ttyrec
```

A partir de ese momento, todo lo que hagas en esa terminal se grabará. Puedes interactuar con cualquier programa (`vi`, `emacs`, `ls`, `ssh`, etc.).

-   **Para detener la grabación:**
    -   Escribe `exit` y presiona Enter.
    -   Presiona `Ctrl + D` (si estás en una shell interactiva).

### 3. Reproducción de una Grabación

Para reproducir una grabación, usa el comando `ttyplay` seguido del nombre del archivo grabado:

```bash
ttyplay ttyrecord
# o si le diste otro nombre
ttyplay mi_grabacion.tty
```

-   **Controles durante la reproducción:**
    -   `Espacio`: Pausar/Reanudar.
    -   `t`: Avance rápido.
    -   `d`: Retroceso.
    -   `0-9`: Cambiar la velocidad de reproducción.

### 4. Opciones Avanzadas de Grabación (ovh-ttyrec específico)

`ovh-ttyrec` puede tener opciones mejoradas en comparación con el `ttyrec` original. Consulta la ayuda (`ttyrec --help`) para conocerlas, pero algunas comunes pueden ser:

-   `-a`: Apendizar a un archivo existente en lugar de sobrescribirlo.
-   `-x <comando>`: Grabar la ejecución de un comando específico y salir cuando termine.
-   `-o <archivo>`: Especificar un nombre de archivo de salida diferente.
-   `--name-format <formato>` o `-F <formato>`: Para especificar un formato de nombre de archivo para las grabaciones (ej. con marca de tiempo).
-   `--compress`: Para usar compresión (ej. `zstd`).

### Ejemplo: Grabar un comando específico y guardarlo con fecha

```bash
ttyrec -o "sesion_$(date +%Y%m%d_%H%M%S).tty" bash -c "ls -l; df -h; exit"
```
Esto grabaría los comandos `ls -l` y `df -h` y saldría, guardando la sesión en un archivo con un nombre basado en la fecha y hora.

## Otras Consideraciones

-   **Seguridad:** Las grabaciones de terminal pueden contener información sensible (contraseñas, claves). Asegúrate de manejar estos archivos de forma segura.
-   **Tamaño del Archivo:** Las grabaciones pueden volverse grandes si las sesiones son muy largas o contienen mucha salida. La compresión puede ayudar a mitigar esto.
-   **Compatibilidad:** El formato de archivo `.ttyrecord` es ampliamente compatible entre diferentes versiones de `ttyrec` y `ttyplay`.
