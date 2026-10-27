
# Ollama

## ¿Qué es Ollama?

**Ollama** es un ejecutor de modelos de lenguaje (LLM) de código abierto que permite descargar, ejecutar y servir modelos localmente con una interfaz de línea de comandos y una API HTTP compatible con OpenAI. En i-Haklab se instala desde `tur-repo` y forma parte de las dependencias del entorno, por lo que queda disponible como el comando `ollama`.

Al ejecutarse en el propio dispositivo, Ollama permite usar modelos de IA sin enviar prompts ni datos a servicios externos. Es la base del modo local del asistente `ai` de i-Haklab y de otras integraciones de la suite.

## ¿Para qué es útil la herramienta?

-   **IA local y privada:** ejecuta modelos sin depender de la nube ni de una cuenta externa.
-   **Asistente de terminal:** `ai` usa Ollama para convertir lenguaje natural en comandos, con modo offline.
-   **Modelos especializados:** permite descargar modelos para código, análisis, redacción o conversación, como `qwen2.5-coder`, `llama3.2` o `deepseek-coder`.
-   **API local:** expone un endpoint compatible con OpenAI en `http://127.0.0.1:11434` para scripts y clientes.
-   **Experimentación:** facilita probar y comparar modelos sin instalar frameworks de Python adicionales.

## ¿Cómo se usa?

### 1. Instalación

Ollama ya se instala como dependencia de i-Haklab. Para instalarlo o reinstalarlo manualmente:

```bash
pkg install ollama
```

Verifica la versión:

```bash
ollama --version
```

### 2. Iniciar el servidor

```bash
ollama serve
```

El servidor escucha por defecto en `127.0.0.1:11434`. En Termux puedes dejarlo en segundo plano:

```bash
nohup ollama serve >/dev/null 2>&1 &
```

### 3. Descargar y ejecutar un modelo

```bash
ollama pull qwen2.5-coder:1.5b
ollama run qwen2.5-coder:1.5b
```

Dentro del prompt interactivo puedes escribir tu consulta o usar `/bye` para salir. Para una consulta directa:

```bash
ollama run qwen2.5-coder:1.5b "Explica qué hace este comando de Termux"
```

### 4. Gestionar modelos

```bash
ollama list
ollama ps
ollama show qwen2.5-coder:1.5b
ollama rm qwen2.5-coder:1.5b
```

`list` muestra los modelos descargados, `ps` los que están cargados en memoria y `rm` elimina un modelo.

### 5. Integración con i-Haklab

El asistente `ai` usa Ollama automáticamente cuando está disponible:

```bash
ai "lista los archivos de mi directorio home" --local
```

También puedes usar Ollama desde otros clientes mediante la API local:

```bash
curl http://127.0.0.1:11434/api/tags
```

## Otras consideraciones

-   **Recursos:** los modelos consumen RAM y almacenamiento. En un dispositivo móvil conviene empezar por modelos pequeños (por ejemplo, 1.5B o 3B) y aumentar según la memoria disponible.
-   **Rendimiento:** en Termux el procesamiento suele ser por CPU, por lo que las respuestas pueden ser más lentas que en un equipo con GPU.
-   **Almacenamiento:** los modelos se guardan por defecto en `~/.ollama/models`. Puedes cambiar la ruta con `OLLAMA_MODELS`.
-   **Servidor local:** `OLLAMA_HOST` permite cambiar la dirección o el puerto. No expongas la API en interfaces públicas sin autenticación ni controles de acceso.
-   **Segundo plano:** Android puede suspender procesos en segundo plano. Si necesitas el servidor activo, mantén Termux en primer plano o usa un wake lock.
-   **Actualización:** actualiza con `pkg update && pkg upgrade`. Los modelos descargados se conservan en `~/.ollama`.
-   **Uso responsable:** verifica la licencia y el origen de cada modelo antes de usarlo en entornos profesionales.

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
