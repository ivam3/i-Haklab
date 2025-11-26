# tmux (Terminal Multiplexer)

## ¿Qué es tmux?

tmux es un **multiplexor de terminal**. Es una herramienta de línea de comandos que te permite crear, gestionar y moverte entre múltiples terminales virtuales dentro de una única ventana de terminal.

Imagina que es un **gestor de ventanas, pero para tu terminal**. En lugar de tener varias ventanas de terminal abiertas en tu escritorio, puedes tener una sola ventana de `tmux` que contenga múltiples "pestañas" (llamadas **ventanas**) y "divisiones" (llamadas **paneles**).

Su característica más poderosa es la capacidad de **desvincularse (detach) y volver a vincularse (attach)** a las sesiones.

## ¿Para qué es útil?

`tmux` es una herramienta indispensable para administradores de sistemas, desarrolladores y cualquier persona que pase mucho tiempo en la línea de comandos.

*   **Persistencia de Sesiones:** Puedes iniciar un proceso largo (como una compilación, una descarga o un script) en un servidor remoto, desvincularte de la sesión de `tmux`, cerrar tu conexión SSH, y volver a conectarte horas después para encontrar el proceso todavía en ejecución, exactamente como lo dejaste. ¡Esto es un cambio de juego para el trabajo remoto!
*   **Multitarea Eficiente:** Permite tener varios contextos de trabajo visibles al mismo tiempo. Por ejemplo, puedes tener un editor de código como `vim` en un panel, la salida de un servidor en otro, y una shell libre en un tercero, todo en la misma pantalla.
*   **Organización:** Ayuda a mantener tu espacio de trabajo limpio y organizado, agrupando las terminales relacionadas en una sola sesión de `tmux`.
*   **Pair Programming (Programación en Pareja):** Permite que varios usuarios se conecten a la misma sesión de `tmux` para ver y escribir en la misma terminal, lo cual es genial para la colaboración remota.

## ¿Cómo se usa? (Conceptos y Comandos Básicos)

`tmux` funciona con un sistema de **prefijo + tecla**. Por defecto, el prefijo es `Ctrl+b`. Esto significa que primero presionas `Ctrl+b` y luego sueltas esas teclas y presionas la tecla del comando que quieres ejecutar.

**Sesiones:**
*   `tmux new -s mi_sesion`: Crea una nueva sesión llamada "mi_sesion".
*   `tmux ls`: Lista todas las sesiones de `tmux` en ejecución.
*   `tmux attach -t mi_sesion`: Se vincula a una sesión existente.
*   `Ctrl+b` luego `d`: Se desvincula de la sesión actual (la deja corriendo en segundo plano).

**Ventanas (Pestañas):**
*   `Ctrl+b` luego `c`: Crea una nueva ventana.
*   `Ctrl+b` luego `p`: Va a la ventana anterior (previous).
*   `Ctrl+b` luego `n`: Va a la ventana siguiente (next).
*   `Ctrl+b` luego `w`: Muestra una lista de ventanas para seleccionar.

**Paneles (Divisiones):**
*   `Ctrl+b` luego `%`: Divide el panel actual verticalmente.
*   `Ctrl+b` luego `"`: Divide el panel actual horizontalmente.
*   `Ctrl+b` luego `flechas (↑, ↓, ←, →)`: Se mueve entre los paneles.

## Consideraciones Adicionales

*   **No es una herramienta de hacking:** `tmux` es una utilidad de productividad para la terminal. No tiene capacidades ofensivas, pero es utilizada por casi todos los profesionales de la ciberseguridad para gestionar su flujo de trabajo.
*   **Altamente Configurable:** Puedes personalizar casi todo en `tmux`, desde el prefijo de los comandos hasta los colores y la barra de estado, editando el archivo `~/.tmux.conf`.
*   **Alternativa a `screen`:** `tmux` es el sucesor moderno del comando `screen`, ofreciendo una experiencia de usuario más amigable y una configuración más sencilla.

---
*Nota: Aprender a usar `tmux` es una de las inversiones de tiempo más rentables que puede hacer un usuario de la línea de comandos. Mejora drásticamente la productividad.*
