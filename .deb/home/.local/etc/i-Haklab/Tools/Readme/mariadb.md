
# MariaDB

## ¿Qué es MariaDB?

MariaDB es un sistema de gestión de bases de datos relacionales (RDBMS) de código abierto, compatible con MySQL. Fue creado por los desarrolladores originales de MySQL como una bifurcación (fork) para asegurar que el proyecto se mantuviera libre y de código abierto después de que Oracle adquiriera MySQL. MariaDB está diseñado para ser un reemplazo directo de MySQL, lo que significa que la mayoría de las aplicaciones que funcionan con MySQL también funcionarán con MariaDB.

Organiza los datos en tablas, que se componen de filas y columnas, y utiliza el lenguaje de consulta estructurado (SQL) para todas sus operaciones. Ha ganado popularidad por su rendimiento, robustez y las nuevas características que ha introducido, superando en algunos aspectos a su predecesor.

## ¿Para qué es útil la herramienta?

MariaDB es una base de datos versátil y potente, utilizada en una amplia gama de aplicaciones y escenarios:

-   **Aplicaciones Web y Móviles:** Es una opción popular para el backend de sitios web dinámicos, aplicaciones web y servicios móviles, especialmente cuando se combina con tecnologías como PHP, Python, Java y Node.js.
-   **Sistemas de Gestión de Contenido (CMS):** Es la base de datos de elección para muchos CMS populares como WordPress, Drupal y Joomla.
-   **Almacenamiento de Datos (Data Warehousing):** Sus capacidades de manejo de grandes volúmenes de datos y su soporte para diferentes motores de almacenamiento lo hacen adecuado para soluciones de data warehousing.
-   **Comercio Electrónico:** Soporta las demandas de rendimiento y fiabilidad de las plataformas de e-commerce.
-   **Análisis y Business Intelligence:** Utilizado para almacenar y consultar datos para informes y análisis de negocio.

## ¿Cómo se usa?

El uso de MariaDB implica la instalación del servidor, la conexión al mismo y la ejecución de comandos SQL para interactuar con las bases de datos.

### 1. Instalación

La instalación de MariaDB varía según el sistema operativo.

-   **En sistemas basados en Debian/Ubuntu:**

    ```bash
    sudo apt update
    sudo apt install mariadb-server mariadb-client
    sudo systemctl start mariadb
    sudo mariadb-secure-installation # Sigue las instrucciones para configurar la seguridad
    ```

-   **En macOS (usando Homebrew):**

    ```bash
    brew install mariadb
    brew services start mariadb
    ```

-   **En Windows:**
    Descarga el instalador MSI desde el sitio web oficial de MariaDB y sigue las instrucciones del asistente.

### 2. Conexión al Servidor

Una vez instalado y en ejecución, puedes conectarte al servidor MariaDB usando el cliente de línea de comandos `mariadb`:

```bash
mariadb -u root -p
```
Se te pedirá la contraseña para el usuario `root` (que configuraste durante la instalación segura).

### 3. Operaciones Básicas SQL

Una vez conectado, puedes ejecutar comandos SQL. Cada sentencia SQL debe terminar con un punto y coma (`;`).

-   **Crear una Base de Datos:**

    ```sql
    CREATE DATABASE mi_base_de_datos;
    ```

-   **Seleccionar una Base de Datos (para trabajar en ella):**

    ```sql
    USE mi_base_de_datos;
    ```

-   **Crear una Tabla:**

    ```sql
    CREATE TABLE usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE,
        fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ```

-   **Insertar Datos:**

    ```sql
    INSERT INTO usuarios (nombre, email) VALUES ('Juan Pérez', 'juan.perez@example.com');
    INSERT INTO usuarios (nombre, email) VALUES ('María García', 'maria.garcia@example.com');
    ```

-   **Seleccionar (Consultar) Datos:**

    ```sql
    SELECT * FROM usuarios;
    SELECT nombre, email FROM usuarios WHERE id = 1;
    ```

-   **Actualizar Datos:**

    ```sql
    UPDATE usuarios SET email = 'nuevo.juan@example.com' WHERE nombre = 'Juan Pérez';
    ```

-   **Eliminar Datos:**

    ```sql
    DELETE FROM usuarios WHERE id = 2;
    ```

-   **Eliminar una Base de Datos:**

    ```sql
    DROP DATABASE mi_base_de_datos;
    ```

### 4. Herramientas Adicionales

Además del cliente de línea de comandos, existen herramientas gráficas y web para gestionar MariaDB:

-   **Clientes GUI:** DBeaver, HeidiSQL (Windows), MySQL Workbench (compatible).
-   **Herramientas Web:** phpMyAdmin.

## Otras Consideraciones

-   **Compatibilidad:** MariaDB mantiene una alta compatibilidad con MySQL, lo que facilita la migración de un sistema a otro.
-   **Motores de Almacenamiento:** MariaDB soporta múltiples motores de almacenamiento, como InnoDB (transaccional, por defecto), Aria (reemplazo de MyISAM), ColumnStore (analítico) y Spider (federado), lo que permite optimizar la base de datos para diferentes cargas de trabajo.
-   **Seguridad:** Es crucial configurar adecuadamente la seguridad de MariaDB, incluyendo contraseñas robustas para el usuario `root`, la creación de usuarios con privilegios mínimos y el aseguramiento del acceso a la base de datos.
