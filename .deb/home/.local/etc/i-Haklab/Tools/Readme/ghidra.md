
# Ghidra

## ¿Qué es Ghidra?

Ghidra es un framework de ingeniería inversa (SRE) de software, desarrollado por la Agencia de Seguridad Nacional (NSA) de Estados Unidos y liberado como código abierto en 2019. Está escrito en Java y proporciona un conjunto completo de herramientas de análisis de software de alta gama que permiten a los analistas investigar y descompilar código ejecutable en múltiples plataformas.

Una de sus características más aclamadas es su **descompilador**, que puede convertir código máquina (binario) en una representación de alto nivel similar al código fuente en C, facilitando enormemente la comprensión de la lógica de un programa.

## ¿Para qué es útil la herramienta?

Ghidra es una herramienta indispensable para una variedad de tareas complejas en el campo de la ciberseguridad y el desarrollo de software:

-   **Análisis de Malware:** Permite a los investigadores de seguridad desensamblar y descompilar software malicioso para entender su comportamiento, identificar sus capacidades (ej. keylogging, ransomware) y crear firmas para su detección.
-   **Investigación de Vulnerabilidades:** Ayuda a los analistas a encontrar fallos de seguridad en el software sin necesidad de tener acceso al código fuente.
-   **Ingeniería Inversa:** Se utiliza para entender el funcionamiento interno de cualquier programa o firmware, ya sea para interoperabilidad, documentación o análisis de la competencia.
-   **Validación de Compiladores:** Permite verificar cómo el código fuente se traduce en código máquina.

## ¿Cómo se usa?

Ghidra es una aplicación de escritorio con una interfaz gráfica. El flujo de trabajo básico es el siguiente:

1.  **Instalación:**
    -   Asegúrate de tener un Kit de Desarrollo de Java (JDK) de 64 bits instalado (versión 11 o superior).
    -   Descarga Ghidra desde su [sitio web oficial](https://ghidra-sre.org/).
    -   Descomprime el archivo `.zip` en un directorio de tu elección.
    -   Ejecuta `ghidraRun.bat` (en Windows) o `ghidraRun` (en Linux/macOS).

2.  **Crear un Proyecto:**
    -   Al iniciar, ve a `File` -> `New Project`.
    -   Selecciona "Non-Shared Project" para un proyecto local y asígnale un nombre y una ubicación.

3.  **Importar y Analizar un Binario:**
    -   Arrastra el archivo ejecutable que deseas analizar (por ejemplo, un `.exe` o un `.elf`) a la ventana del proyecto o usa `File` -> `Import File`.
    -   Ghidra detectará automáticamente la arquitectura y formato del archivo. Confirma la importación.
    -   Haz doble clic en el archivo importado para abrirlo en la herramienta principal, el "CodeBrowser".
    -   Ghidra te preguntará si deseas analizar el archivo. Acepta (`Yes`) y en la siguiente ventana, haz clic en `Analyze` dejando las opciones por defecto. Ghidra comenzará a desensamblar el código, identificar funciones, etc.

4.  **Navegación y Análisis:**
    -   **Ventana de Listado (Listing):** Muestra el código desensamblado (assembler).
    -   **Ventana del Descompilador (Decompiler):** Muestra el código C de alto nivel generado a partir del ensamblador. Esta es una de las ventanas más útiles.
    -   **Árbol de Símbolos (Symbol Tree):** Aquí puedes navegar por las funciones, etiquetas y namespaces identificados. Una buena práctica es buscar la función `main` para empezar el análisis.
    -   **Cadenas Definidas (Defined Strings):** En `Window` -> `Defined Strings` puedes ver todas las cadenas de texto hardcodeadas en el binario, lo que a menudo revela información crucial sobre su funcionalidad (URLs, nombres de archivo, mensajes de error, etc.).

## Otras consideraciones

-   **Requisitos del sistema:** Ghidra puede consumir una cantidad significativa de RAM, especialmente con binarios grandes. Se recomienda tener al menos 4 GB de RAM, pero 8 GB o más es ideal.
-   **Scripting:** Ghidra soporta scripting en Java y Python (a través de Jython) para automatizar tareas repetitivas de análisis.
-   **Depurador:** A partir de versiones recientes, Ghidra incluye un depurador que permite el análisis dinámico del código, es decir, ejecutar el programa paso a paso y observar su comportamiento en tiempo real.
