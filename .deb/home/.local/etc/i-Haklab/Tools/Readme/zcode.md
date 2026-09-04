# ZCode (zcode.z.ai)

## ¿Qué es ZCode?

**ZCode** es un harness de vibe coding con IA (GLM-5.3) distribuido como aplicación Electron arm64. En Termux corre como binario glibc nativo aarch64 sobre `termux-x11`, sin proot.

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

*   **X11 requerido para la GUI:** `zcode` sin argumentos muestra un aviso; la ventana necesita `termux-x11` con `DISPLAY=:0` y `--no-sandbox` (inyectado automáticamente).
*   **Sin root:** usa `--disable-dev-shm-usage` y render por software (`swiftshader`) porque `/dev/shm` no es escribible sin root.
*   **Fuentes y tema:** requiere `fontconfig-glibc`, `freetype-glibc` y `gnome-themes-extra` (tema `Adwaita:dark` por defecto) para que el texto sea visible.
*   **Seguridad:** incluye protecciones para evitar la modificación accidental de archivos sensibles y respeta las configuraciones de `.gitignore`.

---
*Nota: Esta herramienta integra el harness ZCode con modelos GLM en el ecosistema i-Haklab.*
