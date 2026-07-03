# OpenSpec (@fission-ai/openspec)

## ¿Qué es OpenSpec?

**OpenSpec** es un framework ligero de desarrollo basado en especificaciones (spec-driven). Permite definir los requisitos funcionales de tu sistema como archivos Markdown versionados dentro del repositorio (`openspec/specs/*/spec.md`). Al proponer cambios, OpenSpec genera una propuesta, tareas de implementación, decisiones técnicas y deltas de especificación para revisión antes de escribir código. Es compatible de forma nativa con la mayoría de asistentes de codificación IA (Claude Code, Cursor, Codex, OpenCode, Copilot, Gemini CLI, etc.) sin necesidad de MCP ni API keys adicionales.

## ¿Para qué es útil la herramienta?

*   **Especificaciones Vivas:** Los requisitos persisten en el repositorio como documentación viva que no se pierde al cerrar una sesión de chat o cuando alguien deja el equipo.
*   **Revisión por Intención:** Revisa cambios en los requisitos (spec deltas) en lugar de solo el diff de código, entendiendo el "por qué" detrás de cada modificación.
*   **Planificación Ligera:** Con un solo comando (`/openspec:proposal`) genera una propuesta, diseño técnico y lista de tareas sin procesos pesados.
*   **Universal y Open Source:** Funciona con cualquier agente de codificación moderno sin bloqueo de proveedor. No requiere API keys ni servicios externos.
*   **Brownfield-first:** Enfocado en codebases existentes donde el verdadero desafío es entender cómo funciona el sistema actual.

## Instalación

```bash
# Instalación global via npm:
npm install -g @fission-ai/openspec@latest
```

## ¿Cómo se usa? (Ejemplos básicos)

**Ejemplo 1: Inicializar OpenSpec en un proyecto existente**

```bash
cd tu-proyecto
openspec init
```
*(Crea la estructura `openspec/specs/` en tu repositorio).*

**Ejemplo 2: Crear una propuesta de cambio desde un agente compatible**

```bash
# Dentro de Claude Code, OpenCode, Cursor, etc:
/openspec:proposal Agregar checkbox "Recordarme" con sesiones de 30 días
```

Esto genera automáticamente:

```
openspec/changes/mi-cambio/
├── proposal.md    ← descripción del cambio
├── design.md      ← decisiones técnicas
├── tasks.md       ← tareas de implementación
└── specs/         ← deltas de especificación
```

**Ejemplo 3: Definir una especificación manualmente**

```markdown
# auth-session Specification

## Requirements

### Requirement: Session expiration
The system SHALL expire sessions after a configured duration.

#### Scenario: Default session timeout
- GIVEN a user has authenticated
- WHEN 24 hours pass without activity
- THEN invalidate the session token
```

## Consideraciones Adicionales

*   **Requiere Node.js** para ejecutar la CLI.
*   **Sin API Keys:** No necesita claves externas ni configuración de proveedores.
*   **Sin MCP:** La integración con agentes es nativa mediante comandos slash (`/openspec:proposal`).
*   **Colaboración por Git:** Las specs se comparten y revisan mediante PRs y flujos normales de git.
*   **Compatibilidad:** Funciona con Claude Code, Cursor, Codex, OpenCode, GitHub Copilot, Windsurf, Gemini CLI, Antigravity, Cline, RooCode, Kilo Code, Amazon Q, Qoder, Auggie CLI, Qwen Code y otros.
*   **Team Workspaces:** Próximamente para equipos grandes, multi-repo y personalización avanzada.

---

*Nota: Esta herramienta integra un framework de especificaciones universal y open source en el ecosistema i-Haklab.*
