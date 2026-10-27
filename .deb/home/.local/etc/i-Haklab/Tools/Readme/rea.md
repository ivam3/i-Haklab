
# REA (Reverse Engineering Agent)

## ¿Qué es REA?

**REA** es una herramienta de línea de comandos para ingeniería inversa asistida por agentes de IA. En i-Haklab se distribuye como el paquete `rea` 6.8.0-2, que instala `rea-agents` 6.8.0 mediante npm y expone el comando `rea` sobre el runtime de Node.js de Termux.

REA reúne inventario de artefactos, análisis de binarios, aplicaciones Android, JavaScript/Electron y aplicaciones web en un mismo flujo. Cada operación produce **Evidence** verificable, con hashes, rutas, limitaciones y resultados normalizados que pueden consultarse o compararse después.

## ¿Para qué es útil la herramienta?

-   **Análisis de binarios:** inventario ELF/PE/Mach-O, funciones, instrucciones, cadenas, referencias cruzadas y pseudocódigo mediante Ghidra, Rizin o GNU objdump.
-   **Ingeniería inversa de APK:** manifiesto, recursos, firma y relaciones entre componentes sin ejecutar la aplicación.
-   **Análisis de JavaScript y Electron:** reconstrucción estática de aplicaciones locales, bundles web y código ofuscado.
-   **Flujos para agentes:** salida JSON/YAML/Markdown, Evidence reutilizable y servidor MCP para integrar REA con asistentes y automatizaciones.
-   **Análisis nativo en Termux:** REA detecta la instalación de Ghidra 12.1.4 y habilita el descompilador ARM64 sin configuración manual.

## ¿Cómo se usa?

### 1. Instalación

```bash
pkg install rea
```

La primera instalación necesita conexión a internet porque `postinst` descarga `rea-agents` desde npm. Para habilitar el análisis nativo con Ghidra:

```bash
pkg install ghidra
```

La primera instalación de Ghidra descarga la versión oficial 12.1.4 y compila sus componentes nativos ARM64; puede tardar varios minutos.

### 2. Verificar el entorno

```bash
rea --version
rea doctor --json
```

`rea doctor --json` informa los proveedores disponibles y el estado de Ghidra. Puede devolver un código de salida distinto de cero si falta algún proveedor opcional; para revisar solo Ghidra:

```bash
rea doctor --json | jq '.providerInspections[] | select(.id == "ghidra")'
```

### 3. Analizar un binario con Ghidra

```bash
rea analyze /system/bin/toybox --provider ghidra --format json
rea decompile /system/bin/toybox main --provider ghidra --format json
```

El resultado de `analyze` incluye el perfil del proveedor, el número de procedimientos, cadenas y segmentos. `decompile` devuelve pseudocódigo generado por Ghidra, no código fuente original.

### 4. Inspeccionar un APK

```bash
rea inspect-apk-signature app.apk --format json
rea decode-android-resources app.apk --format json
```

`decode-android-resources` decodifica el manifiesto y los recursos con apktool. `inspect-android-package` y las operaciones basadas en JADX requieren un host x64 y quedan bloqueadas en Termux.

### 5. Usar Rizin y GNU objdump

```bash
rea execute-rizin-command archivo.bin iI --format json
rea inspect-with-objdump archivo.bin file_headers --format json
```

El lanzador de REA configura `gobjdump` y aplica un shim de plataforma para que Rizin y objdump funcionen en Termux.

### 6. Integración con agentes

```bash
rea setup
rea providers
rea capabilities
```

`rea setup` configura las integraciones del agente y los proveedores opcionales. La opción `--mcp` inicia REA como servidor MCP por stdio.

## Otras consideraciones

-   **Dependencia de Node.js:** el paquete usa `nodejs-lts` y `npm`; no incluye un runtime Node propio.
-   **Ghidra es opcional:** sin Ghidra, REA puede usar Rizin u objdump para varias operaciones, pero el análisis profundo y el pseudocódigo requieren el proveedor Ghidra.
-   **Detección automática de Ghidra:** el lanzador exporta `GHIDRA_INSTALL_DIR` y `JAVA_HOME` si detecta `~/.local/share/ghidra` y el JDK 21 de Termux. Puedes sobrescribir ambas variables en tu entorno.
-   **Shim de plataforma:** REA recibe `linux` en lugar de `android` para los comandos de Ghidra, Rizin, objdump y diagnóstico. El shim no cambia `process.arch`, por lo que las funciones que exigen x64 siguen bloqueadas.
-   **Limitaciones en Termux:** JADX, pwntools, Wakaru, la inspección EVM, GDB y las descargas de navegadores de Playwright no están disponibles en este entorno. La observación CDP de un Chromium externo sí está soportada.
-   **Actualización:** usa `pkg update && pkg upgrade`. No ejecutes el actualizador interno de REA si el paquete lo desaconseja, porque puede reemplazar el runtime gestionado por Termux.
-   **Datos del usuario:** `pkg uninstall rea` elimina el lanzador y el runtime npm, pero conserva `~/.local/share/rea/hopper`, cachés, estado, capturas, Evidence y el helper `fixer`.
-   **Uso responsable:** utiliza REA únicamente sobre binarios y aplicaciones que tengas autorización para analizar.

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
