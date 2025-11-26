# VirusTotal CLI (vt-cli)

## ¿Qué es VirusTotal CLI?

VirusTotal CLI es la **interfaz de línea de comandos oficial** para el servicio VirusTotal. Permite a los usuarios interactuar con la plataforma de inteligencia de amenazas de VirusTotal directamente desde la terminal, sin necesidad de usar la interfaz web.

VirusTotal es un servicio en línea que analiza archivos y URLs con más de 70 escáneres de antivirus y servicios de listas de bloqueo de dominios, proporcionando un informe detallado sobre si el recurso es malicioso.

## ¿Para qué es útil?

Esta herramienta es extremadamente útil para analistas de malware, investigadores de seguridad (SOC, CTI), y administradores de sistemas.

*   **Análisis Rápido de Archivos:** Permite analizar rápidamente un archivo sospechoso (mediante su hash o subiéndolo directamente) para ver qué motores de antivirus lo detectan como malicioso.
*   **Investigación de URLs y Dominios:** Puedes analizar una URL, un dominio o una dirección IP para comprobar su reputación y ver si está asociado con malware o phishing.
*   **Automatización y Scripting:** Al ser una CLI, se puede integrar fácilmente en scripts para automatizar el análisis de múltiples indicadores de compromiso (IOCs). Por ejemplo, un script podría extraer todas las URLs de un correo electrónico de phishing y enviarlas a VirusTotal para su análisis.
*   **Inteligencia de Amenazas:** Permite realizar búsquedas avanzadas en la base de datos de VirusTotal (una función premium) para encontrar muestras de malware relacionadas, investigar campañas de atacantes y más.

## ¿Cómo se usa? (Ejemplos básicos)

Para usar `vt-cli`, primero necesitas configurar tu clave de API de VirusTotal. Puedes obtener una clave gratuita registrándote en su sitio web.

**Configuración inicial:**
```bash
vt init --apikey TU_CLAVE_DE_API
```

### Escanear y analizar

**1. Analizar un archivo:**

Puedes analizar un archivo local. La herramienta lo subirá y te dará los resultados.

```bash
vt scan file /ruta/al/archivo_sospechoso.exe
```

**2. Obtener información de un hash, URL, dominio o IP:**

Este es uno de los usos más comunes. El comando `vt get` (o `vt file`, `vt url`, etc.) recupera el último informe de análisis para un indicador.

*   **Por hash (MD5, SHA1, SHA256):**
    ```bash
    vt file <hash_del_archivo>
    ```
*   **Por URL:**
    ```bash
    vt url "http://sitio-malicioso.com/phishing"
    ```
*   **Por Dominio:**
    ```bash
    vt domain ejemplodemalware.com
    ```
*   **Por IP:**
    ```bash
    vt ip 8.8.8.8
    ```

**3. Búsqueda avanzada (requiere API premium):**

Permite buscar muestras de malware con características específicas.

```bash
vt intel "type:peexe size:100KB+ positives:5+"
```

## Consideraciones Adicionales

*   **Clave de API:** La funcionalidad de la herramienta está directamente ligada a tu tipo de clave de API. Las claves gratuitas tienen limitaciones estrictas en el número de solicitudes por minuto y por día, y no dan acceso a las funciones de inteligencia avanzadas.
*   **No es un Antivirus:** VirusTotal no elimina el malware de tu sistema. Es una herramienta de **análisis y opinión**. Te dice lo que la comunidad de antivirus piensa sobre un archivo o URL, pero no realiza ninguna acción de limpieza.
*   **Privacidad:** Ten en cuenta que cualquier archivo que subas a VirusTotal es compartido con la comunidad de investigadores de seguridad y empresas de antivirus. **No subas archivos que contengan información personal o sensible.** Utiliza el hash del archivo en su lugar siempre que sea posible.

---
*Nota: `vt-cli` es una herramienta fundamental para cualquier persona que trabaje en el campo de la ciberseguridad, desde la respuesta a incidentes hasta la inteligencia de amenazas.*
