# afrog

## ¿Qué es afrog?

afrog es un escáner de vulnerabilidades de alto rendimiento, rápido y estable, escrito en Go. Está orientado a **Bug Bounty, Pentest y Red Teaming** y funciona en base a PoCs (pruebas de concepto) definibles por el usuario.

Soporta de forma nativa detección de CVE, CNVD, contraseñas por defecto, divulgación de información, identificación por fingerprint, accesos no autorizados, lectura arbitraria de archivos y ejecución de comandos. Su proyecto upstream es `https://github.com/zan8in/afrog`.

En Termux se distribuye desde el repositorio TUR como un binario compilado, por lo que no requiere Go ni compilación manual.

## ¿Para qué es útil la herramienta?

afrog es útil en la fase de detección y validación de vulnerabilidades web y de red:

-   **Bug Bounty y Pentest Web:** Valida rápidamente si un objetivo es vulnerable a CVEs conocidos y malas configuraciones.
-   **Escaneo Masivo:** Permite escanear una lista de objetivos desde un archivo con `-T urls.txt`.
-   **Filtrado por Severidad y Palabra Clave:** Permite enfocarse solo en lo crítico con `-S high,critical` o buscar PoCs por tecnología con `-s weblogic,jboss`.
-   **Reportes HTML Automáticos:** Genera un reporte HTML con la fecha del escaneo para documentar hallazgos.
-   **PoCs Personalizables:** Permite usar un directorio propio de PoCs con `-P mypocs/` y mantenerlos actualizados con `--updatepocs`.
-   **Pre-escaneo de Puertos:** Con `-ps` descubre puertos abiertos antes de lanzar los PoCs.

## ¿Cómo se usa?

### 1. Instalación

En Termux / i-Haklab (repositorio TUR):

```bash
pkg update
pkg install afrog
```

Verificar instalación:

```bash
afrog -v
afrog -h
```

### 2. Ejemplos de Uso Básico

1.  **Escaneo básico de un objetivo:**
    Escanea con todos los PoCs integrados y genera un reporte HTML automáticamente.

    ```bash
    afrog -t https://example.com
    ```

2.  **Escanear múltiples objetivos desde archivo:**
    Un objetivo por línea.

    ```bash
    afrog -T urls.txt
    ```

3.  **Filtrar por severidad:**
    Solo vulnerabilidades altas y críticas.

    ```bash
    afrog -t https://example.com -S high,critical
    ```

4.  **Buscar PoCs por tecnología:**
    Búsqueda difusa, se pueden separar varias por coma.

    ```bash
    afrog -t https://example.com -s weblogic,jboss
    afrog -t https://example.com -s tomcat,phpinfo
    ```

5.  **Usar PoCs personalizados y guardar reporte:**
    ```bash
    afrog -t https://example.com -P mypocs/ -o resultado.html
    ```

6.  **Actualizar PoCs integrados:**
    ```bash
    afrog --updatepocs
    ```

### 3. Opciones Comunes Adicionales

-   `-t, --target`: URL/host objetivo a escanear.
-   `-T, --targets`: archivo con lista de objetivos.
-   `-P, --pocs`: archivo `poc.yaml` o directorio de PoCs propio.
-   `-o, --output`: guardar reporte HTML, ej. `-o resultado.html`.
-   `-s, --search`: buscar PoC por palabra clave.
-   `-S, --severity`: filtrar por `info, low, medium, high, critical, unknown`.
-   `--silent`: sin progreso, solo resultados.
-   `--nofinger, --nf`: desactiva fingerprint.
-   `-ps, --portscan`: activa pre-escaneo de puertos.

## Otras Consideraciones

-   **Ruido:** Es un escáner activo, genera mucho tráfico y puede ser detectado por IDS/IPS/WAF.
-   **Falsos Positivos:** Aunque presume baja tasa de falsos positivos, todo hallazgo debe verificarse manualmente.
-   **Configuración inicial:** La primera vez crea `~/.config/afrog/afrog-config.yaml`. Si ves el error de `ceye reverse service not set`, debes configurar tu plataforma de DNS reverso (ceye, dnslog.cn, etc.) en ese archivo para verificar RCE sin eco.
-   **No es un Exploit:** Sus PoCs son comprobaciones teóricas, no lanza explotación real con fines destructivos.
-   **Legalidad y Ética:** Herramienta ofensiva. **Úsala solo contra objetivos propios o con autorización explícita y por escrito.** Escanear sin permiso es ilegal.

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
