# smali-lsp

## ¿Qué es smali-lsp?

`smali-lsp` es un servidor **Language Server Protocol (LSP)** con servidor **MCP** integrado para **Smali**, el lenguaje bytecode de las aplicaciones Android. Se comunica por `stdio`, sin demonios ni puertos, y se invoca como `java -jar smali-lsp-<version>.jar lsp` o `... mcp`.

Soporta los 41 tipos de instrucciones Dalvik (`invoke-*`, `iget/iput`, `sget/sput`, `new-instance`, `check-cast`, etc.) e indexa proyectos completos de `apktool` con miles de archivos en segundos.

En i-Haklab se distribuye como paquete `smali-lsp` desde el repositorio de la comunidad `demon_hunter (victor028)`, ya configurado en el `postinst`.

## ¿Para qué es útil la herramienta?

`smali-lsp` convierte cualquier editor compatible con LSP y cualquier agente IA con MCP en un entorno de análisis Smali:

*   **Navegación semántica (LSP):** go to definition, find references, hover con firmas y tipos, call hierarchy, type hierarchy, document y workspace symbols, code lens con conteo de referencias, rename y diagnostics.
*   **Análisis con IA (MCP):** 12 herramientas `smali_*` (`smali_index`, `smali_find_definition`, `smali_search_symbols`, `smali_find_references`, `smali_hover`, `smali_call_graph`, `smali_xref_summary`, `smali_search_strings`, entre otras) para indexar, buscar y trazar llamadas en APKs decompilados.
*   **Ingeniería inversa:** complemento ideal tras `apktool d app.apk`, para auditar Smali, rastrear callers de un método o buscar `const-string` sospechosos.
*   **Rendimiento:** indexado paralelo (~3.300 archivos/s), consultas `<1ms` tras indexar y cobertura goto-definition superior al 99%.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado (`pkg install smali-lsp`), localiza el JAR instalado y úsalo según tu editor.

### 1. Iniciar el servidor LSP (stdio)

```bash
java -jar /data/data/com.termux/files/usr/share/java/smali-lsp.jar lsp
```

### 2. Configurar en Neovim (nvim-lspconfig)

```lua
require('lspconfig.configs').smali_lsp = {
  default_config = {
    cmd = { 'java', '-jar', '/data/data/com.termux/files/usr/share/java/smali-lsp.jar', 'lsp' },
    filetypes = { 'smali' },
    root_dir = require('lspconfig.util').root_pattern('AndroidManifest.xml', 'apktool.yml', '.git'),
  },
}
require('lspconfig').smali_lsp.setup {}
```

### 3. Iniciar el servidor MCP para agentes IA

```bash
java -jar /data/data/com.termux/files/usr/share/java/smali-lsp.jar mcp
```

Ejemplo de configuración MCP (`mcp.json`):

```json
{
  "mcpServers": {
    "smali-mcp": {
      "command": "java",
      "args": ["-jar", "/data/data/com.termux/files/usr/share/java/smali-lsp.jar", "mcp"]
    }
  }
}
```

### 4. Flujo típico de análisis

```bash
apktool d mi-app.apk -o mi-app-smali
java -jar /data/data/com.termux/files/usr/share/java/smali-lsp.jar lsp
```

## Consideraciones Adicionales

*   **Dependencia de Java:** requiere `openjdk-21` instalado en Termux.
*   **Detección de proyecto:** detecta automáticamente proyectos `apktool` por `apktool.yml` o `AndroidManifest.xml` como raíz del workspace.
*   **Memoria:** el índice consume ~18 KB por archivo; en APKs muy grandes (>100K archivos) reserva suficiente RAM.
*   **Upstream:** basado en `surendrajat/smali-lsp` (GPL-3.0), empaquetado por `@demonr_rip` para Termux.

---
*Nota: La información proporcionada aquí es para fines educativos y de análisis de seguridad.*
