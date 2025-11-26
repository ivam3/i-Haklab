# Translate Shell

## ¿Qué es Translate Shell?

Translate Shell (anteriormente conocido como Google Translate CLI) es una potente utilidad de línea de comandos que te permite traducir texto directamente desde tu terminal. Utiliza motores de traducción como Google Translate (por defecto), Bing Translator y Yandex.Translate.

Es la herramienta perfecta para obtener traducciones rápidas sin tener que abandonar la línea de comandos y abrir un navegador web.

## ¿Para qué es útil?

Translate Shell es una herramienta de productividad muy versátil:

*   **Traducciones Rápidas:** Permite traducir palabras o frases sobre la marcha mientras trabajas en la terminal.
*   **Ayuda para Programadores:** Puedes usarlo para traducir mensajes de error, comentarios en código o documentación que estén en otro idioma.
*   **Aprendizaje de Idiomas:** Incluye un modo diccionario y puede reproducir el audio de la traducción, lo que lo hace útil para aprender la pronunciación.
*   **Scripting:** Se puede integrar en scripts para automatizar tareas de traducción.
*   **Shell Interactivo:** Ofrece un "shell" de traducción donde puedes escribir y obtener traducciones línea por línea, ideal para conversaciones o para traducir textos largos de forma interactiva.

## ¿Cómo se usa? (Ejemplos básicos)

El comando principal es `trans`.

**Ejemplo 1: Traducción simple (auto-detecta el idioma de origen)**

Por defecto, traduce al inglés.

```bash
trans "Hola, mundo"
```

**Salida:**
```
Hello, world
```

**Ejemplo 2: Traducir a un idioma específico**

Usa el formato `:codigo_idioma` para especificar el destino.

```bash
trans :es "Hello, world"
```

**Salida:**
```
Hola, mundo
```

**Ejemplo 3: Traducir desde y hacia idiomas específicos**

Usa el formato `origen:destino`.

```bash
trans fr:es "Bonjour, monde"
```

**Salida:**
```
Hola, mundo
```

**Ejemplo 4: Modo breve**

Para obtener solo la traducción, sin información adicional, usa la opción `-b`.

```bash
trans -b :es "Hello, world"
```

**Salida:**
```
Hola, mundo
```

**Ejemplo 5: Iniciar el shell interactivo**

Simplemente ejecuta `trans` sin texto a traducir.

```bash
trans
```
Se abrirá un prompt donde podrás escribir texto para ser traducido al instante.

## Consideraciones Adicionales

*   **No es una herramienta de hacking:** Es una utilidad de productividad. No tiene aplicaciones ofensivas en ciberseguridad.
*   **Dependencia de Servicios Externos:** Su funcionamiento depende de los motores de traducción en línea. Si estos servicios cambian su API o bloquean el acceso, la herramienta puede dejar de funcionar.
*   **Límites de Uso:** El uso excesivo puede llevar a que los servicios de traducción bloqueen temporalmente tu dirección IP.

---
*Nota: Translate Shell es una herramienta increíblemente útil para cualquiera que trabaje en un entorno multilingüe desde la línea de comandos.*
