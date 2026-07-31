# Sleepwalker (@sleepwalkerai/cli)

## ¿Qué es Sleepwalker?

**Sleepwalker** es una plataforma de **AI Visibility y Content Intelligence** que permite a equipos, productos y agentes de IA entender cómo los sistemas de IA (ChatGPT, Perplexity, Grok, Gemini) hablan de una marca y qué contenidos necesitan cambiar. Combina dos flujos de trabajo conectados:

*   **AI Visibility:** Ejecuta prompts a través de múltiples plataformas de IA y captura respuestas completas, citas, competidores y tipos de mención.
*   **Content Intelligence:** Serializa páginas públicas, descubre demanda, puntúa la profundidad y frescura del contenido y devuelve recomendaciones prácticas.

Se puede usar desde la app alojada, la API pública, clientes MCP o la CLI, manteniendo todos los resultados conectados.

## ¿Para qué es útil la herramienta?

Sleepwalker es útil para:

*   **Monitoreo de búsqueda IA (GEO):** Seguimiento de prompts para URLs específicas en ChatGPT, Perplexity, Grok y Gemini.
*   **Flujos de trabajo con agentes:** Dar acceso a clientes MCP (como Claude) a respuestas LLM, dominios citados, rendimiento de competidores y tendencias de contenido.
*   **Integraciones de producto:** Usar la API desde herramientas internas, portales de clientes, pipelines de reportes o verificaciones automatizadas de QA.
*   **Revisión de contenido:** Inspeccionar qué dice una página, qué tendencias omite y qué corregir primero.
*   **Exportación gratuita de páginas (OKF):** Convertir cualquier página pública en markdown listo para agentes con `okf export`, que es de código abierto, corre localmente y no requiere cuenta.

## ¿Cómo se usa? (Ejemplos básicos)

Instalación global vía NPM:

```bash
npm install -g @sleepwalkerai/cli
sleepwalker init
```

**Ejemplo 1: Exportación OKF gratuita (sin cuenta ni API key)**

```bash
npx -y @sleepwalkerai/cli okf export https://www.sleepwalker.ai
```

También se puede reducir a un solo concepto con `--content` o `--technical`:

```bash
sleepwalker okf export https://ejemplo.com --content
sleepwalker okf export https://ejemplo.com --technical --out ./snapshot
```

**Ejemplo 2: Configurar la API key y diagnosticar**

```bash
sleepwalker auth key set sw_api_live_...
sleepwalker doctor
```

**Ejemplo 3: Ejecutar una verificación de visibilidad en IA**

```bash
sleepwalker visibility run https://tumarca.com \
  --brand TuMarca \
  --prompt "mejor plataforma de visibilidad IA 2026" \
  --platform perplexity,openai,grok,gemini \
  --watch
```

**Ejemplo 4: Acceso vía MCP**

```
https://mcp.sleepwalker.ai/mcp
```

## Consideraciones Adicionales

*   **API Key:** La mayoría de funciones requieren una clave creada en [app.sleepwalker.ai](https://app.sleepwalker.ai).
*   **Créditos:** El servicio es "paga por uso"; lecturas, listas y sondeos de estado normalmente no consumen créditos, mientras que las acciones (verificaciones de visibilidad, puntuación de contenido, serialización) usan créditos prepagados.
*   **OKF export es gratis:** Corre localmente, sin cuenta, sin API key y sin créditos; es la excepción gratuita de la plataforma.
*   **Cero dependencias:** El paquete CLI es ligero (`@sleepwalkerai/cli`) con dependencias mínimas.
*   **No subir claves:** Usar variables de entorno (`SLEEPWALKER_API_KEY`) o el almacén de claves del CLI; no comprometer claves reales.

---
*Nota: Esta herramienta integra la potencia de los agentes de IA de última generación en el ecosistema i-Haklab.*
