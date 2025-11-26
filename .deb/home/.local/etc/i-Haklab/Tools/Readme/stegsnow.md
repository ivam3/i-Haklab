# Stegsnow

## ¿Qué es Stegsnow?

Stegsnow es una herramienta de esteganografía especializada en ocultar datos dentro de **archivos de texto ASCII**. Su nombre es un juego de palabras con "steganography" (esteganografía) y "snow" (nieve), una referencia a cómo los espacios en blanco pueden parecer "ruido" o "nieve" sin sentido en los datos.

A diferencia de `steghide` (que funciona con imágenes y audio), Stegsnow modifica los archivos de texto añadiendo **espacios en blanco y tabulaciones** al final de las líneas. Dado que estos caracteres son invisibles en la mayoría de los editores y visores de texto, el mensaje oculto pasa completamente desapercibido.

## ¿Para qué es útil?

Stegsnow se utiliza para la comunicación encubierta a través de medios de texto.

*   **Ocultar mensajes en texto plano:** Permite ocultar un mensaje secreto en un archivo de texto de apariencia normal (un correo electrónico, un artículo, código fuente, etc.).
*   **CTFs (Capture The Flag):** Es una herramienta clásica en los desafíos de esteganografía de los CTF, donde los participantes deben detectar y extraer información oculta en archivos de texto.
*   **Comunicaciones de bajo ancho de banda:** Dado que solo añade espacios en blanco, el aumento del tamaño del archivo es a menudo insignificante.
*   **Cifrado Opcional:** Stegsnow también puede cifrar los datos (usando el algoritmo ICE) antes de ocultarlos, proporcionando una segunda capa de seguridad. Si alguien detecta y extrae los datos, todavía necesitará la contraseña para descifrarlos.

## ¿Cómo se usa? (Ejemplos básicos)

Stegsnow se opera desde la línea de comandos.

### 1. Ocultar un mensaje

Este comando ocultará un mensaje en un archivo de texto.

**Sintaxis:**
```bash
stegsnow -C -m "Mi mensaje secreto" -p "mi_contraseña" archivo_original.txt archivo_con_secreto.txt
```

*   `-C`: Comprime el mensaje antes de ocultarlo.
*   `-m "Mi mensaje secreto"`: El mensaje que quieres ocultar. También puedes usar `-f` para especificar un archivo que contenga el mensaje.
*   `-p "mi_contraseña"`: La contraseña para cifrar el mensaje.
*   `archivo_original.txt`: El archivo de texto que servirá como "portada".
*   `archivo_con_secreto.txt`: El nuevo archivo que se creará, conteniendo el texto original más el mensaje oculto.

### 2. Extraer un mensaje

Este comando extrae el mensaje oculto de un archivo.

**Sintaxis:**
```bash
stegsnow -C -p "mi_contraseña" archivo_con_secreto.txt
```

*   `-C`: Es importante recordar si comprimiste el mensaje al ocultarlo, ya que necesitas especificarlo también al extraerlo.
*   `-p "mi_contraseña"`: La contraseña que usaste para cifrar.

Stegsnow imprimirá el mensaje oculto directamente en la salida estándar (la terminal).

## Consideraciones Adicionales

*   **Límites de Espacio:** La cantidad de datos que puedes ocultar es directamente proporcional al número de líneas en el archivo de texto de portada. Stegsnow necesita añadir espacios al final de las líneas, por lo que un archivo con más líneas puede contener más datos.
*   **Formato del Texto:** Stegsnow está diseñado para archivos de texto plano ASCII. No funcionará correctamente con formatos de texto enriquecido como `.docx` o `.rtf`.
*   **Detección:** Aunque los espacios en blanco son invisibles, un análisis cuidadoso del archivo (por ejemplo, seleccionando todo el texto en un editor o usando un visor hexadecimal) revelará su presencia. La fuerza de Stegsnow radica en que la mayoría de la gente no inspecciona los archivos de texto a ese nivel.

---
*Nota: Stegsnow es una herramienta clásica y efectiva para la esteganografía en texto, pero como toda herramienta de este tipo, su seguridad no es absoluta.*
