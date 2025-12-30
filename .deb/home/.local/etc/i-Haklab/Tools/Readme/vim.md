# vim

## ¿Qué es vim?

Vim (Vi IMproved) es un editor de texto altamente configurable construido para permitir una edición de texto muy eficiente. Es una versión mejorada del editor `vi`, que es estándar en casi todos los sistemas UNIX. Vim es conocido por su sistema "modal", donde las teclas tienen diferentes funciones dependiendo del modo en que te encuentres.

## ¿Para qué es útil la herramienta?

*   **Eficiencia:** Una vez dominado, permite editar y manipular texto a una velocidad muy superior a los editores convencionales.
*   **Disponibilidad:** Está presente en prácticamente cualquier servidor Linux/Unix, lo que lo hace indispensable para administradores de sistemas.
*   **Potencia:** Soporta macros, autocompletado, resaltado de sintaxis para cientos de lenguajes, y es infinitamente extensible mediante scripts y plugins.
*   **Recursos:** Es muy ligero y funciona perfectamente en terminales remotas con conexiones lentas.

## ¿Cómo se usa? (Ejemplos básicos)

Vim tiene una curva de aprendizaje pronunciada. Lo básico es entender los modos.

**Modos Principales:**
*   **Normal:** Para navegar y manipular texto (es el modo por defecto).
*   **Insertar:** Para escribir texto (como un editor normal).
*   **Comando:** Para guardar, salir, buscar, etc.

**Ejemplo 1: Abrir un archivo**

```bash
vim archivo.txt
```

**Ejemplo 2: Escribir texto**

1.  Presiona `i` para entrar en modo **Insertar**.
2.  Escribe tu texto.
3.  Presiona `Esc` para volver al modo **Normal**.

**Ejemplo 3: Guardar y Salir**

Desde el modo Normal:
1.  Escribe `:w` y `Enter` para guardar (Write).
2.  Escribe `:q` y `Enter` para salir (Quit).
3.  O combina ambos: `:wq` (Guardar y Salir).
4.  Para salir sin guardar cambios: `:q!`

**Ejemplo 4: Navegación básica (Modo Normal)**

*   `h`, `j`, `k`, `l`: Izquierda, Abajo, Arriba, Derecha.
*   `dd`: Borrar (cortar) una línea.
*   `u`: Deshacer (Undo).

## Consideraciones Adicionales

*   **vimtutor:** Vim incluye un excelente tutorial interactivo. Ejecuta el comando `vimtutor` en tu terminal para aprender lo básico en 30 minutos.
*   **Configuración:** El archivo de configuración es `~/.vimrc`.
*   **Versiones:** Existe `vi` (el original, más limitado), `vim` (el estándar) y `neovim` (una refactorización moderna).

---
*Nota: Salir de Vim es el chiste más viejo de la informática, pero `:q!` te salvará la vida.*
