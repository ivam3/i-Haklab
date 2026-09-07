# spin

## ¿Qué es spin?

`spin` es una herramienta de línea de comandos escrita en C++ que muestra un **spinner animado** mientras se ejecuta un proceso en segundo plano. Sirve para indicar visualmente que una tarea sigue en curso, especialmente cuando tarda varios segundos o minutos.

Además del binario CLI, puede usarse como módulo de Python y como librería de C++. Incluye manual integrado (`man spin`) y estilos y colores predefinidos.

En i-Haklab se distribuye como paquete `spin` desde el repositorio de la comunidad `demon_hunter (victor028)`, listo para usar tras instalar.

## ¿Para qué es útil la herramienta?

`spin` mejora la experiencia de scripts largos y automatizaciones en Termux:

*   **Feedback visual:** muestra animación con texto personalizable mientras corre un comando.
*   **Ejecución paralela:** acepta múltiples comandos separados por coma en `--cmd`.
*   **Pipes:** puede envolver cualquier salida (`echo "hola" | spin -t "Procesando..."`).
*   **Scripts y programación:** reutilizable desde Bash, Python (`spinners.Spinner`) y C++ (`#include "spinners.hpp"`).
*   **Personalización:** intervalo, estilo de símbolos, color, mensajes de éxito y error.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado (`pkg install spin`), consulta la ayuda con:

```bash
spin --help
man spin
```

### 1. Mostrar un spinner con texto personalizado

```bash
spin -t "Cargando..." --cmd "sleep 3"
```

### 2. Cambiar color y ver estilos disponibles

```bash
spin -c 105 -t "Instalando..." --cmd "sleep 5"
spin --show_style
spin --show_colors
```

### 3. Ejecutar varios comandos en paralelo

```bash
spin -c 230 --cmd "sleep 10, sleep 15, sleep 20"
```

### 4. Usar en un script Bash

```bash
_pkgs=("nmap" "git" "python")
spin -t "Instalando paquetes..." --cmd 'for p in "${_pkgs[@]}"; do pkg install -y $p; done'
```

## Consideraciones Adicionales

*   **Intervalo:** ajusta la velocidad de animación con `-i` en milisegundos (por ejemplo `-i 100`).
*   **Modo silencioso:** usa `-q` para suprimir la salida del comando envuelto.
*   **Mensajes finales:** personaliza el resultado con `--result`, `--success="Listo"` y `--error="Falló"`.
*   **Dependencias:** requiere `git`, `clang`, `make`, `libc++` y `libiconv`, instaladas automáticamente como dependencias del paquete.

---
*Nota: La información proporcionada aquí es para fines educativos y de automatización en terminal.*
