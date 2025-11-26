
# hexer

## ¿Qué es hexer?

`hexer` es un editor hexadecimal de línea de comandos para sistemas tipo Unix. Está diseñado para ver y editar archivos binarios, mostrando su contenido tanto en formato hexadecimal como en caracteres ASCII (o el conjunto de caracteres actual) cuando es posible. Su interfaz de usuario está inspirada en el popular editor de texto `vi/ex`, lo que lo hace familiar para usuarios que ya dominan `vi`.

Permite la edición de múltiples archivos simultáneamente (multi-buffer) y ofrece funcionalidades avanzadas para manipular datos a nivel de byte.

## ¿Para qué es útil la herramienta?

`hexer` es una herramienta valiosa para desarrolladores, administradores de sistemas, ingenieros inversos y profesionales de la seguridad:

-   **Edición de Archivos Binarios:** Modificar directamente el contenido de archivos ejecutables, bibliotecas, imágenes de disco o cualquier otro archivo que no sea de texto.
-   **Ingeniería Inversa:** Analizar el funcionamiento interno de programas, firmware o protocolos, examinando y modificando sus datos binarios.
-   **Análisis Forense:** Inspeccionar datos en busca de artefactos ocultos, metadatos o evidencia en archivos binarios.
-   **Debugging de Bajo Nivel:** Entender cómo los programas almacenan datos y cómo se ejecutan a nivel de máquina.
-   **Recuperación de Datos:** En algunos casos, puede usarse para corregir pequeñas corrupciones en archivos a nivel de byte.

## ¿Cómo se usa?

`hexer` se invoca desde la línea de comandos. Su operación se basa en los modos de `vi`: modo comando (para navegación y ejecución de comandos) y modo inserción (para editar datos).

### 1. Invocación

Para abrir un archivo en `hexer`:

```bash
hexer <nombre_del_archivo>
```

Si el archivo no existe, `hexer` lo creará.

### 2. Navegación Básica (Modo Comando)

Una vez abierto el archivo, estarás en el modo comando.

-   **Movimiento del cursor:**
    -   `h`, `j`, `k`, `l`: Mover el cursor (izquierda, abajo, arriba, derecha).
    -   `w`, `b`: Mover a la siguiente/anterior "palabra" (secuencia de bytes no nulos).
    -   `0`, `^`: Ir al principio de la línea actual.
    -   `$`: Ir al final de la línea actual.
    -   `G`: Ir al final del archivo.
    -   `gg`: Ir al principio del archivo.
    -   `<offset>G`: Ir al offset `offset` (en hexadecimal).

-   **Búsqueda:**
    -   `/patrón`: Buscar una secuencia de bytes. El `patrón` puede ser una cadena de texto o bytes hexadecimales.
    -   `n`, `N`: Ir a la siguiente/anterior ocurrencia de la búsqueda.

### 3. Edición de Datos (Modo Inserción y Reemplazo)

-   **Modo Inserción (`i`, `a`):**
    -   Presiona `i` para insertar bytes antes de la posición actual del cursor.
    -   Presiona `a` para insertar bytes después de la posición actual del cursor.
    -   Escribe los bytes en hexadecimal. Por ejemplo, `41` insertará la letra 'A'.
    -   Presiona `Esc` para salir del modo inserción.

-   **Modo Reemplazo (`r`, `R`):**
    -   Presiona `r` para reemplazar un solo byte en la posición actual. Introduce el nuevo byte hexadecimal.
    -   Presiona `R` para entrar en modo reemplazo, permitiéndote sobrescribir múltiples bytes a partir de la posición actual.
    -   Presiona `Esc` para salir del modo reemplazo.

### 4. Guardar y Salir

-   `:w`: Guarda los cambios en el archivo.
-   `:q`: Sale de `hexer` (si no hay cambios sin guardar).
-   `:wq` o `:x`: Guarda los cambios y sale.
-   `:q!`: Sale de `hexer` sin guardar los cambios.

### 5. Deshacer/Rehacer

-   `u`: Deshace la última operación.
-   `Ctrl-R`: Rehace una operación deshecha.

## Otras Consideraciones

-   **Cuidado:** La edición de archivos binarios es una operación de bajo nivel que puede corromper un archivo si no se hace correctamente. Siempre trabaja en copias de seguridad de archivos importantes.
-   **Limitaciones:** `hexer` carga el archivo completo en la memoria, por lo que no es adecuado para editar archivos extremadamente grandes que superen la RAM disponible.
-   **Dependencias:** `hexer` es una utilidad nativa de Unix, por lo que generalmente no tiene dependencias externas complejas más allá de las librerías estándar del sistema.
