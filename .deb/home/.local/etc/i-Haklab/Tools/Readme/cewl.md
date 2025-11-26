# CeWL (Custom Word List Generator)

## ¿Qué es CeWL?

CeWL (Custom Word List Generator) es una herramienta de línea de comandos escrita en Ruby que genera listas de palabras personalizadas (wordlists) a partir del contenido de un sitio web. Su método consiste en "arañar" (spidering) un sitio web hasta una profundidad determinada, recopilar todas las palabras que encuentra y crear una lista con ellas.

La idea detrás de CeWL es que las personas a menudo usan contraseñas relacionadas con su trabajo, su empresa o sus intereses. Al crear una lista de palabras específica para una organización a partir de su propio sitio web, se aumentan las posibilidades de adivinar contraseñas en un ataque de diccionario dirigido.

## ¿Para qué es útil la herramienta?

CeWL es una herramienta muy utilizada en la fase de reconocimiento y ataque de una prueba de penetración. Sus principales usos son:

*   **Generación de Wordlists para Ataques de Contraseña:** Es su función principal. La lista de palabras generada por CeWL se puede usar directamente con herramientas de cracking de contraseñas como [John the Ripper](johntheripper.md) o [Hashcat](hashcat.md), o en ataques de fuerza bruta con herramientas como [Hydra](hydra-gtk.md) o [Burp Suite Intruder](burpsuite.md).
*   **Recopilación de Nombres de Usuario Potenciales:** CeWL no solo extrae palabras, sino que también puede:
    *   **Extraer direcciones de correo electrónico:** Busca enlaces `mailto:` en el sitio para recopilar posibles nombres de usuario para un ataque.
    *   **Extraer metadatos de autores:** Puede descargar documentos (PDF, DOCX, etc.) del sitio y extraer los nombres de los autores de sus metadatos, que a menudo corresponden a empleados de la empresa.
*   **Inteligencia de Fuentes Abiertas (OSINT):** Ayuda a un analista a entender el lenguaje y la terminología específica que utiliza una organización.

## ¿Cómo se usa? (Ejemplos básicos)

CeWL es una herramienta de línea de comandos con varias opciones para refinar la lista de palabras generada.

**Sintaxis básica:**
```bash
cewl [URL_del_sitio] -w [archivo_de_salida]
```

### Ejemplo 1: Generar una lista de palabras básica

Este comando rastreará `http://example.com` y guardará todas las palabras que encuentre en `wordlist.txt`.

```bash
cewl http://example.com -w wordlist.txt
```

### Ejemplo 2: Especificar la profundidad y la longitud de las palabras

Podemos hacer la lista más específica.

```bash
cewl http://example.com -d 2 -m 8 -w wordlist.txt
```
*   `-d 2`: Le dice a CeWL que siga los enlaces del sitio hasta una profundidad de 2 niveles (página principal -> página enlazada).
*   `-m 8`: Le dice a CeWL que solo incluya palabras con una longitud mínima de 8 caracteres.

### Ejemplo 3: Extraer correos electrónicos

Este comando rastreará el sitio y guardará las direcciones de correo electrónico encontradas en `emails.txt`.

```bash
cewl http://example.com -n -e --email_file emails.txt
```
*   `-n` o `--no-words`: Le dice a CeWL que no genere la lista de palabras, solo que realice otras extracciones.
*   `-e` o `--email`: Habilita la extracción de correos.

### Ejemplo 4: Extraer metadatos de autores

Este comando descargará los archivos ofimáticos, extraerá los metadatos y los añadirá a la lista de palabras.

```bash
cewl http://example.com --meta --meta_file metadatos.txt -w wordlist.txt
```
*   `--meta`: Habilita el análisis de metadatos.
*   `--meta_file`: Guarda los datos de los metadatos en un archivo separado.

## Consideraciones Adicionales

*   **Tráfico de Red:** Ten en cuenta que CeWL genera una cantidad significativa de tráfico web al rastrear un sitio. Si estás realizando una prueba de penetración, esto será visible en los logs del servidor web del cliente.
*   **Calidad de la Wordlist:** La efectividad de la lista de palabras depende en gran medida del contenido del sitio web. Un sitio web con mucho texto (blogs, artículos, documentación) producirá una lista de palabras mucho más rica que un sitio puramente visual.
*   **Preinstalado en Kali Linux:** CeWL es una herramienta estándar y viene preinstalada en distribuciones de seguridad como Kali Linux.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. Solo debes usar CeWL en sitios web para los que tengas permiso explícito de realizar pruebas.*
