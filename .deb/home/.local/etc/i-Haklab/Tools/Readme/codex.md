# Codex CLI (@mmmbuto/codex-cli-termux)

## ¿Qué es Codex CLI?

**Codex CLI** es un asistente de inteligencia artificial para la terminal que permite generar, modificar y depurar código mediante comandos en lenguaje natural. La versión para Termux se distribuye como `@mmmbuto/codex-cli-termux@latest` y está optimizada para entornos móviles.

## ¿Para qué es útil?

- Generar código a partir de descripciones en lenguaje natural
- Explicar fragmentos de código complejos
- Refactorizar y depurar scripts existentes
- Asistencia técnica rápida sin salir de la terminal

## ¿Cómo se usa?

**Instalación:**

```bash
npm install -g @mmmbuto/codex-cli-termux@latest
```

O mediante el wrapper de i-HakLab usando el alias:

```bash
apt install codex
# o directamente:
npm install -g codex
```

**Uso básico:**

```bash
codex "Crea un script bash que haga backup de una carpeta"
```

## Consideraciones Adicionales

- Requiere conexión a Internet para funcionar.
- El alias `codex` es reconocido por los wrappers `apt`, `npm` y `pnpm` de i-HakLab, que lo traducen automáticamente a `@mmmbuto/codex-cli-termux@latest`.
- La versión de Termux puede tener diferencias menores respecto a la versión estándar para escritorio.

---

*Nota: Herramienta integrada en el ecosistema i-HakLab a través del wrapper npm/pnpm.*
