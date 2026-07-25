# proroot

## ¿Qué es proroot?

**proroot** es un runtime Linux rootless para Android que permite ejecutar binarios glibc (Linux estándar) directamente desde Termux sin necesidad de root. A diferencia de `proot`, no usa ptrace — emplea LD_PRELOAD + parcheo ELF, eliminando el overhead de cambios de contexto por syscall. El resultado es un rendimiento casi nativo para herramientas como Node.js, Chromium headless, Python con wheels C, y cualquier binario glibc.

## ¿Para qué es útil la herramienta?

proroot es ideal para ejecutar software Linux pesado en Termux sin root:

-   **Node.js / npm / n8n / code-server:** Frameworks y servidores que requieren glibc real, sin el cuello de botella de proot.
-   **Chromium headless:** Automatización de navegador (Playwright, Puppeteer) con rendimiento utilizable.
-   **Python glibc:** Wheels con extensiones C compiladas para glibc (numpy, pandas, scipy, opencv).
-   **Metasploit / gems nativas:** Herramientas de seguridad que dependen de binarios glibc.
-   **Agentes de IA:** OpenCode, Claude Code, Antigravity CLI, cualquier agente que necesite un entorno Linux completo.

## Instalación

```bash
# Mediante el wrapper de i-HakLab:
apt install proroot

# El postinst configura automáticamente:
# 1. Descarga Ubuntu 24.04 (Noble) rootfs
# 2. Descarga las 5 librerías .so de proroot
# 3. Instala el wrapper `proroot` en $PREFIX/bin
```

## ¿Cómo se usa? (Ejemplos básicos)

**Ejemplo 1: Shell interactivo en el guest**
```bash
proroot /bin/bash
```

**Ejemplo 2: Ejecutar un comando específico**
```bash
proroot /bin/sh -c 'uname -a'
```

**Ejemplo 3: Iniciar Node.js desde el rootfs**
```bash
proroot /bin/sh -c 'node server.js'
```

**Ejemplo 4: Chromium headless vía Playwright**
```bash
proroot /bin/sh -c '
    /root/.cache/ms-playwright/chromium-*/chrome-linux/chrome \
        --headless --no-sandbox --remote-debugging-port=9222 \
        --disable-gpu --disable-dev-shm-usage http://localhost:8550
'
```

**Ejemplo 5: Rootfs personalizado**
```bash
proroot -r ~/rootfs-personalizado -0 --link2symlink -w /root /bin/sh
```

## Consideraciones Adicionales

-   **Solo arm64:** proroot funciona únicamente en dispositivos Android con arquitectura arm64-v8a.
-   **Código cerrado:** Los binarios son gratuitos pero proprietarios (no se permite redistribución de binarios modificados).
-   **glibc 2.39:** Ubuntu 24.04 (Noble) es el rootfs oficial. glibc > 2.39 no está soportado en v1.2.8.
-   **No es root real:** Al igual que proot, proroot no otorga permisos de root real al sistema Android anfitrión.
-   **Rendimiento:** Es significativamente más rápido que proot para cargas de trabajo intensivas (Node.js, Chromium, Python con numpy/pandas).

---
*Nota: Esta herramienta integra la potencia de la ejecución Linux rootless en el ecosistema i-Haklab.*
