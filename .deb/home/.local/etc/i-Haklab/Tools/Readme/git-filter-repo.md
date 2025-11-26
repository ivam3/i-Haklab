
# git-filter-repo

## ¿Qué es git-filter-repo?

`git-filter-repo` es una herramienta de línea de comandos para reescribir el historial de un repositorio de Git de manera rápida y segura. Es el sucesor recomendado para el comando `git filter-branch`, ya que es significativamente más rápido, más fácil de usar y menos propenso a errores.

Esta herramienta permite realizar cambios masivos en todo el historial de commits de un repositorio, como eliminar archivos, cambiar nombres de directorios, o modificar información de autor en commits antiguos.

## ¿Para qué es útil la herramienta?

`git-filter-repo` es extremadamente útil para la limpieza y mantenimiento de repositorios de Git. Los casos de uso más comunes son:

-   **Eliminar Datos Sensibles:** Permite purgar completamente un archivo que contenía información sensible (como contraseñas, claves de API, etc.) de todo el historial del repositorio. Un `git rm` normal solo lo elimina del commit actual, pero el archivo permanece en los commits anteriores.
-   **Limpiar Archivos Grandes:** Eliminar archivos grandes y no deseados que se añadieron por error y que están inflando el tamaño del repositorio.
-   **Reestructurar un Repositorio:** Mover todo el contenido de un proyecto a un subdirectorio o, por el contrario, extraer un subdirectorio para convertirlo en su propio repositorio.
-   **Corregir Información de Autor:** Unificar el nombre y correo electrónico de un autor si ha estado haciendo commits con diferentes configuraciones.
-   **Dividir un Monorepo:** Extraer el historial de un subdirectorio específico para crear un nuevo repositorio a partir de él.

## ¿Cómo se usa?

**¡Advertencia!** Esta herramienta reescribe el historial de Git (cambia los hashes de los commits). Esta es una operación destructiva. **Siempre haz una copia de seguridad (un clon limpio) de tu repositorio antes de usarla.**

### 1. Instalación

La forma más común de instalarlo es a través de `pip` (el gestor de paquetes de Python) o el gestor de paquetes de tu sistema.

```bash
# Usando pip (recomendado)
pip install git-filter-repo

# En Debian/Ubuntu
sudo apt install git-filter-repo

# En macOS (con Homebrew)
brew install git-filter-repo
```

### 2. Ejemplos de Uso

Todos los comandos se ejecutan dentro del repositorio de Git que deseas modificar.

-   **Eliminar un archivo de todo el historial:**
    Para purgar `ruta/al/archivo_secreto.txt` de cada commit en la historia:
    ```bash
    git filter-repo --path ruta/al/archivo_secreto.txt --invert-paths
    ```

-   **Eliminar una carpeta de todo el historial:**
    Para purgar la carpeta `node_modules/` (y su contenido) de la historia:
    ```bash
    git filter-repo --path node_modules/ --invert-paths
    ```

-   **Mantener solo una carpeta y eliminar todo lo demás:**
    Esto es útil para dividir un repositorio. Convierte el directorio `mi-proyecto/` en la nueva raíz del repositorio, conservando solo su historial.
    ```bash
    git filter-repo --path mi-proyecto/
    ```

-   **Renombrar una carpeta en todo el historial:**
    ```bash
    git filter-repo --path-rename old_name:new_name
    ```

-   **Cambiar la información de autor:**
    Crea un archivo `mailmap.txt` con el formato: `Nombre Nuevo <nuevo@email.com> Nombre Viejo <viejo@email.com>`
    Y luego ejecuta:
    ```bash
    git filter-repo --mailmap mailmap.txt
    ```

### 3. Después de filtrar

Después de ejecutar `git-filter-repo`, tu historial local estará modificado. Para aplicar estos cambios al repositorio remoto, necesitarás forzar el push. **Esto es peligroso si trabajas en equipo, asegúrate de coordinar con todos.**

```bash
# Revisa que el historial local se vea como esperas (con git log, etc.)
# Luego, añade tu remoto de nuevo (filter-repo lo elimina por seguridad)
git remote add origin <URL_del_remoto>

# Fuerza el push para sobrescribir el historial remoto
git push origin --force --all
git push origin --force --tags
```
