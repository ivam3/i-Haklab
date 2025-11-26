
# Radare2 (r2)

## ¿Qué es Radare2 (r2)?

Radare2, a menudo abreviado como `r2`, es un completo framework de código abierto para la ingeniería inversa y el análisis de binarios. Es una herramienta potente y multiplataforma que consolida una amplia gama de funcionalidades en una única suite, lo que la hace indispensable para tareas como el análisis de malware, la auditoría de seguridad, la explotación de vulnerabilidades y la depuración a bajo nivel.

`r2` es más que un simple desensamblador; funciona como una navaja suiza para el análisis de código máquina, soportando numerosas arquitecturas de CPU y formatos de archivo.

## ¿Para qué es útil la herramienta?

Radare2 es una herramienta esencial para ingenieros inversos, analistas de seguridad, desarrolladores y cualquier persona que necesite comprender el funcionamiento interno de programas sin acceso al código fuente. Sus principales utilidades son:

-   **Ingeniería Inversa de Software:** Desensamblar y analizar binarios para comprender su lógica, funcionalidad y estructura.
-   **Análisis de Malware:** Investigar el comportamiento de virus, gusanos, troyanos y otro software malicioso.
-   **Análisis de Vulnerabilidades:** Identificar fallos de seguridad en código compilado, como desbordamientos de búfer, errores de formato de cadena, etc.
-   **Desarrollo de Exploits:** Asistir en la creación de exploits, buscando gadgets ROP (Return-Oriented Programming) y analizando las mitigaciones de seguridad.
-   **Depuración:** Depurar programas a bajo nivel, establecer puntos de interrupción, inspeccionar y modificar la memoria y los registros.
-   **Análisis Forense:** Extraer información de archivos ejecutables, firmware o volcados de memoria para investigaciones forenses.
-   **Parcheo de Binarios:** Modificar directamente el código o los datos dentro de un binario.

## ¿Cómo se usa?

Radare2 se utiliza principalmente a través de su interfaz de línea de comandos, que es extremadamente flexible pero tiene una curva de aprendizaje pronunciada debido a su extensa cantidad de comandos.

### 1. Instalación

En distribuciones de Linux, `radare2` a menudo está disponible en los repositorios:

```bash
sudo apt install radare2 # En sistemas basados en Debian/Ubuntu
```

### 2. Abrir un Binario

Para abrir un archivo ejecutable (binario) para análisis:

```bash
r2 <ruta/al/archivo_binario>
```
Para abrirlo en modo de escritura (para parchear):
```bash
r2 -w <ruta/al/archivo_binario>
```
Para abrirlo en modo depurador:
```bash
r2 -d <ruta/al/archivo_binario>
```

### 3. Comandos Básicos y Flujo de Trabajo

Una vez que abres un binario, estarás en el prompt de `r2` (generalmente `[0x00000000]>`).

1.  **Analizar el Binario:**
    El primer paso suele ser analizar el binario para que `r2` identifique funciones, cadenas, referencias, etc.

    ```
    aaa   # Análisis automático (funciones, cadenas, etc.)
    ```
    Si estás en modo depurador, usa `aaaa` para un análisis más profundo.

2.  **Modo Visual:**
    Para una vista más interactiva, presiona `V` (mayúscula) para entrar en el modo visual. Una vez dentro, puedes alternar entre diferentes vistas (desensamblador, hexdump, depurador, gráfico de flujo de control) presionando `p` (minúscula).

    ```
    V
    ```

3.  **Navegación:**
    -   `s <dirección_o_función>`: "Seek" o ir a una dirección específica (ej. `s main`, `s 0x400500`).
    -   `s <nombre_función>`: Ir al inicio de una función.
    -   `s-`: Volver a la posición anterior.

4.  **Desensamblado y Pseudo-código:**
    -   `pd <n>`: Desensamblar `n` bytes o instrucciones desde la posición actual.
    -   `pdf`: Desensamblar la función actual.
    -   `s main; pde`: Descompilar la función `main` a pseudo-código (esto requiere el descompilador de `r2`).

5.  **Depuración (si abres con `r2 -d`):**
    -   `db <dirección>`: Establecer un punto de interrupción.
    -   `dbf <nombre_función>`: Establecer un punto de interrupción en una función.
    -   `dc`: Continuar la ejecución hasta el siguiente punto de interrupción.
    -   `ds`: "Step into" (ejecutar una instrucción y entrar en una llamada a función).
    -   `dso`: "Step over" (ejecutar una instrucción sin entrar en llamadas a función).
    -   `dr`: Mostrar registros.

6.  **Editar Binarios (si abres con `r2 -w`):**
    -   `s <dirección>`: Navega a la dirección que quieres editar.
    -   `wa <instrucción_assembler>`: Ensambla la instrucción y la escribe en la dirección actual.
    -   `wx <bytes_hex>`: Escribe bytes hexadecimales directamente.

7.  **Salir:**
    -   `q`: Salir de `r2`.

### 4. Nmap Scripting Engine (NSE)

Para ejecutar scripts NSE:
```bash
nmap -sC example.com   # Ejecuta scripts por defecto
nmap --script http-enum example.com # Ejecuta un script específico
```

## Otras Consideraciones

-   **Curva de Aprendizaje:** Radare2 es una herramienta extremadamente potente y flexible, pero tiene una curva de aprendizaje considerable debido a su amplia funcionalidad y su interfaz basada en comandos.
-   **Integración:** Se puede integrar con otras herramientas y es extensible mediante plugins y scripts.
-   **Modo Gráfico:** También existe una interfaz gráfica llamada Iaito, aunque la potencia de `r2` reside en su CLI.
