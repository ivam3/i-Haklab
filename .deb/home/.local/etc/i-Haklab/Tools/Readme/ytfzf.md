# ytfzf

## ¿Qué es ytfzf?

`ytfzf` es una ingeniosa herramienta de línea de comandos que te permite **buscar y reproducir vídeos de YouTube directamente desde tu terminal**. Su nombre es un acrónimo de "YouTube `fzf`", haciendo referencia a `fzf` (un "buscador de archivos difuso" interactivo) que utiliza para la selección de vídeos.

Combina varias herramientas de línea de comandos para proporcionar una experiencia completa sin necesidad de un navegador web:
*   Realiza búsquedas en YouTube.
*   Presenta los resultados en una lista interactiva.
*   Reproduce el vídeo seleccionado utilizando un reproductor de vídeo externo (como `mpv` o `vlc`).
*   Puede incluso descargar vídeos.

## ¿Para qué es útil?

`ytfzf` es una herramienta de productividad y comodidad, especialmente para usuarios que prefieren la terminal o que tienen recursos limitados.

*   **Reproducción de YouTube sin Navegador:** Permite ver vídeos de YouTube sin la distracción de la interfaz web, los anuncios, o el consumo de recursos de un navegador.
*   **Búsqueda Rápida:** La integración con `fzf` hace que la búsqueda y selección de vídeos sea increíblemente rápida y eficiente.
*   **Ahorro de Recursos:** Utiliza menos RAM y CPU que la reproducción de vídeos en un navegador web, lo que es ideal para máquinas antiguas, servidores remotos (a través de SSH con reenvío X) o dispositivos de baja potencia como un Raspberry Pi o un teléfono con Termux.
*   **Descarga de Vídeos:** Ofrece la opción de descargar el vídeo o solo el audio del vídeo seleccionado.
*   **Privacidad:** Al no usar el navegador, puede ofrecer una experiencia de visualización más privada, aunque no es una herramienta de anonimato per se.

## ¿Cómo se usa? (Ejemplos básicos)

`ytfzf` es relativamente fácil de usar, una vez que tienes sus dependencias instaladas (`fzf`, `mpv`/`vlc`, `youtube-dl`/`yt-dlp`).

**Ejemplo 1: Buscar y seleccionar un vídeo**

Este comando buscará vídeos con la palabra clave "lofi hip hop". `ytfzf` listará los resultados y podrás usar `fzf` para seleccionar el vídeo.

```bash
ytfzf "lofi hip hop"
```

Después de ejecutarlo, verás una lista interactiva. Puedes escribir para filtrar, usar las flechas para navegar, y `Enter` para seleccionar y reproducir el vídeo.

**Ejemplo 2: Reproducir el primer resultado directamente**

Si quieres saltarte la selección interactiva y simplemente reproducir el primer vídeo encontrado.

```bash
ytfzf --plain "linux tutorials"
```
*   `--plain`: Reproduce el primer resultado sin la selección interactiva.

**Ejemplo 3: Descargar un vídeo**

Este comando buscará "gemini 2.5 flash" y te dará la opción de descargar el vídeo en lugar de reproducirlo.

```bash
ytfzf -d "gemini 2.5 flash"
```
*   `-d`: Habilita el modo de descarga.

## Consideraciones Adicionales

*   **Dependencias:** Requiere que varias herramientas estén instaladas en tu sistema (`fzf`, `mpv` o `vlc`, y `yt-dlp` o `youtube-dl`).
*   **No es una herramienta de hacking:** `ytfzf` es una herramienta de productividad y conveniencia. No tiene aplicaciones ofensivas en ciberseguridad.
*   **Personalización:** Es altamente configurable, permitiendo a los usuarios ajustar los reproductores, los parámetros de búsqueda y el formato de salida.

---
*Nota: `ytfzf` es una excelente demostración de cómo la combinación de herramientas de línea de comandos puede crear soluciones poderosas y eficientes.*
