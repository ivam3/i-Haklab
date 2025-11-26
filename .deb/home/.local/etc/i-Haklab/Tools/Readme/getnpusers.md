
# GetNPUsers.py

## ¿Qué es GetNPUsers.py?

`GetNPUsers.py` es una herramienta de la suite Impacket que se utiliza para identificar y obtener los hashes de contraseñas de cuentas de usuario en un dominio de Active Directory que no requieren pre-autenticación de Kerberos. Esta condición, conocida como "AS-REP Roasting", es una mala configuración de seguridad que permite a un atacante solicitar un Ticket de Concesión de Tickets (TGT) sin necesidad de proporcionar credenciales.

## ¿Para qué es útil la herramienta?

El principal propósito de esta herramienta es la seguridad ofensiva y las pruebas de penetración. Se utiliza para:

- **Identificar cuentas vulnerables:** Escanea el Active Directory en busca de cuentas de usuario que tengan el atributo `DONT_REQUIRE_PREAUTH` habilitado.
- **Obtener hashes de contraseñas:** Para las cuentas vulnerables identificadas, `GetNPUsers.py` solicita un TGT y extrae de la respuesta (AS-REP) un hash de la contraseña del usuario.
- **Ataques de fuerza bruta offline:** Los hashes obtenidos están en un formato compatible con herramientas de cracking como Hashcat o John the Ripper, lo que permite intentar descifrar las contraseñas en un entorno controlado sin generar ruido en la red del objetivo.

## ¿Cómo se usa?

La herramienta se ejecuta desde la línea de comandos y requiere una lista de usuarios potenciales para verificar.

### Sintaxis básica

```bash
python3 GetNPUsers.py <dominio>/ -usersfile <archivo_de_usuarios> -format <formato> -outputfile <archivo_de_salida>
```

- `<dominio>/`: El dominio de Active Directory a atacar. Se debe incluir la barra `/`.
- `-usersfile <archivo_de_usuarios>`: Un archivo de texto con una lista de nombres de usuario a verificar (uno por línea).
- `-format <formato>`: El formato de salida para los hashes (ej. `hashcat` o `john`).
- `-outputfile <archivo_de_salida>`: El archivo donde se guardarán los hashes obtenidos.
- `-dc-ip <IP_del_DC>`: (Opcional) Especifica la IP del controlador de dominio.

### Ejemplos de uso

1.  **Buscar usuarios vulnerables y guardar los hashes:**
    Suponiendo que tenemos un archivo `usuarios.txt` con una lista de nombres de usuario del dominio `midominio.local`.

    ```bash
    python3 GetNPUsers.py midominio.local/ -usersfile usuarios.txt -format hashcat -outputfile hashes_asrep.txt
    ```
    Este comando intentará obtener el TGT para cada usuario en `usuarios.txt`. Si un usuario no requiere pre-autenticación, su hash se guardará en `hashes_asrep.txt` en formato para Hashcat.

2.  **Realizar la consulta sin credenciales:**
    El ataque AS-REP Roasting no requiere credenciales válidas para iniciarse. El siguiente comando es un ejemplo de cómo se ejecutaría sin proporcionar usuario ni contraseña.
    ```bash
    python3 GetNPUsers.py corporate.com/ -no-pass -usersfile users.list -dc-ip 10.10.5.2
    ```

## Cracking del hash con Hashcat

Una vez obtenido un hash (por ejemplo, `$krb5asrep$23$...`), se puede intentar crackear con Hashcat usando el modo `18200`.

```bash
hashcat -m 18200 hashes_asrep.txt /usr/share/wordlists/rockyou.txt
```

## Otras consideraciones

- **Se necesita una lista de usuarios:** A diferencia de otras herramientas, `GetNPUsers.py` generalmente requiere una lista de nombres de usuario para ser efectivo. Esta lista se puede obtener con otras herramientas de enumeración como `GetADUsers.py`.
- **Conectividad:** Se requiere conectividad de red con el controlador de dominio en el puerto 88 (Kerberos).
