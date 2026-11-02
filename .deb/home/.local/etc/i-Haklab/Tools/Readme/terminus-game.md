# terminus-game

## ¿Qué es terminus-game?

`terminus-game` es un juego de aventura de texto para aprender a usar la línea de comandos de Linux. La historia te lleva por un mundo de fantasía (bosques, academias de magia, cuevas y ciudades) donde los hechizos son en realidad comandos reales de Unix/Linux: `ls`, `cd`, `less`, `pwd`, `cp`, `mv`, `rm`, `grep`, `touch` y `sudo`.

Es un port nativo para Termux del juego original **Terminus** de Michele Pratusevich. Reproduce la lógica y el texto original en inglés mediante Node.js y sustituye el terminal del navegador por una interfaz de línea de comandos, con soporte opcional de imágenes en la terminal.

## ¿Para qué es útil?

*   **Aprender comandos jugando:** cada comando se introduce en un contexto narrativo y se practica hasta interiorizarlo.
*   **Practicar la terminal:** refuerza rutas, navegación entre directorios, lectura de archivos, búsqueda de texto y manipulación de objetos.
*   **Sin conocimientos previos:** el juego incluye un anciano que explica cada comando con `man COMANDO`.
*   **Progreso persistente:** guarda la partida automáticamente y la retoma donde la dejaste.
*   **Uso educativo:** ideal para quien empieza con Linux, para talleres o para repasar comandos básicos.

## ¿Cómo se usa? (Ejemplos básicos)

**Instalación desde i-Haklab:**

```bash
pkg install terminus-game
terminus-game --version
```

**Iniciar el juego:**

```bash
terminus-game
```

Dentro del juego, los primeros pasos son:

```text
ls
cd WesternForest
less Sign
pwd
man ls
```

**Opciones útiles:**

```bash
terminus-game --reset          # comenzar una partida nueva
terminus-game --no-save        # jugar sin guardar
terminus-game --save archivo   # usar un archivo de guardado propio
terminus-game --images=chafa   # mostrar imágenes en la terminal
terminus-game --images=open    # abrir imágenes con termux-open
terminus-game --images=off     # desactivar imágenes
terminus-game --script archivo # ejecutar comandos desde un archivo
terminus-game --help
```

**Imágenes (opcional):**

```bash
pkg install chafa
terminus-game --images=auto
```

Sin `chafa` el juego funciona igual, solo que sin dibujos.

**Partida guardada:**

```bash
cat ~/.local/share/terminus-game/save.json
```

**Eliminación:**

```bash
pkg remove terminus-game
```

El archivo de guardado se conserva; bórralo manualmente (o usa `--reset`) para empezar de cero.

## Consideraciones Adicionales

*   **Contenido en inglés:** el texto del juego es el original de Terminus; esta documentación está en español.
*   **Dependencia:** requiere `nodejs-lts` (proporciona `node`).
*   **Imágenes opcionales:** `chafa` para dibujos en la terminal o `termux-api` (`termux-open`) para abrirlos en una app externa.
*   **Guardado:** `~/.local/share/terminus-game/save.json`. Puedes cambiarlo con `--save` o la variable `TERMINUS_SAVE`. Sobrevive a actualizaciones, reinstalaciones y a la desinstalación del paquete.
*   **Compatibilidad:** arquitectura `all`; no usa proot, glibc ni servicios externos.
*   **Créditos:** juego original de Michele Pratusevich, publicado bajo licencia GPL-2.0. Repositorio: https://github.com/mprat/Terminus

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
