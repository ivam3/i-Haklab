# AI (hybrid-cli-ai)

## ¿Qué es AI?

**AI** es un asistente de terminal que convierte lenguaje natural en el comando exacto que necesitas. Usa automáticamente un modelo local de **Ollama** cuando está disponible (modo offline, gratis) y cae en **Groq Cloud** cuando no lo está, sin que tengas que acordarte de flags ni sintaxis: describe lo que quieres y la herramienta propone el comando.

Es un *feature* de i-Haklab (wrapper `ai`), no una herramienta instalable vía `apt`.

## ¿Para qué es útil la herramienta?

AI es útil para:

*   **No memorizar sintaxis:** Escribe en lenguaje natural y obtén el comando listo para tu shell.
*   **Multilenguaje:** Describe la tarea en español, inglés o mezcla; el modelo entiende la intención.
*   **Modo offline:** Con Ollama corriendo localmente, funciona sin internet ni costo.
*   **Ejecución con confirmación o directa:** Revisa el comando sugerido antes de ejecutarlo, o usa `--run` para ejecutar automáticamente.
*   **Historial:** Cada comando generado queda registrado; consulta o limpia el historial cuando quieras.

## ¿Cómo se usa? (Ejemplos básicos)

El wrapper se auto-instala en el primer uso (clona e instala `hybrid-cli-ai` y garantiza el modelo `qwen2.5-coder:1.5b`).

**Ejemplo 1: Uso básico (por defecto agrega `--model qwen2.5-coder:1.5b --run`)**

```bash
ai "lista los archivos de ~/"
```

**Ejemplo 2: Ver el comando sin ejecutarlo**

```bash
ai "lista los archivos de ~/" --no-run
```

**Ejemplo 3: Usar otro modelo o forzar el modo**

```bash
ai "lista los archivos de ~/" --model qwen2:0.5b
ai "lista los archivos de ~/" --cloud
ai "lista los archivos de ~/" --local
```

**Ejemplo 4: Comando por voz (requiere Termux:API y permiso de micrófono)**

```bash
ai              # voz + ejecutar el comando
ai -v           # idem (flag explícito)
ai --no-run     # voz + sugerir SIN ejecutar
ai -v --no-run  # idem
```

**Ejemplo 5: Historial**

```bash
ai --history
ai --clear-history
```

**Ejemplo 6: Deshabilitar / rehabilitar**

```bash
ai disable
ai "lista los archivos de ~/"   # lo vuelve a instalar automáticamente
```

## Consideraciones Adicionales

*   **Modo por defecto:** `ai "texto"` equivale a `ai "texto" --model qwen2.5-coder:1.5b --run`. Puedes manipular libremente con tus propias opciones; `--no-run` evita la ejecución automática.
*   **Ollama:** Viene incluida con i-Haklab. Si el servidor está apagado, `ai` lo enciende solo y descarga el modelo `qwen2.5-coder:1.5b` si falta.
*   **Groq Cloud:** Requiere una clave de Groq. Se configura con `i-Haklab setapikey` → `groq` (guarda `APIKEY_groq`, que el wrapper mapea a `GROQ_API_KEY`) o directamente con `export GROQ_API_KEY=...` (clave gratis en https://console.groq.com).
*   **Voz:** Requiere el paquete `termux-api` y la app Android **Termux:API (termux-api.apk)** con el permiso de micrófono habilitado.
*   **Hecha para Termux:** La IA sabe que está en un teléfono con Termux y te propone comandos con `pkg` y rutas del móvil, no de Linux de PC (`sudo`, `/usr/bin`).
*   **Conoce i-Haklab:** Si tu pregunta menciona i-Haklab (p. ej. `setapikey`, `alltools`, claves), la IA responde con ayuda de la suite: subcomandos, herramientas y cómo instalarlas.

---
*Nota: Esta herramienta integra la potencia de los agentes de IA de última generación en el ecosistema i-Haklab.*
