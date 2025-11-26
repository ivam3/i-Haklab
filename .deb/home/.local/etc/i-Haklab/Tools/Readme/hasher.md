
# Herramienta Hasher (Calculador de Hash)

## ¿Qué es una Herramienta Hasher?

Una "herramienta hasher" o "calculador de hash" es una aplicación de software diseñada para generar un valor hash criptográfico de un archivo o conjunto de datos. Un valor hash es una cadena alfanumérica de longitud fija que se produce a partir de los datos de entrada mediante un algoritmo matemático específico (como MD5, SHA-1, SHA-256, etc.). Una característica fundamental de los hashes es que cualquier cambio, por mínimo que sea, en los datos originales, producirá un valor hash completamente diferente.

Estos valores hash actúan como una "huella digital" única para el archivo, lo que permite verificar su integridad.

## ¿Para qué es útil la herramienta?

Las herramientas hasher son fundamentales en ciberseguridad, administración de sistemas y desarrollo de software por varias razones:

-   **Verificación de Integridad de Archivos:** Es el uso más común. Permite confirmar que un archivo no ha sido modificado, corrompido o manipulado durante su almacenamiento o transmisión. Esto se logra comparando el hash calculado de un archivo descargado con un valor hash de confianza proporcionado por el distribuidor original.
-   **Comparación Rápida de Archivos:** Permite determinar si dos archivos son idénticos sin necesidad de comparar su contenido completo, lo cual es mucho más eficiente para archivos grandes. Si sus valores hash coinciden, los archivos son idénticos.
-   **Seguridad de Datos:** Los hashes son la base de muchas aplicaciones de seguridad, como el almacenamiento seguro de contraseñas (solo se guarda el hash de la contraseña, no la contraseña en texto plano) o la creación de firmas digitales.
-   **Detección de Archivos Maliciosos:** Los hashes de malware conocido a menudo se utilizan para identificar y bloquear amenazas.

## ¿Cómo se usa?

En entornos Linux y Unix, la mayoría de las herramientas hasher son comandos de línea que vienen preinstalados o son fácilmente accesibles. Los más comunes son `md5sum`, `sha1sum`, `sha256sum`, `sha512sum`, etc.

### Sintaxis Básica

```bash
<nombre_del_comando_hash> <ruta_del_archivo>
```

### Ejemplos de Uso

1.  **Calcular el hash MD5 de un archivo:**
    ```bash
    md5sum mi_documento.pdf
    ```
    La salida será algo como: `e4d7f1a3b9c2d8e7f6a5b4c3d2e1f0a9  mi_documento.pdf`

2.  **Calcular el hash SHA-256 de un archivo:**
    SHA-256 es un algoritmo más seguro y recomendado para la verificación de integridad hoy en día.
    ```bash
    sha256sum mi_aplicacion.zip
    ```
    La salida será algo como: `a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6e7f8a9b0c1d2e3f4a5b6c7d8e9f0a1b2  mi_aplicacion.zip`

3.  **Verificar la integridad de un archivo (comparando con un hash conocido):**
    Imagina que has descargado `archivo.iso` y el proveedor te ha dado un hash SHA-256 para verificarlo (por ejemplo, `5c02b1f8e1c6d5b4a3e2f1d0c9b8a7e6d5c4b3a2e1f0d9c8b7a6e5d4c3b2a1f0`).

    a. **Calcula el hash del archivo descargado:**
    ```bash
    sha256sum archivo.iso
    ```
    b. **Compara la salida con el hash proporcionado.** Si son idénticos, el archivo es íntegro.

    Muchas herramientas hash también pueden leer un archivo de "checksums" para verificar múltiples archivos a la vez. Por ejemplo, si tienes un archivo `checksums.txt` con líneas como:
    ```
    5c02b1f8e1c6d5b4a3e2f1d0c9b8a7e6d5c4b3a2e1f0d9c8b7a6e5d4c3b2a1f0  archivo1.iso
    a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6e7f8a9b0c1d2e3f4a5b6c7d8e9f0a1b2  archivo2.zip
    ```
    Puedes verificar todos los archivos de la siguiente manera:
    ```bash
    sha256sum -c checksums.txt
    ```
    Esto reportará si cada archivo `OK` o `FAILED`.

## Otras Consideraciones

-   **Algoritmos de Hash:**
    -   **MD5 y SHA-1:** Aunque todavía se usan, se consideran criptográficamente débiles y no se recomiendan para fines de seguridad crítica debido a la posibilidad de colisiones (dos archivos diferentes que producen el mismo hash).
    -   **SHA-256 y SHA-512 (familia SHA-2):** Son los algoritmos más recomendados actualmente para la verificación de integridad y seguridad.
-   **Disponibilidad:** Estas herramientas son estándar en la mayoría de los sistemas operativos basados en Linux/Unix y también están disponibles para Windows (a menudo a través de Git Bash, WSL o herramientas de terceros).
