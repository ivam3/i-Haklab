# Exif / ExifTool

## ¿Qué son los datos EXIF?

**EXIF** (Exchangeable Image File Format) es un estándar que especifica los formatos de imágenes, sonido y, lo más importante, las **etiquetas de metadatos** utilizadas por las cámaras digitales, los teléfonos y otros dispositivos.

Cuando tomas una foto con tu teléfono o cámara, el dispositivo no solo guarda la imagen en sí, sino que también incrusta una gran cantidad de información adicional dentro del propio archivo de imagen. Estos son los metadatos EXIF.

Los datos EXIF pueden incluir, entre muchas otras cosas:
*   **Coordenadas GPS:** La ubicación geográfica exacta donde se tomó la foto.
*   **Fecha y Hora:** El momento preciso en que se capturó la imagen.
*   **Información del Dispositivo:** La marca y el modelo de la cámara o teléfono (ej. "Apple iPhone 13 Pro").
*   **Parámetros de la Cámara:** Velocidad de obturación, apertura, ISO, si se usó el flash, etc.
*   **Información del Software:** El software que se utilizó para ver o editar la imagen.

## ¿Qué es ExifTool?

En el contexto de la lista de herramientas, cuando se menciona `exif`, casi con toda seguridad se refiere a **ExifTool**.

**ExifTool** es una potente herramienta de línea de comandos, libre y de código abierto, creada por Phil Harvey. Es la herramienta estándar de la industria para **leer, escribir y editar los metadatos** contenidos en una amplia variedad de archivos, no solo imágenes.

Aunque su nombre proviene de EXIF, ExifTool puede manejar muchos otros tipos de metadatos, como XMP, IPTC, y metadatos específicos de formatos de video, audio y documentos (PDF, Office, etc.).

## ¿Para qué es útil la herramienta?

ExifTool es una navaja suiza para cualquiera que necesite trabajar con metadatos.

*   **Inteligencia de Fuentes Abiertas (OSINT) y Forense Digital:**
    *   Es su uso más crítico en seguridad. Un analista puede usar ExifTool para extraer metadatos de imágenes o documentos publicados en internet.
    *   Las coordenadas GPS pueden revelar la ubicación de un sospechoso, la oficina de una empresa o un lugar de interés.
    *   La información del dispositivo y el software puede ayudar a perfilar la tecnología que utiliza una persona u organización.
*   **Fotografía:** Los fotógrafos la usan para organizar sus fotos, verificar los datos de sus cámaras o añadir información de copyright a sus imágenes.
*   **Privacidad:** Puedes usar ExifTool para **eliminar todos los metadatos** de tus fotos antes de subirlas a internet, protegiendo así tu privacidad y evitando compartir accidentalmente tu ubicación u otra información personal.

## ¿Cómo se usa?

ExifTool es una herramienta de línea de comandos.

### Ejemplo 1: Leer todos los metadatos de un archivo

Este es el uso más básico. Simplemente se le pasa el nombre del archivo.

```bash
exiftool mi_imagen.jpg
```

**Salida de ejemplo:**
```
ExifTool Version Number         : 12.40
File Name                       : mi_imagen.jpg
File Size                       : 2.1 MB
Make                            : Apple
Camera Model Name               : iPhone 12
Software                        : 15.1
Date/Time Original              : 2023:10:27 14:30:00
GPS Latitude                    : 40 deg 24' 49.07" N
GPS Longitude                   : 3 deg 42' 9.32" W
GPS Position                    : 40 deg 24' 49.07" N, 3 deg 42' 9.32" W
... y muchas otras etiquetas ...
```

### Ejemplo 2: Extraer solo una etiqueta específica

Si solo te interesan las coordenadas GPS:

```bash
exiftool -gpsposition mi_imagen.jpg
```

### Ejemplo 3: Eliminar todos los metadatos

Para proteger tu privacidad, puedes crear una copia de la imagen sin ningún metadato.

```bash
exiftool -all= mi_imagen.jpg
```
*   `-all=`: Esta sintaxis le dice a ExifTool que elimine el valor de todas las etiquetas.
*   Por defecto, ExifTool no sobrescribe el archivo original. Crea un nuevo archivo (`mi_imagen.jpg_original`) como copia de seguridad y modifica el archivo original.

### Ejemplo 4: Escribir metadatos

También puedes añadir o modificar etiquetas.

```bash
exiftool -Artist="Juan Perez" -Copyright="2023 Juan Perez. Todos los derechos reservados." mi_imagen.jpg
```

## Consideraciones Adicionales

*   **Soporte de Archivos:** ExifTool soporta una cantidad asombrosa de formatos de archivo, lo que la hace increíblemente versátil.
*   **Seguridad:** Ten cuidado al descargar imágenes o documentos de fuentes no confiables. Aunque es raro, se han conocido vulnerabilidades en la forma en que las aplicaciones procesan los metadatos, lo que podría teóricamente ser un vector de ataque.
*   **Legalidad:** La extracción de metadatos de archivos disponibles públicamente es legal. Sin embargo, el uso que se le dé a esa información puede tener implicaciones legales y éticas.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. Sé consciente de los metadatos que compartes en línea.*
