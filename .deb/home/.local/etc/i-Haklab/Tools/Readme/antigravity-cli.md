# Antigravity (@google/antigravity)

## ¿Qué es Antigravity?

**Antigravity** es una plataforma de desarrollo "agent-first" de Google diseñada para ejecutar tareas de programación, investigación y automatización de forma autónoma mediante el uso de modelos Gemini. A diferencia de las interfaces de chat tradicionales, Antigravity está optimizado para actuar como un agente que puede navegar por el sistema de archivos, leer código y ejecutar comandos para resolver problemas complejos.

## ¿Para qué es útil la herramienta?

Antigravity lleva la asistencia de IA a un nivel superior, permitiendo:

*   **Desarrollo Autónomo:** Delegar tareas completas como "corrige este bug en el parser" o "añade tests unitarios a este módulo".
*   **Auditoría de Seguridad:** Analizar repositorios enteros en busca de vulnerabilidades y proponer parches automáticos.
*   **Investigación de Código:** Mapear arquitecturas complejas y entender dependencias sin intervención manual exhaustiva.
*   **Automatización Avanzada:** Ejecutar flujos de trabajo multi-paso que involucran lectura, escritura y validación de código.

## ¿Cómo se usa? (Ejemplos básicos)

En Termux el comando instalado es **`agy`** (no `antigravity`). Sin argumentos abre la sesión interactiva; para una consulta puntual se usa `-p` / `--print`:

**Ejemplo 1: Sesión interactiva**

```bash
agy
```

**Ejemplo 2: Una tarea de refactorización (sin interacción)**

```bash
agy -p "Refactoriza el módulo de autenticación para usar JWT en lugar de sesiones"
```

**Ejemplo 3: Análisis de vulnerabilidades**

```bash
agy -p "Busca inyecciones SQL en la carpeta /src y propón soluciones"
```

**Ejemplo 4: Continuar la última conversación**

```bash
agy -c
```

**Subcomandos útiles:**

```bash
agy models      # modelos disponibles
agy mcp         # gestionar servidores MCP
agy plugins     # gestionar plugins
agy changelog   # notas de versión
agy update      # actualizar el CLI
agy --help      # ayuda completa (--model, --mode, --effort, --print, ...)
```

## Consideraciones Adicionales

*   **Confianza y Permisos:** Al ser un agente autónomo con acceso al sistema de archivos, debe ejecutarse en entornos controlados y supervisados.
*   **Autenticación:** el primer arranque abre el flujo OAuth de Google en el navegador; también reconoce `GEMINI_API_KEY` en el entorno.
*   **Paquete:** `antigravity-cli` (solo `aarch64`) instala el bootstrapper `agy`, descarga el CLI oficial desde el updater de Google y le aplica los parches de memoria VA39 para que funcione en Termux.
*   **Seguridad:** Ten en cuenta los riesgos de inyección de prompts indirectos al permitir que el agente procese código de fuentes no confiables.
*   **Optimización para Termux:** En el ecosistema i-Haklab, Antigravity está especialmente configurado para funcionar de manera eficiente en dispositivos Android.

---
*Nota: Esta herramienta integra la potencia de los agentes autónomos de última generación en el ecosistema i-Haklab.*
