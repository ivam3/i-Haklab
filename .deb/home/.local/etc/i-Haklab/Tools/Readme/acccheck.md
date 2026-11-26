# acccheck

## ¿Qué es acccheck?

`acccheck` es una herramienta de línea de comandos utilizada para realizar ataques de diccionario de contraseñas contra el protocolo SMB (Server Message Block) en sistemas Windows. Esencialmente, intenta adivinar las contraseñas de las cuentas de usuario probando una lista de contraseñas comunes o predefinidas.

## ¿Para qué es útil la herramienta?

Esta herramienta es útil para:

*   **Pentesting:** Los profesionales de la seguridad utilizan `acccheck` para evaluar la seguridad de las contraseñas en una red.
*   **Auditoría de seguridad:** Permite a los administradores de sistemas identificar cuentas de usuario con contraseñas débiles o fáciles de adivinar.
*   **Recuperación de contraseñas:** En algunos casos, se puede utilizar para recuperar el acceso a una cuenta si la contraseña se ha olvidado, aunque este no es su propósito principal.

## ¿Cómo se instala en Termux?

```bash
pkg install acccheck
acccheck --help
```

El `postinst` clona la herramienta upstream en `~/.local/share/acccheck` y deja el comando `acccheck` en `$PREFIX/bin`. Depende de `git` y `perl`, y necesita **`smbclient`** (paquete `samba`), que se instala como dependencia del paquete.

## ¿Cómo se usa? (Ejemplos básicos)

El uso básico de `acccheck` implica especificar el host de destino, un usuario o una lista de usuarios, y una lista de contraseñas.

**Sintaxis básica:**

```bash
acccheck -t [IP del objetivo] -u [usuario] -P [archivo_de_contraseñas]
```

**Flags principales:**

| Flag | Significado |
| :--- | :--- |
| `-t` / `-T` | IP objetivo / archivo con lista de IPs |
| `-u` / `-U` | usuario / archivo con lista de usuarios |
| `-p` / `-P` | contraseña única / archivo de contraseñas |
| `-v` | modo verbose (solo recomendable con diccionarios pequeños) |

**Ejemplo 1: Probar un solo usuario con una lista de contraseñas**

Supongamos que quieres probar la contraseña del usuario `admin` en la máquina con la dirección IP `192.168.1.100`, utilizando una lista de contraseñas guardada en `passwords.txt`.

```bash
acccheck -t 192.168.1.100 -u admin -P passwords.txt
```

**Ejemplo 2: Probar una lista de usuarios**

Si tienes una lista de nombres de usuario en un archivo llamado `users.txt`, puedes probar todas esas cuentas con la misma lista de contraseñas.

```bash
acccheck -t 192.168.1.100 -U users.txt -P passwords.txt
```

## Consideraciones Adicionales

*   **Legalidad:** El uso de `acccheck` en sistemas para los que no tienes permiso explícito es ilegal.
*   **Salida:** las combinaciones usuario/contraseña válidas se escriben en un archivo llamado `cracked` en el directorio actual.
*   **Requisito:** necesita `smbclient` (paquete `samba`); sin él la herramienta no puede conectarse al objetivo.
*   **Ruido en la red:** Los ataques de diccionario pueden generar una cantidad significativa de tráfico de red y pueden ser detectados por sistemas de detección de intrusos (IDS).
*   **Alternativas:** Otras herramientas populares para ataques de diccionario en SMB incluyen `hydra` y `medusa`.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. No la utilices para actividades maliciosas.*
