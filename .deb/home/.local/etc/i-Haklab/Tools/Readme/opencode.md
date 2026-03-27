# OpenCode CLI (opencode-ai)

## ¿Qué es OpenCode CLI?

**OpenCode CLI** es un agente de programación de código abierto y agnóstico de modelos, diseñado para la terminal. A diferencia de otras herramientas, permite utilizar casi cualquier proveedor de IA (OpenAI, Anthropic, Google Gemini, Groq, o modelos locales) para asistir en el desarrollo, depuración y análisis de código directamente desde una interfaz de terminal (TUI) moderna y fluida.

## ¿Para qué es útil la herramienta?

OpenCode CLI destaca por su versatilidad y seguridad en el flujo de trabajo:

*   **Agentes Especializados:**
    *   **Plan Mode:** Un agente de solo lectura ideal para explorar arquitecturas y proponer estrategias sin riesgo de modificar archivos.
    *   **Build Mode:** Un agente con permisos de escritura capaz de implementar funciones, refactorizar y corregir errores tras tu aprobación.
*   **Agnóstico de Modelos:** Soporta múltiples proveedores simultáneamente mediante configuración de API Keys o protocolos como **MCP (Model Context Protocol)** para extender sus habilidades con herramientas externas.
*   **Integración con LSP y Git:** Capacidad nativa para interactuar con servidores de lenguaje (LSP) para detectar errores de sintaxis y gestionar ramas o commits de Git de forma inteligente.
*   **Seguridad y Control:** Incluye comandos como `/undo` y `/redo` para revertir o reaplicar cambios realizados por la IA de manera instantánea.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado (vía NPM como `opencode-ai` o mediante su script oficial), puedes usarlo así:

**Ejemplo 1: Iniciar la interfaz interactiva (TUI)**

```bash
opencode
```
*(Usa la tecla `Tab` para alternar entre el modo Plan y Build).*

**Ejemplo 2: Inicializar un proyecto con contexto**

```bash
opencode /init
```
*(Crea un archivo `AGENTS.md` que ayuda a la IA a entender la estructura y reglas de tu repositorio).*

**Ejemplo 3: Ejecutar una tarea rápida desde la línea de comandos**

```bash
opencode run "Crea una función en Python para validar direcciones IP"
```

## Consideraciones Adicionales

*   **Autenticación:** Configura tus proveedores fácilmente con `opencode auth login`.
*   **Extensibilidad:** Soporta el protocolo **MCP**, permitiendo que la IA use herramientas externas (buscadores, bases de datos, etc.).
*   **Integración con GitHub:** Permite automatizar el triaje de *issues* y la creación de Pull Requests mediante GitHub Actions.
*   **Privacidad:** Al ser compatible con modelos locales (vía Ollama u otros), puedes procesar código sensible sin que este salga de tu máquina.

---
*Nota: Esta herramienta integra la versatilidad de los agentes de código abierto y multi-proveedor en el ecosistema i-Haklab.*
