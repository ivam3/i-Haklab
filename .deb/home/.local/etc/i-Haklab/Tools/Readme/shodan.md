# Shodan

## ¿Qué es Shodan?

Shodan es un **motor de búsqueda para dispositivos conectados a Internet**. A diferencia de Google, que indexa el contenido de la web (páginas HTML, texto, imágenes), Shodan indexa los "banners" de servicio de los dispositivos. Un banner de servicio es la información que un dispositivo envía cuando se le contacta en un puerto específico.

Esto permite a Shodan encontrar y catalogar:
-   Servidores web y routers
-   Cámaras de seguridad (webcams)
-   Sistemas de control industrial (SCADA)
-   Semáforos, centrales eléctricas, y sistemas de calefacción
-   Bases de datos, impresoras, y prácticamente cualquier cosa que esté conectada a internet.

Por esta razón, a menudo se le llama "el motor de búsqueda más aterrador del mundo".

## ¿Para qué es útil?

Shodan es una herramienta extremadamente poderosa tanto para la defensa como para el ataque en el ciberespacio.

**Para profesionales de la seguridad (defensivo):**
*   **Mapeo de la superficie de ataque:** Permite a las organizaciones ver sus propios activos desde la perspectiva de un atacante, descubriendo dispositivos olvidados o mal configurados que están expuestos a internet.
*   **Monitorización de vulnerabilidades:** Ayuda a identificar dispositivos que ejecutan software obsoleto o vulnerable (por ejemplo, "servidores Apache versión 1.3" o "cámaras con la contraseña por defecto").
*   **Inteligencia de amenazas:** Los investigadores lo usan para rastrear la propagación de malware, la actividad de botnets y tendencias generales en la seguridad de internet.

**Para pentesters y atacantes (ofensivo):**
*   **Reconocimiento:** Es una de las primeras paradas para encontrar objetivos fáciles. Un atacante puede buscar dispositivos vulnerables a un exploit específico.
*   **Identificación de "low-hanging fruit":** Permite encontrar sistemas con contraseñas por defecto, sin autenticación, o con servicios de administración expuestos.

## ¿Cómo se usa? (Ejemplos básicos)

Shodan se puede usar a través de su sitio web (shodan.io) o mediante una **interfaz de línea de comandos (CLI)**, que es lo que a menudo se instala en distribuciones de pentesting.

Para usar la CLI, primero necesitas inicializarla con tu clave de API (que puedes obtener registrándote en el sitio web de Shodan).

```bash
shodan init TU_CLAVE_DE_API
```

### Ejemplos de búsqueda con la CLI

**1. Búsqueda de información de un host:**

Obtiene toda la información que Shodan tiene sobre una IP específica.

```bash
shodan host 8.8.8.8
```

**2. Búsqueda simple:**

Busca dispositivos que coincidan con un término. Por ejemplo, para encontrar servidores Apache:

```bash
shodan search apache
```

**3. Uso de filtros:**

La verdadera potencia de Shodan reside en sus filtros. Los filtros se usan con el formato `filtro:valor`.

*   **Encontrar webcams en un país específico:**
    ```bash
    shodan search webcam country:ES
    ```
*   **Encontrar servidores con un puerto abierto (ej. MongoDB, puerto 27017) en una ciudad:**
    ```bash
    shodan search port:27017 city:"Madrid"
    ```
*   **Encontrar sistemas Windows XP:**
    ```bash
    shodan search os:"Windows XP"
    ```

## Consideraciones Adicionales

*   **API Key:** El acceso a Shodan (especialmente a través de la CLI y para búsquedas avanzadas) está limitado por tu clave de API. Las cuentas gratuitas tienen limitaciones significativas en el número de resultados y filtros que puedes usar.
*   **Legalidad:** Navegar por Shodan es completamente legal. Sin embargo, intentar acceder a los dispositivos que encuentras en Shodan sin autorización explícita es ilegal.
*   **Shodan Dorks:** Al igual que con Google, existen "Shodan Dorks", que son consultas de búsqueda predefinidas y optimizadas para encontrar sistemas interesantes o vulnerables.

---
*Nota: Shodan es una herramienta de inteligencia y reconocimiento. Trata la información que encuentres con responsabilidad y ética.*
