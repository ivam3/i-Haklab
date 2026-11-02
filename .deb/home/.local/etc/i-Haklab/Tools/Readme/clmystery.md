# clmystery

## ¿Qué es clmystery?

`clmystery` (The Command Line Murders) es un juego interactivo para aprender a usar la línea de comandos. La historia plantea un asesinato en Terminal City y propone resolverlo investigando archivos con comandos reales de Unix/Linux: `cat`, `ls`, `grep`, `find`, `sort`, `uniq`, entre otros.

No es un binario: es un conjunto de archivos y pistas que se juega directamente desde la terminal. i-Haklab instala la versión original en inglés y la traducción al español.

## ¿Para qué es útil?

*   **Aprender comandos:** practica búsqueda, filtrado y análisis de datos sin necesidad de conocimientos previos.
*   **Pensar como investigador:** obliga a formular hipótesis y cruzar información de varias fuentes.
*   **Practicar la terminal:** refuerza el uso de rutas, tuberías (`|`), redirecciones y utilidades básicas.
*   **Uso educativo:** incluye hoja de trucos, pistas y solución para acompañar el aprendizaje.

## ¿Cómo se usa? (Ejemplos básicos)

**Instalación desde i-Haklab:**

```bash
apt install clmystery
```

**Versión en inglés:**

```bash
cd ~/.local/share/clmystery
cat instructions
```

**Versión en español:**

```bash
cd ~/.local/share/clmystery_esp
cat instrucciones
```

Lee primero las instrucciones y la hoja de trucos. Evita abrir el resto de los archivos con un editor: la gracia es investigarlos usando la terminal. Si te bloqueas, puedes consultar las pistas o la solución.

**Eliminación:**

```bash
apt remove clmystery
```

`cleanup` elimina tanto la copia en inglés como la versión en español.

## Consideraciones Adicionales

*   **Dos versiones:** el repositorio original se instala en `~/.local/share/clmystery`; la traducción se descomprime en `~/.local/share/clmystery_esp`.
*   **Dependencias:** i-Haklab usa `git`, `megatools` y `unzip` para descargar y extraer el juego.
*   **Sin conexión:** una vez instalado, el juego funciona localmente; no envía datos ni requiere cuenta.
*   **Créditos:** creado por Noah Veltman y publicado bajo licencia MIT. Repositorio: https://github.com/veltman/clmystery

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
