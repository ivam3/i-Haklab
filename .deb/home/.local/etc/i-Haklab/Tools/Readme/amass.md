# OWASP Amass

## ¿Qué es Amass?

OWASP Amass es una potente herramienta de código abierto para el reconocimiento de redes y la recopilación de información. Es ampliamente utilizada por profesionales de la seguridad para realizar un mapeo exhaustivo de la superficie de ataque externa de una organización. Amass puede descubrir subdominios, direcciones IP, y otra información crítica utilizando una variedad de técnicas de reconocimiento, tanto activas como pasivas.

Forma parte del Proyecto OWASP (Open Web Application Security Project), lo que garantiza que es una herramienta mantenida y de confianza en la comunidad de la ciberseguridad.

## ¿Para qué es útil la herramienta?

Amass es una de las herramientas más completas para la fase de reconocimiento en una prueba de penetración o auditoría de seguridad. Sus principales usos son:

*   **Enumeración de subdominios:** Descubre subdominios de un dominio objetivo, a menudo revelando aplicaciones o servicios olvidados o menos seguros.
*   **Descubrimiento de activos:** Identifica la infraestructura de red de una organización, incluyendo servidores, balanceadores de carga y otros dispositivos conectados a internet.
*   **Mapeo de la superficie de ataque:** Proporciona una visión completa de todos los activos expuestos de una organización en internet, ayudando a los profesionales de la seguridad a entender dónde podrían existir vulnerabilidades.
*   **Recopilación de inteligencia:** Utiliza docenas de fuentes de datos para recopilar información, incluyendo:
    *   Registros DNS y transferencias de zona.
    *   Certificados de transparencia (Certificate Transparency logs).
    *   Motores de búsqueda y APIs públicas.
    *   Archivos web (como Archive.org).
    *   Scraping de páginas web.

## ¿Cómo se usa? (Ejemplos básicos)

Amass tiene varios subcomandos, pero el más utilizado es `intel` y `enum`.

**1. `amass enum` - Enumeración de Subdominios (Reconocimiento Activo y Pasivo)**

Este es el comando principal y más común. Realiza una enumeración exhaustiva de subdominios.

**Sintaxis básica:**

```bash
amass enum -d [dominio_objetivo]
```

**Ejemplo:**

Supongamos que quieres descubrir todos los subdominios del dominio `example.com`.

```bash
amass enum -d example.com
```

**Ejemplo con más intensidad (modo pasivo):**

Para una búsqueda más rápida y sigilosa que solo utiliza fuentes pasivas (sin enviar tráfico directo al objetivo):

```bash
amass enum -passive -d example.com
```

**Guardar los resultados:**

Es muy recomendable guardar siempre los resultados para un análisis posterior.

```bash
amass enum -d example.com -o resultados_amass.txt
```

**2. `amass intel` - Recopilación de Inteligencia**

Este comando te permite recopilar información sobre una organización o dominio a partir de las fuentes de datos de Amass.

**Ejemplo: Encontrar dominios asociados a una organización**

```bash
amass intel -org "OWASP"
```

**3. `amass viz` - Visualización de Resultados**

Amass puede generar archivos para visualizar la relación entre los activos descubiertos, lo cual es extremadamente útil para entender la infraestructura de red.

```bash
# Primero, guarda los resultados en la base de datos de Amass (por defecto)
amass enum -d example.com

# Luego, genera un archivo para visualización (por ejemplo, en formato D3.js)
amass viz -d3 -o mapa_example.html
```

## Consideraciones Adicionales

*   **Configuración de APIs:** Para obtener los mejores resultados, Amass puede integrarse con docenas de APIs de servicios externos (como VirusTotal, Shodan, etc.). Necesitarás obtener claves de API para estos servicios y configurarlas en el archivo de configuración de Amass.
*   **Tiempo de ejecución:** Un escaneo exhaustivo con Amass puede llevar mucho tiempo, desde minutos hasta varias horas, dependiendo de la complejidad del dominio objetivo y tu configuración.
*   **Legalidad:** Aunque muchas de las técnicas de Amass son pasivas, el reconocimiento activo puede ser detectado. Asegúrate de tener permiso antes de escanear un dominio que no te pertenece.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. No la utilices para actividades maliciosas.*
