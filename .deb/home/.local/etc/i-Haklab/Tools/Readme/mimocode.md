# MiMo Code (mimocode)

## ¿Qué es MiMo Code?

**MiMo Code** (ejecutable como `mimo`) es un asistente de programación y agente autónomo de IA nativo para la terminal, desarrollado en código abierto por el equipo de MiMo de Xiaomi (basado en un fork de OpenCode). Está diseñado para ejecutar tareas de desarrollo complejas de forma autónoma, con la capacidad única de recordar el contexto de un proyecto a lo largo del tiempo gracias a su sistema de memoria persistente basada en SQLite.

## ¿Para qué es útil la herramienta?

MiMo Code transforma tu entorno de desarrollo en la terminal en una experiencia fluida e inteligente, destacando en:

*   **Desarrollo Autónomo Multietapa:** Capacidad para leer, escribir y modificar código, ejecutar comandos en la terminal y gestionar operaciones de Git para resolver tareas complejas.
*   **Memoria Persistente de Proyecto:** Mantiene un registro a largo plazo de las decisiones de arquitectura, progreso y contexto (`MEMORY.md`), evitando el olvido de información entre sesiones.
*   **Evolución e Innovación:** Permite extraer lecciones de sesiones anteriores y destilar flujos exitosos en habilidades reutilizables mediante comandos integrados.
*   **Flexibilidad de Modelos:** Aunque viene preconfigurado con el modelo Xiaomi MiMo, admite la integración con Claude Code, modelos de OpenAI y otros proveedores compatibles.

## ¿Cómo se usa? (Ejemplos básicos)

MiMo Code se ejecuta en la terminal a través del comando `mimo`. A continuación se muestran algunos de los casos de uso más comunes:

**Ejemplo 1: Iniciar el entorno interactivo (TUI) con un objetivo específico**

```bash
mimo --prompt "Refactoriza la función de login para soportar autenticación multifactor (MFA)"
```

**Ejemplo 2: Ejecutar una tarea directa sin entrar al modo interactivo**

```bash
mimo run "Analiza el archivo index.js y optimiza los bucles para mejorar el rendimiento" -f index.js
```

**Ejemplo 3: Continuar una sesión anterior conservando toda su memoria**

```bash
mimo --continue
```

## Consideraciones Adicionales

*   **Modos de Operación:** Cuenta con tres modos de flujo de trabajo principales: **Build** (permisos de escritura y ejecución), **Plan** (análisis y diseño de arquitectura) y **Compose** (desarrollo guiado por especificaciones).
*   **Comandos Internos Clave:** Utiliza `/goal` para definir objetivos con validación automática, `/dream` para guardar conocimientos en la memoria a largo plazo y `/distill` para reutilizar flujos exitosos.
*   **Configuración Personalizable:** Toda la configuración se puede ajustar mediante variables de entorno (como `MIMOCODE_HOME`) o editando el archivo de configuración `.mimocode/mimocode.json`.
*   **Ecosistema Termux:** Diseñado para ejecutarse eficientemente en la línea de comandos, encajando a la perfección en terminales móviles y entornos restringidos de i-Haklab.

---
*Nota: Esta herramienta integra la potencia de los agentes autónomos con memoria persistente de última generación en el ecosistema i-Haklab.*
