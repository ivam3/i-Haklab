# fish

## ¿Qué es fish?

`fish` (Friendly Interactive SHell) es una shell de línea de comandos inteligente y fácil de usar para Linux, macOS y otros sistemas operativos. A diferencia de bash o zsh, que a menudo requieren una configuración extensa para ser amigables, `fish` está diseñada para ofrecer una gran experiencia de usuario desde el primer momento.

## ¿Para qué es útil la herramienta?

`fish` mejora significativamente la productividad en la terminal gracias a:

*   **Autosugerencias:** Sugiere comandos mientras escribes basándose en tu historial y en los archivos del directorio actual.
*   **Resaltado de sintaxis:** Colorea los comandos en tiempo real, indicando si son válidos (azul) o inválidos (rojo), y resaltando cadenas y rutas.
*   **Navegación intuitiva:** Facilita la navegación por directorios y variables sin necesidad de plugins externos.
*   **Configuración web:** Incluye una herramienta de configuración basada en navegador para cambiar colores y el prompt.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalada, puedes entrar a `fish` simplemente escribiendo su nombre, o configurarla como tu shell por defecto.

**Ejemplo 1: Iniciar fish**

```bash
fish
```

**Ejemplo 2: Usar autosugerencias**

Empieza a escribir un comando que hayas usado antes. `fish` lo mostrará en un color atenuado a la derecha del cursor.
*   Para aceptar la sugerencia completa, presiona `Flecha Derecha` o `Ctrl + F`.
*   Para aceptar palabra por palabra, presiona `Alt + Flecha Derecha`.

**Ejemplo 3: Definir una función (alias)**

La sintaxis de `fish` es ligeramente diferente a la de bash.

```fish
function ll
    ls -lh $argv
end
funcsave ll
```
Esto crea un comando `ll` persistente.

**Ejemplo 4: Configuración visual**

Para abrir la interfaz de configuración web:

```fish
fish_config
```

## Consideraciones Adicionales

*   **Compatibilidad POSIX:** `fish` **no** es totalmente compatible con POSIX (como bash). Los scripts escritos para `sh` o `bash` pueden no funcionar directamente en `fish`. Debes ejecutarlos con `bash script.sh`.
*   **Variables:** La asignación de variables es diferente (`set variable valor` en lugar de `variable=valor`).

---
*Nota: Fish es ideal para uso interactivo diario, aunque para scripting de sistema se suele preferir bash por su portabilidad.*
