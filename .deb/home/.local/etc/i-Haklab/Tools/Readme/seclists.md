# SecLists

## ¿Qué es SecLists?

SecLists es una colección masiva y curada de listas de seguridad. No es una herramienta en el sentido tradicional, sino un repositorio de datos. Es el resultado de un esfuerzo comunitario para recopilar una gran cantidad de listas utilizadas en evaluaciones de seguridad, pruebas de penetración y hacking ético.

Estas listas incluyen, pero no se limitan a:
-   Nombres de usuario
-   Contraseñas
-   URLs y rutas de directorios
-   Payloads para fuzzing
-   Web shells
-   Patrones de datos sensibles (para `grep`)
-   Y mucho más.

Es un recurso indispensable para cualquier profesional de la seguridad.

## ¿Para qué es útil?

La utilidad de SecLists radica en la calidad y amplitud de sus diccionarios, que se utilizan como entrada para otras herramientas. Su propósito es:

*   **Ataques de Fuerza Bruta:** Proporcionar listas de contraseñas y nombres de usuario para herramientas como `hydra`, `nmap` (con scripts NSE), o `metasploit` para intentar adivinar credenciales.
*   **Descubrimiento de Contenido Web:** Herramientas como `gobuster`, `dirb`, o `wfuzz` utilizan las listas de SecLists para descubrir directorios, archivos y subdominios ocultos en servidores web.
*   **Fuzzing:** Suministrar una gran variedad de payloads (cadenas de texto maliciosas o inesperadas) para probar la robustez de las aplicaciones web y encontrar vulnerabilidades como XSS (Cross-Site Scripting) o Inyección SQL.
*   **Análisis de Seguridad:** Las listas de patrones de `grep` ayudan a buscar información sensible, como claves de API o contraseñas, que podrían haber sido dejadas accidentalmente en el código fuente o en archivos de configuración.

## ¿Cómo se usa? (Ejemplos conceptuales)

SecLists no se "ejecuta", sino que se "utiliza" junto con otras herramientas. El uso típico es pasar una de sus listas como argumento a otro programa.

La ubicación de las listas puede variar, pero en sistemas como Kali Linux, a menudo se encuentra en `/usr/share/seclists/`.

**Ejemplo 1: Descubrimiento de directorios con `gobuster`**

Para buscar directorios comunes en un sitio web, usarías `gobuster` con una lista de SecLists.

```bash
gobuster dir -u http://example.com -w /usr/share/seclists/Discovery/Web-Content/common.txt
```
En este comando, `-w` especifica la lista de palabras (wordlist) que `gobuster` utilizará para hacer las peticiones.

**Ejemplo 2: Ataque de diccionario con `hydra`**

Para intentar adivinar la contraseña de un usuario en un servicio FTP.

```bash
hydra -l usuario -P /usr/share/seclists/Passwords/Leaked-Databases/rockyou.txt ftp://192.168.1.100
```
Aquí, `-P` apunta al famoso diccionario `rockyou.txt` dentro de SecLists.

## Consideraciones Adicionales

*   **Es un Compendio:** Piensa en SecLists como una enciclopedia de "palabras" para pentesters. Su valor no está en sí mismo, sino en cómo se aplica con otras herramientas.
*   **Tamaño:** La colección completa de SecLists es muy grande (varios Gigabytes), por lo que a veces se instalan versiones más pequeñas o específicas según las necesidades.
*   **Actualizaciones:** El repositorio de SecLists en GitHub (de Daniel Miessler, g0tmi1k, y Jason Haddix) se actualiza continuamente con nuevas listas.

---
*Nota: El uso de las listas contenidas en SecLists para atacar sistemas sin autorización explícita es ilegal.*
