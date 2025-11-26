# WebScan

## ¿Qué es WebScan?

"WebScan" es un nombre genérico para una categoría de herramientas diseñadas para el **escaneo de vulnerabilidades en aplicaciones web**. En el contexto de esta colección de herramientas, se refiere a un script o programa de línea de comandos que automatiza la búsqueda de fallos de seguridad comunes en un sitio web.

Estas herramientas suelen ser un conjunto de utilidades que combinan varias funciones de reconocimiento y escaneo en una sola interfaz.

## ¿Para qué es útil?

Un WebScanner es una de las primeras herramientas que se utilizan en una prueba de penetración de una aplicación web. Su propósito es identificar rápidamente las "frutas maduras" (vulnerabilidades obvias y fáciles de encontrar).

Sus funciones suelen incluir:
*   **Recopilación de Información:** Obtener información básica sobre el servidor web, como las cabeceras HTTP, la tecnología utilizada (ej. Apache, Nginx), y el sistema operativo.
*   **Búsqueda de Paneles de Administración:** Intentar encontrar la página de inicio de sesión del administrador probando una lista de rutas comunes (ej. `/admin`, `/login`, etc.).
*   **Escaneo de Vulnerabilidades Comunes:** Buscar vulnerabilidades conocidas como:
    *   Inyección SQL (SQLi)
    *   Cross-Site Scripting (XSS)
    *   Inclusión de Archivos Locales (LFI) / Remotos (RFI)
*   **Búsqueda Inversa de IP:** Encontrar otros sitios web que están alojados en el mismo servidor que el objetivo.
*   **Uso de Dorks:** Integración con motores de búsqueda para encontrar sitios potencialmente vulnerables.

## ¿Cómo se usa? (Ejemplo conceptual)

Estas herramientas suelen ejecutarse desde la línea de comandos, proporcionando la URL del sitio web objetivo como parámetro.

**Sintaxis conceptual:**
```bash
python webscan.py -u http://example.com
```

La herramienta ejecutaría entonces sus diferentes módulos:
1.  Realizaría una petición para obtener las cabeceras del servidor.
2.  Empezaría a probar rutas para encontrar el panel de administración.
3.  Rastrearía el sitio en busca de URLs con parámetros (ej. `index.php?id=1`).
4.  Probaría esos parámetros con payloads básicos de SQLi y XSS.
5.  Finalmente, presentaría un informe en la terminal con todos los hallazgos.

## Consideraciones Adicionales

*   **Herramientas de Primera Pasada:** Los WebScanners como este son herramientas de reconocimiento inicial. Rara vez tienen la profundidad o la sofisticación de escáneres más avanzados y completos como **Nikto**, **Nmap** (con NSE), o **ZAP (Zed Attack Proxy)**.
*   **Ruido y Detección:** Estos escaneos son muy "ruidosos" y son fácilmente detectados y bloqueados por Firewalls de Aplicaciones Web (WAF) y Sistemas de Detección de Intrusos (IDS).
*   **Falsos Positivos:** Pueden generar muchos falsos positivos (alertas sobre vulnerabilidades que no existen realmente). Los hallazgos siempre deben ser verificados manualmente por un pentester.
*   **Legalidad:** El escaneo de vulnerabilidades en un sitio web sin el permiso explícito del propietario es ilegal.

---
*Nota: Un WebScanner es una herramienta útil para una evaluación rápida, pero nunca debe ser la única herramienta utilizada en una auditoría de seguridad seria.*
