# SQLite

## ¿Qué es SQLite?

SQLite no es una herramienta de hacking, sino un **motor de base de datos SQL**. Es, de hecho, el motor de base de datos más desplegado en el mundo. A diferencia de los sistemas de bases de datos tradicionales como MySQL o PostgreSQL, SQLite no es un sistema cliente-servidor. En su lugar, es una **biblioteca de C** que se integra directamente en la aplicación que la utiliza.

La base de datos completa (definiciones, tablas, índices y los propios datos) se almacena como un **único archivo** en el disco. Esto la hace increíblemente portátil, eficiente y fácil de usar.

El programa `sqlite3` es la **interfaz de línea de comandos (CLI)** que permite a los usuarios interactuar con una base de datos de SQLite.

## ¿Para qué es útil?

SQLite se utiliza en una cantidad asombrosa de aplicaciones:
*   **Navegadores Web:** Firefox, Chrome y Safari lo usan para almacenar el historial, las cookies y los marcadores.
*   **Sistemas Operativos Móviles:** Android e iOS lo utilizan extensivamente como el formato de almacenamiento de datos para las aplicaciones.
*   **Aplicaciones de Escritorio:** Muchas aplicaciones (como Skype o Dropbox) lo usan para almacenar la configuración y los datos del usuario.
*   **Sistemas Embebidos:** Es perfecto para dispositivos que necesitan una base de datos transaccional pero no tienen los recursos para un motor de base de datos completo.

En el contexto de las pruebas de penetración y la informática forense, la herramienta `sqlite3` es crucial para:
*   **Analizar Datos de Aplicaciones:** Un pentester o un analista forense puede extraer archivos de base de datos (`.db`, `.sqlite`, `.sqlite3`) de una aplicación móvil o de escritorio y usar `sqlite3` para examinar su contenido, buscando información sensible como contraseñas, tokens de sesión, datos personales, etc.
*   **Explotación de Inyección SQL:** A veces, una vulnerabilidad de inyección SQL puede dar acceso a una base de datos SQLite en el backend de una aplicación web.

## ¿Cómo se usa? (Ejemplos básicos con `sqlite3`)

La CLI `sqlite3` es una herramienta potente para gestionar bases de datos SQLite.

**1. Crear o abrir una base de datos:**

Si el archivo `mi_base_de_datos.db` no existe, se creará. Si existe, se abrirá.

```bash
sqlite3 mi_base_de_datos.db
```
Esto te llevará al prompt interactivo de SQLite: `sqlite>`.

**2. Ejecutar comandos SQL:**

Una vez dentro, puedes ejecutar comandos SQL estándar.

*   **Crear una tabla:**
    ```sql
    CREATE TABLE usuarios (id INTEGER PRIMARY KEY, nombre TEXT, email TEXT);
    ```
*   **Insertar datos:**
    ```sql
    INSERT INTO usuarios (nombre, email) VALUES ('Juan Perez', 'juan.perez@example.com');
    ```
*   **Consultar datos:**
    ```sql
    SELECT * FROM usuarios;
    ```

**3. Usar "dot-commands":**

SQLite tiene meta-comandos que empiezan con un punto (`.`). Son muy útiles para gestionar la base de datos.

*   **Listar todas las tablas:**
    ```
    sqlite> .tables
    ```
*   **Mostrar el esquema de una tabla:**
    ```
    sqlite> .schema usuarios
    ```
*   **Exportar la base de datos a un archivo SQL:**
    ```
    sqlite> .output backup.sql
    sqlite> .dump
    ```
*   **Salir de la CLI:**
    ```
    sqlite> .exit
    ```

## Consideraciones Adicionales

*   ** omnipresencia:** Dada su popularidad, encontrar un archivo `.db` o `.sqlite` durante una auditoría es muy común. Saber cómo analizarlo es una habilidad fundamental.
*   **Tipado Dinámico:** A diferencia de la mayoría de las bases de datos SQL, SQLite utiliza un sistema de tipado dinámico. Puedes almacenar una cadena en una columna definida como entero, por ejemplo.
*   **No es para Alta Concurrencia:** SQLite es excelente para muchas cosas, pero no está diseñado para aplicaciones con alta concurrencia de escritura, donde un sistema cliente-servidor como PostgreSQL sería más apropiado.

---
*Nota: Saber manejar `sqlite3` es una habilidad esencial para cualquier persona involucrada en el desarrollo de software, la administración de sistemas o la ciberseguridad.*
