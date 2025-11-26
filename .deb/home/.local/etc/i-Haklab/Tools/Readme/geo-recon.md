
# Geo-Recon

## ¿Qué es Geo-Recon?

Geo-Recon es una herramienta de OSINT (Inteligencia de Fuentes Abiertas) desarrollada en Python. Su función principal es realizar un reconocimiento geográfico y de reputación de direcciones IP. Permite a los analistas de seguridad y entusiastas obtener rápidamente información detallada sobre una IP, como su ubicación geográfica (país, ciudad, región), el proveedor de servicios de Internet (ISP), y la organización a la que pertenece.

## ¿Para qué es útil la herramienta?

Esta herramienta es especialmente útil en las fases iniciales de una investigación de seguridad o de una prueba de penetración. Sus principales aplicaciones son:

-   **Reconocimiento y Footprinting:** Permite a un atacante o a un analista de seguridad obtener una idea de la infraestructura física y lógica de un objetivo a partir de una dirección IP.
-   **Análisis de Logs:** Ayuda a identificar el origen geográfico de actividades sospechosas encontradas en los registros (logs) de servidores, firewalls o aplicaciones.
-   **Investigación de Amenazas:** Facilita la atribución inicial de un ataque o de una campaña maliciosa al identificar la procedencia de las direcciones IP involucradas.
-   **Validación de la superficie de ataque:** Permite a una organización verificar qué información geográfica es públicamente accesible a través de sus IPs.

## ¿Cómo se usa?

Geo-Recon es una herramienta de línea de comandos. Se invoca directamente desde la terminal, pasándole como argumento la dirección IP que se desea investigar.

### Sintaxis básica

```bash
python3 geo-recon.py <dirección_ip>
```

-   `<dirección_ip>`: La dirección IP pública que se quiere investigar.

### Ejemplo de uso

1.  **Consultar una dirección IP:**
    Para obtener la información de geolocalización de la IP `8.8.8.8` (DNS público de Google), se ejecutaría el siguiente comando:

    ```bash
    python3 geo-recon.py 8.8.8.8
    ```

    La herramienta se conectará a diversas APIs y servicios de geolocalización para recopilar y presentar la información.

### Ejemplo de salida esperada

La salida del comando suele estar bien estructurada, mostrando los datos de forma clara:

```
[+] Realizando reconocimiento para: 8.8.8.8

- - - - - - - - - - - - - - - - - - - -
[+] Información de Geolocalización:
- - - - - - - - - - - - - - - - - - - -
    País:          United States
    Ciudad:        Mountain View
    Región:        California
    Coordenadas:   (37.422, -122.084)
    Organización:  Google LLC
    ISP:           Google LLC
- - - - - - - - - - - - - - - - - - - -
```

## Otras consideraciones

-   **Dependencias:** La herramienta puede requerir la instalación de ciertas librerías de Python. Generalmente se instalan con `pip install -r requirements.txt`.
-   **APIs:** El funcionamiento de Geo-Recon depende de servicios de terceros (APIs de geolocalización). Es posible que algunas de estas APIs requieran una clave (API Key) para su uso, la cual debería configurarse según las instrucciones de la herramienta.
-   **Limitaciones:** La precisión de la geolocalización de una IP puede variar. No siempre apunta a la ubicación física exacta del dispositivo, sino a la del proveedor de servicios de Internet.
