# WPScan

## ¿Qué es WPScan?

WPScan es un **escáner de vulnerabilidades de "caja negra" para WordPress**. Es la herramienta de referencia, escrita en Ruby, para que los administradores de sitios y los profesionales de la seguridad auditen la seguridad de un sitio web basado en WordPress.

Funciona como un atacante, sin necesidad de acceder al código fuente o al panel de administración, para encontrar vulnerabilidades conocidas en:
*   El núcleo de WordPress.
*   Los plugins instalados.
*   Los temas (themes) utilizados.

## ¿Para qué es útil?

Dado que WordPress es el CMS más popular del mundo, también es el más atacado. WPScan es una herramienta esencial para la defensa y el ataque de sitios WordPress.

*   **Detección de Versiones:** Identifica la versión del núcleo de WordPress, así como de todos los plugins y temas que puede encontrar. Esto es crucial, ya que las versiones desactualizadas son una de las principales causas de sitios hackeados.
*   **Enumeración de Vulnerabilidades:** Compara las versiones de software detectadas con una enorme base de datos de vulnerabilidades conocidas y te informa si alguno de los componentes es vulnerable a un exploit público.
*   **Enumeración de Usuarios:** Puede intentar descubrir los nombres de usuario de las cuentas registradas en el sitio, que es el primer paso para un ataque de fuerza bruta.
*   **Ataques de Fuerza Bruta:** Puede lanzar un ataque de diccionario contra los usuarios enumerados para encontrar contraseñas débiles.
*   **Comprobación de Configuraciones Inseguras:** Busca archivos de configuración expuestos (como `wp-config.php`), backups de bases de datos accesibles públicamente, y otros errores de configuración comunes.

## ¿Cómo se usa? (Ejemplos básicos)

WPScan es una herramienta de línea de comandos. Su uso principal gira en torno a la URL del sitio WordPress.

**Ejemplo 1: Escaneo básico de vulnerabilidades**

Este es el comando más común. Escanea el sitio, detecta versiones y busca vulnerabilidades conocidas en el núcleo, plugins y temas.

```bash
wpscan --url http://example-wordpress.com
```

**Ejemplo 2: Escaneo agresivo de plugins**

Este comando realiza una búsqueda más profunda para detectar plugins.

```bash
wpscan --url http://example-wordpress.com --plugins-detection aggressive
```

**Ejemplo 3: Enumerar usuarios**

```bash
wpscan --url http://example-wordpress.com --enumerate u
```
*   `--enumerate u`: Enumera los nombres de usuario.

**Ejemplo 4: Ataque de fuerza bruta**

Este comando intenta adivinar la contraseña para los usuarios encontrados, utilizando una lista de contraseñas.

```bash
wpscan --url http://example-wordpress.com --enumerate u --passwords /ruta/a/mi/diccionario.txt
```
*   `--passwords`: Especifica el archivo de diccionario a utilizar.

## Consideraciones Adicionales

*   **API Key:** Para acceder a la base de datos de vulnerabilidades más actualizada, WPScan requiere una clave de API gratuita de su sitio web (wpscan.com). La herramienta te guiará para obtenerla y configurarla.
*   **Herramienta Defensiva y Ofensiva:** Aunque es una herramienta de ataque, su uso principal y recomendado es **defensivo**: los administradores de sitios deben escanear sus propias webs regularmente para encontrar y corregir fallos antes de que un atacante lo haga.
*   **Legalidad:** El escaneo de un sitio web con WPScan sin el permiso del propietario es ilegal, ya que puede ser considerado un acceso no autorizado.

---
*Nota: Si gestionas un sitio de WordPress, el uso regular de WPScan no es opcional, es una parte fundamental de una buena postura de seguridad.*
