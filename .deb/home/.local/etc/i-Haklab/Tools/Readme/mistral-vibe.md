# Mistral Vibe (mistral-vibe)

## ¿Qué es Mistral Vibe?

**Mistral Vibe** es una herramienta de línea de comandos que integra los modelos de lenguaje de Mistral AI en el flujo de trabajo de desarrollo, proporcionando capacidades de edición agéntica, explicación de código y generación automatizada directamente desde la terminal.

## ¿Para qué es útil?

- Asistencia en programación con modelos Mistral AI
- Generación y refactorización de código
- Explicación de fragmentos de código complejos
- Automatización de tareas de desarrollo

## Instalación

```bash
# Mediante el wrapper de i-HakLab:
apt install mistral-vibe
# O directamente con pip:
pip install mistral-vibe
```

## ¿Cómo se usa?

```bash
mistral-vibe "describe el propósito de este repositorio"
```

## Consideraciones Adicionales

- Requiere una API key de Mistral AI configurada en las variables de entorno.
- Se instala automáticamente como dependencia al instalar `claude-code` o `qwen-code` mediante los wrappers de i-HakLab.

---

*Nota: Herramienta integrada en el ecosistema i-HakLab para desarrollo asistido por IA.*
