# Steghide

## ¿Qué es Steghide?

Steghide es una herramienta de **esteganografía** de línea de comandos. La esteganografía es el arte y la ciencia de ocultar un mensaje, archivo o información dentro de otro mensaje, archivo o medio. Steghide permite incrustar datos secretos en ciertos tipos de archivos de imagen y audio, de manera que la existencia del mensaje secreto sea indetectable a simple vista.

A diferencia de la criptografía (que cifra un mensaje haciéndolo ilegible), la esteganografía oculta el hecho mismo de que se está enviando un mensaje.

## ¿Para qué es útil?

Steghide se utiliza para ocultar información a plena vista. Sus principales aplicaciones son:

*   **Comunicaciones Secretas:** Permite enviar información sensible (por ejemplo, un documento de texto) oculta dentro de una imagen de apariencia inocente. Si alguien intercepta la imagen, no sabrá que contiene datos ocultos.
*   **Marcas de Agua Digitales:** Se puede usar para incrustar información de copyright o propiedad dentro de un archivo de imagen o audio para demostrar su autoría.
*   **Desafíos de Ciberseguridad (CTF):** Es una herramienta muy popular en las competiciones de "Capture The Flag", donde los participantes deben encontrar mensajes ocultos en los archivos proporcionados.
*   **Seguridad por capas:** A menudo se combina con la criptografía. Steghide puede ocultar un archivo que ya ha sido previamente cifrado, añadiendo una capa extra de seguridad.

Steghide soporta formatos de archivo como JPEG, BMP para imágenes, y WAV y AU para audio.

## ¿Cómo se usa? (Ejemplos básicos)

Steghide funciona con subcomandos para realizar las dos operaciones principales: incrustar (`embed`) y extraer (`extract`).

### 1. Incrustar un archivo secreto

Este comando ocultará un archivo `secreto.txt` dentro de una imagen `portada.jpg`.

**Sintaxis:**
```bash
steghide embed -cf [archivo_portada] -ef [archivo_secreto]
```

**Ejemplo:**
```bash
steghide embed -cf portada.jpg -ef secreto.txt
```

Al ejecutar este comando, Steghide te pedirá una **frase de contraseña (passphrase)**. Esta contraseña es necesaria para proteger los datos y será requerida para extraerlos más tarde. ¡No la olvides!

### 2. Extraer un archivo secreto

Este comando extrae los datos ocultos de un archivo `portada.jpg`.

**Sintaxis:**
```bash
steghide extract -sf [archivo_con_secreto]
```

**Ejemplo:**
```bash
steghide extract -sf portada.jpg
```
Steghide te pedirá la frase de contraseña que usaste para incrustar los datos. Si es correcta, extraerá el archivo secreto (`secreto.txt` en este caso) en el directorio actual.

### 3. Ver información sobre un archivo

Puedes usar el comando `info` para comprobar si un archivo contiene datos ocultos (aunque no te los mostrará sin la contraseña).

```bash
steghide info portada.jpg
```
Esto te dirá si hay datos incrustados, su tamaño y el algoritmo de cifrado utilizado.

## Consideraciones Adicionales

*   **Capacidad:** No puedes ocultar un archivo de 10 MB en una imagen de 100 KB. La cantidad de datos que puedes ocultar depende del tamaño y la compresión del archivo de portada. Steghide te informará si el archivo secreto es demasiado grande.
*   **Contraseña:** La seguridad de tus datos ocultos depende de la fortaleza de tu contraseña. Sin la contraseña, es computacionalmente muy difícil extraer la información.
*   **No es infalible contra el análisis forense:** Aunque es invisible para el ojo humano, las herramientas avanzadas de análisis esteganográfico pueden detectar anomalías estadísticas en un archivo que sugieran la presencia de datos ocultos.

---
*Nota: La esteganografía es una técnica poderosa. Asegúrate de utilizarla de manera ética y legal.*
