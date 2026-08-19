# TestSprite (@testsprite/testsprite-mcp)

## ¿Qué es TestSprite?

**TestSprite** es un servidor MCP (Model Context Protocol) que permite a los asistentes de IA (Cursor, VSCode, OpenCode, Claude, etc.) **probar, depurar y corregir tu código automáticamente**. No requiere escribir tests manualmente, prompts complejos ni experiencia en testing: la IA genera PRDs, planes de prueba y código de test, y los ejecuta en entornos seguros en la nube de TestSprite.

## ¿Para qué es útil la herramienta?

*   **Tests automáticos:** Solo di "Help me test this project with TestSprite" y la IA se encarga de todo.
*   **Generación de PRDs y planes de prueba:** Produce documentación y casos de prueba a partir del proyecto.
*   **Corrección guiada:** Detecta fallos y aplica arreglos directamente en el código.
*   **Ejecución en la nube:** Los tests corren en entornos seguros de TestSprite sin ensuciar tu máquina.

## Instalación

```bash
# Instalación global via npm:
npm install -g @testsprite/testsprite-mcp@latest
```

Al instalarlo via los wrappers de i-Haklab se ejecuta automáticamente el preconf (verifica Node >= 22) y el pkg2conf (corrige el shebang y muestra la configuración del API key).

## ¿Cómo se usa? (Ejemplos básicos)

**Ejemplo 1: Configurar el API key con i-Haklab**

```bash
i-Haklab setapikey testsprite
```

Esto guarda tu clave como `APIKEY_testsprite` en las variables de i-Haklab.

**Ejemplo 2: Registrar el MCP server en tu agente IA**

Añade TestSprite a la configuración MCP de tu agente (por ejemplo `~/.config/opencode/opencode.json`):

```json
{
  "mcp": {
    "TestSprite": {
      "type": "local",
      "enabled": true,
      "command": ["node", "/data/data/com.termux/files/usr/lib/node_modules/@testsprite/testsprite-mcp/dist/index.js"],
      "environment": { "API_KEY": "tu-api-key" },
      "timeout": 60000
    }
  }
}
```

**Ejemplo 3: Probar un proyecto**

Arrastra tu proyecto al chat de tu agente y escribe:

```
Help me test this project with TestSprite
```

## Consideraciones Adicionales

*   **API Key:** La obtienes en [app.testsprite.com/dashboard/settings/apikey](https://www.testsprite.com/dashboard/settings/apikey).
*   **Node >= 22:** Requerido por el paquete; el preconf de i-Haklab instala `nodejs-lts` si tu versión es menor.
*   **No subir claves:** Usar `i-Haklab setapikey testsprite` o variables de entorno; nunca comprometer claves reales.

---
*Nota: Esta herramienta integra la potencia de los agentes de IA de última generación en el ecosistema i-Haklab.*