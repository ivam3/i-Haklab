# Qwen Code CLI (@qwen-code/qwen-code)

## ¿Qué es Qwen Code CLI?

**Qwen Code CLI** es una herramienta de línea de comandos de código abierto optimizada para tareas de programación agéntica, diseñada específicamente para aprovechar el potencial de los modelos **Qwen-Coder** de Alibaba Cloud. Permite interactuar con tu base de código de forma inteligente, funcionando como un asistente experto que puede leer, escribir y razonar sobre proyectos complejos directamente desde la terminal.

## ¿Para qué es útil la herramienta?

Qwen Code CLI está diseñada para potenciar el flujo de trabajo de desarrollo mediante:

*   **Edición Agéntica:** Capacidad para realizar refactorizaciones, corregir errores (bug fixing) y generar pruebas unitarias de forma autónoma tras analizar el contexto.
*   **Comprensión de Código:** Explica estructuras de proyectos grandes, dependencias y lógica de negocio difícil de seguir.
*   **Automatización de Workflows:** Ayuda en la gestión de tareas operativas como la creación de Pull Requests, rebases de Git y documentación de código.
*   **Soporte Multimodal:** Detección automática de imágenes para tareas que requieren visión artificial.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado y configurado (ya sea mediante Qwen OAuth o una API Key de Alibaba Cloud), puedes usarlo escribiendo:

**Ejemplo 1: Iniciar una sesión interactiva**

```bash
qwen
```

**Ejemplo 2: Pedir una refactorización específica**

```bash
qwen "Refactoriza el módulo de autenticación para usar JWT en lugar de sesiones"
```

**Ejemplo 3: Generar tests unitarios**

```bash
qwen "Crea pruebas unitarias con Jest para el archivo src/utils/formatter.js"
```

## Consideraciones Adicionales

*   **Autenticación:** Soporta **Qwen OAuth** para un uso gratuito (con límites diarios) o configuración mediante variables de entorno para APIs compatibles con OpenAI.
*   **Requisitos:** Necesita **Node.js 20** o superior para funcionar correctamente.
*   **Privacidad:** Al igual que otras IAs basadas en la nube, asegúrate de no compartir secretos o información sensible si usas los modelos públicos.

---
*Nota: Esta herramienta integra la potencia de los modelos Qwen-Coder en el ecosistema i-Haklab.*
