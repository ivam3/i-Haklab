# fzf (Fuzzy Finder)

## ¿Qué es fzf?

**fzf** es un buscador difuso (fuzzy finder) de línea de comandos de propósito general. Es una herramienta extremadamente rápida y ligera escrita en Go que permite filtrar listas de archivos, procesos, historial de comandos, ramas de git y mucho más, utilizando una interfaz interactiva.

## ¿Para qué es útil la herramienta?

fzf mejora drásticamente la eficiencia en la terminal al permitir:

*   **Búsqueda Rápida de Archivos:** Localizar y abrir archivos instantáneamente sin recordar la ruta exacta.
*   **Navegación de Historial:** Buscar en el historial de comandos (`CTRL-R`) de forma interactiva y visual.
*   **Filtrado de Comandos:** Se puede usar en tuberías (`pipes`) para filtrar la salida de cualquier comando (como `ps`, `git log`, `npm list`).
*   **Previsualización:** Ver el contenido de los archivos mientras navegas por la lista de resultados.

## ¿Cómo se usa? (Ejemplos básicos)

**Ejemplo 1: Buscar y abrir un archivo (integración básica)**

```bash
fzf
```
Simplemente escribe `fzf` y comenzará a listar los archivos del directorio actual. Al seleccionar uno, imprimirá la ruta en la terminal.

**Ejemplo 2: Filtrar la salida de un comando**

```bash
ls -la | fzf
```

**Ejemplo 3: Buscar en el historial de comandos (si está configurado)**

Presiona `CTRL-R` en tu terminal para invocar fzf y buscar entre tus comandos anteriores.

**Ejemplo 4: Búsqueda con previsualización**

```bash
fzf --preview 'cat {}'
```
Muestra el contenido del archivo resaltado en un panel lateral.

## Consideraciones Adicionales

*   **Instalación:** Se puede instalar fácilmente mediante gestores de paquetes como `apt`, `brew` o descargando el binario directamente.
*   **Atajos de Teclado:** A menudo se configura con atajos como `CTRL-T` (archivos), `CTRL-R` (historial) y `ALT-C` (directorios).
*   **Personalización:** Es altamente personalizable mediante variables de entorno como `FZF_DEFAULT_OPTS`.

---
*Nota: Esta herramienta integra la potencia de la búsqueda interactiva en el ecosistema i-Haklab.*
