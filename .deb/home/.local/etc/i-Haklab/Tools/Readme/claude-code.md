# Claude Code (@anthropic-ai/claude-code)

## ¿Qué es Claude Code?

**Claude Code** es la herramienta oficial de línea de comandos de Anthropic que permite interactuar con los modelos Claude de forma nativa desde la terminal. Está diseñada específicamente para que los desarrolladores puedan realizar cambios complejos en su código, ejecutar comandos de terminal y gestionar flujos de trabajo de desarrollo completos utilizando lenguaje natural y las capacidades de razonamiento superiores de Claude.

## ¿Para qué es útil la herramienta?

Claude Code transforma la terminal en un entorno de desarrollo asistido de alto nivel, siendo ideal para:

*   **Edición Directa de Archivos:** Claude puede leer archivos, proponer ediciones y aplicarlas tras tu confirmación.
*   **Gestión de Git:** Ayuda a crear commits significativos, gestionar ramas y preparar Pull Requests de forma autónoma.
*   **Depuración de Errores:** Analiza trazas de errores de ejecución o compilación y propone soluciones inmediatas.
*   **Investigación de Código:** Permite realizar preguntas complejas sobre cómo interactúan diferentes partes de un sistema.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalada mediante NPM (`@anthropic-ai/claude-code`), puedes iniciar la sesión interactiva:

**Ejemplo 1: Iniciar Claude Code en el directorio actual**

```bash
claude
```

**Ejemplo 2: Pedir una modificación específica**

```bash
claude "Agrega validación de correo electrónico al formulario de registro en login.js"
```

**Ejemplo 3: Generar un commit tras realizar cambios**

```bash
claude "Crea un commit para los cambios actuales con un mensaje descriptivo"
```

## Consideraciones Adicionales

*   **API Key:** Requiere una clave de API de Anthropic válida configurada en tu entorno.
*   **Control del Usuario:** Claude Code siempre pide confirmación antes de realizar cambios permanentes en los archivos o ejecutar comandos del sistema.
*   **Seguridad:** Incluye protecciones para evitar la modificación accidental de archivos sensibles y respeta las configuraciones de `.gitignore`.

---
*Nota: Esta herramienta integra la inteligencia avanzada de los modelos Claude en el ecosistema i-Haklab.*
