# code-oss

## ¿Qué es code-oss?

`code-oss` es la compilación de código abierto de **Visual Studio Code (VS Code)**, sin el branding ni la telemetría de Microsoft. Es un editor de código completo, extensible y con depuración integrada. Su proyecto upstream es `https://github.com/microsoft/vscode`.

En Termux se distribuye desde el repositorio x11 como paquete de escritorio nativo (usa Electron), por lo que requiere un entorno gráfico como Termux:X11 o VNC. No debe confundirse con `code-server`, que sirve VS Code en el navegador desde un servidor remoto.

## ¿Para qué es útil la herramienta?

`code-oss` es útil como entorno de desarrollo gráfico completo en Android/Termux:

-   **Edición de Código Moderna:** Resaltado, autocompletado (IntelliSense), refactorización, terminal integrada y control Git.
-   **Extensiones:** Soporte de extensiones vía Open VSX para lenguajes, linters, formateadores, Docker, Python, C/C++, etc.
-   **Depuración Visual:** Breakpoints, inspección de variables y pila de llamadas sin salir del editor.
-   **Proyectos Locales y Remotos:** Abrir carpetas locales, trabajar con `termux-desktop-xfce`, `tigervnc` o sesiones Termux:X11.
-   **Alternativa Privada a VS Code Oficial:** Misma base que VS Code pero compilada desde fuentes abiertas.

## ¿Cómo se usa?

### 1. Instalación

En Termux / i-Haklab (repositorio x11):

```bash
pkg update
pkg install code-oss
```

Esto instala además sus dependencias (`electron-for-code-oss`, `libx11`, `libxkbfile`, `libsecret`, `ripgrep`). Es un paquete pesado (unos 162 MB de descarga, unos 915 MB instalado).

Necesitas un servidor gráfico activo. Ejemplo con Termux:X11 o VNC:

```bash
pkg install termux-x11-nightly tigervnc termux-desktop-xfce
vncserver -geometry 1920x1080
```

### 2. Ejemplos de Uso Básico

1.  **Abrir el editor (dentro de la sesión gráfica):**
    ```bash
    code-oss
    ```

2.  **Abrir una carpeta de proyecto directamente:**
    ```bash
    code-oss ~/proyectos/mi-app
    ```

3.  **Abrir un archivo concreto:**
    ```bash
    code-oss ~/proyectos/mi-app/main.py
    ```

4.  **Ver ayuda y versión:**
    ```bash
    code-oss --help
    code-oss --version
    ```

5.  **Instalar una extensión desde terminal:**
    ```bash
    code-oss --install-extension ms-python.python
    code-oss --list-extensions
    ```

## Otras Consideraciones

-   **Requiere X11:** No funciona en la terminal sola. Debes lanzar primero Termux:X11 o `vncserver` y exportar `DISPLAY` antes de ejecutar `code-oss`.
-   **Recursos:** Al estar basado en Electron consume bastante RAM/CPU. En móviles modestos puede ir lento; en ese caso valora `neovim`, `vim` o `code-server` remoto.
-   **Marketplace:** Por licencia usa Open VSX en lugar del marketplace oficial de Microsoft. La mayoría de extensiones populares están disponibles, pero algunas privativas de Microsoft no.
-   **Diferencia con code-server:** `code-oss` es app de escritorio nativa; `code-server` se ejecuta en un servidor y se usa desde el navegador. Ambos conviven bien en i-Haklab.
-   **Actualizaciones:** Al venir del repo x11, actualízalo con `pkg upgrade` como cualquier paquete del sistema.

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
