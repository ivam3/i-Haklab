
# OpenJDK 21

## ¿Qué es OpenJDK 21?

OpenJDK 21 es la implementación de código abierto y gratuita de la Plataforma Java, Edición Estándar (Java SE) versión 21. Representa la última versión de Soporte a Largo Plazo (LTS), lo que significa que recibirá actualizaciones y soporte durante un período extendido, haciéndola ideal para proyectos de producción que requieren estabilidad y mantenimiento a largo plazo.

OpenJDK 21 incluye el **JDK (Java Development Kit)**, que contiene todas las herramientas necesarias para desarrollar y compilar aplicaciones Java (como `javac`), y el **JRE (Java Runtime Environment)**, que incluye la Máquina Virtual de Java (JVM) para ejecutar aplicaciones Java (`java`).

## ¿Para qué es útil la herramienta?

OpenJDK 21 es un componente fundamental para desarrolladores, administradores de sistemas y usuarios finales que trabajan con aplicaciones Java. Su utilidad abarca una amplia gama de escenarios:

-   **Desarrollo de Aplicaciones:** Es el entorno principal para escribir, compilar, depurar y probar aplicaciones Java de todo tipo (escritorio, web, móviles, empresariales, microservicios, etc.).
-   **Ejecución de Aplicaciones:** Permite ejecutar cualquier aplicación Java compilada. Muchas aplicaciones y servicios empresariales, herramientas de desarrollo (IDEs como IntelliJ IDEA, Eclipse) y plataformas (Apache Tomcat, Apache Kafka) dependen de Java.
-   **Compatibilidad:** Al ser una versión LTS, proporciona una base estable para proyectos críticos que requieren compatibilidad a largo plazo y un mantenimiento predecible.
-   **Acceso a Nuevas Características:** Incorpora las últimas características y mejoras del lenguaje Java (como clases e interfaces selladas, API de funciones y memoria externas, mejoras en la concurrencia, etc.), permitiendo a los desarrolladores escribir código más moderno, eficiente y robusto.

## ¿Cómo se usa?

El uso de OpenJDK 21 implica su instalación, la configuración de variables de entorno y el uso de los comandos `javac` (para compilar) y `java` (para ejecutar).

### 1. Instalación

La instalación varía ligeramente según el sistema operativo.

-   **En sistemas basados en Debian/Ubuntu (ej. Kali Linux):**
    ```bash
    sudo apt update
    sudo apt install openjdk-21-jdk # Instala el JDK completo
    # Si solo necesitas el JRE para ejecutar aplicaciones:
    # sudo apt install openjdk-21-jre
    ```

-   **En RHEL/CentOS/Fedora:**
    ```bash
    sudo dnf install java-21-openjdk-devel # Instala el JDK
    ```

-   **En macOS (usando Homebrew):**
    ```bash
    brew install openjdk@21
    # Para vincularlo como la versión por defecto:
    # sudo ln -sfn /usr/local/opt/openjdk@21/libexec/openjdk.jdk /Library/Java/JavaVirtualMachines/openjdk-21.jdk
    ```

-   **En Windows:**
    Descarga el instalador binario (ej. un archivo `.zip` o `.msi`) desde el sitio web de OpenJDK o de un distribuidor de confianza (ej. Adoptium, Oracle). Descomprime e instala.

### 2. Verificación de la Instalación

Después de la instalación, verifica que Java esté correctamente configurado:

```bash
java -version
javac -version # Para verificar el JDK
```
Deberías ver una salida que indique la versión "21".

### 3. Configuración de Variables de Entorno (si es necesario)

A menudo, es necesario configurar las variables de entorno `JAVA_HOME` y `PATH`.

-   **`JAVA_HOME`:** Apunta al directorio raíz de tu instalación de OpenJDK 21.
    ```bash
    export JAVA_HOME="/usr/lib/jvm/java-21-openjdk-amd64" # Ejemplo en Linux
    ```

-   **`PATH`:** Asegúrate de que el directorio `bin` de tu instalación de Java esté en el PATH.
    ```bash
    export PATH="$JAVA_HOME/bin:$PATH"
    ```
    Estas líneas se suelen añadir a tu archivo de configuración de shell (ej. `~/.bashrc`, `~/.zshrc`).

### 4. Compilar y Ejecutar Aplicaciones Java

1.  **Escribe tu código Java:**
    Crea un archivo llamado `HelloWorld.java`:
    ```java
    public class HelloWorld {
        public static void main(String[] args) {
            System.out.println("¡Hola desde OpenJDK 21!");
        }
    }
    ```

2.  **Compila el código fuente:**
    Usa el compilador `javac` para convertir el código Java en bytecode.
    ```bash
    javac HelloWorld.java
    ```
    Esto creará un archivo `HelloWorld.class`.

3.  **Ejecuta la aplicación:**
    Usa el comando `java` para ejecutar el bytecode.
    ```bash
    java HelloWorld
    ```
    La salida será: `¡Hola desde OpenJDK 21!`

### 5. Gestión de Múltiples Versiones de Java

Si tienes varias versiones de Java instaladas, puedes usar herramientas como `update-alternatives` en Linux para cambiar la versión predeterminada:

```bash
sudo update-alternatives --config java
sudo update-alternatives --config javac
```

## Otras Consideraciones

-   **Soporte a Largo Plazo (LTS):** OpenJDK 21 es una versión LTS, lo que significa que es adecuada para proyectos de producción que requieren estabilidad y actualizaciones de seguridad durante varios años.
-   **Licencia:** OpenJDK es de código abierto bajo la licencia GPLv2 con Classpath Exception, lo que permite su uso libre y su distribución en software propietario.
-   **Ecosistema:** Java es uno de los ecosistemas de desarrollo más grandes y maduros, con una vasta cantidad de frameworks, bibliotecas y herramientas.
