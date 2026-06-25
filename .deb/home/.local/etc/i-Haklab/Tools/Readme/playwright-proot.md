# Playwright-proot (playwright-cli)

## ¿Qué es Playwright-proot?

**Playwright-proot** es un wrapper empaquetado como `.deb` que integra **Playwright CLI** en Termux mediante `proot-distro Ubuntu`. Permite ejecutar **Chromium headless** en Android para automatización de navegador (snapshot, screenshots, click, fill, eval) sin necesidad de X11/Wayland.

## ¿Para qué es útil la herramienta?

Playwright-proot es esencial para testing visual y automatización de aplicaciones web desde Termux:

-   **Testing de PWAs y apps web:** Ideal para probar aplicaciones Flet, Flutter Web, React, Vue o cualquier SPA directamente desde el terminal Android.
-   **Captura de screenshots:** Toma capturas de pantalla completas de páginas web o elementos específicos para documentación o verificación visual.
-   **Automatización de navegador:** Permite simular clics, llenar formularios, navegar entre páginas y ejecutar JavaScript en el contexto de la página.
-   **Integración con agentes de IA:** Puede ser invocado por herramientas como OpenCode o Claude Code para realizar testing visual automatizado como parte de un flujo de trabajo.
-   **Depuración de interfaces web:** Captura el estado del DOM, errores de consola y peticiones de red para diagnosticar problemas en aplicaciones web.

## Instalación

```bash
# Mediante el wrapper de i-HakLab:
apt install playwright-proot

# El postinst configura automaticamente:
# 1. proot-distro Ubuntu (si no existe)
# 2. Librerias glibc para Chromium
# 3. Node.js + @playwright/cli
# 4. Chromium headless (arm64)
```

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado, el servidor target (ej: Flet) debe estar corriendo en Termux:

```bash
flet run --web --port 8550 main.py
```

**Ejemplo 1: Ejecutar comandos en una sola sesión**

```bash
playwright-proot run "goto http://localhost:8550; wait 5000; snapshot; screenshot --filename=app.png"
```

**Ejemplo 2: Enviar comandos desde stdin**

```bash
echo "goto http://localhost:8550; snapshot; eval 'document.title'" | playwright-proot run
```

**Ejemplo 3: Sesión interactiva (para depuración manual)**

```bash
playwright-proot open http://localhost:8550
```

**Ejemplo 4: Detener Chromium**

```bash
playwright-proot close
```

## Consideraciones Adicionales

-   **Modo headless:** Chromium se ejecuta sin interfaz gráfica — no requiere X11 ni Wayland.
-   **CanvasKit / Flutter:** Las apps renderizadas con CanvasKit (Flet, Flutter Web) no exponen sus elementos en el DOM. Usar `screenshot` en lugar de `click` para verificar contenido visual.
-   **Espacio en disco:** La instalación completa (Ubuntu + Chromium) requiere aproximadamente 1.2 GB de espacio libre.
-   **Rendimiento:** En dispositivos con 4 GB de RAM o menos, la carga inicial de Chromium puede tomar entre 10 y 20 segundos.
-   **Primera ejecución:** El `postinst` descarga e instala las dependencias automáticamente. Requiere conexión a internet.

---
*Nota: Esta herramienta integra automatización de navegador headless en el ecosistema i-Haklab.*
