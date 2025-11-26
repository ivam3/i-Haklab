# speedtest-go

## ¿Qué es speedtest-go?

`speedtest-go` es una implementación en el lenguaje de programación Go de la popular prueba de velocidad de Internet de `speedtest.net`. Es una herramienta de línea de comandos (CLI) que te permite medir el rendimiento de tu conexión a Internet (velocidad de descarga, subida y latencia) directamente desde la terminal, sin necesidad de abrir un navegador web.

Al estar escrita en Go, es un binario único, rápido y eficiente que funciona en múltiples plataformas (Linux, macOS, Windows).

## ¿Para qué es útil?

Esta herramienta es útil para una variedad of tareas, tanto para usuarios domésticos como para administradores de sistemas:

*   **Medición Rápida de Velocidad:** Permite comprobar rápidamente si estás obteniendo la velocidad de Internet por la que pagas.
*   **Diagnóstico de Problemas de Red:** Ayuda a diagnosticar si una conexión a Internet lenta es un problema local o de tu proveedor de servicios.
*   **Scripting y Automatización:** Al ser una herramienta de línea de comandos, se puede integrar fácilmente en scripts. Por ejemplo, puedes programar una prueba de velocidad para que se ejecute cada hora y guarde los resultados en un archivo para monitorizar el rendimiento de tu red a lo largo del tiempo.
*   **Pruebas en Servidores Remotos:** Es ideal para probar la velocidad de conexión de servidores remotos o dispositivos sin interfaz gráfica (como una Raspberry Pi o un servidor en la nube) a los que solo puedes acceder por SSH.

## ¿Cómo se usa? (Ejemplo básico)

El uso de `speedtest-go` es muy sencillo.

**Sintaxis básica para una prueba de velocidad:**

Simplemente ejecuta el comando sin argumentos.

```bash
speedtest-go
```

La herramienta seleccionará automáticamente el servidor más cercano, realizará las pruebas de ping, descarga y subida, y mostrará los resultados en la terminal.

**Ejemplo de salida:**

```
===== Speedtest.net Execution =====

Provider: tu-proveedor-de-internet
Location: Ciudad, País

Ping: 12.345 ms
Jitter: 1.234 ms

Download: 94.56 Mbit/s
Upload: 23.45 Mbit/s
```

### Opciones Adicionales

*   **Listar servidores disponibles:**
    ```bash
    speedtest-go --list
    ```
*   **Usar un servidor específico:**
    Puedes elegir un servidor de la lista anterior y usar su ID para la prueba.
    ```bash
    speedtest-go --server <ID_del_servidor>
    ```
*   **Salida en formato JSON:**
    Esto es muy útil para la automatización y el scripting.
    ```bash
    speedtest-go --json
    ```

## Consideraciones Adicionales

*   **No es una herramienta de hacking:** A diferencia de muchas otras herramientas en esta colección, `speedtest-go` es una utilidad de red puramente para diagnóstico. No tiene aplicaciones ofensivas en el ámbito de la seguridad.
*   **Precisión:** Los resultados pueden variar ligeramente entre diferentes ejecuciones debido a las condiciones de la red en ese momento. Para obtener una imagen precisa, es bueno realizar varias pruebas en diferentes momentos del día.
*   **Consumo de Ancho de Banda:** Ten en cuenta que realizar una prueba de velocidad consumirá una cantidad significativa de tu ancho de banda durante la prueba.

---
*Nota: Esta es una herramienta de diagnóstico de red. Es útil y segura de usar en cualquier entorno.*
