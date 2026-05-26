# Antigravity (@google/antigravity)

## ¿Qué es Antigravity?

**Antigravity** es una plataforma de desarrollo "agent-first" de Google diseñada para ejecutar tareas de programación, investigación y automatización de forma autónoma mediante el uso de modelos Gemini. A diferencia de las interfaces de chat tradicionales, Antigravity está optimizado para actuar como un agente que puede navegar por el sistema de archivos, leer código y ejecutar comandos para resolver problemas complejos.

## ¿Para qué es útil la herramienta?

Antigravity lleva la asistencia de IA a un nivel superior, permitiendo:

*   **Desarrollo Autónomo:** Delegar tareas completas como "corrige este bug en el parser" o "añade tests unitarios a este módulo".
*   **Auditoría de Seguridad:** Analizar repositorios enteros en busca de vulnerabilidades y proponer parches automáticos.
*   **Investigación de Código:** Mapear arquitecturas complejas y entender dependencias sin intervención manual exhaustiva.
*   **Automatización Avanzada:** Ejecutar flujos de trabajo multi-paso que involucran lectura, escritura y validación de código.

## ¿Cómo se usa? (Ejemplos básicos)

Antigravity se utiliza principalmente a través de su CLI o su entorno integrado. Aquí algunos ejemplos de su potencia:

**Ejemplo 1: Una tarea de refactorización**

```bash
antigravity "Refactoriza el módulo de autenticación para usar JWT en lugar de sesiones"
```

**Ejemplo 2: Análisis de vulnerabilidades**

```bash
antigravity "Busca inyecciones SQL en la carpeta /src y propón soluciones"
```

**Ejemplo 3: Creación de documentación**

```bash
antigravity "Genera un archivo README.md detallado basado en el código de este repositorio"
```

## Consideraciones Adicionales

*   **Confianza y Permisos:** Al ser un agente autónomo con acceso al sistema de archivos, debe ejecutarse en entornos controlados y supervisados.
*   **API Key:** Requiere configuración previa con las credenciales de Google Cloud o AI Studio.
*   **Seguridad:** Ten en cuenta los riesgos de inyección de prompts indirectos al permitir que el agente procese código de fuentes no confiables.
*   **Optimización para Termux:** En el ecosistema i-Haklab, Antigravity está especialmente configurado para funcionar de manera eficiente en dispositivos Android.

---
*Nota: Esta herramienta integra la potencia de los agentes autónomos de última generación en el ecosistema i-Haklab.*
