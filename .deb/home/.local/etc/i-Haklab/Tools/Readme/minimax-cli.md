# MiniMax CLI (mmx-cli)

## ¿Qué es MiniMax CLI?

**MiniMax CLI** (representado por el comando `mmx`) es la interfaz de línea de comandos oficial de la plataforma de inteligencia artificial MiniMax. Está diseñada para proporcionar a los desarrolladores y agentes de IA un acceso directo y nativo a la suite de modelos generativos multimodales de MiniMax desde la terminal, facilitando la creación de contenido y la consulta de información sin necesidad de configuraciones complejas.

## ¿Para qué es útil la herramienta?

MiniMax CLI convierte tu terminal en un potente centro creativo multimodal, siendo útil para:

*   **Generación Multimodal Directa:** Crear texto, imágenes, video, audio y música mediante comandos sencillos.
*   **Asistencia e Integración de Agentes:** Funciona como una habilidad ("skill") para agentes de IA (como Cursor, Claude Code u OpenClaw), permitiéndoles interactuar con el entorno.
*   **Traducción de Voz y Audio (TTS):** Generar síntesis de voz a partir de texto (Text-to-Speech) con soporte para más de 30 voces diferentes.
*   **Búsqueda en la Web:** Utilizar el motor de búsqueda integrado de MiniMax para obtener información en tiempo real directamente en la terminal.
*   **Comprensión Visual:** Enviar imágenes para que los modelos de visión de MiniMax las analicen y describan.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalada (`npm install -g mmx-cli`) y configurada con tu API Key, puedes usarla de las siguientes maneras:

**Ejemplo 1: Conversar con el modelo de texto**

```bash
mmx text chat --message "Explícame la diferencia entre fusión y fisión nuclear"
```

**Ejemplo 2: Generar una imagen**

```bash
mmx image "Un astronauta tocando la guitarra en Marte, estilo cyberpunk"
```

**Ejemplo 3: Sintetizar texto a voz**

```bash
mmx speech synthesize --text "Hola, bienvenido al entorno i-Haklab" --out bienvenida.mp3
```

**Ejemplo 4: Generar un video (Asíncrono)**

```bash
mmx video generate --prompt "Un dron volando sobre un bosque nevado en el atardecer"
```

## Consideraciones Adicionales

*   **API Key y Autenticación:** Requiere una clave de API válida de la plataforma MiniMax, que se puede configurar iniciando sesión con `mmx auth login --api-key tu-api-key`.
*   **Soporte Multirregión:** Permite alternar y trabajar tanto con la plataforma global (`api.minimax.io`) como con la región de China (`api.minimaxi.com`).
*   **Requisitos:** Requiere tener Node.js en su versión 18 o superior instalado en el sistema.
*   **Integración de Agentes:** Los agentes de IA pueden añadirla como habilidad global mediante el comando `npx skills add MiniMax-AI/cli -y -g`.

---
*Nota: Esta herramienta integra la potencia de los modelos multimodales de última generación en el ecosistema i-Haklab.*
