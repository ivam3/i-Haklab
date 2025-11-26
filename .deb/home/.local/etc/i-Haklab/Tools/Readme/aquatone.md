# Aquatone

## ¿Qué es Aquatone?

Aquatone es una herramienta de reconocimiento para la inspección visual de sitios web. Su objetivo principal es ayudar a los profesionales de la seguridad a obtener una visión general rápida de la superficie de ataque basada en HTTP de un objetivo.

La idea es simple pero potente: en lugar de revisar manualmente cientos o miles de dominios y subdominios, Aquatone los visita, toma una captura de pantalla de cada uno y los presenta en un informe fácil de digerir. Esto permite al analista identificar visualmente aplicaciones interesantes, páginas de inicio de sesión, paneles de administración, errores de configuración, o sitios web obsoletos que podrían ser vulnerables.

## ¿Para qué es útil la herramienta?

Aquatone es una herramienta fundamental en la fase de reconocimiento de una prueba de penetración o en la caza de recompensas (bug bounty). Sus usos principales son:

*   **Descubrimiento rápido de activos web:** A partir de una lista de dominios o subdominios, Aquatone descubre cuáles tienen servidores web en ejecución.
*   **Inspección visual a gran escala:** Permite "ver" cómo son cientos de sitios web a la vez, lo que es mucho más rápido que visitarlos uno por uno.
*   **Priorización de objetivos:** Ayuda a los pentesters a decidir qué sitios web parecen más prometedores para investigar más a fondo. Una página de error, un panel de login, o una aplicación web compleja suelen ser más interesantes que una página estática.
*   **Recopilación de información:** Además de las capturas de pantalla, Aquatone también recopila las cabeceras de respuesta HTTP de cada sitio, lo que puede revelar información sobre la tecnología del servidor (por ejemplo, `Server: nginx`, `X-Powered-By: PHP/7.4`).
*   **Agrupación visual:** El informe final agrupa las capturas de pantalla que son visualmente similares, lo que facilita la identificación de aplicaciones que utilizan la misma plantilla o tecnología.

## ¿Cómo se usa? (Ejemplo básico)

El uso moderno de Aquatone se centra en su capacidad de tomar capturas de pantalla a partir de una lista de URLs. A menudo se combina con otras herramientas.

**Flujo de trabajo típico:**

1.  **Descubrimiento de subdominios:** Usa una herramienta como **Amass** o **subfinder** para generar una lista de subdominios para un objetivo.
2.  **Sondeo de puertos HTTP:** Usa una herramienta como **httprobe** o **httpx** para determinar cuáles de esos subdominios tienen un servidor web activo y en qué puerto (80, 443, etc.).
3.  **Captura de pantalla con Aquatone:** Pasa la lista de URLs activas a Aquatone para que tome las capturas de pantalla y genere el informe.

**Ejemplo de flujo de trabajo completo:**

Supongamos que queremos analizar el dominio `example.com`.

**Paso 1: Encontrar subdominios (con `amass`)**
```bash
amass enum -d example.com -o subdomains.txt
```

**Paso 2: Encontrar servidores web activos (con `httpx`)**
```bash
cat subdomains.txt | httpx -o urls.txt
```
El archivo `urls.txt` ahora contendrá URLs como `http://www.example.com`, `https://app.example.com`, etc.

**Paso 3: Usar Aquatone**
Ahora, pasamos la lista de URLs a Aquatone.

```bash
cat urls.txt | aquatone
```

Aquatone comenzará a visitar cada URL en un navegador sin cabeza (headless), tomará una captura de pantalla, recogerá las cabeceras y guardará todo en una carpeta de salida, generalmente `~/aquatone/[nombre_del_objetivo]/`.

**El Informe Final**

Dentro de la carpeta de salida, encontrarás:

*   `screenshots/`: La carpeta con todas las imágenes PNG.
*   `headers/`: Archivos de texto con las cabeceras de cada sitio.
*   `report.html`: El archivo más importante. Ábrelo en tu navegador para ver el informe interactivo con todas las capturas de pantalla y la información recopilada.

## Consideraciones Adicionales

*   **Dependencias:** Aquatone depende de **Google Chrome** o **Chromium** para poder tomar las capturas de pantalla. Debe estar instalado en tu sistema.
*   **Configuración:** Puedes configurar el número de hilos (threads) para acelerar el proceso, así como el tamaño de las capturas de pantalla y los tiempos de espera (timeouts).
*   **`aquatone-discover` y `aquatone-scan`:** Las versiones más antiguas de Aquatone tenían sus propios módulos de descubrimiento y escaneo de puertos. Las versiones más recientes se han enfocado en ser excelentes en una sola cosa: la parte de la captura y el reporte, esperando que el usuario proporcione las URLs a través de la entrada estándar (`stdin`).

---
*Nota: La información proporcionada aquí es para fines educativos y de reconocimiento ético. Asegúrate de tener permiso para escanear los objetivos.*
