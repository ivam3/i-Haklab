# Engram (Gentleman-Programming/engram)

## ¿Qué es Engram?

**Engram** es un sistema de memoria persistente diseñado específicamente para agentes de codificación de IA. Actúa como un "cerebro" que permite a los asistentes virtuales recordar el contexto, las decisiones arquitectónicas y los aprendizajes técnicos a través de diferentes sesiones de trabajo. Es una herramienta agnóstica al agente y utiliza el protocolo MCP (Model Context Protocol) para integrarse sin problemas con herramientas como Gemini CLI, Claude Code y otros.

## ¿Para qué es útil la herramienta?

Engram soluciona el problema de la "amnesia" en los modelos de IA, siendo útil para:

*   **Persistencia de Contexto:** Evitar que la IA olvide decisiones tomadas en sesiones anteriores sobre la estructura del proyecto.
*   **Búsqueda Semántica y de Texto:** Localizar rápidamente fragmentos de conocimiento o soluciones a errores pasados mediante SQLite + FTS5.
*   **Sincronización en Equipos:** Compartir memorias entre diferentes máquinas utilizando Git sin generar conflictos de fusión.
*   **Independencia y Velocidad:** Funciona como un binario único en Go, lo que lo hace extremadamente ligero y rápido, sin necesidad de dependencias complejas como Docker o Node.js.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado, puedes interactuar con Engram de diversas maneras:

**Ejemplo 1: Instalar y configurar para Gemini CLI**

```bash
brew install gentleman-programming/tap/engram
engram setup gemini-cli
```

**Ejemplo 2: Guardar un aprendizaje manualmente**

```bash
engram save "Corrección de Bug en Auth" "Se cambió el middleware de JWT para usar el algoritmo RS256 en lugar de HS256 por razones de seguridad."
```

**Ejemplo 3: Buscar en la memoria**

```bash
engram search "JWT"
```

**Ejemplo 4: Lanzar la interfaz interactiva (TUI)**

```bash
engram tui
```

## Consideraciones Adicionales

*   **Protocolo MCP:** Engram brilla cuando se usa como servidor MCP, permitiendo que la IA use herramientas como `mem_save` y `mem_search` de forma autónoma.
*   **Privacidad Local:** Por defecto, todos los datos se almacenan localmente en una base de datos SQLite cifrable.
*   **Sincronización Git:** Utiliza un sistema de fragmentos comprimidos para facilitar el intercambio de conocimientos en repositorios compartidos.

---
*Nota: Esta herramienta integra la potencia de los modelos de lenguaje de última generación en el ecosistema i-Haklab.*
