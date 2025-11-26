# Sublist3r

## ¿Qué es Sublist3r?

Sublist3r (o Sublister) es una herramienta de línea de comandos escrita en Python, diseñada para la **enumeración de subdominios**. Su objetivo es encontrar tantos subdominios como sea posible para un dominio determinado, utilizando principalmente técnicas de OSINT (Inteligencia de Fuentes Abiertas).

En lugar de depender de una sola técnica, Sublist3r consulta una amplia gama de fuentes públicas para recopilar su información, incluyendo:
*   **Motores de búsqueda:** Google, Yahoo, Bing, Baidu, Ask.
*   **Servicios de análisis de seguridad:** VirusTotal, ThreatCrowd, DNSdumpster.
*   **Datos de certificados:** Netcraft.

## ¿Para qué es útil?

Sublist3r es una herramienta fundamental en la fase de reconocimiento de cualquier prueba de penetración o auditoría de seguridad.

*   **Mapeo de la Superficie de Ataque:** Ayuda a los pentesters y a los administradores de sistemas a descubrir activos (sitios web, servidores de correo, etc.) que pertenecen a una organización. A menudo, los subdominios olvidados o menos mantenidos son los más vulnerables.
*   **Descubrimiento de Activos para Bug Bounty:** Los cazadores de recompensas por errores (bug bounty hunters) lo utilizan para encontrar un espectro más amplio de aplicaciones web bajo el alcance de un programa, aumentando sus posibilidades de encontrar una vulnerabilidad.
*   **Inteligencia Competitiva:** Puede ser utilizado para analizar la infraestructura web de un competidor.

## ¿Cómo se usa? (Ejemplos básicos)

Sublist3r es muy fácil de usar desde la terminal.

**Ejemplo 1: Escaneo básico de un dominio**

Este es el uso más común. Simplemente especifica el dominio con la opción `-d`.

```bash
python sublist3r.py -d example.com
```
La herramienta comenzará a consultar todas sus fuentes y mostrará los subdominios encontrados en tiempo real.

**Ejemplo 2: Guardar los resultados en un archivo**

Es muy recomendable guardar siempre la salida para un análisis posterior.

```bash
python sublist3r.py -d example.com -o subdominios_example.txt
```
*   `-o`: Especifica el archivo de salida.

**Ejemplo 3: Escanear puertos en los subdominios encontrados**

Sublist3r puede realizar un escaneo básico de puertos en los subdominios que encuentra para ver qué servicios están corriendo.

```bash
python sublist3r.py -d example.com -p 80,443,8080
```
*   `-p`: Especifica una lista de puertos a escanear (separados por comas).

**Ejemplo 4: Usar un motor de búsqueda específico**

Puedes limitar la búsqueda a motores específicos si lo deseas.

```bash
python sublist3r.py -d example.com -e google,yahoo
```
*   `-e`: Especifica los motores de búsqueda a utilizar.

## Consideraciones Adicionales

*   **Técnica Pasiva:** La mayor parte de la recopilación de datos de Sublist3r es pasiva, lo que significa que obtiene la información de fuentes de terceros sin enviar tráfico directo al dominio objetivo. Esto lo hace relativamente sigiloso.
*   **Complemento, no reemplazo:** Aunque Sublist3r es excelente, para una enumeración completa, a menudo se combina con otras herramientas que utilizan diferentes técnicas, como el "brute-forcing" de subdominios (por ejemplo, `gobuster` o `amass` en modo activo).
*   **Legalidad y Ética:** Sublist3r recopila información disponible públicamente. Su uso es legal, pero la forma en que se utiliza la información descubierta está sujeta a la ética y la ley. Solo debe usarse para fines autorizados.

---
*Nota: Sublist3r es una de las primeras herramientas que se suelen ejecutar al iniciar una auditoría de seguridad de una aplicación web.*
