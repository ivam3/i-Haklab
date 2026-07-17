# Hermes Agent (hermes-agent)

## ¿Qué es Hermes Agent?

**Hermes Agent** es un agente de IA personal de código abierto creado por **Nous Research**. Está diseñado para ejecutarse en múltiples superficies (CLI, TUI, escritorio, y pasarela de mensajería) manteniendo el mismo núcleo de agente en todas ellas. Soporta más de 20 plataformas de mensajería como Telegram, Discord, Slack, WhatsApp, Signal, Matrix, y otras, permitiendo interactuar con la IA desde cualquier lugar.

## ¿Para qué es útil la herramienta?

Hermes Agent se distingue por su arquitectura extensible y su enfoque en la persistencia de contexto:

*   **Memoria Persistente:** Aprende a través de las conversaciones usando memoria a largo plazo (Engram, Honcho, Mem0, SuperMemory, etc.) y mantiene el contexto entre sesiones mediante compresión de contexto.
*   **Habilidades (Skills):** Los agentes pueden crear, modificar y mantener sus propias habilidades mediante un sistema de curador automático. Las habilidades son paquetes de conocimiento que amplían la capacidad del agente sin modificar el núcleo.
*   **Delegación a Subagentes:** Puede delegar tareas complejas a subagentes especializados (modo orquestador) que trabajan en paralelo con contextos aislados.
*   **Tareas Programadas (Cron):** Permite programar ejecuciones periódicas con `cronjob`, incluyendo scripts de recolección de datos y entrega multi-plataforma.
*   **Automatización de Navegador:** Controla navegadores web mediante Playwright para navegar, extraer contenido y realizar acciones en páginas web.
*   **Terminal Real:** Ejecuta comandos en un terminal real del sistema, con soporte para contenedores (Docker), SSH, y entornos remotos.
*   **Pasarela de Mensajería:** Un mismo agente responde en Telegram, Discord, Slack, WhatsApp y otras plataformas simultáneamente.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado, puedes usarlo desde la terminal o desde cualquiera de las plataformas soportadas:

**Ejemplo 1: Iniciar chat interactivo (CLI)**

```bash
hermes
```

**Ejemplo 2: Configurar API keys y ajustes**

```bash
hermes setup
```

**Ejemplo 3: Preguntar directamente desde la línea de comandos**

```bash
hermes "Explica qué es Hermes Agent y cómo funciona"
```

**Ejemplo 4: Iniciar la pasarela de mensajería**

```bash
hermes gateway
```

## Consideraciones Adicionales

*   **Instalación en Termux:** Disponible como paquete `.deb` (`pkg install hermes`). El proceso de post-instalación clona el repositorio, crea un entorno virtual Python, instala dependencias (pip + npm), y configura `~/.hermes/`.
*   **Dependencias del Sistema:** Requiere Python ≥ 3.11, Node.js LTS, git, clang, rust, make, pkg-config, libffi, openssl. En Termux se instalan automáticamente como dependencias del paquete.
*   **Navegador Web:** En Termux, el motor Chromium se instala vía `playwright-proot` (proot), lo que permite las herramientas de automatización de navegador sin necesidad de permisos especiales.
*   **Perfiles:** Soporta múltiples perfiles completamente aislados, cada uno con su propio `HERMES_HOME` (`~/.hermes/profiles/<nombre>`), configuraciones, memoria y sesiones independientes.
*   **Actualización:** Se actualiza con `hermes update` o reinstalando el paquete.

---

*Nota: Esta herramienta integra la versatilidad de los agentes de IA personales con el ecosistema i-Haklab y Termux, proporcionando un asistente persistente y multiplataforma.*
