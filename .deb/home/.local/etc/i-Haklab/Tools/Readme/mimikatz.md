
# Mimikatz

## ¿Qué es Mimikatz?

Mimikatz es una herramienta de código abierto desarrollada por Benjamin Delpy, originalmente como una prueba de concepto para demostrar vulnerabilidades en los protocolos de autenticación de Microsoft Windows. Es una utilidad extremadamente potente para Windows (x32/x64) que permite extraer contraseñas en texto claro, hashes de contraseñas, PINs y tickets Kerberos de la memoria del sistema.

Su función principal es acceder a los secretos de seguridad almacenados en la memoria del proceso `lsass.exe` (Local Security Authority Subsystem Service) de Windows.

## ¿Para qué es útil la herramienta?

Mimikatz es una herramienta de "doble filo", ampliamente utilizada tanto por atacantes maliciosos como por profesionales de la seguridad para evaluar y mejorar las defensas.

**Usos Legítimos (por pentesters, Blue Teams, investigadores):**

-   **Auditorías de Seguridad:** Para evaluar la seguridad de un entorno Windows y detectar configuraciones débiles o vulnerabilidades en la gestión de credenciales.
-   **Pruebas de Penetración:** Demostrar cómo un atacante podría escalar privilegios o moverse lateralmente dentro de una red si logra comprometer una máquina Windows.
-   **Análisis Forense:** En ciertos escenarios de respuesta a incidentes, puede ayudar a entender qué credenciales han sido expuestas en un sistema comprometido.
-   **Educación:** Enseñar sobre los riesgos asociados con el almacenamiento de credenciales en memoria y las técnicas de ataque que los explotan.

**Usos Maliciosos (por atacantes):**

-   **Robo de Credenciales:** Obtener acceso a contraseñas y hashes para usarlos en ataques de Pass-the-Hash (PtH), Pass-the-Ticket (PtT) o para escalar privilegios.
-   **Movimiento Lateral:** Una vez que se ha comprometido una máquina, Mimikatz se utiliza para obtener credenciales de otros usuarios conectados a esa máquina y usarlas para acceder a otros sistemas en la red.
-   **Persistencia:** Crear "Golden Tickets" (tickets Kerberos falsificados) para mantener acceso de administrador de dominio indefinido.

## ¿Cómo se usa?

Mimikatz es una herramienta de línea de comandos. Requiere privilegios elevados para funcionar correctamente.

### 1. Obtener Mimikatz

Puedes descargar Mimikatz desde el repositorio oficial de GitHub de Benjamin Delpy. Es importante usar la versión correcta (x32 o x64) para el sistema operativo objetivo.

### 2. Ejecución y Privilegios

1.  **Ejecutar como Administrador:** Abre un símbolo del sistema (CMD) o PowerShell como administrador.
2.  **Cargar Mimikatz:** Navega a la carpeta donde descomprimiste Mimikatz y ejecuta el binario.

    ```cmd
    C:\mimikatz> mimikatz.exe
    ```
    Esto te dará la consola interactiva de Mimikatz.

3.  **Elevar Privilegios:** Dentro de la consola de Mimikatz, el primer comando que se suele ejecutar es para obtener los privilegios necesarios para interactuar con `lsass.exe`.

    ```
    mimikatz # privilege::debug
    ```
    Si el comando es exitoso, verás un mensaje como `Privilege '20' OK`.

### 3. Extracción de Credenciales (Comandos Clave)

-   **Volcar Credenciales del `lsass.exe`:**
    Este es el comando más famoso. Intenta volcar contraseñas en texto claro (si están disponibles), hashes NTLM, hashes SHA1 y tickets Kerberos.

    ```
    mimikatz # sekurlsa::logonpasswords
    ```
    Esto mostrará una gran cantidad de información. Busca las líneas que contengan `Password` (para texto claro) o `NTLM` para los hashes.

-   **Pass-the-Hash (PtH):**
    Una vez que tienes un hash NTLM, puedes usarlo para iniciar sesión en otro sistema sin conocer la contraseña.

    ```
    mimikatz # sekurlsa::pth /user:Administrador /domain:DOMINIO /ntlm:HASH_NTLM /run:cmd.exe
    ```
    Esto abrirá un CMD como el usuario `Administrador` usando el hash NTLM proporcionado.

-   **Pass-the-Ticket (PtT):**
    Utiliza un ticket Kerberos robado para autenticarse. Los tickets se pueden guardar con `kerberos::list` y luego inyectar.

    ```
    mimikatz # kerberos::ptt ticket.kirbi
    ```

-   **Golden Ticket:**
    Crear un ticket Kerberos falsificado para la cuenta KRBTGT, lo que otorga acceso de administrador de dominio. Este es un ataque de persistencia potente.

    ```
    mimikatz # kerberos::golden /user:fakeadmin /domain:DOMINIO.LOCAL /sid:S-1-5-21-XXX /krbtgt:HASH_KRBTGT /id:500 /ptt
    ```
    (Requiere el SID del dominio y el hash NTLM de la cuenta KRBTGT, que también se pueden obtener con Mimikatz).

## Otras Consideraciones

-   **Detección:** Los programas antivirus y EDR (Endpoint Detection and Response) están diseñados para detectar la ejecución de Mimikatz. Para usarlo en un entorno de pruebas, a menudo es necesario deshabilitar temporalmente el antivirus.
-   **Obfuscación:** Los atacantes a menudo obfuscan o modifican Mimikatz para evadir la detección.
-   **Configuración de Windows:** Ciertas configuraciones de Windows (como el `Protected Process Light` o la deshabilitación del almacenamiento de contraseñas en texto claro) pueden mitigar algunos de los ataques de Mimikatz.
-   **Legalidad y Ética:** El uso de Mimikatz sin autorización explícita es ilegal y puede tener graves consecuencias. Utiliza esta herramienta solo en entornos controlados y con permiso explícito para fines de pruebas de seguridad.
