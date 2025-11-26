
# hashID

## ¿Qué es hashID?

`hashID` es una utilidad de línea de comandos escrita en Python que se utiliza para identificar el tipo de un hash desconocido. En el mundo de la ciberseguridad, a menudo se encuentran cadenas de caracteres que representan hashes de contraseñas u otros datos cifrados, y saber qué algoritmo de hashing se utilizó es el primer paso para intentar crackearlos o analizarlos.

`hashID` analiza la longitud, el formato, los caracteres utilizados y otras características de la cadena de hash proporcionada, comparándolas con su extensa base de datos de más de 300 tipos de hashes conocidos. Esto incluye hashes criptográficos comunes (MD5, SHA-familia), hashes de contraseñas de sistemas operativos (NTLM, formatos Unix), hashes de aplicaciones, y muchos más.

## ¿Para qué es útil la herramienta?

`hashID` es una herramienta esencial para profesionales de la ciberseguridad como pentesters, analistas de malware, investigadores forenses y administradores de sistemas. Sus principales usos son:

-   **Pre-Análisis de Hashes:** Antes de intentar crackear un hash con herramientas como Hashcat o John the Ripper, es fundamental saber qué algoritmo se utilizó. `hashID` proporciona esta información de manera rápida y precisa.
-   **Optimización del Cracking:** Al identificar el tipo de hash, `hashID` puede sugerir el modo de ataque específico para Hashcat o el formato para John the Ripper, lo que ahorra tiempo y recursos.
-   **Análisis Forense:** Ayuda a entender la naturaleza de los datos cifrados o las contraseñas encontradas en volcados de memoria, archivos de configuración o discos.
-   **Educación:** Es una excelente herramienta para aprender sobre los diferentes tipos de hashes y sus características.

## ¿Cómo se usa?

`hashID` es muy fácil de usar desde la línea de comandos.

### 1. Instalación

`hashID` a menudo viene preinstalado en distribuciones de seguridad como Kali Linux. Si no lo está, puedes instalarlo usando `pip`:

```bash
pip install hashid
```

### 2. Ejemplos de Uso Básico

-   **Identificar un hash individual:**
    Simplemente pasa la cadena de hash como un argumento entre comillas.

    ```bash
    hashid "5f4dcc3b5aa765d61d8327deb882cf99"
    ```
    La salida mostrará el tipo de hash identificado (en este caso, MD5) y posibles variaciones.

-   **Identificar hashes de un archivo:**
    Si tienes un archivo de texto (`hashes.txt`) con un hash por línea, puedes pasar el archivo como argumento.

    ```bash
    hashid hashes.txt
    ```

-   **Mostrar el modo Hashcat y el formato John the Ripper:**
    `hashID` puede mostrar directamente la información necesaria para usar el hash con Hashcat o John the Ripper.

    ```bash
    hashid --mode "5f4dcc3b5aa765d61d8327deb882cf99"
    ```
    (Esto añadirá el número de modo `-m` para Hashcat a la salida).

    ```bash
    hashid --john "5f4dcc3b5aa765d61d8327deb882cf99"
    ```
    (Esto mostrará el formato de John the Ripper).

-   **Identificación extendida:**
    La opción `--extended` (o `-e`) muestra todos los tipos de hash posibles, incluyendo aquellos que pueden ser hashes con "salt" (sal) o variaciones.

    ```bash
    hashid --extended "hash_string_here"
    ```

### Ejemplos de Salida Típica

```
~$ hashid "5f4dcc3b5aa765d61d8327deb882cf99"
-- HASH: 5f4dcc3b5aa765d61d8327deb882cf99 --
    Type: MD5
    Category: Hashing
    WIKIPEDIA: https://en.wikipedia.org/wiki/MD5
```

```
~$ hashid "$2a$10$abcdefghijklmnopqrstuuopabcdefghij.k."
-- HASH: $2a$10$abcdefghijklmnopqrstuuopabcdefghij.k. --
    Type: bcrypt
    Category: Password Hash
    WIKIPEDIA: https://en.wikipedia.org/wiki/Bcrypt
```

## Otras Consideraciones

-   **Precisión:** `hashID` es muy preciso, pero en raras ocasiones puede haber ambigüedades si un hash es muy corto o si un algoritmo menos común coincide con las características de otro. La opción `--extended` puede ayudar en estos casos.
-   **No es un Cracker:** Es importante recordar que `hashID` solo identifica el tipo de hash; no lo "crackea" ni recupera la contraseña original. Para eso, necesitarías herramientas como Hashcat o John the Ripper.
