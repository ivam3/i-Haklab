
# HatCloud

## ¿Qué es HatCloud?

HatCloud es una herramienta escrita en Ruby diseñada para ayudar a los profesionales de la seguridad a eludir la protección de Cloudflare y descubrir la dirección IP real de un servidor web protegido por este servicio. Cloudflare actúa como un proxy inverso, ocultando la IP de origen del servidor, lo que dificulta que los atacantes o investigadores de seguridad apunten directamente al servidor.

HatCloud no explota vulnerabilidades en Cloudflare directamente, sino que utiliza bases de datos públicas (como la que se encontraba en CrimeFlare.Biz) y otras técnicas de OSINT para encontrar registros históricos o direcciones IP expuestas que Cloudflare no está ocultando activamente.

## ¿Para qué es útil la herramienta?

HatCloud es una herramienta específica dentro del arsenal de un pentester o un investigador de seguridad para la fase de reconocimiento:

-   **Descubrimiento de IP Real:** Su propósito principal es revelar la IP real de un servidor web protegido por Cloudflare. Una vez que se conoce la IP real, se pueden realizar ataques directos al servidor de origen, evitando la protección de Cloudflare.
-   **Análisis de Superficie de Ataque:** Ayuda a entender la verdadera infraestructura de una organización y a identificar posibles puntos débiles que no están detrás de la protección de Cloudflare.
-   **Evaluación de Configuración:** Puede ser útil para que las organizaciones verifiquen si sus configuraciones de Cloudflare son robustas y no están filtrando la IP real.

## ¿Cómo se usa?

HatCloud es una herramienta de línea de comandos basada en Ruby.

### 1. Instalación

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/HatBashBR/HatCloud.git
    ```

2.  **Navegar al directorio:**
    ```bash
    cd HatCloud
    ```

3.  **Instalar dependencias (si es necesario):**
    ```bash
    gem install <nombre_de_la_gema> # Reemplaza con las gemas necesarias si no están instaladas
    ```

### 2. Ejemplos de Uso

Para ejecutar HatCloud y buscar la IP real de un sitio web, usa el siguiente comando, reemplazando `tu_sitio.com` con el dominio objetivo:

```bash
ruby hatcloud.rb --byp tu_sitio.com
```
O su forma abreviada:
```bash
ruby hatcloud.rb -b tu_sitio.com
```

La herramienta entonces consultará sus fuentes y mostrará cualquier dirección IP real que pueda descubrir.

## Otras consideraciones

-   **Herramienta Discontinuada:** Es importante tener en cuenta que el repositorio oficial de HatCloud en GitHub está marcado como "discontinued" (descontinuado). Esto significa que es posible que ya no reciba actualizaciones o soporte, y su efectividad puede disminuir con el tiempo a medida que Cloudflare actualiza sus sistemas y las bases de datos de IP se vuelven obsoletas.
-   **Precisión:** La capacidad de HatCloud para encontrar la IP real depende en gran medida de la existencia de información pública o configuraciones erróneas pasadas. No garantiza el éxito en todos los casos.
-   **Legalidad y Ética:** El uso de HatCloud debe ser ético y legal. Solo debe emplearse en sistemas para los que se tenga autorización explícita para realizar pruebas de seguridad.
