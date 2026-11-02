# comandle

## ¿Qué es comandle?

`comandle` es un juego diario de terminal inspirado en Wordle: cada día hay un comando de Linux o de seguridad que debes adivinar en un máximo de 6 intentos. Al terminar la ronda, la herramienta explica el comando con una descripción, tres ejemplos y una nota de seguridad.

Está escrito en Go como un binario único y también puede jugarse desde el navegador con el mismo comando del día. Fue creado por VT Security y publicado por Legios bajo licencia Apache-2.0.

## ¿Para qué es útil?

*   **Aprender comandos:** refuerza el reconocimiento de comandos reales de Linux y de seguridad de forma entretenida.
*   **Práctica guiada:** el modo `practica` permite jugar rondas fuera de la partida diaria, incluso eligiendo un comando puntual para una clase o demostración.
*   **Consultar fichas:** `explicar` muestra qué hace cualquier comando de la lista, con ejemplos y consideraciones de seguridad.
*   **Seguimiento personal:** guarda tus estadísticas y tu racha localmente, sin cuentas ni telemetría en la versión de terminal.

## ¿Cómo se usa? (Ejemplos básicos)

**Instalación desde i-Haklab:**

```bash
apt install comandle
```

**Instalación con Go 1.27 o superior:**

```bash
go install github.com/legiosai/comandle@latest
```

**Comandos principales:**

```bash
comandle                  # juega el comando del día
comandle practica         # ronda aleatoria que no suma a tus estadísticas
comandle practica nmap    # practica un comando puntual
comandle explicar chmod   # muestra la ficha de un comando
comandle lista            # comandos de los días anteriores
comandle stats            # tus estadísticas y tu racha
```

**Mecánica de juego:**

Escribes un comando de la misma cantidad de letras que el objetivo. Cada letra se marca en verde si está en la posición correcta, en amarillo si existe pero en otra posición y en gris si no pertenece al comando. La categoría se muestra desde el inicio y se revelan pistas tras dos, cuatro y cinco intentos fallidos. En la terminal, `?` lista los comandos válidos para esa longitud.

**Versión web:** https://comandle.valentorassa.com

## Consideraciones Adicionales

*   **Estadísticas locales:** en la terminal se guardan en `$XDG_STATE_HOME/comandle/stats.json` si la variable está definida, o en `~/.config/comandle/` en Linux. La versión de terminal no se conecta a internet.
*   **Sin colores:** con `NO_COLOR=1` o cuando la salida no es una terminal, las letras se representan como `[x]` (posición correcta) y `(x)` (posición incorrecta).
*   **Privacidad:** la web solo suma contadores anónimos y no usa cookies ni identificadores; respeta Global Privacy Control.
*   **Uso educativo:** no es una herramienta ofensiva; su objetivo es familiarizarte con comandos reales y sus implicaciones de seguridad.

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
