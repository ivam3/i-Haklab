
# Ghidra

## ¿Qué es Ghidra?

Ghidra es un framework de ingeniería inversa (SRE) de software, desarrollado por la Agencia de Seguridad Nacional (NSA) de Estados Unidos y liberado como código abierto en 2019. Está escrito en Java y proporciona un conjunto completo de herramientas de análisis de software de alta gama que permiten a los analistas investigar y descompilar código ejecutable en múltiples plataformas.

Una de sus características más aclamadas es su **descompilador**, que puede convertir código máquina (binario) en una representación de alto nivel similar al código fuente en C, facilitando enormemente la comprensión de la lógica de un programa.

En i-Haklab se distribuye como el paquete `ghidra` 12.1.4-1, con los componentes nativos compilados para `linux_arm_64` en Termux.

## ¿Para qué es útil la herramienta?

Ghidra es una herramienta indispensable para una variedad de tareas complejas en el campo de la ciberseguridad y el desarrollo de software:

-   **Análisis de Malware:** Permite a los investigadores de seguridad desensamblar y descompilar software malicioso para entender su comportamiento, identificar sus capacidades (ej. keylogging, ransomware) y crear firmas para su detección.
-   **Investigación de Vulnerabilidades:** Ayuda a los analistas a encontrar fallos de seguridad en el software sin necesidad de tener acceso al código fuente.
-   **Ingeniería Inversa:** Se utiliza para entender el funcionamiento interno de cualquier programa o firmware, ya sea para interoperabilidad, documentación o análisis de la competencia.
-   **Validación de Compiladores:** Permite verificar cómo el código fuente se traduce en código máquina.
-   **Análisis nativo en Termux:** El descompilador ARM64 permite analizar binarios Android y ELF directamente desde el dispositivo.

## ¿Cómo se usa?

Ghidra incluye una aplicación de escritorio y herramientas headless. En Termux se ejecuta con Java 21 y los componentes nativos compilados para `linux_arm_64`.

### 1. Instalación en Termux

```bash
pkg install ghidra
```

La primera instalación descarga la versión oficial 12.1.4, verifica su SHA-256 y compila el descompilador y `sleigh` con el NDK de Android. Puede tardar varios minutos y necesita espacio libre para el archivo, la compilación y la instalación anterior. Las dependencias (JDK 21, Gradle, NDK, clang, etc.) se instalan automáticamente.

### 2. Iniciar la interfaz gráfica

```bash
ghidra
```

El lanzador exporta `GHIDRA_INSTALL_DIR` y arranca `ghidraRun` desde `~/.local/share/ghidra`.

### 3. Crear un proyecto

1.  Al iniciar, ve a `File` -> `New Project`.
2.  Selecciona "Non-Shared Project" para un proyecto local y asígnale un nombre y una ubicación.

### 4. Importar y analizar un binario

1.  Arrastra el archivo ejecutable que deseas analizar (por ejemplo, un `.exe` o un `.elf`) a la ventana del proyecto o usa `File` -> `Import File`.
2.  Ghidra detectará automáticamente la arquitectura y el formato del archivo. Confirma la importación.
3.  Haz doble clic en el archivo importado para abrirlo en el "CodeBrowser".
4.  Acepta el análisis automático (`Yes`) y haz clic en `Analyze` dejando las opciones por defecto.

### 5. Navegación y análisis

-   **Ventana de Listado (Listing):** Muestra el código desensamblado (assembler).
-   **Ventana del Descompilador (Decompiler):** Muestra el código C de alto nivel generado a partir del ensamblador.
-   **Árbol de Símbolos (Symbol Tree):** Permite navegar por funciones, etiquetas y namespaces. Busca la función `main` para empezar.
-   **Cadenas Definidas (Defined Strings):** En `Window` -> `Defined Strings` puedes ver las cadenas de texto incluidas en el binario.

### 6. Uso headless

Para automatizar análisis sin interfaz gráfica:

```bash
export GHIDRA_INSTALL_DIR="$HOME/.local/share/ghidra"
"$GHIDRA_INSTALL_DIR/support/analyzeHeadless" --help
```

### 7. Integración con REA

El paquete `rea` detecta Ghidra automáticamente y aplica el shim de plataforma necesario en Termux:

```bash
pkg install rea
rea doctor --json
rea analyze /system/bin/toybox --provider ghidra --format json
rea decompile /system/bin/toybox main --provider ghidra --format json
```

No necesitas exportar `GHIDRA_INSTALL_DIR` ni `JAVA_HOME` manualmente si ambos paquetes están instalados.

## Otras consideraciones

-   **Requisitos del sistema:** Ghidra 12.1.4 requiere JDK 21. Puede consumir una cantidad significativa de RAM, especialmente con binarios grandes. Se recomienda tener al menos 4 GB de RAM, pero 8 GB o más es ideal.
-   **Compilación nativa:** La primera instalación compila los componentes de `linux_arm_64`. Si la compilación falla, la instalación anterior se conserva y se muestra la ruta de la compilación en staging.
-   **Copias de seguridad:** En una actualización, la instalación anterior se guarda en `~/.local/share/ghidra.backup-<timestamp>` hasta que la nueva compilación finaliza correctamente. Puedes eliminarla después de verificar el funcionamiento con `rm -rf ~/.local/share/ghidra.backup-*`.
-   **Scripting:** Ghidra soporta scripting en Java y Python (a través de Jython) para automatizar tareas repetitivas de análisis.
-   **Depurador:** Ghidra incluye un depurador que permite el análisis dinámico del código, ejecutar el programa paso a paso y observar su comportamiento en tiempo real.
-   **Actualización:** usa `pkg update && pkg upgrade` para actualizar el paquete. No reemplaces manualmente los archivos de `~/.local/share/ghidra`.

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
