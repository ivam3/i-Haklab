# Freebuff CLI (freebuff)

## ¿Qué es Freebuff?

**Freebuff** es la versión gratuita y con publicidad de Codebuff, un asistente de codificación IA de código abierto para la terminal. Utiliza la misma arquitectura multi-agente que Codebuff, pero está impulsado por los mejores modelos open-source disponibles (DeepSeek, Kimi, MiniMax, MiMo, Gemini) y se financia mediante anuncios de texto. No requiere suscripción, ni créditos, ni configuración — solo instalas y empiezas a programar.

## ¿Para qué es útil la herramienta?

Freebuff democratiza el acceso a la asistencia de codificación con IA siendo completamente gratuito:

*   **Asistencia Gratuita:** Sin suscripciones, sin API keys, sin tarjeta de crédito. Funciona desde el primer `freebuff`.
*   **Modelos Open-source:** Utiliza los mejores modelos de código abierto como DeepSeek V4, MiMo 2.5, Kimi K2.6, y MiniMax M3 — sin bloqueo propietario.
*   **Arquitectura Multi-agente:** La misma potencia de Codebuff: File Picker, Planner, Editor, Reviewer, Web Research y Browser Use agents.
*   **Rápido:** 5–10× más rápido gracias a modelos rápidos y recolección de contexto en segundos.
*   **Completo:** Investigación web integrada, uso de navegador y más.

## ¿Cómo se usa? (Ejemplos básicos)

Instalación global vía NPM:

```bash
npm install -g freebuff
```

**Ejemplo 1: Iniciar Freebuff en el directorio actual**

```bash
cd tu-proyecto
freebuff
```

**Ejemplo 2: Ejecutar una tarea**

```bash
freebuff "Añade validación de email al formulario de registro"
```

**Ejemplo 3: Referenciar archivos específicos**

```
@login.js Agrega validación de contraseña segura a este archivo
```

**Comandos útiles en la CLI:**

| Comando | Descripción |
|---------|-------------|
| `/help` | Atajos de teclado y consejos |
| `/new` | Nueva conversación |
| `/history` | Historial de conversaciones |
| `/bash` | Modo bash |
| `/theme:toggle` | Alternar tema claro/oscuro |

## Consideraciones Adicionales

*   **Publicidad:** Freebuff se financia mediante anuncios de texto relevantes para desarrolladores en la terminal.
*   **Disponibilidad Geográfica:** Modo "full" en EE. UU., Canadá, Reino Unido, UE y otros países seleccionados. Modo "limitado" en el resto del mundo.
*   **Modo Limitado:** Incluye DeepSeek V4 Flash y MiMo 2.5, con 5 sesiones de 1 hora por día.
*   **Privacidad:** No almacenan tu código base. Solo registros mínimos para depuración. No entrenan con tus datos.
*   **Modelos:** En modo completo puedes elegir entre DeepSeek V4 Pro, MiMo 2.5 Pro, Kimi K2.6, DeepSeek V4 Flash, MiMo 2.5 y MiniMax M3.

---

*Nota: Esta herramienta integra la alternativa gratuita y de código abierto a Codebuff en el ecosistema i-Haklab, permitiendo asistencia de codificación IA sin costo alguno.*
