# SQLiv

## ¿Qué es SQLiv?

SQLiv (Mass SQL Injection Vulnerability Scanner) es una herramienta de código abierto escrita en Python para el **descubrimiento de vulnerabilidades de inyección SQL**.

Su principal característica es la capacidad de realizar escaneos **masivos**. En lugar de probar un solo sitio web, SQLiv puede utilizar motores de búsqueda (como Google) y "dorks" para encontrar cientos de sitios web potencialmente vulnerables y luego intentar confirmar la vulnerabilidad en cada uno de ellos.

## ¿Para qué es útil?

SQLiv es una herramienta de reconocimiento y descubrimiento de vulnerabilidades. Sus principales usos son:

*   **Escaneo Masivo con Dorks:** Permite a los investigadores de seguridad y pentesters encontrar rápidamente sitios web vulnerables a la inyección SQL en internet utilizando consultas de búsqueda especializadas (Google Dorks).
*   **Escaneo Dirigido:** También puede ser utilizado para escanear un único dominio objetivo. La herramienta puede "crawlear" (rastrear) el sitio en busca de URLs con parámetros y luego probar cada parámetro para detectar una posible inyección SQL.
*   **Análisis de Múltiples Dominios:** Puedes proporcionarle una lista de dominios y SQLiv los analizará en busca de vulnerabilidades.
*   **Automatización:** Al ser una herramienta de línea de comandos, es útil para la automatización de las fases iniciales de una prueba de penetración.

## ¿Cómo se usa? (Ejemplos básicos)

SQLiv se ejecuta desde la línea de comandos y tiene varios modos de operación.

**Ejemplo 1: Escaneo masivo usando un Google Dork**

Este comando utiliza un dork común para encontrar páginas `.php` con un parámetro `id` y luego prueba si son vulnerables.

```bash
python sqliv.py -d "inurl:index.php?id=" -e google
```
*   `-d`: El dork de búsqueda.
*   `-e`: El motor de búsqueda a utilizar (google, bing, etc.).

SQLiv primero buscará los sitios en Google y luego los probará uno por uno.

**Ejemplo 2: Escaneo de un único sitio web (dirigido)**

Este comando escaneará el sitio web `http://testphp.vulnweb.com/` en busca de vulnerabilidades.

```bash
python sqliv.py -t http://testphp.vulnweb.com/
```
*   `-t`: La URL del objetivo.

La herramienta rastreará el sitio, encontrará URLs con parámetros como `cat.php?id=1`, y las probará.

**Ejemplo 3: Escaneo Inverso de Dominio**

Este modo encuentra otros sitios web alojados en el mismo servidor que el objetivo y los escanea también.

```bash
python sqliv.py -t http://testphp.vulnweb.com/ -r
```
*   `-r`: Habilita el modo de escaneo inverso de dominio.

## Consideraciones Adicionales

*   **No es un Explotador Completo:** SQLiv está diseñado principalmente para el **descubrimiento** de vulnerabilidades. Aunque puede confirmar la existencia de una inyección SQL, no es una herramienta de explotación completa como `sqlmap`. Su propósito es encontrar los objetivos, que luego pueden ser analizados más a fondo con otras herramientas.
*   **Ruido:** Los escaneos masivos pueden generar mucho "ruido" y ser detectados por sistemas de seguridad.
*   **Legalidad y Ética:** El escaneo de sitios web en busca de vulnerabilidades sin el permiso explícito del propietario es ilegal. SQLiv debe ser utilizado únicamente en programas de bug bounty, pruebas de penetración autorizadas o en tus propias aplicaciones.

---
*Nota: SQLiv es una herramienta potente para encontrar vulnerabilidades a gran escala. Su uso debe ser ético y responsable.*
