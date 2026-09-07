# Cactus (cactus-compute/cactus)

## ¿Qué es Cactus?

**Cactus** es un motor de IA híbrido *edge-cloud* para dispositivos móviles. Permite ejecutar modelos de lenguaje (LLM), visión (VLM) y voz directamente en el dispositivo (vía el **Cactus Engine** nativo compilado en C++20 con kernels NEON para ARM), con la opción de escalar a la nube cuando hace falta. Está disponible como paquete `cactus` en el repositorio Termux de i-Haklab.

## ¿Para qué es útil la herramienta?

Cactus es útil para:

*   **Inferencia en el dispositivo:** Ejecuta LLM/VLM/speech en tu teléfono sin depender de la nube.
*   **Descarga y gestión de modelos:** Autentícate con HuggingFace/Cactus, descarga y lista los modelos cacheados.
*   **Transcripción de voz:** `cactus transcribe` convierte audio a texto con modelos como `openai/whisper-base`.
*   **API compatible con OpenAI:** `cactus serve` levanta un servidor local tipo OpenAI para integrarlo en tus apps.
*   **Conversión de pesos (convert stack):** `cactus convert` transforma modelos de HuggingFace al formato CQ optimizado para el motor.

## ¿Cómo se usa? (Ejemplos básicos)

El paquete se instala con `pkg install cactus`. La primera instalación compila el motor en tu teléfono y tarda unos 5-15 minutos (puedes seguir el avance en `~/.local/share/cactus/build.log`).

**Ejemplo 1: Autenticación**

```bash
cactus auth hf
cactus auth pat
```

**Ejemplo 2: Descargar y ejecutar un modelo por primera vez**

```bash
cactus download Cactus-Compute/needle
cactus run Cactus-Compute/needle
```

**Ejemplo 3: Listar modelos cacheados**

```bash
cactus list
```

**Ejemplo 4: Transcribir un audio**

```bash
cactus transcribe openai/whisper-base --file audio.wav
```

**Ejemplo 5: Servir una API tipo OpenAI**

```bash
cactus serve Cactus-Compute/needle --port 8080
```

**Ejemplo 6: Convertir pesos de HuggingFace a formato CQ**

```bash
cactus convert HuggingFace/modello
```

## Consideraciones Adicionales

*   **Requisitos:** Se instala todo solo con el paquete (Python, herramientas de compilación y librerías de IA incluidas).
*   **`cactus convert`:** Si la conversión falla o tarda demasiado, solo afecta a `convert`; el resto de comandos siguen funcionando.
*   **Descargas de HuggingFace:** Usan descarga clásica, optimizada para funcionar en el teléfono.
*   **Ayuda:** https://t.me/Ivam3_Bot · Issues: https://github.com/cactus-compute/cactus

---
*Nota: Esta herramienta integra la inteligencia de Cactus AI en el ecosistema i-Haklab.*