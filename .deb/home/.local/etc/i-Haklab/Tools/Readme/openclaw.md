# OpenClaw

## ¿Qué es OpenClaw?

**OpenClaw** es una reimplementación de código abierto y multiplataforma del motor del clásico juego de plataformas **Captain Claw (1997)**. Escrito principalmente en C++ y utilizando la librería SDL2, este proyecto busca permitir que el juego original se ejecute de manera fluida en sistemas modernos (incluyendo Android vía Termux), corrigiendo errores del motor original y añadiendo mejoras técnicas sin alterar la esencia del juego.

## ¿Para qué es útil la herramienta?

OpenClaw es ideal para los entusiastas de los juegos retro que desean revivir las aventuras de Nathaniel Joseph Claw en hardware actual, ofreciendo:

*   **Compatibilidad Moderna:** Ejecución nativa en Linux y Android sin necesidad de emuladores pesados o capas de compatibilidad lentas.
*   **Soporte de Resoluciones:** Permite jugar en pantallas modernas con mejores opciones de escalado y rendimiento estable.
*   **Código Abierto:** Facilita la preservación del juego y permite a la comunidad aplicar correcciones y mejoras visuales.
*   **Ligereza:** Al ser una ejecución nativa, consume muy pocos recursos, lo que lo hace perfecto para dispositivos móviles.

## ¿Cómo se usa? (Ejemplos básicos)

Para que OpenClaw funcione, es imprescindible contar con los archivos de datos originales del juego.

**Ejemplo 1: Iniciar el juego (si los datos están en la carpeta por defecto)**

```bash
openclaw
```

**Ejemplo 2: Ejecutar especificando la ruta de los archivos del juego**

```bash
openclaw --path /ruta/a/la/carpeta/de/CaptainClaw
```

## Consideraciones Adicionales

*   **Archivos de Datos:** Por razones legales, OpenClaw **no incluye** los archivos del juego. El usuario debe proporcionar el archivo principal `CLAW.PWD` y otros recursos originales.
*   **Dependencias:** En el entorno de i-Haklab, asegúrate de tener instaladas las librerías necesarias (`SDL2`, `SDL2_image`, `SDL2_mixer`, `SDL2_ttf`).
*   **Estado del Proyecto:** Es una recreación del motor, por lo que algunas cinemáticas o comportamientos específicos de la IA pueden variar ligeramente respecto a la versión original de Monolith Productions.

---
*Nota: Esta herramienta permite preservar y disfrutar del legado de los juegos de plataformas clásicos dentro del ecosistema i-Haklab.*
