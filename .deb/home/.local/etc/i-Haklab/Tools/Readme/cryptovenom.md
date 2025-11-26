# CryptoVenom

## ¿Qué es CryptoVenom?

CryptoVenom es una herramienta de código abierto escrita en Python, diseñada como una suite de utilidades para **criptografía y criptoanálisis**. Su objetivo es proporcionar una colección de herramientas en un solo lugar para trabajar con diferentes algoritmos de cifrado, codificación, hashing y análisis.

Es una herramienta especialmente útil para entusiastas de la seguridad, estudiantes y, sobre todo, para jugadores de competiciones **CTF (Capture The Flag)**, donde los retos criptográficos son muy comunes.

## ¿Para qué es útil la herramienta?

CryptoVenom agrupa una amplia variedad de funciones que son útiles en el análisis de datos cifrados o codificados, permitiendo al usuario:

*   **Cifrar y Descifrar:** Implementa cifrados clásicos (como César, Vigenère, Atbash) y cifrados modernos.
*   **Codificar y Decodificar:** Incluye codificadores comunes como Base64, Hexadecimal, Binario, etc.
*   **Calcular Hashes:** Permite generar hashes de texto o archivos usando algoritmos populares como MD5, SHA-1, SHA-256, etc.
*   **Realizar Criptoanálisis:** Proporciona herramientas para ayudar a romper o analizar ciertos tipos de cifrados, como análisis de frecuencia para cifrados de sustitución simple.
*   **Funciones Matemáticas:** Incluye funciones matemáticas que son fundamentales en criptografía, como operaciones con números primos, máximo común divisor, etc.
*   **Operaciones Lógicas:** Realiza operaciones a nivel de bits como XOR, AND, OR, que son muy comunes en los algoritmos de cifrado.

Básicamente, es una caja de herramientas que evita que un jugador de CTF tenga que buscar o escribir scripts individuales para cada pequeña tarea criptográfica que encuentre en un reto.

## ¿Cómo se usa? (Ejemplo conceptual)

CryptoVenom funciona como un shell interactivo en la línea de comandos. El usuario inicia la herramienta y luego utiliza comandos específicos para acceder a las diferentes categorías y funciones.

**Flujo de trabajo conceptual:**

1.  **Iniciar la herramienta:**
    ```bash
    python CryptoVenom.py
    ```

2.  **Navegar por los menús:**
    La herramienta presentaría un menú principal con categorías como:
    *   `1. Cifrados Clásicos`
    *   `2. Hashes`
    *   `3. Codificadores`
    *   `4. Criptoanálisis`
    *   `...`

3.  **Seleccionar una herramienta:**
    El usuario seleccionaría una categoría, por ejemplo, `Cifrados Clásicos`, y luego se le presentaría otro menú con cifrados específicos:
    *   `1. Cifrado César`
    *   `2. Cifrado de Vigenère`
    *   `3. Cifrado Atbash`

4.  **Proporcionar la entrada:**
    Una vez seleccionada la herramienta (por ejemplo, `Cifrado César`), el programa pediría al usuario el texto a cifrar/descifrar y la clave (el desplazamiento).

    ```
    Introduce el texto: "Hola Mundo"
    Introduce el desplazamiento: 3
    ```

5.  **Obtener el resultado:**
    La herramienta realizaría la operación y mostraría el resultado.
    ```
    Texto cifrado: "Krod Pxqgr"
    ```

## Consideraciones Adicionales

*   **Público Objetivo:** Está claramente enfocada en el ámbito educativo y de los CTF. No es una herramienta diseñada para implementar criptografía robusta en sistemas de producción. Para eso, se deben usar librerías criptográficas estándar y auditadas.
*   **Entorno:** Según su documentación, es una herramienta diseñada principalmente para sistemas Linux, como Kali Linux o Parrot OS.
*   **Alternativa a CyberChef:** Funcionalmente, cumple un rol similar al de la popular aplicación web [CyberChef](https://gchq.github.io/CyberChef/), pero directamente en la terminal, lo que puede ser más rápido o conveniente en algunos escenarios.

---
*Nota: La información proporcionada aquí es para fines educativos y de resolución de retos de seguridad. No utilices las implementaciones de esta herramienta para asegurar datos sensibles en el mundo real.*
