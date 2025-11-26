# BloodHound

## ¿Qué es BloodHound?

BloodHound es una herramienta de análisis de seguridad que utiliza la **teoría de grafos** para visualizar y entender las relaciones de permisos y las rutas de ataque en entornos de **Active Directory (AD)** y **Azure AD**. Es una de las herramientas más poderosas y utilizadas tanto por equipos de ataque (Red Team) como de defensa (Blue Team).

En lugar de ver los permisos como una lista interminable de usuarios y grupos, BloodHound los representa como un grafo, donde los usuarios, grupos y ordenadores son "nodos" y los permisos entre ellos son "aristas". Esto permite descubrir visualmente rutas de escalada de privilegios complejas y a menudo ocultas que serían casi imposibles de encontrar manualmente.

## ¿Para qué es útil la herramienta?

BloodHound es una herramienta de doble filo, útil para ambos lados de la ciberseguridad:

### Para Atacantes (Red Team / Pentesters)

*   **Identificar Rutas de Ataque:** Su principal función es encontrar la ruta más corta y eficiente para escalar privilegios. Por ejemplo, puede mostrar cómo un usuario estándar puede, a través de una cadena de membresías de grupos y permisos, llegar a ser Administrador del Dominio (Domain Admin).
*   **Mapeo del Dominio:** Permite obtener un mapa completo de quién tiene control sobre qué en todo el dominio de Active Directory.
*   **Abuso de Privilegios:** Descubre relaciones de permisos no obvias, como un usuario que tiene permiso para cambiar la contraseña de otro usuario que pertenece a un grupo privilegiado.

### Para Defensores (Blue Team / Administradores de Sistemas)

*   **Auditoría de Seguridad:** Permite a los administradores visualizar y auditar las complejas relaciones de permisos en su propio entorno.
*   **Identificar y Corregir Malas Configuraciones:** Ayuda a encontrar y eliminar permisos excesivos, grupos anidados innecesariamente y otras configuraciones de riesgo.
*   **Análisis de "Blast Radius":** Si una cuenta se ve comprometida, BloodHound puede mostrar instantáneamente a qué recursos críticos podría acceder esa cuenta (su "radio de explosión"), ayudando a priorizar la respuesta a incidentes.

## ¿Cómo funciona?

El uso de BloodHound se divide en dos fases principales:

### 1. Recolección de Datos (Ingest)

Primero, necesitas recolectar la información del entorno de Active Directory. Esto se hace con un "recolector" o "ingestor". El más común es **SharpHound**.

*   **SharpHound:** Es un ejecutable (.exe) o un script de PowerShell que se ejecuta en una máquina unida al dominio. No requiere privilegios de administrador para la mayoría de sus recolecciones. SharpHound consulta a Active Directory para obtener toda la información sobre usuarios, grupos, ordenadores, sesiones, GPOs (Group Policy Objects), y listas de control de acceso (ACLs), y la guarda en una serie de archivos JSON (o en un único archivo ZIP).

### 2. Visualización y Análisis

Una vez que tienes los archivos JSON, los importas a la interfaz gráfica de BloodHound.

*   **Interfaz Gráfica de BloodHound:** Esta aplicación utiliza una base de datos de grafos (Neo4j) para procesar los datos. Permite:
    *   **Visualizar el grafo:** Ver las relaciones entre los diferentes objetos de AD.
    *   **Realizar consultas (Queries):** BloodHound viene con una serie de consultas predefinidas para encontrar las rutas de ataque más comunes, como "Encontrar la ruta más corta al grupo Domain Admins" o "Listar todos los usuarios con sesiones en servidores de alta criticidad".
    *   **Explorar relaciones:** Hacer clic en cualquier nodo (usuario, grupo, etc.) para ver todos sus permisos y relaciones.

## Ejemplo de un Hallazgo Típico

Un análisis con BloodHound podría revelar una ruta como esta:

1.  El usuario `Bob` (un usuario estándar) es miembro del grupo `HelpDesk`.
2.  El grupo `HelpDesk` tiene permiso para forzar el cambio de contraseña sobre el usuario `Alice`.
3.  La usuaria `Alice` es miembro del grupo `Server Admins`.
4.  El grupo `Server Admins` tiene derechos de administrador local sobre el servidor `DC01` (un Controlador de Dominio).

**Conclusión:** Un atacante que comprometa la cuenta de `Bob` puede usar esa posición para tomar el control de `Alice`, y a través de ella, comprometer todo el dominio. Esta es una ruta de ataque que sería muy difícil de ver sin una herramienta como BloodHound.

## Consideraciones Adicionales

*   **BloodHound Community vs. Enterprise:** Existe una versión gratuita y de código abierto (Community Edition), que es la utilizada por la mayoría de los pentesters. También hay una versión comercial (Enterprise) con características adicionales para la monitorización continua y la remediación, enfocada en los equipos de defensa.
*   **Ruido en la Red:** La ejecución de SharpHound genera una gran cantidad de consultas LDAP al controlador de dominio, lo que puede ser detectado por sistemas de monitoreo de seguridad.
*   **Azure AD:** BloodHound también soporta la recolección y análisis de entornos de Azure AD, utilizando un ingestor llamado **AzureHound**.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad. La recolección de datos de un Active Directory sin autorización es una actividad hostil y debe ser tratada como tal.*
