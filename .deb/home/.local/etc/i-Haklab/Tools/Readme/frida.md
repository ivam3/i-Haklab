# Frida

## ¿Qué es Frida?

Frida es un **framework de instrumentación de código dinámico**. Dicho de una forma más simple, es una herramienta que te permite inyectar tus propios scripts (escritos en JavaScript) dentro de aplicaciones que se están ejecutando en tiempo real en un sistema. Esto te da el poder de "engancharte" (hook) a cualquier función de una aplicación, observar y modificar sus argumentos, cambiar su lógica, llamar a funciones por tu cuenta, y mucho más.

Es una de las herramientas más potentes y versátiles para la ingeniería inversa, el análisis de seguridad y la depuración de aplicaciones, especialmente en plataformas móviles (Android e iOS) pero también en aplicaciones de escritorio (Windows, macOS, Linux).

## ¿Para qué es útil la herramienta?

Frida es como un bisturí para un cirujano de software. Permite a los desarrolladores y analistas de seguridad diseccionar una aplicación en vivo.

*   **Análisis de Seguridad y Pruebas de Penetración:**
    *   **Burlar el "SSL Pinning":** Es uno de sus usos más comunes. Permite interceptar el tráfico HTTPS de aplicaciones que normalmente no se puede ver con un proxy como [Burp Suite](burpsuite.md), al desactivar en tiempo real la lógica de la app que verifica el certificado del servidor.
    *   **Omitir Detección de Root/Jailbreak:** Permite engañar a una aplicación para que piense que no se está ejecutando en un dispositivo rooteado o con jailbreak.
    *   **Manipular la Lógica de la App:** Puedes forzar a que una función que comprueba si un usuario es "premium" siempre devuelva `true`, desbloqueando así funciones de pago con fines de análisis.
    *   **Extraer Claves y Secretos:** Puedes "engancharte" a funciones criptográficas para ver las claves y los datos en texto plano antes de que sean cifrados o después de ser descifrados.

*   **Ingeniería Inversa y Análisis de Malware:**
    *   Permite a los analistas observar el comportamiento de una aplicación maliciosa en un entorno controlado, viendo a qué archivos accede, qué datos envía por la red, etc.

*   **Depuración Avanzada:** Los desarrolladores pueden usar Frida para depurar problemas complejos en sus propias aplicaciones o para entender cómo interactúan las librerías de terceros.

## ¿Cómo funciona?

Frida tiene una arquitectura cliente-servidor:

1.  **El Servidor Frida (`frida-server`):** Es un pequeño demonio que se ejecuta en el dispositivo objetivo (por ejemplo, un teléfono Android, un iPhone o un ordenador). Este servidor es el que tiene la capacidad de inyectar código en los procesos en ejecución.
2.  **La Herramienta Cliente (en tu ordenador):** Es la herramienta de línea de comandos de Frida (como `frida`, `frida-trace`) o tus propios scripts de Python que se ejecutan en tu máquina de desarrollo.
3.  **El Agente (JavaScript):** El cliente envía un agente, escrito en JavaScript, al servidor. El servidor lo inyecta en el proceso de la aplicación objetivo. Este script de JavaScript es el que realiza toda la magia: busca funciones en memoria, se engancha a ellas, y se comunica de vuelta con el cliente.

**Flujo de trabajo típico:**
1.  Ejecutar `frida-server` en el dispositivo objetivo (ej. un teléfono Android).
2.  Conectar el teléfono al ordenador vía USB.
3.  Desde el ordenador, ejecutar un comando de Frida para inyectar un script en una aplicación específica (por ejemplo, `com.example.app`).
    ```bash
    frida -U -f com.example.app -l mi_script.js
    ```
4.  El `mi_script.js` ahora se ejecuta dentro de la aplicación, dándote control sobre ella.

## ¿Cómo se usa? (Ejemplo conceptual de un script)

El poder de Frida reside en sus scripts.

**`bypass_login.js` (Ejemplo conceptual para omitir una pantalla de login):**

```javascript
// Envolver el código en Java.perform para asegurarnos de que se ejecuta
// en el contexto de la máquina virtual de Java de Android.
Java.perform(function() {
    // Buscar la clase que maneja el login
    const LoginActivity = Java.use('com.example.app.LoginActivity');

    // Encontrar la función que comprueba las credenciales, por ejemplo, 'checkCredentials'
    // que recibe un username y un password, y devuelve true o false.
    LoginActivity.checkCredentials.implementation = function(username, password) {
        console.log('La función checkCredentials fue llamada con: ' + username + ', ' + password);

        // En lugar de dejar que la función original se ejecute,
        // la forzamos a que siempre devuelva 'true'.
        console.log('¡Omitiendo la comprobación! Devolviendo "true"...');
        return true;
    };
});
```

Al inyectar este script, cada vez que la aplicación intente verificar un nombre de usuario y contraseña, nuestro código se ejecutará en su lugar y le dirá a la aplicación que las credenciales son siempre correctas.

## Consideraciones Adicionales

*   **Curva de Aprendizaje:** Frida es extremadamente potente, pero requiere conocimientos de programación (especialmente JavaScript) y una comprensión de cómo funcionan las aplicaciones a bajo nivel (conceptos de memoria, clases, métodos, etc.).
*   **Requisitos:** Para aplicaciones móviles, generalmente requiere que el dispositivo esté "rooteado" (Android) o tenga "jailbreak" (iOS) para poder inyectarse en cualquier proceso.
*   **Herramientas Complementarias:** A menudo se usa junto con otras herramientas, como `objection` (que proporciona un shell sobre Frida para realizar tareas comunes sin tener que escribir scripts) y `r2frida` (que integra Frida con el framework de ingeniería inversa Radare2).

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad. La manipulación de aplicaciones de esta manera debe realizarse únicamente con fines legales y éticos.*
