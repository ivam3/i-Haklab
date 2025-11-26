
# GetADUsers.py

## ¿Qué es GetADUsers.py?

`GetADUsers.py` es un script de Python que forma parte de la suite de herramientas Impacket. Está diseñado para realizar consultas y extraer información detallada de los usuarios de un dominio de Active Directory (AD). Se comunica con los controladores de dominio utilizando el protocolo LDAP (Lightweight Directory Access Protocol) para obtener los datos.

## ¿Para qué es útil la herramienta?

Esta herramienta es ampliamente utilizada por profesionales de la seguridad en fases de reconocimiento y enumeración durante una prueba de penetración o ejercicios de Red Team. Sus principales usos son:

- **Enumeración de usuarios:** Permite obtener una lista completa de los nombres de usuario en un dominio de Active Directory.
- **Recopilación de información:** Puede extraer atributos específicos de los usuarios, como direcciones de correo electrónico, descripciones, último inicio de sesión, fecha del último cambio de contraseña, y más.
- **Auditoría de seguridad:** Facilita la revisión de las configuraciones de las cuentas de usuario, como la identificación de cuentas deshabilitadas o aquellas con contraseñas que no expiran.
- **Identificación de objetivos:** La información recolectada puede ser crucial para identificar posibles objetivos para ataques posteriores, como el password spraying o la ingeniería social.

## ¿Cómo se usa?

`GetADUsers.py` se ejecuta desde la línea de comandos. A continuación, se muestran los parámetros y ejemplos de uso más comunes.

### Sintaxis básica

```bash
python3 GetADUsers.py -dc-ip <IP_del_DC> -all <dominio>/<usuario>:<contraseña>
```

- `-dc-ip <IP_del_DC>`: La dirección IP del controlador de dominio al que se quiere conectar.
- `-all`: Parámetro para solicitar que se devuelvan todos los usuarios, incluyendo cuentas deshabilitadas.
- `<dominio>/<usuario>:<contraseña>`: Las credenciales para autenticarse en el Active Directory.

### Ejemplos de uso

1.  **Obtener todos los usuarios de un dominio:**
    Este comando se conecta a un controlador de dominio y solicita la lista de todos los usuarios, autenticándose con un usuario y contraseña.
    ```bash
    python3 GetADUsers.py -dc-ip 10.10.10.1 -all 'midominio.local/john:Password123'
    ```

2.  **Autenticación con Pass-the-Hash:**
    Si se dispone del hash NTLM de un usuario, se puede utilizar en lugar de la contraseña.
    ```bash
    python3 GetADUsers.py -dc-ip 10.10.10.1 -all -hashes :<hash_ntlm> 'midominio.local/usuario'
    ```

3.  **Guardar la salida en un archivo:**
    La salida estándar se puede redirigir a un archivo para su posterior análisis.
    ```bash
    python3 GetADUsers.py -dc-ip 10.10.10.1 -all 'midominio.local/john:Password123' > usuarios_ad.txt
    ```

4.  **Uso con Kerberos:**
    También es posible autenticarse utilizando un ticket de Kerberos.
    ```bash
    export KRB5CCNAME=/ruta/al/ticket.ccache
    python3 GetADUsers.py -dc-ip 10.10.10.1 -all -k -no-pass 'midominio.local/usuario'
    ```

## Otras consideraciones

- **Dependencias:** `GetADUsers.py` requiere Python 3 y la librería Impacket instalada.
- **Permisos:** La cuenta utilizada para la consulta debe tener permisos de lectura en el Active Directory. Generalmente, un usuario de dominio estándar tiene suficientes permisos.
- **Seguridad:** Proporcionar contraseñas en texto plano en la línea de comandos puede ser un riesgo de seguridad. En entornos seguros, se prefieren métodos como la autenticación con Kerberos o hashes.
