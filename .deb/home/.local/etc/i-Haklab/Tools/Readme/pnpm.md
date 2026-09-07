# pnpm

## ¿Qué es pnpm?

**pnpm** es un gestor de paquetes para Node.js que destaca por su **eficiencia en el uso de espacio en disco** y su velocidad en comparación con npm o yarn.

Utiliza enlaces simbólicos para evitar duplicación de dependencias.

En **i-HakLab**, el comando `pnpm` viene mejorado: funciona igual que el
original, pero además prepara solo el entorno de herramientas conocidas
(`n8n`, `open-lovable`) y acepta nombres cortos (alias) para los agentes
de IA más usados.

## ¿Para qué es útil?

* Gestión eficiente de dependencias
* Proyectos grandes en Node.js
* Entornos monorepo
* Desarrollo frontend moderno
* Instalación global de herramientas CLI en Termux
* Automatización de dependencias para `n8n` y `open-lovable`

## Comandos básicos

**Instalar dependencias:**

```bash
pnpm install
```

**Instalar una herramienta global:**

```bash
pnpm add -g paquete
```

**Ejecutar scripts:**

```bash
pnpm dev
```

**Actualizar dependencias:**

```bash
pnpm update
```

**Actualizar herramientas globales:**

```bash
pnpm update -g
```

**Desinstalar una herramienta global:**

```bash
pnpm remove -g paquete
```

## Ventajas vs npm

Menor consumo de disco
Instalaciones más rápidas
Lockfile estricto

## Ayudas automáticas de i-HakLab

i-HakLab interviene solo al instalar, actualizar o desinstalar; el resto de
comandos funcionan igual que el pnpm original.

## Alias normalizados

Al instalar o actualizar paquetes, el wrapper traduce estos alias al paquete real:

| Alias usado | Paquete real |
|---|---|
| `gemini-cli` | `@google/gemini-cli` |
| `qwen-code` | `@qwen-code/qwen-code` |
| `claude-code` | `@anthropic-ai/claude-code` |
| `codex` | `@mmmbuto/codex-cli-termux@latest` |
| `copilot-cli` / `github-copilot` | `@github/copilot` |
| `minimax-cli` | `mmx-cli` |

Ejemplo:

```bash
pnpm install -g qwen-code
```

se resuelve como:

```bash
pnpm install -g @qwen-code/qwen-code
```

## Instalación especial de n8n

Al instalar `n8n`, i-HakLab prepara sola todo lo necesario:

1. Dependencias del sistema (Node.js, SQLite).
2. Herramientas auxiliares (gestor de procesos y compilación).
3. Carpetas y archivos de configuración (`~/.n8n`, entorno de compilación).
4. Aprobación de compilaciones del paquete.

```bash
pnpm approve-builds -g
```

## Instalación especial de open-lovable

Al instalar o actualizar `open-lovable`, i-Haklab descarga sola la última
versión oficial en `~/.local/share/open-lovable` (borrando la anterior si
existe) y deja sus dependencias listas.

## Configuración automática

Después de instalar o actualizar paquetes, i-Haklab aplica sola la
configuración que cada herramienta necesite. Si algo quedó a medias,
reinstala el paquete y listo.

## Notas importantes

* `pnpm add -g paquete` es la forma recomendada por pnpm para añadir herramientas globales.
* i-HakLab acepta `install`/`update` además de `add`/`remove`, por compatibilidad con guías y scripts de internet.
* Si un paquete global requiere scripts de compilación, revisa la salida de `pnpm approve-builds`.

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
