# Smithery CLI (@smithery/cli)

## ¿Qué es Smithery CLI?

**Smithery CLI** es un marketplace y proxy de MCP (Model Context Protocol) servers que permite descubrir, conectar y gestionar servidores MCP desde la terminal y agentes de IA como OpenCode o Claude Code. Actúa como un punto centralizado para acceder a más de 100,000 herramientas y skills de IA.

## ¿Para qué es útil la herramienta?

Smithery simplifica el descubrimiento y conexión de MCP servers:

*   **Marketplace de MCPs:** Busca y descubre servidores MCP públicos desde el registry de Smithery.
*   **Proxy Unificado:** Proporciona un endpoint único (`mcp.smithery.run/<namespace>`) que enruta a todos los MCPs conectados en tu cuenta, manejando autenticación OAuth automáticamente.
*   **Conexión a Clientes AI:** Instala MCPs directamente en agentes como opencode, claude-code, cursor, windsurf y más mediante `--client`.
*   **Gestión de Conexiones:** Administra múltiples servidores MCP desde un solo lugar con comandos `add`, `list`, `get`, `remove`.

## ¿Cómo se usa? (Ejemplos básicos)

**Ejemplo 1: Autenticarse**

```bash
smithery auth login
```

**Ejemplo 2: Buscar servidores MCP**

```bash
smithery mcp search "github"
```

**Ejemplo 3: Conectar un servidor MCP**

```bash
smithery mcp add "https://server.smithery.ai/exa" --id exa
```

**Ejemplo 4: Listar conexiones activas**

```bash
smithery mcp list
```

**Ejemplo 5: Instalar un MCP directamente en opencode**

```bash
smithery mcp add https://server.smithery.ai/exa --client opencode
```

**Ejemplo 6: Usar el endpoint unificado en opencode**

```bash
opencode mcp add smithery --url "https://mcp.smithery.run/tu-namespace" --header "X-API-Key=smry_..."
```

## Consideraciones Adicionales

*   **Autenticación:** Requiere `smithery auth login` (vía navegador) o configurar `SMITHERY_API_KEY`.
*   **Android/Termux:** El bundle ofuscado de Smithery no contempla `process.platform="android"`. En i-HakLab se parchea automáticamente vía pkg2conf para que retorne `"linux"`.
*   **Endpoint Unificado:** La URL `https://mcp.smithery.run/<namespace>` reemplaza la necesidad de configurar cada MCP individualmente en el agente.
*   **OAuth:** Los MCP servers alojados en Smithery utilizan OAuth2 para autenticación. El endpoint unificado maneja esto automáticamente.

---
*Nota: Esta herramienta integra el marketplace de MCP servers más grande del mundo en el ecosistema i-Haklab.*
