
# Jython-LTS

## ¿Qué es Jython-LTS?

Jython-LTS (Long Term Support) se refiere a las versiones de Jython que reciben soporte extendido. Actualmente, esto corresponde a la serie **Jython 2.7.x**. Jython es una implementación del lenguaje de programación Python diseñada para ejecutarse en la Máquina Virtual de Java (JVM). Esto significa que permite ejecutar código Python en entornos Java, y lo que es más importante, permite la interoperabilidad bidireccional entre Python y Java.

Con Jython, los programas Python pueden importar y utilizar clases y bibliotecas de Java directamente, y las aplicaciones Java pueden incrustar un intérprete de Jython para ejecutar scripts Python.

## ¿Para qué es útil la herramienta?

Jython-LTS es una herramienta valiosa para desarrolladores, arquitectos de sistemas y profesionales de la seguridad que trabajan en entornos mixtos Java/Python:

-   **Interoperabilidad Java/Python:** Es su principal ventaja. Permite integrar bibliotecas Java existentes en proyectos Python, o utilizar código Python para añadir funcionalidades de scripting a aplicaciones Java.
-   **Acceso al Ecosistema Java:** Desde Jython, puedes acceder a la vasta colección de APIs y frameworks de Java, como Swing para GUIs, JDBC para bases de datos, o bibliotecas de red.
-   **Scripting de Aplicaciones Java:** Los desarrolladores de aplicaciones Java pueden permitir que sus usuarios finales o administradores escriban scripts en Python para extender o personalizar la funcionalidad de la aplicación sin recompilar Java.
-   **Prototipado Rápido:** Utilizar la concisión y la facilidad de uso de Python para desarrollar prototipos rápidamente que se ejecutan en la JVM.
-   **Sistemas Legacy:** Es particularmente útil para mantener y extender sistemas que aún dependen de Python 2.7 y necesitan integración con Java, dado que la versión actual de Jython-LTS está basada en Python 2.7.

## ¿Cómo se usa?

El uso de Jython implica tener un entorno Java configurado y luego ejecutar scripts o el intérprete de Jython.

### 1. Requisitos Previos

-   **JDK (Java Development Kit):** Necesitas tener una versión de JDK (Java 8 o superior) instalada y la variable de entorno `JAVA_HOME` configurada correctamente.

### 2. Instalación

1.  **Descargar:** Descarga el instalador de Jython (un archivo `.jar`) desde el sitio web oficial de Jython (jython.org). Busca la última versión de la serie 2.7.x.
2.  **Instalar:** Ejecuta el instalador JAR desde la terminal:
    ```bash
    java -jar jython-installer-2.7.x.jar
    ```
    Sigue el asistente de instalación. Se recomienda una instalación "Standard".
3.  **Configurar PATH (Opcional):** Para facilitar el uso, añade el directorio `bin` de Jython a la variable de entorno `PATH` de tu sistema.

### 3. Ejemplos de Uso

1.  **Ejecutar el Intérprete Interactivo:**
    Abre una terminal y escribe `jython`. Esto te dará una shell interactiva donde puedes ejecutar comandos Python y acceder a clases de Java.

    ```bash
    jython
    ```
    ```python
    >>> from java.lang import System
    >>> System.out.println("¡Hola desde Jython!")
    ¡Hola desde Jython!
    >>>
    ```

2.  **Ejecutar un Script Python con Jython:**
    Puedes ejecutar cualquier script Python (con sintaxis Python 2.7) utilizando el intérprete de Jython.

    `mi_script.py`:
    ```python
    from java.util import Date

    print "La fecha y hora actuales en Java son:", Date()
    ```
    Desde la terminal:
    ```bash
    jython mi_script.py
    ```

3.  **Importar Clases Java en Python:**
    Dentro de tu script Python, puedes importar cualquier clase Java como si fuera un módulo Python.

    ```python
    # mi_app_jython.py
    from javax.swing import JFrame, JLabel
    from java.awt import FlowLayout

    frame = JFrame("Ventana Jython", defaultCloseOperation = JFrame.EXIT_ON_CLOSE)
    frame.setLayout(FlowLayout())
    frame.add(JLabel("¡Hola desde una GUI Java creada con Jython!"))
    frame.pack()
    frame.setVisible(True)
    ```
    Ejecuta: `jython mi_app_jython.py`

4.  **Incrustar Jython en una Aplicación Java:**
    Los desarrolladores de Java pueden integrar Jython en sus aplicaciones para permitir la ejecución de scripts.

    ```java
    // JavaApplication.java
    import org.python.util.PythonInterpreter;
    import org.python.core.*;

    public class JavaApplication {
        public static void main(String[] args) throws PyException {
            PythonInterpreter interpreter = new PythonInterpreter();
            interpreter.exec("print '¡Hola desde un script Jython incrustado!'");
            interpreter.execfile("mi_script.py"); // Ejecuta un script Python
        }
    }
    ```
    Para compilar y ejecutar esto, necesitarías las librerías de Jython en el classpath de tu proyecto Java.

## Otras Consideraciones

-   **Compatibilidad Python 2.7:** Es importante recordar que Jython-LTS (la serie 2.7.x) es compatible con Python 2.7. Esto significa que no soporta la sintaxis ni las características de Python 3.
-   **Extensiones C:** Jython no puede ejecutar módulos de Python escritos en C (como NumPy o algunas partes de SciPy). Está limitado a código Python puro y a la interoperabilidad con Java.
-   **Rendimiento:** Aunque Jython compila código Python a bytecode de Java, el rendimiento puede variar y no siempre es igual al de CPython (el intérprete estándar de Python) o al de Java nativo.
