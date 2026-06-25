# Context7 CLI (ctx7)

## ¿Qué es Context7 CLI?

**Context7 CLI** (`ctx7`) es una herramienta de línea de comandos que recupera documentación actualizada, referencias de API y ejemplos de código para cualquier librería o framework de programación directamente desde la terminal. Consulta documentación oficial en tiempo real sin necesidad de abrir el navegador.

## ¿Para qué es útil la herramienta?

`ctx7` es esencial para desarrolladores que necesitan documentación precisa y actualizada:

-   **Documentación bajo demanda:** Obtén ejemplos de código y guías de API de cualquier librería sin salir de la terminal.
-   **Detección de librerías:** Resuelve nombres de paquetes a IDs de documentación compatibles con búsqueda contextual.
-   **Soporte multi-librería:** Consulta documentación de React, Next.js, Prisma, Express, Django, Vue, Tailwind, Supabase y cientos más.
-   **Versiones específicas:** Permite consultar documentación de versiones concretas de una librería.
-   **Ejemplos de código:** Cada consulta incluye fragmentos de código reales extraídos de repositorios oficiales.
-   **Integración con agentes de IA:** Diseñado para ser usado por asistentes como OpenCode o Claude Code para mantener el contexto actualizado.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado, resuelve una librería y consulta su documentación:

**Ejemplo 1: Resolver el ID de una librería**

```bash
ctx7 library react "How to use useEffect with cleanup"
```

**Ejemplo 2: Consultar documentación con el ID resuelto**

```bash
ctx7 docs /facebook/react "How to use useEffect with cleanup"
```

**Ejemplo 3: Consultar una versión específica**

```bash
ctx7 docs /vercel/next.js/v14.3.0 "How to set up middleware in app router"
```

**Ejemplo 4: Consultar documentación de Prisma**

```bash
ctx7 library prisma "Define one-to-many relations with cascade delete"
ctx7 docs /prisma/prisma "Define one-to-many relations with cascade delete"
```

## Consideraciones Adicionales

-   **Autenticación:** Funciona sin autenticación. Para límites más altos, usa `ctx7 login` o configura `CONTEXT7_API_KEY`.
-   **Formato de consulta:** Las consultas descriptivas y detalladas producen mejores resultados que términos vagos.
-   **Sin instalación:** Puedes usar `npx ctx7@latest` sin instalar nada globalmente.
-   **Límite de consultas:** Por defecto tiene un cuota mensual. Autenticarse aumenta el límite.

---
*Nota: Esta herramienta integra consulta de documentación técnica en tiempo real en el ecosistema i-Haklab.*
