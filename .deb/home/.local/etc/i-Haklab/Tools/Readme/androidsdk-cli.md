# Android SDK Command-Line Tools

## ¿Qué son las Android SDK Command-Line Tools?

Las **Herramientas de Línea de Comandos del SDK de Android** son un paquete de utilidades que permiten a los desarrolladores y usuarios avanzados interactuar con y gestionar el entorno de desarrollo de Android directamente desde una terminal o consola. Son una parte fundamental del Android SDK (Software Development Kit), pero pueden ser instaladas y utilizadas de forma independiente, sin necesidad de tener instalado el entorno de desarrollo completo de Android Studio.

Esto las hace ideales para servidores de integración continua, para desarrolladores que prefieren editores de código más ligeros, o para usuarios que solo necesitan acceso a herramientas específicas como ADB o Fastboot.

## ¿Para qué son útiles estas herramientas?

Este conjunto de herramientas es crucial para una gran variedad de tareas relacionadas con el desarrollo y la gestión de aplicaciones y dispositivos Android. La funcionalidad se divide en varias utilidades clave:

*   **`sdkmanager`:** El gestor de paquetes del SDK. Permite listar, instalar, actualizar y desinstalar componentes del SDK como:
    *   **Platform-tools:** Herramientas para interactuar con la plataforma Android, como `adb` y `fastboot`.
    *   **Build-tools:** Herramientas necesarias para compilar y empaquetar una aplicación Android.
    *   **System-images:** Imágenes del sistema operativo Android para usar en el emulador.
    *   **Platforms:** Las diferentes versiones de la API de Android (por ejemplo, Android 12, Android 13).
*   **`avdmanager`:** El gestor de dispositivos virtuales de Android (AVD). Permite crear, eliminar y gestionar emuladores de Android que puedes ejecutar en tu ordenador.
*   **`lint`:** Una herramienta de análisis de código estático que revisa tus proyectos de Android en busca de posibles bugs, optimizaciones, y problemas de usabilidad, seguridad o rendimiento.
*   **`apkanalyzer`:** Permite analizar el contenido de un archivo APK, ayudando a entender su tamaño, la estructura de sus componentes y sus dependencias.

(Nota: Herramientas como `adb` y `fastboot` se distribuyen dentro del paquete `platform-tools`, que se gestiona con `sdkmanager`).

## ¿Cómo se usan? (Ejemplos básicos)

El uso de estas herramientas se realiza enteramente desde la línea de comandos.

### `sdkmanager`

**1. Listar todos los paquetes disponibles:**

```bash
sdkmanager --list
```

**2. Instalar un paquete:**

Por ejemplo, para instalar las platform-tools (que contienen adb y fastboot) y las build-tools para una versión específica:

```bash
sdkmanager "platform-tools" "build-tools;33.0.1"
```

**3. Actualizar todos los paquetes instalados:**

```bash
sdkmanager --update
```

### `avdmanager`

**1. Listar los AVDs existentes:**

```bash
avdmanager list avd
```

**2. Crear un nuevo AVD:**

Para crear un emulador, primero necesitas una imagen del sistema. Usarías `sdkmanager` para instalarla, por ejemplo: `sdkmanager "system-images;android-33;google_apis;x86_64"`.

Luego, puedes crear el AVD:

```bash
avdmanager create avd -n MyPixel6 -k "system-images;android-33;google_apis;x86_64"
```
* `-n` define el nombre del AVD.
* `-k` especifica la imagen del sistema a utilizar.

## Consideraciones Adicionales

*   **JAVA_HOME:** Muchas de estas herramientas requieren que el Kit de Desarrollo de Java (JDK) esté instalado y que la variable de entorno `JAVA_HOME` esté configurada correctamente.
*   **PATH:** Para un uso más cómodo, es highly recomendable añadir los directorios de las herramientas (como `cmdline-tools/latest/bin` y `platform-tools`) a la variable de entorno `PATH` de tu sistema.
*   **Evolución:** Las herramientas de línea de comandos han evolucionado. `sdkmanager` reemplazó al antiguo `android sdk`, y las herramientas `cmdline-tools` son la forma moderna de gestionar el SDK, reemplazando al antiguo paquete "SDK Tools".

---
*Nota: La información proporcionada aquí es para fines educativos. La gestión del SDK es una tarea técnica que requiere comprender los componentes del desarrollo de Android.*
