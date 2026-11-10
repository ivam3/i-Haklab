# npm

## ¿Qué es npm?

**npm** (Node Package Manager) es el gestor de paquetes oficial de Node.js.
Viene incluido con Node y permite instalar, actualizar y desinstalar tanto las
dependencias de un proyecto como herramientas CLI de uso global.

En **i-HakLab**, el comando `npm` viene mejorado: funciona igual que el
original, pero además prepara solo el entorno de herramientas conocidas
(`n8n`, `open-lovable`, `pnpm`, `testsprite`, `zcode-cli`, `openspec`) y acepta
nombres cortos (alias) para los agentes de IA más usados.

## ¿Para qué es útil?

* Instalar las dependencias de proyectos Node.js.
* Instalar herramientas CLI globales en Termux.
* Actualizar y desinstalar paquetes.
* Automatizar las dependencias de `n8n` y `open-lovable`.
* Traducir alias cortos al paquete real.

## Comandos básicos

**Instalar las dependencias del proyecto:**

```bash
npm install
```

**Instalar un paquete en el proyecto:**

```bash
npm install paquete
```

**Instalar una herramienta global:**

```bash
npm install -g paquete
```

**Instalar varias herramientas globales:**

```bash
npm install -g paquete1 paquete2
```

**Actualizar dependencias:**

```bash
npm update
```

**Actualizar herramientas globales:**

```bash
npm update -g
```

**Desinstalar una herramienta global:**

```bash
npm uninstall -g paquete
```

**Ver las herramientas globales instaladas:**

```bash
npm ls -g --depth=0
```

## Cómo se procesan los argumentos

Antes de llamar a npm, el wrapper separa las **opciones** de los **paquetes**:

* Cualquier opción (`-g`, `--global`, `--save-dev`, `--omit=dev`,
  `--registry=...`, etc.) se pasa intacta a npm.
* El orden ya no importa: `npm install paquete -g` equivale a
  `npm install -g paquete`.
* Varios paquetes se instalan en una sola llamada.
* Las opciones que llevan un valor separado (`--registry URL`, `--omit dev`)
  se conservan completas.
* `npm install` sin paquetes dentro de un proyecto instala sus dependencias.
  Antes el wrapper no hacía nada en ese caso.
* `npm install -g` sin paquete muestra un error de uso, en lugar de intentar
  instalar el directorio actual.

## Alias normalizados

Al instalar, actualizar o desinstalar paquetes, el wrapper traduce estos alias al paquete real:

| Alias usado | Paquete real |
|---|---|
| `gemini-cli` | `@google/gemini-cli` |
| `qwen-code` | `@qwen-code/qwen-code` |
| `claude-code` | `@anthropic-ai/claude-code` |
| `codex` | `@mmmbuto/codex-cli-termux@latest` |
| `copilot-cli` / `github-copilot` | `@github/copilot` |
| `minimax-cli` | `mmx-cli` |
| `testsprite` | `@testsprite/testsprite-mcp` |
| `zcode-cli` | `zcode-app-cli` |
| `openspec` | `@fission-ai/openspec` |
| `sleepwalker` | `@sleepwalkerai/cli` |
| `kimi-code` | `@moonshot-ai/kimi-code` |
| `context7` | `ctx7` |

Ejemplo:

```bash
npm install -g qwen-code
```

se resuelve como:

```bash
npm install -g @qwen-code/qwen-code
```

## Ayudas automáticas de i-HakLab

i-HakLab interviene solo al instalar, actualizar o desinstalar; el resto de
comandos funcionan igual que el npm original.

### Instalación especial de n8n

Al instalar `n8n`, i-HakLab prepara sola todo lo necesario:

1. Dependencias del sistema (Node.js, SQLite).
2. Herramientas auxiliares (gestor de procesos y compilación).
3. Carpetas y archivos de configuración (`~/.n8n`, entorno de compilación).

### Instalación especial de open-lovable

Al instalar o actualizar `open-lovable`, i-Haklab descarga sola la última
versión oficial en `~/.local/share/open-lovable` (borrando la anterior si
existe) y deja sus dependencias listas.

### Instalación especial de pnpm

Al instalar `pnpm`, i-Haklab activa Corepack y configura la importación por
copia, necesaria porque SELinux en Android rechaza los enlaces duros del
almacén de pnpm. npm no sobrescribe el shim de Corepack.

### Testsprite y zcode-cli

Ambos verifican que Node sea 22 o superior y, si hace falta, instalan la
versión LTS antes de continuar.

### Configuración automática

Después de instalar o actualizar paquetes, i-Haklab aplica sola la
configuración que cada herramienta necesite. Si algo quedó a medias,
reinstala el paquete y listo.

## Notas importantes

* Se aceptan los alias nativos `install`/`i`/`add`, `update`/`up`/`upgrade` y
  `uninstall`/`remove`/`rm`/`un`.
* Las opciones desconocidas se pasan a npm sin interpretarlas como paquetes.
* Para diagnosticar el árbol global usa `npm ls -g --depth=0`.
* Si un paquete global requiere scripts de compilación, revisa la salida de
  la instalación y las opciones de `allow-scripts`.

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
