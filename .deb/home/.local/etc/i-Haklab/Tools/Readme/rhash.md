
# RHash (Recursive Hasher)

## ¿Qué es RHash?

RHash (Recursive Hasher) es una utilidad de consola diseñada para calcular y verificar sumas hash (también conocidas como checksums o huellas digitales) de archivos y enlaces magnet. Es una herramienta muy versátil que soporta una amplia gama de algoritmos de hash criptográficos, incluyendo CRC32, MD5, SHA1, SHA256, SHA512, SHA3, Tiger, WHIRLPOOL, ED2K, AICH, y muchos otros.

Su propósito principal es asegurar la integridad de los datos, verificando que los archivos no han sido alterados, corrompidos o manipulados durante el almacenamiento o la transmisión.

## ¿Para qué es útil la herramienta?

RHash es una herramienta indispensable para administradores de sistemas, usuarios avanzados y cualquier persona preocupada por la integridad de sus datos:

-   **Verificación de Integridad:** Permite a los usuarios verificar que los archivos descargados o almacenados son idénticos a los originales, sin corrupción o alteración maliciosa.
-   **Detección de Cambios:** Identificar si un archivo ha sido modificado, incluso ligeramente, generando un hash diferente.
-   **Generación de Enlaces Magnet:** Crear enlaces magnet para archivos o directorios, facilitando su distribución y verificación en redes P2P como BitTorrent.
-   **Auditorías de Seguridad:** En entornos de seguridad, se utiliza para verificar la integridad de los binarios del sistema y detectar posibles compromisos.
-   **Almacenamiento y Respaldo:** Asegurar que los datos respaldados se almacenan correctamente y sin corrupción.
-   **Manejo de Grandes Colecciones de Archivos:** Su capacidad recursiva para procesar directorios completos lo hace eficiente para grandes colecciones de archivos.

## ¿Cómo se usa?

RHash es una herramienta de línea de comandos.

### 1. Instalación

En la mayoría de las distribuciones de Linux, RHash se puede instalar directamente desde los repositorios:

```bash
sudo apt install rhash # En sistemas basados en Debian/Ubuntu
sudo dnf install rhash # En sistemas basados en RHEL/Fedora
```

### 2. Ejemplos de Uso Básico

1.  **Calcular el Hash Predeterminado (CRC32) de un Archivo:**
    ```bash
    rhash mi_documento.zip
    ```
    La salida mostrará el hash CRC32.

2.  **Calcular Múltiples Hashes para un Archivo:**
    Puedes especificar varios algoritmos de hash. Por ejemplo, para obtener MD5, SHA1 y CRC32:
    ```bash
    rhash --md5 --sha1 --crc32 mi_documento.zip
    ```
    También puedes usar `-a` o `--all` para calcular todos los hashes soportados:
    ```bash
    rhash -a mi_documento.zip
    ```

3.  **Calcular Hashes para un Directorio Entero (Recursivo):**
    La opción `-r` o `--recursive` permite procesar todos los archivos dentro de un directorio y sus subdirectorios.

    ```bash
    rhash -a -r mis_archivos/
    ```

4.  **Generar un Archivo de Checksums:**
    Puedes generar un archivo que contenga los hashes de uno o más archivos, que luego puede usarse para verificar su integridad. La opción `-o` especifica el archivo de salida.

    ```bash
    rhash --sha256 mi_documento.zip -o mi_documento.sha256
    ```
    O para todos los archivos en un directorio:
    ```bash
    rhash -a -r mis_archivos/ -o mis_archivos.rhash
    ```

5.  **Verificar la Integridad de Archivos con un Archivo de Checksums:**
    Usa la opción `-c` o `--check` para verificar archivos contra un archivo de hashes previamente generado.

    ```bash
    rhash -c mi_documento.sha256
    ```
    RHash te informará si los archivos coinciden o si han sido modificados.

6.  **Generar un Enlace Magnet:**
    Para un archivo específico:
    ```bash
    rhash --magnet mi_video.mp4
    ```

### 3. Opciones de Uso Comunes

-   `-V` o `--version`: Muestra la versión de RHash.
-   `-h` o `--help`: Muestra la ayuda.
-   `-u` o `--update`: Actualiza un archivo hash existente, añadiendo sumas para nuevos archivos o sobrescribiendo sumas de archivos modificados.
-   `-v` o `--verbose`: Muestra un progreso detallado.
-   `--lorem`: Genera texto de lorem ipsum y calcula su hash (útil para pruebas).

## Otras Consideraciones

-   **Algoritmos Seguros:** Para la verificación de integridad crítica, se recomienda utilizar algoritmos de la familia SHA-2 (SHA256, SHA512) o SHA3, ya que MD5 y SHA1 se consideran criptográficamente débiles.
-   **Velocidad:** RHash está optimizado para la velocidad y puede procesar grandes volúmenes de datos de manera eficiente.
-   **Integración:** Es una herramienta de línea de comandos que se puede integrar fácilmente en scripts de shell para automatizar tareas.
