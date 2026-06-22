# pnpm

## ¿Qué es pnpm?

**pnpm** es un gestor de paquetes para Node.js que destaca por su **eficiencia en el uso de espacio en disco** y su velocidad en comparación con npm o yarn.

Utiliza enlaces simbólicos para evitar duplicación de dependencias.

En **i-HakLab**, `pnpm` cuenta con un wrapper instalado en:

```bash
~/.local/bin/pnpm
```

Este wrapper conserva la compatibilidad con el binario real de Termux (`$PREFIX/bin/pnpm`), pero añade automatizaciones para herramientas Node.js usadas dentro de la suite.

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

## Automatizaciones del wrapper i-HakLab

El wrapper interviene en:

```bash
pnpm install ...
pnpm update ...
pnpm uninstall ...
```

Para el resto de comandos delega directamente al pnpm real:

```bash
$PREFIX/bin/pnpm "$@"
```

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

Cuando el paquete solicitado es `n8n`, el wrapper prepara el entorno de Termux:

1. Instala dependencias del sistema:

```bash
apt install nodejs-lts libsqlite sqlite
```

2. Instala paquetes globales auxiliares con pnpm:

```bash
pnpm install -g pm2 gyp node-gyp
```

3. Crea directorios de configuración:

```bash
mkdir -p ~/.n8n ~/.gyp
```

4. Genera:

```bash
~/.gyp/include.gypi
```

5. Ejecuta aprobación de builds globales:

```bash
pnpm approve-builds -g
```

## Instalación especial de open-lovable

Para `open-lovable`, el wrapper:

1. Elimina una instalación previa en `~/.local/share/open-lovable` si existe.
2. Clona el repositorio oficial en esa ruta.
3. Habilita `corepack`.
4. Ejecuta el comando `pnpm install` o `pnpm update` desde el directorio clonado.

## Configuración posterior con pkg2conf

Después de instalar o actualizar paquetes, el wrapper revisa:

```bash
~/.local/etc/i-Haklab/Tools/listofpkg2conf
```

Si la herramienta requiere configuración adicional, ejecuta:

```bash
bash ~/.local/libexec/pkg2conf nombre-del-paquete
```

## Notas importantes

* `pnpm add -g paquete` es la forma recomendada por pnpm para añadir herramientas globales.
* El wrapper de i-HakLab acepta flujos con `install`/`update` para mantener compatibilidad con scripts existentes.
* Si un paquete global requiere scripts de compilación, revisa la salida de `pnpm approve-builds`.
