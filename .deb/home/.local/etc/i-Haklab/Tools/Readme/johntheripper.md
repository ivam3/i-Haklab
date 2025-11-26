
# John the Ripper

## ¿Qué es John the Ripper (JtR)?

John the Ripper, a menudo abreviado como JtR, es una herramienta de código abierto muy popular y potente para la recuperación de contraseñas. Su propósito principal es detectar contraseñas débiles en sistemas y aplicaciones mediante la descifrado de hashes de contraseñas. JtR es un software multiplataforma, disponible para una amplia gama de sistemas operativos, incluyendo Linux, Windows y macOS.

Es conocido por su capacidad de trabajar con numerosos formatos de hash, desde hashes de sistemas Unix (DES, MD5, Blowfish) y Windows (NTLM), hasta hashes de aplicaciones y bases de datos.

## ¿Para qué es útil la herramienta?

JtR es una herramienta esencial para auditores de seguridad, pentesters, administradores de sistemas y cualquier persona que necesite evaluar la robustez de las contraseñas. Sus usos principales incluyen:

-   **Auditorías de Contraseñas:** Identificar contraseñas débiles en un sistema para que puedan ser fortalecidas antes de que un atacante las explote.
-   **Pruebas de Penetración:** En un entorno autorizado, JtR se utiliza para demostrar cómo las contraseñas débiles pueden comprometer la seguridad de un sistema.
-   **Recuperación de Contraseñas Olvidadas:** Ayudar a los usuarios a recuperar el acceso a sus cuentas si han perdido sus contraseñas, siempre que se tenga acceso a los hashes correspondientes.
-   **Análisis Forense Digital:** En algunos casos, puede ayudar a descifrar contraseñas de archivos cifrados o usuarios de sistemas comprometidos durante una investigación de incidentes.

## ¿Cómo se usa?

JtR opera principalmente mediante ataques de diccionario y de fuerza bruta, aunque también soporta otros modos. Para usarlo, necesitas tener los hashes de las contraseñas que quieres crackear.

### 1. Instalación

En muchas distribuciones de Linux orientadas a la seguridad (como Kali Linux), JtR viene preinstalado. Si no, puedes instalarlo fácilmente:

```bash
sudo apt-get install john
```
También puedes descargarlo y compilarlo desde el sitio web oficial o el repositorio de GitHub si necesitas la última versión o una configuración específica.

### 2. Uso Básico

La sintaxis básica para JtR es:

```bash
john [opciones] <archivo_de_hashes>
```

-   `<archivo_de_hashes>`: Es un archivo de texto donde cada línea contiene un hash de contraseña a intentar crackear.

### 3. Modos de Ataque Comunes

1.  **Ataque de Diccionario (Wordlist Attack):**
    Este es el ataque más común y efectivo, ya que la mayoría de las contraseñas son palabras o combinaciones simples. Necesitas una "wordlist" (lista de palabras) que contenga contraseñas comunes.

    ```bash
    john --wordlist=/usr/share/wordlists/rockyou.txt hashes.txt
    ```
    -   `--wordlist`: Especifica la ruta al archivo del diccionario.
    -   `hashes.txt`: El archivo que contiene los hashes a crackear.

2.  **Ataque de Fuerza Bruta (Single Crack Mode / Incremental Mode):**
    JtR puede intentar todas las combinaciones posibles de caracteres. Esto es mucho más lento, pero puede ser efectivo para contraseñas cortas y simples.

    ```bash
    john --incremental hashes.txt
    ```
    -   `--incremental`: Indica a JtR que use el modo de fuerza bruta (incremental), probando combinaciones de caracteres.

3.  **Especificar el Formato del Hash:**
    A veces, JtR no detecta automáticamente el tipo de hash. Puedes especificarlo con la opción `--format`. Por ejemplo, para hashes NTLM:

    ```bash
    john --format=NT hashes_ntlm.txt
    ```
    Puedes ver una lista de formatos soportados con `john --list=formats`.

### 4. Mostrar Contraseñas Crackeadas

Una vez que JtR ha terminado de ejecutarse y ha encontrado algunas contraseñas, puedes ver los resultados:

```bash
john --show hashes.txt
```

### 5. Herramientas Auxiliares

JtR a menudo viene con herramientas auxiliares para extraer hashes de diferentes fuentes:

-   `unshadow`: Combina `/etc/passwd` y `/etc/shadow` para crear un archivo de hashes compatible con JtR.
-   `zip2john`: Extrae hashes de archivos ZIP protegidos con contraseña.
-   `rar2john`: Extrae hashes de archivos RAR protegidos con contraseña.

### Ejemplo de Flujo de Trabajo (Linux)

1.  **Extraer hashes de contraseñas de usuario (ej. de un sistema Linux):**
    ```bash
    sudo unshadow /etc/passwd /etc/shadow > my_linux_hashes.txt
    ```

2.  **Crackear los hashes usando un diccionario:**
    ```bash
    john --wordlist=/usr/share/wordlists/rockyou.txt my_linux_hashes.txt
    ```

3.  **Mostrar las contraseñas encontradas:**
    ```bash
    john --show my_linux_hashes.txt
    ```

## Otras Consideraciones

-   **Ética y Legalidad:** John the Ripper es una herramienta potente y debe usarse **siempre de manera ética y legal**. Solo úsala en sistemas para los que tengas autorización explícita para realizar pruebas de seguridad. El uso no autorizado es ilegal y puede tener graves consecuencias.
-   **Recursos:** El crackeo de contraseñas es una tarea que consume muchos recursos de CPU. Prepárate para que tu sistema funcione lentamente mientras JtR está en marcha.
-   **Diccionarios:** La efectividad del ataque de diccionario depende en gran medida de la calidad y el tamaño de la wordlist.
