# ZCode (zcode.z.ai)

## ¿Qué es ZCode?

**ZCode** es un entorno de programación con IA (modelos GLM) con ventana
gráfica. En Termux funciona sobre `termux-x11`, sin necesidad de root.

> ¿Prefieres la terminal en vez de la ventana? Usa `zcode-cli`
> (`i-Haklab about zcode-cli`).

## ¿Para qué es útil la herramienta?

ZCode convierte Termux en un entorno de desarrollo asistido por IA, ideal para:

*   **Edición Directa de Archivos:** el agente lee archivos, propone ediciones y las aplica tras tu confirmación.
*   **Gestión de Git:** ayuda a crear commits, gestionar ramas y preparar Pull Requests de forma autónoma.
*   **Depuración de Errores:** analiza trazas de ejecución o compilación y propone soluciones inmediatas.
*   **Investigación de Código:** responde preguntas complejas sobre cómo interactúan diferentes partes del sistema.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado (`pkg install zcode`), la ayuda estática no requiere X:

**Ejemplo 1: Ver la ayuda (sin X)**

```bash
zcode --help
```

**Ejemplo 2: Abrir un proyecto en la GUI (requiere termux-x11)**

```bash
termux-x11 :0 &
DISPLAY=:0 zcode ~/proyectos/mi-app
```

**Ejemplo 3: Ver la versión**

```bash
zcode --version
```

## Consideraciones Adicionales

*   **X11 requerido para la ventana:** `zcode` sin argumentos muestra un aviso; para la interfaz gráfica necesitas `termux-x11` corriendo (ver ejemplo 2). Todo lo técnico (permisos, render por software, tema oscuro) se ajusta solo durante la instalación.
*   **Fuentes y tema:** Si alguna vez ves la ventana en blanco o el texto invisible, reinstala el paquete (restaura el tema y las fuentes).
*   **Seguridad:** incluye protecciones para evitar la modificación accidental de archivos sensibles y respeta las configuraciones de `.gitignore`.

---
*Nota: Esta herramienta integra el harness ZCode con modelos GLM en el ecosistema i-Haklab.*
