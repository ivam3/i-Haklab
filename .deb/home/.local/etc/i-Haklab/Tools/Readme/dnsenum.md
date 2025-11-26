# dnsenum

## ¿Qué es dnsenum?

`dnsenum` es un script de Perl, potente y multihilo, diseñado para la **enumeración de información DNS** de un dominio. Es una de las herramientas más utilizadas durante la fase de reconocimiento (o recolección de información) de una prueba de penetración para mapear la infraestructura de red de un objetivo.

El objetivo de `dnsenum` es ser lo más completo posible, intentando obtener toda la información que pueda de los servidores DNS de un dominio, lo que a menudo revela datos críticos sobre la superficie de ataque de una organización.

## ¿Para qué es útil la herramienta?

`dnsenum` automatiza el proceso de consultar una gran cantidad of información relacionada con el DNS. Esto es útil para:

*   **Mapeo de la Infraestructura:** Descubrir las direcciones IP de los servidores web, servidores de correo y otros servidores de nombres del dominio.
*   **Descubrimiento de Hosts y Subdominios:** Encontrar subdominios (como `dev.example.com`, `intranet.example.com`) que pueden no ser públicos y que a menudo tienen menos seguridad que el sitio principal.
*   **Identificar la Superficie de Ataque:** Al encontrar más hosts y direcciones IP pertenecientes a una organización, se amplía la superficie de ataque que un pentester puede investigar en busca de vulnerabilidades.
*   **Encontrar Mala Configuraciones de DNS:** Su capacidad para intentar transferencias de zona puede revelar una mala configuración de seguridad crítica en los servidores DNS.

## Funcionalidades Clave

`dnsenum` realiza una secuencia de operaciones para recopilar información:

1.  **Obtiene los Registros Básicos:** Comienza por obtener los registros fundamentales del dominio:
    *   `A`: La dirección IP del host.
    *   `NS`: Los servidores de nombres autorizados para el dominio.
    *   `MX`: Los servidores de correo.

2.  **Intenta una Transferencia de Zona (AXFR):** Esta es una de sus funciones más importantes. Una transferencia de zona es como pedirle a un servidor DNS que te entregue su "agenda telefónica" completa, con una lista de todos los hosts y direcciones IP que conoce para ese dominio. Si un servidor DNS está mal configurado y permite transferencias de zona a cualquiera, esto puede entregar un mapa completo de la red interna.

3.  **Enumeración de Subdominios por Fuerza Bruta:** Utiliza una lista de palabras incorporada para intentar adivinar subdominios comunes (como `www`, `ftp`, `mail`, `test`, `dev`, etc.).

4.  **Scraping de Google:** Realiza búsquedas específicas en Google (usando dorks como `site:example.com`) para encontrar subdominios que Google haya indexado.

5.  **Búsquedas Inversas (Reverse Lookups):** Una vez que ha recopilado un conjunto de direcciones IP, realiza búsquedas inversas para ver si puede encontrar más nombres de host asociados a esas IPs.

## ¿Cómo se usa? (Ejemplo básico)

`dnsenum` es una herramienta de línea de comandos.

**Sintaxis básica:**
```bash
dnsenum [dominio_objetivo]
```

### Ejemplo 1: Escaneo estándar

Este es el comando más común. Realizará todas sus comprobaciones por defecto contra el dominio `example.com`.

```bash
dnsenum example.com
```

**Salida de ejemplo (abreviada):**
```
dnsenum.pl v1.2.6
...
-----   example.com   -----

Host's Address:
__________________
example.com.                     3600    IN    A        93.184.216.34

Name Servers:
__________________
example.com.                     172800  IN    NS      a.iana-servers.net.
example.com.                     172800  IN    NS      b.iana-servers.net.

Mail Servers:
__________________
...

Trying Zone Transfer for example.com on a.iana-servers.net ...
AXFR failed for example.com on a.iana-servers.net: Operation refused

Bruteforcing with /usr/share/dnsenum/dns.txt:
__________________
www.example.com.                 3600    IN    A        93.184.216.34
...

Google scraping:
__________________
(Se mostrarían los subdominios encontrados en Google)
...
```

### Ejemplo 2: Escaneo más agresivo

```bash
dnsenum --noreverse -f /ruta/a/wordlist.txt -r example.com
```
*   `--noreverse`: Desactiva las búsquedas inversas, que pueden ser lentas.
*   `-f /ruta/a/wordlist.txt`: Especifica una lista de palabras personalizada para la fuerza bruta de subdominios.
*   `-r`: Intenta realizar un escaneo recursivo en los subdominios descubiertos.

## Consideraciones Adicionales

*   **Legalidad:** `dnsenum` es una herramienta de reconocimiento. Aunque la mayoría de sus operaciones son consultas de DNS legales, algunas (como la fuerza bruta intensa o los intentos de transferencia de zona) pueden ser consideradas hostiles por el propietario del dominio y pueden alertar a los sistemas de seguridad.
*   **Preinstalado en Kali Linux:** `dnsenum` es una herramienta clásica y viene preinstalada en distribuciones de pentesting como Kali Linux.
*   **Alternativas Modernas:** Aunque `dnsenum` sigue siendo útil, han surgido muchas herramientas más nuevas y rápidas para la enumeración de subdominios, como `amass`, `subfinder`, y `assetfinder`, que a menudo utilizan APIs de múltiples fuentes para ser más rápidas y completas.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. Utiliza esta herramienta de forma responsable.*
