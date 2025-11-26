
# Hashcat

## ¿Qué es Hashcat?

Hashcat es la utilidad de recuperación de contraseñas más rápida y avanzada del mundo, de código abierto y multiplataforma. Es una herramienta potente que se utiliza para "crackear" hashes de contraseñas. En lugar de almacenar contraseñas en texto plano, los sistemas de seguridad suelen guardar un "hash" de la contraseña, que es una representación alfanumérica única. Hashcat intenta revertir este proceso, descubriendo la contraseña original que produjo un hash dado.

Se distingue por su capacidad de aprovechar el procesamiento paralelo de las unidades de procesamiento gráfico (GPU), lo que le permite realizar ataques a velocidades increíblemente altas, superando con creces a las soluciones basadas únicamente en CPU.

## ¿Para qué es útil la herramienta?

Hashcat es una herramienta esencial para profesionales de la ciberseguridad, pentesters, auditores de seguridad y administradores de sistemas. Sus principales usos son:

-   **Auditoría de Seguridad:** Probar la fuerza de las contraseñas utilizadas en sistemas y redes para identificar debilidades antes de que sean explotadas por atacantes.
-   **Pruebas de Penetración:** Recuperar contraseñas cifradas para demostrar el impacto de una vulnerabilidad.
-   **Recuperación de Contraseñas:** Ayudar a los usuarios a recuperar contraseñas que han olvidado, siempre que se tenga acceso a sus hashes.
-   **Análisis Forense Digital:** En algunos casos, puede ayudar en la investigación de incidentes para acceder a datos protegidos con contraseña.

## ¿Cómo se usa?

Hashcat se opera a través de la línea de comandos y es altamente configurable. Requiere que se le especifique el tipo de ataque, el algoritmo de hash y los archivos que contienen los hashes y las palabras/máscaras a probar.

### 1. Instalación

Hashcat no requiere instalación en el sentido tradicional. Simplemente se descarga y se ejecuta.

1.  **Descargar:** Visita el sitio web oficial de Hashcat ([hashcat.net](https://hashcat.net/hashcat/)) y descarga la última versión estable para tu sistema operativo (Windows, Linux, macOS).
2.  **Descomprimir:** Extrae el contenido del archivo ZIP/TAR.GZ en una carpeta de tu elección.
3.  **Drivers (Linux/Windows):** Asegúrate de tener los drivers actualizados de tu tarjeta gráfica (NVIDIA CUDA, AMD OpenCL) para aprovechar la aceleración por GPU.

### 2. Sintaxis y Modos de Ataque

La sintaxis básica de Hashcat es:

```bash
hashcat -a <modo_ataque> -m <tipo_hash> <archivo_hashes> <diccionario_o_mascara>
```

-   `-a <modo_ataque>`: Especifica el tipo de ataque.
    -   `0`: Ataque de diccionario
    -   `1`: Combinador (dictionary + dictionary)
    -   `3`: Ataque de fuerza bruta (brute-force)
    -   `6`: Ataque híbrido (wordlist + mask)
    -   `7`: Ataque híbrido (mask + wordlist)
-   `-m <tipo_hash>`: Especifica el algoritmo de hashing. Hashcat tiene un ID numérico para cada tipo (ej. `0` para MD5, `1000` para NTLM, `18200` para AS-REP Roasting, `13100` para Kerberoasting, etc.). Puedes ver una lista completa con `hashcat --help`.
-   `<archivo_hashes>`: Ruta al archivo de texto que contiene los hashes a crackear (un hash por línea).
-   `<diccionario_o_mascara>`: Ruta a un archivo de diccionario (wordlist) o una máscara para ataques de fuerza bruta.

### 3. Ejemplos de Uso

1.  **Ataque de diccionario contra hashes MD5:**
    ```bash
    hashcat -a 0 -m 0 hashes.txt /usr/share/wordlists/rockyou.txt
    ```
    (Intenta crackear los hashes MD5 en `hashes.txt` usando las palabras del diccionario `rockyou.txt`).

2.  **Ataque de fuerza bruta contra hashes NTLM (contraseñas de 7 caracteres alfanuméricos):**
    ```bash
    hashcat -a 3 -m 1000 hashes_ntlm.txt ?l?d?u?s?l?d?u
    ```
    (Aquí, `?l` = minúsculas, `?d` = dígitos, `?u` = mayúsculas, `?s` = caracteres especiales).

3.  **Crackear un hash de Kerberoasting (`hashcat -m 13100`):**
    ```bash
    hashcat -m 13100 hashes_kerberoasting.txt /usr/share/wordlists/rockyou.txt
    ```

### 4. Otras Opciones Útiles

-   `--show`: Muestra las contraseñas crackeadas al final.
-   `--outfile <archivo>`: Guarda las contraseñas crackeadas en un archivo.
-   `--session <nombre_sesion>`: Permite guardar y reanudar una sesión de crackeo.
-   `--status`: Muestra información de estado durante el proceso (velocidad, tiempo estimado).
-   `--potfile-disable`: Deshabilita el uso del potfile (donde Hashcat guarda los hashes ya crackeados).

## Consideraciones Éticas y Legales

Hashcat es una herramienta extremadamente potente. Su uso debe ser siempre **ético y legal**. Nunca debe utilizarse para acceder a sistemas o datos sin autorización explícita. El uso indebido puede tener graves consecuencias legales. Únicamente úsalo en contextos autorizados, como pruebas de seguridad o en tus propios sistemas.
