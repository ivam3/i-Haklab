# Gemini CLI (@google/gemini-cli)

## ¿Qué es Gemini CLI?

**Gemini CLI** es una potente interfaz de línea de comandos que permite interactuar con los modelos de inteligencia artificial Gemini de Google directamente desde la terminal. Está diseñada para desarrolladores y entusiastas que buscan integrar capacidades de IA en sus flujos de trabajo de terminal, permitiendo generar texto, analizar código y realizar consultas complejas de forma rápida y eficiente.

## ¿Para qué es útil la herramienta?

Gemini CLI transforma la terminal en un entorno asistido por IA, siendo útil para:

*   **Asistencia en Programación:** Generar fragmentos de código, explicar errores de sintaxis o sugerir mejoras algorítmicas.
*   **Automatización de Tareas:** Crear scripts o procesar datos utilizando lenguaje natural.
*   **Consultas Técnicas Rápidas:** Obtener respuestas sobre comandos de Linux, configuraciones de red o documentación sin salir de la consola.
*   **Análisis de Archivos:** Enviar el contenido de archivos locales para que la IA los resuma o analice.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez configurada con tu API Key, puedes usar Gemini CLI de la siguiente manera:

**Ejemplo 1: Una consulta simple**

```bash
gemini "Explícame cómo funciona el protocolo SSH en dos frases"
```

**Ejemplo 2: Analizar un archivo local**

```bash
cat config.php | gemini "Busca posibles vulnerabilidades en este código"
```

**Ejemplo 3: Generar un script**

```bash
gemini "Crea un script de bash para respaldar la carpeta /data/db cada domingo a las 3am"
```

## Consideraciones Adicionales

*   **API Key:** Requiere una clave de API válida de Google AI Studio configurada en las variables de entorno.
*   **Privacidad:** Recuerda que las consultas se envían a los servidores de Google; evita enviar información extremadamente sensible o secretos de estado.
*   **Actualizaciones:** Al ser una herramienta en rápido desarrollo, es recomendable mantenerla actualizada para acceder a los últimos modelos y características.

---
*Nota: Esta herramienta integra la potencia de los modelos de lenguaje de última generación en el ecosistema i-Haklab.*
