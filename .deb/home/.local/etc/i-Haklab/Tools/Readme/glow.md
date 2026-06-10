# glow

## ¿Qué es glow?

**glow** es un renderizador de Markdown para la línea de comandos diseñado para leer documentación directamente en la terminal con un estilo visual moderno y elegante. Es parte de la suite de herramientas de *Charm*, escrita en Go, y permite visualizar archivos Markdown de forma estructurada y legible.

## ¿Para qué es útil la herramienta?

glow transforma los archivos de texto plano Markdown en documentos visualmente atractivos, facilitando:

*   **Lectura de Documentación:** Leer archivos `README.md` y otros documentos técnicos sin salir de la terminal.
*   **Organización:** Permite descubrir y explorar archivos Markdown de forma interactiva en directorios locales.
*   **Soporte Remoto:** Puede renderizar archivos directamente desde URLs o repositorios de GitHub.
*   **Estética:** Utiliza colores y estilos (vía la librería *Lip Gloss*) para resaltar encabezados, listas, bloques de código y enlaces.

## ¿Cómo se usa? (Ejemplos básicos)

**Ejemplo 1: Renderizar un archivo local**

```bash
glow README.md
```

**Ejemplo 2: Modo interactivo**

```bash
glow
```
Al ejecutarlo sin argumentos, se abre una interfaz interactiva para navegar por tus archivos Markdown locales y guardados.

**Ejemplo 3: Leer un archivo desde GitHub**

```bash
glow https://github.com/charmbracelet/glow/blob/master/README.md
```

**Ejemplo 4: Paginar la salida**

```bash
glow -p README.md
```
Usa el paginador integrado para leer documentos largos cómodamente.

## Consideraciones Adicionales

*   **Estilos:** Puedes personalizar el tema visual (light/dark) mediante la opción `--style`.
*   **Integración con Git:** Glow puede detectar automáticamente archivos Markdown en repositorios Git.
*   **Almacenamiento Local:** Permite "esconder" (stash) documentos Markdown para leerlos más tarde de forma rápida.

---
*Nota: Esta herramienta integra la potencia del renderizado visual en el ecosistema i-Haklab.*
