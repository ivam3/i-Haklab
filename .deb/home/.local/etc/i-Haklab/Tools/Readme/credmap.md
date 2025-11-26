# Credmap

## ¿Qué es Credmap?

Credmap es una herramienta de código abierto diseñada para ilustrar el peligro de la **reutilización de credenciales**. Su función es tomar un par de credenciales (un nombre de usuario/correo y una contraseña) que han sido comprometidas en una fuga de datos (data breach) y probarlas automáticamente contra una lista de sitios web populares para ver si la víctima reutilizó la misma contraseña en otros lugares.

Es una herramienta de concienciación y de pruebas de penetración que demuestra cómo una sola fuga de datos puede llevar a la compromiso de múltiples cuentas de un usuario.

## ¿Para qué es útil la herramienta?

Credmap es utilizado tanto por profesionales de la seguridad como por atacantes para:

*   **Pruebas de Penetración (Credential Stuffing):** En un escenario de pentesting, si se obtiene una lista de credenciales de una fuente (por ejemplo, una base de datos filtrada de la empresa cliente), un pentester puede usar Credmap para comprobar si esas mismas credenciales dan acceso a otros servicios de la empresa o a servicios de terceros utilizados por los empleados (como portales de RRHH, correo web, etc.).
*   **Concienciación sobre Seguridad:** Es una herramienta excelente para demostrar visualmente a los usuarios y a la dirección de una empresa por qué la política de usar contraseñas únicas para cada servicio es tan crítica.
*   **Ataques de "Credential Stuffing":** Los ciberdelincuentes utilizan esta misma técnica a gran escala. Toman las enormes listas de credenciales que se venden en la dark web y las prueban automáticamente contra cientos de sitios (bancos, redes sociales, tiendas online) con la esperanza de encontrar coincidencias.

## ¿Cómo funciona?

Credmap es una herramienta de línea de comandos que automatiza el proceso de inicio de sesión en varios sitios web.

1.  **Entrada:** El usuario proporciona a Credmap un nombre de usuario o correo electrónico y una contraseña. También puede proporcionar una lista de credenciales en un archivo.
2.  **Prueba de Inicio de Sesión:** La herramienta intenta iniciar sesión en una lista predefinida de sitios web (como LinkedIn, Facebook, Twitter, Reddit, etc.) utilizando las credenciales proporcionadas.
3.  **Análisis de la Respuesta:** Credmap analiza la respuesta de cada sitio web para determinar si el inicio de sesión fue exitoso o no. Un inicio de sesión exitoso indica que la contraseña fue reutilizada en ese sitio.
4.  **Informe:** La herramienta informa al usuario en qué sitios las credenciales funcionaron.

## ¿Cómo se usa? (Ejemplo básico)

Credmap se ejecuta desde la línea de comandos.

**Sintaxis básica:**

```bash
python credmap.py -u [usuario/email] -p [contraseña]
```

### Ejemplo 1: Probar una sola credencial

Supongamos que quieres comprobar si el usuario `test@example.com` reutilizó la contraseña `Password123`.

```bash
python credmap.py -u test@example.com -p Password123
```

**Salida de ejemplo:**
```
[*] Iniciando la comprobación de reutilización de credenciales para test@example.com...
[*] Probando en LinkedIn...
[+] ¡Credenciales válidas encontradas en LinkedIn!
[*] Probando en Reddit...
[-] Credenciales inválidas en Reddit.
[*] Probando en Spotify...
[+] ¡Credenciales válidas encontradas en Spotify!
[*] Comprobación completada.
```

### Ejemplo 2: Usar una lista de credenciales

Si tienes un archivo `credenciales.txt` con el formato `usuario:contraseña` por línea, puedes hacer que Credmap las pruebe todas.

```bash
python credmap.py -l credenciales.txt
```

### Ejemplo 3: Probar solo en sitios específicos

Puedes limitar la prueba a uno o más sitios web.

```bash
python credmap.py -u test@example.com -p Password123 --include linkedin,github
```

## Consideraciones Adicionales

*   **Legalidad y Ética:** Probar credenciales en sitios web sin el permiso explícito del propietario de la cuenta es **ilegal** y una violación de los términos de servicio de esos sitios. Credmap debe usarse de forma ética, por ejemplo, en un entorno de pentesting autorizado donde se te ha dado permiso para realizar este tipo de pruebas.
*   **Bloqueos y CAPTCHAs:** Muchos sitios web tienen mecanismos para detectar y bloquear intentos de inicio de sesión automatizados y repetidos desde la misma dirección IP. Pueden bloquear la IP o presentar un CAPTCHA, lo que detendría a la herramienta. Por ello, Credmap tiene opciones para usar proxies y rotar IPs.
*   **Autenticación de Múltiples Factores (MFA):** Esta técnica es ineficaz contra cuentas que tienen habilitada la MFA, ya que la contraseña por sí sola no es suficiente para obtener acceso. Esto subraya la importancia de habilitar la MFA en todas las cuentas posibles.

---
*Nota: La información proporcionada aquí es para fines educativos y de concienciación sobre seguridad. No uses esta herramienta para actividades maliciosas o ilegales.*
