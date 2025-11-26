# enum4linux

## ¿Qué es enum4linux?

`enum4linux` es una herramienta de línea de comandos clásica, escrita en Perl, utilizada para la **enumeración de información de sistemas Windows y Samba** a través del protocolo SMB/CIFS. Su objetivo es automatizar la extracción de tantos datos como sea posible de un objetivo, lo que ayuda a un pentester a obtener una imagen clara de la configuración del sistema y a encontrar posibles vectores de ataque.

Actúa como un envoltorio (wrapper) para varias herramientas del conjunto de Samba (`smbclient`, `rpclient`, `net`, `nmblookup`), unificando sus salidas en un informe fácil de leer.

## ¿Para qué es útil la herramienta?

`enum4linux` es una de las primeras herramientas que se ejecutan contra un host Windows o Samba en una prueba de penetración interna. La información que recopila es fundamental para planificar los siguientes pasos de un ataque:

*   **Enumeración de Usuarios y Grupos:** Descubre listas de usuarios y grupos locales o de dominio, lo que proporciona nombres de usuario válidos para ataques de fuerza bruta o de phishing.
*   **Enumeración de Recursos Compartidos (Shares):** Lista las carpetas compartidas en la red, que pueden contener archivos sensibles o tener permisos de escritura que permitan a un atacante plantar malware.
*   **Identificación del Sistema y Dominio:** Determina el nombre del host, el sistema operativo, y si la máquina es parte de un grupo de trabajo o de un dominio de Active Directory.
*   **Obtención de la Política de Contraseñas:** Intenta recuperar la política de contraseñas del sistema (longitud mínima, complejidad, historial de contraseñas), información muy valiosa para crear listas de palabras dirigidas.
*   **Descubrimiento de Impresoras y otros servicios:** Enumera información sobre impresoras y otros servicios compartidos.

## ¿Cómo funciona?

`enum4linux` intenta conectarse al objetivo a través del protocolo SMB, a menudo utilizando una **"sesión nula" (null session)**. Una sesión nula es una conexión anónima que, en sistemas más antiguos o mal configurados, puede permitir a un usuario no autenticado consultar una gran cantidad de información del sistema a través de RPC (Remote Procedure Call).

Las principales técnicas que utiliza son:

*   **Consultas RPC:** Utiliza `rpclient` para conectarse a los servicios RPC del objetivo y solicitar información como listas de usuarios, grupos y políticas.
*   **RID Cycling:** Esta es una técnica de fuerza bruta para enumerar usuarios. Cada usuario en un sistema Windows tiene un Identificador Relativo (RID), que es un número incremental (por ejemplo, 500 para el administrador, 1001, 1002, etc.). `enum4linux` puede "ciclar" a través de un rango de RIDs y preguntar al sistema "¿quién es el usuario con RID 1001?", "¿quién es el usuario con RID 1002?", y así sucesivamente, para construir una lista de usuarios.
*   **Consultas NetBIOS:** Utiliza `nmblookup` para obtener los nombres NetBIOS registrados por el host.

## ¿Cómo se usa? (Ejemplo básico)

`enum4linux` es muy fácil de usar. Su modo más simple es simplemente pasarle la dirección IP del objetivo.

**Sintaxis básica:**
```bash
enum4linux [opciones] <direccion_IP>
```

### Ejemplo: Escaneo completo

Este comando ejecutará todas las comprobaciones por defecto contra el host en `192.168.1.100`.

```bash
enum4linux 192.168.1.100
```

**Salida de ejemplo (muy abreviada):**
```
==========================
|    Target: 192.168.1.100    |
==========================

...
[+] Getting OS Information
...
[+] Getting User List
...
user:[Administrator] rid:[0x1f4]
user:[Guest] rid:[0x1f5]
user:[alice] rid:[0x3e9]
user:[bob] rid:[0x3ea]

[+] Getting Group List
...
group:[Administrators] rid:[0x220]
group:[Users] rid:[0x221]

[+] Getting Share List
...
Sharename       Type      Comment
---------       ----      -------
C$              Disk      Default share
IPC$            IPC       Remote IPC
Users           Disk

[+] Getting Password Policy
...
    Minimum password length: 8
    Password history length: 5
...
```

### Opciones comunes

*   `-U`: Obtener lista de usuarios.
*   `-S`: Obtener lista de recursos compartidos.
*   `-P`: Obtener la política de contraseñas.
*   `-G`: Obtener lista de grupos.
*   `-a`: Realizar todas las enumeraciones (equivale a ejecutarlo sin opciones).

## Consideraciones Adicionales

*   **Sistemas Modernos:** La efectividad de `enum4linux` ha disminuido en los sistemas Windows modernos (Windows 10, Server 2016 y posteriores), ya que Microsoft ha restringido por defecto el acceso anónimo que permitían las sesiones nulas. Sin embargo, sigue siendo extremadamente útil contra sistemas más antiguos (Windows XP/7/Server 2003/2008) y servidores Samba mal configurados.
*   **Ruido en la Red:** Las operaciones de `enum4linux`, especialmente el RID cycling, son muy "ruidosas" y fácilmente detectables por los sistemas de monitoreo de seguridad.
*   **`enum4linux-ng`:** Existe una versión más nueva y reimaginada llamada `enum4linux-ng` (Next Generation), escrita en Python, que añade más funcionalidades y es activamente mantenida.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. Solo debes usar esta herramienta en redes y sistemas para los que tengas permiso explícito de realizar pruebas.*
