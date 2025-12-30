# xleak

## ¿Qué es xleak?

`xleak` es una herramienta de línea de comandos moderna y eficiente, escrita en Rust, diseñada para visualizar, explorar y exportar archivos de Excel directamente desde la terminal, sin necesidad de tener Microsoft Excel instalado.

Inspirada en herramientas como `doxx`, `xleak` ofrece una interfaz de usuario basada en texto (TUI) rica e interactiva, permitiendo navegar por hojas de cálculo, buscar datos y convertir archivos a formatos más manejables como CSV o JSON. Soporta una amplia variedad de formatos, incluyendo `.xlsx`, `.xls`, `.xlsm`, `.xlsb` y `.ods`.

## ¿Para qué es útil la herramienta?

Esta herramienta es extremadamente útil en varios escenarios:

*   **Análisis Forense y Pentesting:** Permite examinar rápidamente archivos de Excel exfiltrados o encontrados en servidores comprometidos sin necesidad de transferirlos a una máquina con interfaz gráfica.
*   **Entornos de Servidor (Headless):** Ideal para administradores de sistemas que necesitan inspeccionar datos en hojas de cálculo directamente en servidores remotos vía SSH.
*   **Conversión de Datos:** Facilita la automatización de tareas al permitir la exportación rápida de tablas de Excel a formatos procesables por scripts (CSV, JSON).
*   **Visualización Rápida:** Es mucho más ligero y rápido que abrir una suite ofimática completa solo para consultar un dato puntual.

## ¿Cómo se usa? (Ejemplos básicos)

`xleak` puede usarse en modo interactivo (TUI) o en modo de línea de comandos estándar para exportaciones rápidas.

**Sintaxis básica:**

```bash
xleak [OPCIONES] <ARCHIVO>
```

**Ejemplo 1: Modo Interactivo (Recomendado)**

Para abrir un archivo Excel y navegar por él con el teclado (flechas, búsqueda, etc.):

```bash
xleak reporte_trimestral.xlsx -i
```
*   `-i`: Activa el modo interactivo TUI.
*   **Controles TUI:** Usa las flechas para moverte, `Tab` para cambiar de hoja, `/` para buscar y `q` para salir.

**Ejemplo 2: Ver una hoja específica**

Si solo te interesa una hoja en particular del libro de Excel:

```bash
xleak datos.xlsx --sheet "Resultados Q3"
```
*   `--sheet`: Especifica el nombre (o índice numérico) de la hoja a mostrar.

**Ejemplo 3: Exportar a CSV**

Para convertir una hoja de cálculo a un archivo CSV estándar:

```bash
xleak datos.xlsx --export csv > salida.csv
```
*   `--export csv`: Cambia el formato de salida a CSV. También soporta `json` y `text`.

**Ejemplo 4: Ver fórmulas**

Si necesitas ver las fórmulas subyacentes en lugar de los valores calculados:

```bash
xleak calculos.xlsx -i --formulas
```

## Características Clave

*   **Soporte Multiformato:** Lee `.xlsx`, `.xls`, `.xlsm`, `.ods` y más.
*   **Interfaz TUI Potente:** Navegación completa con teclado, búsqueda de texto completo (`/`), y soporte para copiar celdas (`c`) o filas (`C`).
*   **Temas Visuales:** Soporta varios esquemas de colores (Dracula, Solarized, GitHub, etc.) configurables.
*   **Manejo de Tablas:** Puede listar y extraer "Tablas" definidas específicamente dentro de archivos `.xlsx`.
*   **Rendimiento:** Escrito en Rust, es muy rápido y maneja archivos grandes eficientemente usando carga perezosa (lazy loading).

## Consideraciones Adicionales

*   **Solo Lectura:** `xleak` está diseñado para visualizar y exportar datos, no para editar o modificar los archivos de Excel originales.
*   **Configuración:** Permite personalizar atajos de teclado (incluyendo modo VIM) y temas a través de un archivo de configuración (`config.toml`).

---
*Nota: `xleak` es una herramienta excelente para mantener en tu kit de utilidades de terminal, especialmente si trabajas frecuentemente con datos estructurados en entornos de línea de comandos.*
