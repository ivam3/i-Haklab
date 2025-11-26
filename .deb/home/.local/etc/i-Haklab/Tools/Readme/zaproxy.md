# ZAProxy (OWASP ZAP)

## ¿Qué es ZAProxy?

ZAProxy, comúnmente conocido como **OWASP ZAP (Zed Attack Proxy)**, es un **escáner de seguridad de aplicaciones web** de código abierto y gratuito. Es una de las herramientas más populares y utilizadas en el mundo para encontrar vulnerabilidades en aplicaciones web durante las fases de desarrollo y prueba.

ZAP funciona como un **proxy intermediario** (Man-in-the-Middle). Esto significa que se interpone entre el navegador del usuario y la aplicación web, interceptando todas las peticiones y respuestas HTTP. Esta posición le permite inspeccionar el tráfico, modificarlo y lanzar ataques activos.

## ¿Para qué es útil?

OWASP ZAP es una herramienta integral para la seguridad de aplicaciones web, adecuada para una amplia gama de usuarios, desde desarrolladores hasta pentesters experimentados.

*   **Búsqueda de Vulnerabilidades:** Identifica una gran variedad de vulnerabilidades comunes en aplicaciones web, como:
    *   Inyección SQL (SQLi)
    *   Cross-Site Scripting (XSS)
    *   Inclusión de Archivos Locales (LFI) / Remotos (RFI)
    *   Fallas de configuración de seguridad
    *   Autenticación y gestión de sesiones deficientes
*   **Proxy Intermediario:** Permite inspeccionar, modificar y reenviar peticiones HTTP/S de forma manual, lo que es esencial para la depuración y la prueba manual de vulnerabilidades.
*   **Escaneo Automático Activo:** Lanza ataques automatizados contra el objetivo para encontrar vulnerabilidades.
*   **Escaneo Automático Pasivo:** Analiza el tráfico que pasa a través del proxy sin lanzar ataques directos, buscando indicadores de vulnerabilidades.
*   **Fuzzer:** Permite enviar payloads personalizados a las peticiones para descubrir cómo reacciona la aplicación.
*   **Spidering/Crawling:** Descubre todas las páginas, enlaces y funcionalidades de un sitio web.
*   **Soporte de API:** Puede ser automatizado y controlado a través de su API, lo que lo hace ideal para la integración en entornos de CI/CD (DevSecOps).

## ¿Cómo se usa? (Ejemplos básicos)

OWASP ZAP se puede usar en modo GUI o en modo de línea de comandos (Headless). El modo GUI es el más común para la interacción manual.

### Modo GUI (General)

1.  **Iniciar ZAP:** Abre la aplicación ZAP.
2.  **Configurar el Proxy:** Configura tu navegador web para usar ZAP como proxy (normalmente `localhost:8080`).
3.  **Explorar la Aplicación:** Navega por la aplicación web que deseas probar. ZAP interceptará todo el tráfico y construirá un mapa del sitio.
4.  **Lanzar Ataques:** Una vez que ZAP ha "conocido" la aplicación, puedes lanzar un "Escaneo Activo" o "Escaneo Pasivo" desde la interfaz para buscar vulnerabilidades.

### Modo de Línea de Comandos (Automatización)

Para la automatización, ZAP se puede ejecutar en modo "headless" (sin GUI) y controlarse a través de scripts.

**Ejemplo 1: Escaneo rápido automatizado**

Este comando inicia ZAP, rastrea un sitio web y luego ejecuta un escaneo activo.

```bash
zap.sh -cmd -port 8080 -host 127.0.0.1 -config api.disablekey=true -newsession $(date +%F) -target http://example.com -spider -scan -silent
```
*   `zap.sh`: El ejecutable de ZAP (puede ser `zap.bat` en Windows).
*   `-cmd`: Indica que se ejecute en modo de línea de comandos.
*   `-target`: La URL del sitio web a escanear.
*   `-spider`: Rastrea el sitio.
*   `-scan`: Lanza un escaneo activo.
*   `-silent`: Ejecuta el escaneo sin interacción.

**Ejemplo 2: Generar un informe HTML**

Puedes generar informes de los hallazgos.

```bash
zap.sh -cmd -port 8080 -host 127.0.0.1 -config api.disablekey=true -newsession $(date +%F) -target http://example.com -spider -scan -silent -htmlreport /path/to/report.html
```

## Consideraciones Adicionales

*   **Curva de Aprendizaje:** ZAP es una herramienta muy potente con muchas funcionalidades. Puede llevar tiempo dominarla por completo.
*   **Falsos Positivos:** Como cualquier escáner de vulnerabilidades, ZAP puede generar falsos positivos. Los hallazgos siempre deben ser verificados manualmente.
*   **Legalidad y Ética:** El uso de ZAP para escanear y atacar aplicaciones web sin el permiso explícito y por escrito del propietario es ilegal. Debe usarse estrictamente en entornos autorizados de pruebas de penetración o en tus propias aplicaciones.

---
*Nota: OWASP ZAP es un pilar fundamental en la seguridad de aplicaciones web y una herramienta indispensable para cualquiera que se dedique a probar o defender sitios web.*
