# GDB (GNU Project Debugger)

## ¿Qué es GDB?

GDB, el **GNU Project Debugger**, es la herramienta estándar y más utilizada en entornos Unix/Linux para **depurar programas** que se ejecutan en tiempo real. Es un depurador de línea de comandos que permite a los desarrolladores y analistas inspeccionar lo que sucede dentro de un programa mientras se está ejecutando o después de que ha fallado.

GDB es compatible con una amplia variedad de lenguajes de programación, incluyendo C, C++, Rust, Go, Fortran y muchos otros. Es una herramienta indispensable para cualquier programador o ingeniero inverso que trabaje con código compilado.

## ¿Para qué es útil la herramienta?

GDB proporciona un control y una visibilidad sin precedentes sobre la ejecución de un programa, lo que lo hace útil para:

*   **Identificar y Corregir Errores (Debugging):** El propósito principal. Permite a los desarrolladores encontrar la causa raíz de los fallos, los errores de segmentación (segmentation faults), los bucles infinitos, y otros bugs.
*   **Análisis Forense y de Seguridad:** Los analistas pueden usar GDB para inspeccionar el estado de un programa malicioso, entender su comportamiento, extraer información (como claves o payloads) de su memoria, o analizar cómo se explota una vulnerabilidad.
*   **Ingeniería Inversa:** Permite a los ingenieros inversos comprender el flujo de control y los algoritmos de un programa compilado sin tener el código fuente original.
*   **Comprender la Ejecución de Programas:** Ayuda a los estudiantes a entender cómo funciona el código a un nivel muy bajo, cómo se utilizan los registros de la CPU, la pila, la memoria y el paso de parámetros.

## Funcionalidades Clave de GDB

GDB te permite realizar las siguientes acciones en un programa:

*   **Ejecutar un Programa:** Iniciar el programa y controlarlo.
*   **Puntos de Ruptura (Breakpoints):** Detener la ejecución del programa en líneas de código específicas o cuando se cumple una condición.
*   **Paso a Paso (Stepping):** Ejecutar el programa línea a línea (`step`) o función a función (`next`), observando los cambios en el estado.
*   **Inspeccionar Variables:** Ver el valor de las variables en cualquier punto de la ejecución.
*   **Inspeccionar Memoria:** Examinar el contenido de la memoria del programa.
*   **Modificar el Estado:** Cambiar el valor de las variables o incluso los registros de la CPU en tiempo de ejecución para probar diferentes escenarios.
*   **Stack Trace:** Ver la pila de llamadas para entender qué funciones llevaron al estado actual o al fallo.
*   **Debugging Remoto:** Depurar un programa que se ejecuta en una máquina diferente (por ejemplo, en un dispositivo embebido).

## ¿Cómo se usa? (Ejemplos básicos)

Para depurar un programa con GDB, el programa debe haber sido compilado con información de depuración (la opción `-g` en `gcc`).

**1. Compilar el programa con información de depuración:**

```bash
gcc -g -o mi_programa mi_programa.c
```

**2. Iniciar GDB:**

```bash
gdb ./mi_programa
```
Esto iniciará GDB y cargará `mi_programa`, pero no lo ejecutará aún. Estarás en el prompt de GDB (`(gdb)`).

### Comandos Básicos de GDB:

*   **`break <línea_o_función>`:** Establece un punto de ruptura.
    ```gdb
    (gdb) break main
    (gdb) break mi_programa.c:10
    ```

*   **`run`:** Inicia la ejecución del programa. Si hay un punto de ruptura, se detendrá allí.

*   **`continue` (o `c`):** Continúa la ejecución del programa hasta el siguiente punto de ruptura o hasta que termine.

*   **`next` (o `n`):** Ejecuta la siguiente línea de código, saltando por encima de las llamadas a funciones (no entra en ellas).

*   **`step` (o `s`):** Ejecuta la siguiente línea de código, entrando en las llamadas a funciones.

*   **`print <variable>` (o `p <variable>`):** Muestra el valor de una variable.
    ```gdb
    (gdb) print mi_variable
    (gdb) print *puntero
    ```

*   **`info locals`:** Muestra todas las variables locales en el ámbito actual.

*   **`info args`:** Muestra los argumentos de la función actual.

*   **`backtrace` (o `bt`):** Muestra la pila de llamadas, es decir, la secuencia de funciones que llevaron al punto actual.

*   **`quit` (o `q`):** Sale de GDB.

### Ejemplo de Sesión de Depuración:

```gdb
(gdb) break main
Breakpoint 1 at 0x40052d: file mi_programa.c, line 5.
(gdb) run
Starting program: /home/user/mi_programa

Breakpoint 1, main () at mi_programa.c:5
5       int a = 10;
(gdb) next
6       int b = 20;
(gdb) print a
$1 = 10
(gdb) next
7       int suma = a + b;
(gdb) print b
$2 = 20
(gdb) continue
Continuing.
Program exited normally.
```

## Consideraciones Adicionales

*   **Interfaz TUI:** GDB tiene una interfaz gráfica de usuario básica de texto (TUI) que se puede activar con `gdb -tui mi_programa`. Esto divide la pantalla para mostrar el código fuente, los registros y el prompt de GDB simultáneamente.
*   **Complementos:** Existen muchos complementos para GDB (como PEDA, GEF, Voltron) que mejoran su funcionalidad y visualización, especialmente para tareas de ingeniería inversa y explotación de binarios.
*   **Depuración de Fallos (Core Dumps):** GDB también puede abrir un archivo "core dump" (una instantánea del estado de la memoria de un programa en el momento de su fallo) para analizar la causa del error.

---
*Nota: GDB es una herramienta poderosa y compleja que requiere práctica para dominarla. Esencial para cualquier trabajo serio con código compilado.*
