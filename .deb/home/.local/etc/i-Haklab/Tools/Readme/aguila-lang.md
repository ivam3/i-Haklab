# Aguila (emersonxinay/aguila)

## ¿Qué es Aguila?

**Aguila** (paquete `aguila-lang`, comando `aguila`) es un lenguaje de programación moderno que combina la sintaxis sencilla de Python con el rendimiento de Rust. Su propuesta principal es eliminar la barrera del idioma: las palabras clave y la estructura del lenguaje están en español (`si`, `sino`, `mientras`, `funcion`, `retornar`, `imprimir`), y el código se compila a un binario nativo.

## ¿Para qué es útil la herramienta?

*   **Programar en español:** Escribir algoritmos con palabras clave y sintaxis en español sin renunciar a un lenguaje compilado.
*   **Aprender programación:** La sintaxis cercana a Python y el REPL interactivo lo hacen adecuado para practicar lógica, bucles, funciones y estructuras de datos.
*   **Rendimiento nativo:** El código se compila a un ejecutable de máquina (Rust) en lugar de interpretarse, con arranque y ejecución rápidos.
*   **Scripts y automatización:** Ejecutar archivos `.ag` desde la terminal para tareas puntuales o prototipos.
*   **Termux/Android:** En `aarch64` se instala un binario nativo Bionic, sin proot ni capas glibc.

## ¿Cómo se usa? (Ejemplos básicos)

**Instalación:**

```bash
pkg install aguila-lang
aguila --version
```

**Ejemplo 1: Abrir el REPL**

```bash
aguila
```

**Ejemplo 2: Ejecutar un programa**

Crea `programa.ag`:

```aguila
nombre = "Termux"
imprimir "Hola, " + nombre

si 20 >= 18 {
    imprimir "Eres mayor de edad"
} sino {
    imprimir "Eres menor de edad"
}
```

Ejecútalo con:

```bash
aguila ejecutar programa.ag
```

**Ejemplo 3: Funciones, bucles y listas**

```aguila
funcion saludar(nombre) {
    retornar "Hola, " + nombre
}

imprimir saludar("Aguila")

para i = 1 hasta 4 {
    imprimir i
}

frutas = ["Manzana", "Banana"]
frutas.agregar("Uva")
imprimir frutas[2]
```

**Ejemplo 4: Comprobar o compilar sin ejecutar**

```bash
aguila chequear programa.ag
aguila compilar programa.ag
```

## Consideraciones Adicionales

*   **Versión:** el paquete instala `2.4.3`, la versión cuyo código fuente público está disponible en la rama `dev` del repositorio.
*   **Arquitectura:** en `aarch64` descarga un binario nativo ya compilado; en otras arquitecturas, o si la descarga falla, compila el código fuente con Rust (puede tardar unos minutos y requiere `rust`, que se instala solo en ese caso).
*   **Interpolación de cadenas:** la sintaxis `f"..."` que aparece en el README upstream no está disponible en `2.4.3`; usa concatenación con `+`.
*   **Dependencias:** `curl` para la descarga del binario. `rust` solo se instala si hace falta compilar.
*   **Ayuda:** https://t.me/Ivam3_Bot · Issues: https://github.com/emersonxinay/aguila/issues

---
*Nota: Esta herramienta integra el lenguaje Aguila y su ejecución nativa en el ecosistema i-Haklab.*
