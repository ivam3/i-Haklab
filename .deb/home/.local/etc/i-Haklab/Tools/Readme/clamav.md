# ClamAV (Clam AntiVirus)

## ¿Qué es ClamAV?

ClamAV (Clam AntiVirus) es un **motor antivirus de código abierto** diseñado para detectar troyanos, virus, malware y otras amenazas maliciosas. Aunque fue desarrollado originalmente para sistemas Unix, es una herramienta multiplataforma que se ha convertido en el estándar de facto para el escaneo de correo electrónico en servidores de correo.

A diferencia de los antivirus de escritorio a los que muchos usuarios están acostumbrados, ClamAV es principalmente un motor de línea de comandos. No tiene su propia interfaz gráfica de usuario (GUI), aunque existen proyectos de terceros que la proporcionan (como ClamWin para Windows o ClamTk para Linux).

## ¿Para qué es útil la herramienta?

ClamAV es una solución flexible y ampliamente utilizada, especialmente en entornos de servidor. Sus principales casos de uso son:

*   **Escaneo de Servidores de Correo:** Este es su uso más común. Se integra con los servidores de correo (como Postfix o Exim) para escanear los correos electrónicos entrantes y salientes en busca de archivos adjuntos maliciosos, deteniendo el malware antes de que llegue a los usuarios.
*   **Escaneo de Servidores de Archivos:** Se puede utilizar para escanear periódicamente los archivos almacenados en un servidor web o en un servidor de archivos en busca de malware.
*   **Protección de Endpoints:** En sistemas Linux, puede funcionar como un antivirus tradicional, escaneando archivos bajo demanda o incluso proporcionando protección en tiempo real (escaneo al acceso) si se configura correctamente.
*   **Análisis Forense y Respuesta a Incidentes:** Los analistas de seguridad pueden usar ClamAV para escanear sistemas sospechosos o imágenes de disco en busca de malware conocido.
*   **Puertas de Enlace (Gateways):** Se integra en gateways de red para escanear el tráfico en busca de amenazas.

## Componentes Principales de ClamAV

ClamAV se compone de varias utilidades de línea de comandos:

*   **`clamscan`:** Es el escáner de línea de comandos principal. Se utiliza para realizar escaneos bajo demanda de archivos o directorios.
*   **`freshclam`:** Es la herramienta de actualización. Se encarga de descargar las últimas definiciones de virus (la base de datos de firmas) desde los servidores de ClamAV. Es crucial mantener esta base de datos actualizada para una detección eficaz.
*   **`clamd`:** Es la versión demonio (servicio en segundo plano) del escáner. Se carga en memoria y espera instrucciones, lo que permite un escaneo mucho más rápido, ya que no tiene que cargar las firmas de la base de datos cada vez que se inicia. `clamdscan` es el cliente que se comunica con `clamd`.

## ¿Cómo se usa? (Ejemplos básicos)

El uso de ClamAV se realiza principalmente desde la terminal.

### 1. Actualizar la Base de Datos de Virus

Antes de realizar cualquier escaneo, siempre debes asegurarte de que tus firmas de virus estén actualizadas.

```bash
sudo freshclam
```

### 2. Escanear un Archivo

Para escanear un solo archivo en busca de malware:

```bash
clamscan archivo_sospechoso.exe
```

### 3. Escanear un Directorio Completo

Para escanear un directorio (por ejemplo, el directorio `Descargas` del usuario actual) de forma recursiva:

```bash
clamscan -r ~/Descargas
```
*   `-r`: Escanea directorios de forma recursiva.

### 4. Escaneo con Opciones Recomendadas

Un comando de escaneo más completo y útil podría ser:

```bash
clamscan -r -i --move=/ruta/a/cuarentena /ruta/a/escanear
```
*   `-r`: Recursivo.
*   `-i`: Solo muestra los archivos infectados en el informe.
*   `--move=/ruta/a/cuarentena`: Mueve los archivos infectados a un directorio de cuarentena en lugar de simplemente reportarlos. **¡Usa esta opción con cuidado!**

**Salida de ejemplo:**

```
----------- SCAN SUMMARY -----------
Known viruses: 8652345
Engine version: 0.103.7
Scanned directories: 15
Scanned files: 102
Infected files: 1

/home/user/Descargas/malware.exe: Eicar-Test-Signature FOUND

----------- INFECTED FILES -----------
/home/user/Descargas/malware.exe: Eicar-Test-Signature FOUND

...
```

## Consideraciones Adicionales

*   **Detección Basada en Firmas:** ClamAV se basa principalmente en firmas para detectar malware. Esto significa que es muy bueno para detectar amenazas conocidas, pero puede no ser tan eficaz contra malware nuevo o desconocido (ataques de día cero) que aún no tienen una firma.
*   **Rendimiento:** El escaneo de archivos puede consumir una cantidad considerable de CPU y recursos de E/S, especialmente en sistemas con muchos archivos. El uso del demonio `clamd` ayuda a mitigar parte de la sobrecarga.
*   **Licencia:** ClamAV es de código abierto y mantenido por Cisco Talos, lo que lo convierte en una solución de confianza y transparente en la industria de la seguridad.

---
*Nota: ClamAV es una herramienta poderosa para una estrategia de defensa en profundidad. Asegúrate de entender las implicaciones de rendimiento y de las acciones que tomas sobre los archivos detectados (como moverlos o eliminarlos).*
