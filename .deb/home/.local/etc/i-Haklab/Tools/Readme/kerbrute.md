
# Kerbrute

## ¿Qué es Kerbrute?

Kerbrute es una herramienta de código abierto escrita en Go (Golang) diseñada para realizar enumeración de usuarios y ataques de pulverización de contraseñas (password spraying) contra servicios de autenticación Kerberos, comúnmente encontrados en entornos de Active Directory de Windows. Su principal ventaja es que puede realizar estos ataques de manera eficiente y a menudo sigilosa, sin generar bloqueos masivos de cuentas.

Se aprovecha de las características del protocolo Kerberos para verificar la validez de los nombres de usuario y para intentar autenticar credenciales.

## ¿Para qué es útil la herramienta?

Kerbrute es una herramienta crucial para pentesters, equipos de Red Team y profesionales de la seguridad que evalúan la postura de seguridad de entornos con Active Directory:

-   **Enumeración de Usuarios:** Permite identificar nombres de usuario válidos en un dominio de Active Directory sin causar bloqueos de cuenta. Esto es valioso para obtener listas de usuarios que pueden ser el objetivo de ataques posteriores.
-   **Pulverización de Contraseñas (Password Spraying):** Realiza un ataque en el que se prueba una única contraseña (comúnmente una contraseña débil o por defecto) contra una gran lista de nombres de usuario. Esto es efectivo para evadir las políticas de bloqueo de cuentas, ya que cada cuenta solo recibe un intento de contraseña incorrecta.
-   **Ataques de Fuerza Bruta:** Puede realizar ataques de fuerza bruta tradicionales contra usuarios individuales o contra combinaciones de usuario-contraseña.
-   **Reconocimiento:** Ayuda a mapear la superficie de ataque de un dominio de Active Directory.

## ¿Cómo funciona?

Kerbrute explota el comportamiento de la preautenticación de Kerberos. Cuando un cliente solicita un Ticket Granting Ticket (TGT) al Centro de Distribución de Claves (KDC) sin preautenticación, o con credenciales incorrectas:

-   Si el nombre de usuario **no existe**, el KDC devuelve un error específico que indica que el usuario no se encontró.
-   Si el nombre de usuario **existe**, pero la preautenticación falla (contraseña incorrecta), el KDC devuelve un error diferente que indica que se requiere preautenticación o que las credenciales son inválidas. Este comportamiento permite a Kerbrute inferir la existencia de un usuario sin necesidad de una contraseña correcta ni de activar eventos de bloqueo de cuenta en el caso de la enumeración.

## ¿Cómo se usa?

Kerbrute es una herramienta de línea de comandos. Se distribuye como un binario precompilado para diversas plataformas, lo que facilita su uso sin necesidad de instalar Go.

### 1. Instalación

1.  **Descargar:** Descarga el binario precompilado adecuado para tu sistema operativo desde la página de lanzamientos del repositorio oficial de Kerbrute en GitHub.
2.  **Descomprimir y Dar Permisos:** Descomprime el archivo y dale permisos de ejecución al binario.

    ```bash
    tar -xvf kerbrute_linux_amd64
    chmod +x kerbrute
    ```
    (El nombre del archivo puede variar según el sistema operativo y la arquitectura).

### 2. Ejemplos de Uso

Todos los comandos se ejecutan desde la terminal.

-   **Enumeración de Usuarios (`userenum`):**
    Este comando toma una lista de nombres de usuario y verifica cuáles existen en el dominio.

    ```bash
    ./kerbrute userenum --domain midominio.local --dc 192.168.1.10 usernames.txt
    ```
    -   `--domain`: Especifica el nombre del dominio de Active Directory.
    -   `--dc`: Especifica la dirección IP del controlador de dominio.
    -   `usernames.txt`: Un archivo de texto con un nombre de usuario por línea.

-   **Pulverización de Contraseñas (`passwordspray`):**
    Este comando intenta una única contraseña contra cada nombre de usuario en una lista.

    ```bash
    ./kerbrute passwordspray --domain midominio.local --dc 192.168.1.10 usernames.txt "Winter2023!"
    ```
    -   `usernames.txt`: Lista de nombres de usuario.
    -   `"Winter2023!"`: La contraseña única a probar.

-   **Fuerza Bruta para un Usuario (`bruteuser`):**
    Este comando prueba una lista de contraseñas contra un único nombre de usuario.

    ```bash
    ./kerbrute bruteuser --domain midominio.local --dc 192.168.1.10 "johndoe" passwords.txt
    ```
    -   `"johndoe"`: El nombre de usuario objetivo.
    -   `passwords.txt`: Un archivo de texto con una contraseña por línea.

## Otras Consideraciones

-   **Ética y Legalidad:** Kerbrute es una herramienta ofensiva. Su uso debe ser **estrictamente ético y legal**, y solo en sistemas para los que se tenga autorización explícita para realizar pruebas de seguridad. El uso no autorizado es ilegal.
-   **Detección:** Aunque la enumeración de usuarios puede ser sigilosa, los ataques de pulverización de contraseñas pueden generar suficientes eventos de seguridad como para activar alertas en sistemas de monitoreo o SIEM, incluso si no bloquean cuentas directamente.
-   **Rendimiento:** Kerbrute es muy rápido gracias a que está escrito en Go y a su diseño eficiente para el protocolo Kerberos.
