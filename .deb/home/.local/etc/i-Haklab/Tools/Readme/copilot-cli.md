# Copilot CLI (@github/copilot)

## ¿Qué es Copilot CLI?

**GitHub Copilot CLI** (paquete `@github/copilot`) es la interfaz de línea de comandos del asistente de inteligencia artificial de GitHub. Permite obtener sugerencias de comandos, explicaciones de código y traducciones entre idiomas de programación directamente desde la terminal, sin necesidad de un IDE.

## ¿Para qué es útil?

- **Traducción de lenguaje natural a comandos:** Describe lo que quieres hacer en inglés o español y Copilot CLI sugiere el comando adecuado.
- **Explicación de comandos complejos:** Pregunta qué hace un comando específico y obtén una explicación detallada.
- **Conversión entre tecnologías:** Traduce fragmentos de código entre diferentes lenguajes o frameworks.

## ¿Cómo se usa?

**Instalación:**

```bash
npm install -g @github/copilot
```

O mediante el wrapper de i-HakLab usando cualquiera de los alias reconocidos:

```bash
apt install copilot-cli
# o
npm install -g copilot-cli
# o
apt install github-copilot
```

**Autenticación (primera vez):**

```bash
github-copilot auth
```

**Ejemplos de uso:**

```bash
# Preguntar qué comando usar
github-copilot "cómo comprimir todos los archivos .log en el directorio actual"

# Explicar un comando
github-copilot explain "grep -r 'ERROR' /var/log/ | sort | uniq -c | sort -nr"
```

## Consideraciones Adicionales

- Requiere autenticación con una cuenta de GitHub que tenga una suscripción activa a GitHub Copilot.
- Los alias `copilot-cli` y `github-copilot` son intercambiables en los wrappers de i-HakLab, ambos resueltos al paquete `@github/copilot`.
- Funciona offline para explicaciones de comandos, pero las sugerencias de lenguaje natural requieren conexión a Internet.

---

*Nota: Herramienta integrada en el ecosistema i-HakLab a través del wrapper npm/pnpm.*
