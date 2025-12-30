# python

## ¿Qué es python?

Python es un lenguaje de programación interpretado, de alto nivel y propósito general. Su filosofía de diseño enfatiza la legibilidad del código mediante el uso de una indentación significativa. Es uno de los lenguajes más populares del mundo debido a su simplicidad, versatilidad y la enorme comunidad que lo respalda.

## ¿Para qué es útil la herramienta?

En el contexto de administración de sistemas y seguridad, Python es omnipresente:

*   **Scripting y Automatización:** Automatizar tareas repetitivas del sistema de archivos, redes o procesamiento de datos.
*   **Desarrollo de Herramientas de Seguridad:** Una gran parte de las herramientas de pentesting y exploits (como muchas en este repositorio) están escritas en Python.
*   **Ciencia de Datos e IA:** Es el estándar para análisis de datos, aprendizaje automático e inteligencia artificial.
*   **Desarrollo Web:** Frameworks como Django o Flask permiten crear aplicaciones web robustas rápidamente.

## ¿Cómo se usa? (Ejemplos básicos)

Python puede usarse de modo interactivo o ejecutando scripts.

**Ejemplo 1: Modo Interactivo (REPL)**

Simplemente escribe `python` en la terminal para entrar en el intérprete.

```python
>>> print("Hola Mundo")
Hola Mundo
>>> 2 + 2
4
```
Presiona `Ctrl + D` para salir.

**Ejemplo 2: Ejecutar un script**

Si tienes un archivo llamado `script.py`:

```bash
python script.py
```

**Ejemplo 3: Instalar librerías con pip**

Python tiene un gestor de paquetes llamado `pip`.

```bash
pip install requests
```
Esto descarga e instala la librería `requests` desde el Python Package Index (PyPI).

**Ejemplo 4: Servidor web simple**

Python incluye un servidor web básico en su librería estándar, útil para compartir archivos rápidamente.

```bash
python -m http.server 8000
```

## Consideraciones Adicionales

*   **Versiones:** Existe una distinción importante entre Python 2 y Python 3. Python 2 está obsoleto (End of Life desde 2020). Hoy en día, `python` suele referirse a Python 3, pero en sistemas antiguos podrías necesitar escribir `python3`.
*   **Entornos Virtuales:** Para evitar conflictos entre dependencias de distintos proyectos, se recomienda usar entornos virtuales (`python -m venv mi_entorno`).

---
*Nota: Python es a menudo descrito como "baterías incluidas" debido a su completa biblioteca estándar.*
