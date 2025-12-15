# Converter

## ¿Qué es Converter?

**Converter** es una herramienta de línea de comandos diseñada para **convertir archivos entre distintos formatos**, especialmente imágenes, videos y archivos multimedia, utilizando motores como FFmpeg, ImageMagick u otras utilidades internas según la implementación.

Es comúnmente usada para automatizar tareas de conversión dentro de scripts o flujos de trabajo.

## ¿Para qué es útil?

* Conversión rápida de formatos multimedia
* Automatización de procesos de transformación
* Normalización de archivos para compatibilidad
* Uso en pipelines o scripts Bash

## Ejemplos de uso básicos

**Convertir un video MP4 a MKV:**

```bash
converter video.mp4 video.mkv
```

**Convertir una imagen PNG a JPG:**

```bash 
converter imagen.png imagen.jpg
```

## Consideraciones

Puede depender de herramientas externas como ffmpeg
El rendimiento depende del tamaño del archivo
Ideal para entornos CLI como Termux o servidores
