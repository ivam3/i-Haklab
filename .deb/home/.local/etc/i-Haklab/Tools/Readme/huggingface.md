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

El paquete se instala con `pkg install huggingface`; el `postinst` instala `huggingface_hub` vía pip (global, sin venv) junto a sus dependencias puras.

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

*   **Descargas clásicas (sin Xet):** `huggingface_hub` 1.27.0 declara `hf-xet` como dependencia dura en aarch64, pero no tiene wheel para Termux y no compila en Python 3.14 (`_Py_FalseStruct`). Por eso el `postinst` lo instala con `--no-deps` y crea `${PREFIX}/etc/profile.d/huggingface.sh` que exporta `HF_HUB_DISABLE_XET=1`, forzando descargas HTTP clásicas. Si en el futuro sale un wheel de `hf-xet` funcional, puedes borrar ese archivo o hacer `unset HF_HUB_DISABLE_XET`.
*   **Limpieza al desinstalar:** El `postrm` elimina automáticamente `huggingface.sh` del `profile.d`.
*   **Ejecutables:** `huggingface-cli` y `hf` se instalan en `$PREFIX/bin` (instalación global, idempotente).
*   **Documentación oficial:** https://huggingface.co/docs/huggingface_hub
*   **Ayuda:** https://t.me/Ivam3_Bot

---
*Nota: Esta herramienta integra la potencia de la plataforma HuggingFace Hub en el ecosistema i-Haklab.*