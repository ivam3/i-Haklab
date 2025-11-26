# Sherlock

## ¿Qué es Sherlock?

Sherlock es una potente herramienta de línea de comandos de código abierto para **OSINT (Inteligencia de Fuentes Abiertas)**. Su función principal es buscar un nombre de usuario específico a través de una vasta cantidad de redes sociales y plataformas en línea para encontrar perfiles asociados.

En esencia, si una persona utiliza el mismo nombre de usuario en múltiples sitios (como `johndoe` en Twitter, Instagram, y GitHub), Sherlock puede encontrarlos rápidamente.

## ¿Para qué es útil?

Sherlock es una de las herramientas de referencia en la fase de reconocimiento de una investigación de seguridad o una auditoría. Sus principales usos son:

*   **Recopilación de Inteligencia (OSINT):** Es la herramienta perfecta para investigadores, periodistas o curiosos que intentan mapear la huella digital de una persona a partir de un solo dato: su nombre de usuario.
*   **Pruebas de Penetración (Pentesting):** En la fase de reconocimiento, los pentesters utilizan Sherlock para recopilar información sobre un objetivo. Las cuentas de redes sociales pueden revelar información personal, intereses, contactos, ubicación y otros datos que podrían ser utilizados en un ataque de ingeniería social.
*   **Investigación de la Huella Digital:** Permite a cualquier persona comprobar qué perfiles están asociados a su propio nombre de usuario en internet, ayudando a gestionar su privacidad y su presencia en línea.

## ¿Cómo se usa? (Ejemplo básico)

Sherlock se ejecuta desde la línea de comandos y es muy fácil de usar.

**Sintaxis básica:**

```bash
sherlock [nombre_de_usuario]
```

**Ejemplo:**

Supongamos que quieres buscar el nombre de usuario `johndoe`.

```bash
sherlock johndoe
```

Sherlock comenzará a escanear cientos de sitios web. La salida se mostrará en la terminal, con un `[+]` verde para los sitios donde se encontró el nombre de usuario y un `[-]` rojo para los que no.

**Ejemplo de salida:**

```
[*] Checking username johndoe on:
[+] GitHub: https://github.com/johndoe
[+] Instagram: https://instagram.com/johndoe
[-] Facebook: Not Found
[+] Twitter: https://twitter.com/johndoe
...
```

**Guardar los resultados en un archivo:**

Puedes guardar los resultados en un archivo de texto para un análisis posterior.

```bash
sherlock johndoe -o resultados.txt
```

**Buscar múltiples usuarios:**

Puedes buscar varios nombres de usuario a la vez.

```bash
sherlock usuario1 usuario2 usuario3
```

## Consideraciones Adicionales

*   **Falsos Positivos:** Aunque Sherlock es bastante preciso, es posible que encuentre "falsos positivos". Por ejemplo, puede que exista un perfil con el nombre de usuario `johndoe`, pero que no pertenezca a la persona que estás investigando. Siempre es necesaria la verificación manual.
*   **Tiempos de Escaneo:** Un escaneo completo puede tardar varios minutos, ya que la herramienta realiza peticiones a cientos de sitios web.
*   **Legalidad y Ética:** Sherlock utiliza únicamente información pública y no requiere credenciales ni APIs. Sin embargo, la forma en que se utiliza la información recopilada puede tener implicaciones legales y éticas. Utilízala de forma responsable y en el marco de la ley.

---
*Nota: Sherlock es una herramienta de recopilación de información pasiva. No interactúa con las cuentas encontradas, simplemente verifica su existencia.*
