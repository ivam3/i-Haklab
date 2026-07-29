# Kimi Code (@moonshot-ai/kimi-code)

## ¿Qué es Kimi Code?

**Kimi Code** es el agente de codificación open-source de línea de comandos de Moonshot AI, diseñado para ejecutarse directamente en la terminal. Lee y edita archivos, ejecuta comandos del sistema, busca en la web y trabaja a través de tareas complejas paso a paso usando lenguaje natural. Su distribución single-binary permite una instalación sin dependencias de Node.js, y su TUI optimizado está pensado para sesiones largas y enfocadas.

## ¿Para qué es útil la herramienta?

* **Edición Agéntica:** Puede refactorizar, corregir errores y generar código nuevo tras analizar el contexto del proyecto.
* **Subagentes:** Integra subagentes `coder`, `explore` y `plan` que ejecutan trabajo paralelo en contextos aislados.
* **Soporte MCP:** Configura y autentica servidores MCP conversacionalmente mediante `/mcp-config`, sin editar JSON a mano.
* **Lifecycle Hooks:** Permite ejecutar comandos locales en puntos clave (bloquear llamadas riesgosas, auditar decisiones, notificaciones).
* **Entrada de Video:** Acepta grabaciones de pantalla o demos como entrada para que el agente observe sin descripciones textuales.

## ¿Cómo se usa? (Ejemplos básicos)

**Ejemplo 1: Iniciar sesión interactiva en el directorio actual**

```bash
kimi
```

**Ejemplo 2: Pedir una refactorización específica**

```bash
kimi "Refactoriza el módulo de autenticación para usar JWT en lugar de sesiones"
```

**Ejemplo 3: Ejecutar una instrucción única sin modo interactivo**

```bash
kimi -p "Explica la estructura de este proyecto y sus directorios principales"
```

## Consideraciones Adicionales

* **Autenticación:** Requiere iniciar sesión con `/login` en el primer uso (soporta OAuth de Kimi Code o API key de Moonshot AI).
* **Node.js:** La instalación por npm requiere Node.js 22.19.0 o superior; el script oficial de instalación no necesita Node.js.
* **Modo YOLO:** Usa `--yolo` para omitir confirmaciones en entornos de confianza.

---
*Nota: Esta herramienta integra el agente de codificación de Moonshot AI en el ecosistema i-Haklab.*
