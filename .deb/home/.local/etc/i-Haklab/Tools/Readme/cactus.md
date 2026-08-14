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

El paquete se instala con `pkg install cactus`; el `postinst` clona el upstream en `~/.local/share/cactus`, instala las dependencias Python y compila el motor nativo (tarda unos 5-15 minutos; el log queda en `~/.local/share/cactus/build.log`).

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

*   **Dependencias:** El paquete depende de `huggingface` (huggingface_hub), Python, CMake, Rust, `build-essential`, `libcurl`, `python-torch`, `python-torchvision`, `python-scipy`, `python-numpy`, `python-pillow` y `python-tokenizers`.
*   **`cactus convert` necesita el *convert stack*:** Se instala automáticamente en el paso 4 del `postinst` (`sentencepiece`, `protobuf`, `transformers==5.5.4` con `safetensors`, `regex`, `pyyaml`). Si falla o expira el timeout solo afecta a `convert`; el resto de comandos siguen funcionando.
*   **Compatible con Python 3.14:** El `postinst` parchea `requires-python` del `pyproject.toml` y relaja el chequeo de `tokenizers` (transformers exige `<=0.23.0` pero en Termux se usa `python-tokenizers` 0.23.1).
*   **Descargas de HuggingFace:** Por el paquete `huggingface`, las descargas usan HTTP clásico (`HF_HUB_DISABLE_XET=1`) porque `hf-xet` no tiene wheel para Termux/aarch64.
*   **Ejecutables:** El binario `cactus` se instala en `$PREFIX/bin` (sin venv, instalación global e idempotente: se re-parcha tras cada reinstalación).
*   **Ayuda:** https://t.me/Ivam3_Bot · Issues: https://github.com/cactus-compute/cactus

---
*Nota: Esta herramienta integra la inteligencia de Cactus AI en el ecosistema i-Haklab.*