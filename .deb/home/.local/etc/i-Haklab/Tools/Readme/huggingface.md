# HuggingFace (huggingface_hub)

## ¿Qué es HuggingFace?

**HuggingFace Hub** es la plataforma central de la comunidad de IA donde se alojan y comparten modelos, datasets y espacios. El paquete `huggingface` de i-Haklab instala la librería cliente `huggingface_hub` (Python) y la herramienta CLI `huggingface-cli` / `hf`, que permite descargar, publicar y versionar modelos y datasets directamente desde la terminal de Termux.

## ¿Para qué es útil la herramienta?

HuggingFace es útil para:

*   **Descargar modelos y datasets:** Accede a cualquier modelo público de la Hub con un solo comando o desde Python.
*   **Autenticación:** Guarda tu token para acceder a modelos privados o con gating (`login` / `whoami`).
*   **Publicación:** Sube archivos, modelos o datasets con `huggingface-cli upload`.
*   **Base de otras herramientas:** Es la dependencia principal de paquetes de IA de i-Haklab como `cactus` (descarga de pesos).
*   **Uso desde Python:** `snapshot_download`, `hf_hub_download`, etc. en tus scripts.

## ¿Cómo se usa? (Ejemplos básicos)

El paquete se instala con `pkg install huggingface` y queda listo para usar.

**Ejemplo 1: Autenticarse con HuggingFace**

```bash
huggingface-cli login
```

**Ejemplo 2: Ver el usuario autenticado**

```bash
huggingface-cli whoami
```

**Ejemplo 3: Descargar un modelo**

```bash
huggingface-cli download gpt2
```

**Ejemplo 4: Subir un archivo/modelo**

```bash
huggingface-cli upload org/mi-modelo ruta/archivo
```

**Ejemplo 5: Desde Python**

```python
from huggingface_hub import snapshot_download
snapshot_download("org/model")
```

## Consideraciones Adicionales

*   **Descargas:** Usan el modo clásico, optimizado para funcionar en el teléfono sin pasos extra.
*   **Documentación oficial:** https://huggingface.co/docs/huggingface_hub
*   **Ayuda:** https://t.me/Ivam3_Bot

---
*Nota: Esta herramienta integra la potencia de la plataforma HuggingFace Hub en el ecosistema i-Haklab.*