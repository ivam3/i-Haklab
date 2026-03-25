# Zsh (Z Shell)

## ¿Qué es Zsh?

**Zsh** es una shell de Unix potente y altamente personalizable que se basa en Bash pero incluye numerosas mejoras y características avanzadas. Es conocida por su flexibilidad, su potente sistema de autocompletado y su capacidad para integrarse con una vasta gama de temas y plugins que mejoran drásticamente la experiencia del usuario en la terminal.

En i-Haklab, Zsh viene preconfigurada para ofrecer un entorno de trabajo moderno, visualmente atractivo y extremadamente productivo.

## ¿Para qué es útil la herramienta?

Zsh mejora significativamente el flujo de trabajo diario gracias a:

*   **Autocompletado Inteligente:** Mucho más potente que el de Bash, permitiendo navegar por archivos, comandos y opciones de forma visual y rápida.
*   **Corrección Ortográfica:** Capaz de detectar y sugerir correcciones para comandos mal escritos.
*   **Plugins de Productividad:** i-Haklab incluye por defecto:
    *   `zsh-autosuggestions`: Sugiere comandos basados en tu historial mientras escribes.
    *   `zsh-syntax-highlighting`: Colorea los comandos en tiempo real para indicar si la sintaxis es correcta antes de ejecutarla.
*   **Personalización del Prompt:** Permite mostrar información útil como el usuario actual, la ruta, el estado de Git, etc., de forma clara.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez configurada mediante `pkg2conf`, puedes entrar a Zsh simplemente escribiendo su nombre:

**Ejemplo 1: Iniciar Zsh**

```bash
zsh
```

**Ejemplo 2: Usar las autosugerencias**

Empieza a escribir un comando frecuente. Zsh lo completará en gris. Presiona `Ctrl + F` o la tecla `Flecha Derecha` para aceptarlo.

**Ejemplo 3: Navegación rápida**

En Zsh, muchas veces ni siquiera necesitas escribir `cd` para entrar en una carpeta:
```bash
/data/data/com.termux/files/home
```
(Si la opción `autocd` está activa, entrarás directamente al directorio).

## Consideraciones Adicionales

*   **Configuración:** El archivo de configuración principal se encuentra en `~/.zshrc`, el cual en i-Haklab es un enlace simbólico a `~/.local/etc/zsh/zshrc`.
*   **Plugins:** Los plugins se gestionan localmente en `~/.local/share/zsh/plugins/` para garantizar velocidad y funcionamiento offline.
*   **Compatibilidad:** Zsh es compatible con la gran mayoría de scripts de Bash, pero ofrece una experiencia interactiva muy superior.

---
*Nota: Zsh es la shell recomendada para usuarios avanzados de i-Haklab que buscan el máximo rendimiento en su terminal.*
