# Termux Oracle Skill (termux-oracle-skill)

## ¿Qué es Termux Oracle Skill?

**Termux Oracle Skill** es un paquete de conocimiento portable diseñado para dotar a los agentes de IA (OpenCode, Claude Code, Gemini CLI, etc.) de contexto experto sobre el ecosistema Termux, Android, y la suite i-Haklab. Al instalarse en el directorio de skills del agente, este adquiere documentación detallada sobre configuración, limitaciones del kernel de Android, alternativas a Docker, herramientas precompiladas, y la estructura completa del entorno i-Haklab.

## ¿Para qué es útil la herramienta?

Termux Oracle Skill transforma a cualquier agente de IA en un especialista de Termux, siendo ideal para:

*   **Configuración Automatizada de Termux:** Guiar al agente en la instalación de paquetes, configuración de almacenamiento (`termux-setup-storage`), y preparación del entorno de desarrollo.
*   **Comprensión de Limitaciones del Ecosistema:** Proveer contexto preciso sobre las restricciones del kernel de Android (ausencia de systemd, Docker nativo, cgroups) y las soluciones alternativas disponibles.
*   **Despliegue de Herramientas i-Haklab:** Asistir en la instalación y configuración de las +300 herramientas de la suite, incluyendo servidores (Apache, MariaDB, PostgreSQL), frameworks de seguridad (Metasploit, Bettercap), y entornos gráficos (XFCE4, QEMU).
*   **Integración Multi-Agente:** Un mismo skill funciona sin modificaciones en más de 27 agentes distintos (OpenCode, Claude Code, Codex CLI, Gemini CLI, Cursor, Windsurf, etc.) siguiendo el estándar abierto de skills.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado en el directorio de skills de tu agente favorito, el conocimiento se carga automáticamente al iniciar una sesión en el repositorio:

**Ejemplo 1: Consultar sobre Termux**

```bash
opencode "¿Cómo configuro Termux para desarrollo después de instalar la suite?"
```
*(El agente usará el skill para responder con precisión sobre `termux-setup-storage`, repositorios apt y variables de entorno).*

**Ejemplo 2: Solucionar limitaciones de Android**

```bash
claude "¿Puedo ejecutar Docker en Termux? Si no, ¿qué alternativas tengo?"
```
*(El skill contiene la documentación sobre `termux-docker-qemu` y `udocker` como alternativas).*

**Ejemplo 3: Instalar herramientas específicas**

```bash
gemini "Quiero instalar Metasploit en Termux con la suite i-Haklab"
```
*(El skill referencia la estructura de la suite y los scripts de instalación disponibles).*

## Consideraciones Adicionales

*   **Instalación:** Copia el directorio `termux-oracle-skill/` dentro de `~/.<agente>/skills/` o la ruta de skills de tu agente (`.claude/skills/`, `.config/opencode/skills/`, etc.).
*   **Sin Dependencias:** El skill es auto-contenido — no requiere paquetes adicionales ni configuración de red para funcionar.
*   **Multi-Agente:** Un solo skill funciona en todos los agentes compatibles; no necesitas versiones distintas para cada uno.
*   **Actualizable:** Nuevas versiones del skill se publican en GitHub Releases; el paquete `.deb` (`termux-oracle-skill`) está disponible en el repositorio Ivam3 de Termux.

---
*Nota: Este skill integra el conocimiento experto del ecosistema Termux y la suite i-Haklab en los agentes de IA modernos.*
