# txt2media

## ¿Qué es txt2media?

**txt2media** convierte texto en audio (voz) y puede incrustar ese audio en un video.
Se invoca como subcomando de i-HakLab (`i-Haklab txt2media`). Usa **Edge-TTS** (voces
neurales gratuitas, p. ej. `es-MX-DaliaNeural`) para la síntesis y **ffmpeg** para
mezclar el audio con video.

- **Requisitos**: `python3`, `ffmpeg` y el módulo `edge-tts` (se auto-instala vía `pip`
  la primera vez). Requiere internet (las voces se sintetizan en el servicio de Edge).

## ¿Para qué es útil?

*   **Narración**: generar locuciones en español/inglés para videos, tutoriales o avisos.
*   **Accesibilidad**: convertir documentos `.txt` en audio escuchable.
*   **Contenido**: montar video final con voz sintética en un solo comando.

## ¿Cómo se usa? (Ejemplos básicos)

**Texto directo a MP3**

```bash
i-Haklab txt2media -t "Hola mundo" -o saludo
```

**Archivo de texto a MP3 con voz y velocidad**

```bash
i-Haklab txt2media -f notas.txt -o narracion -v en-US-JennyNeural -r +10%
```

**Incrustar audio en un video**

```bash
i-Haklab txt2media --video base.mp4 --audio saludo.mp3 -o final.mp4
```

**Listar todas las voces disponibles**

```bash
i-Haklab txt2media -l
```

## Opciones

| Opción | Descripción |
| :--- | :--- |
| `-t "texto"` | Texto a sintetizar. |
| `-f archivo` | Archivo `.txt` a sintetizar. |
| `-o salida` | Nombre base de salida (sin extensión). |
| `-v voz` | Voz Edge-TTS (por defecto: `es-MX-DaliaNeural`). |
| `-r velocidad` | Velocidad (`+10%`, `+0%`, `-10%`; por defecto `+10%`). |
| `--video base.mp4 --audio out.mp3 [-o final.mp4]` | Mezcla audio en video (`-c:v copy`, `-shortest`). |
| `-l` | Lista todas las voces (`edge_tts --list-voices`). |
| `-h` | Muestra la ayuda. |

## Consideraciones Adicionales

*   **Salidas**: `~/.local/share/txt2media/{texts,audios,videos/}`, además de `Music` y
    `Movies` (con `media-scan` para que Android las indexe).
*   **Reintentos**: la síntesis reintenta automáticamente ante fallos de red.
*   Voces de ejemplo: `es-MX-DaliaNeural` (ES), `en-US-JennyNeural` (EN); ver `-l` para todas.

---
*Nota: síntesis de voz y mezcla A/V del ecosistema i-HakLab (Edge-TTS + ffmpeg).*
