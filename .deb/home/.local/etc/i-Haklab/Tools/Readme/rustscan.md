# rustscan

## ¿Qué es rustscan?

RustScan es un escáner de puertos moderno, rápido e inteligente, escrito en Rust. Su filosofía es hacer una cosa muy bien y muy rápido: encontrar puertos abiertos en segundos, y luego delegar el análisis detallado a `nmap` pasándole los puertos encontrados automáticamente.

El binario instalado reporta la versión 2.3.0 y su proyecto upstream es `https://rustscan.github.io/RustScan`. En Termux depende de `nmap`, que se instala junto a él.

## ¿Para qué es útil la herramienta?

RustScan es ideal en la fase de reconocimiento y escaneo de red:

-   **Descubrimiento Ultrarrápido:** Escanea los 65k puertos en segundos ajustando `--batch-size` y `--timeout`, donde `nmap` solo tardaría minutos.
-   **Pipeline con Nmap:** Con `-- <comando nmap>` ejecuta nmap solo contra los puertos abiertos (ej. `-sC -sV` para scripts y versiones).
-   **Escaneo de Redes Completas:** Acepta CIDRs, IPs, hosts o archivos con `-a`, y rangos con `-r 1-1000` o `--top` (top 1000).
-   **Salida Limpia para Scripts:** Con `-g` (greppable) emite solo puertos, ideal para `grep` o encadenar con otras herramientas.
-   **UDP y Orden Aleatorio:** Soporta `--udp` y `--scan-order random` para evadir patrones simples de detección.

## ¿Cómo se usa?

### 1. Instalación

En Termux / i-Haklab (repositorio main):

```bash
pkg update
pkg install rustscan
```

Verificar instalación:

```bash
rustscan --help
rustscan --version
```

### 2. Ejemplos de Uso Básico

1.  **Escaneo básico de un host (los 65k puertos, luego nmap por defecto):**
    ```bash
    rustscan -a 192.168.1.10
    ```

2.  **Escaneo + nmap con detección de servicios y scripts:**
    Todo lo que va tras `--` se pasa a nmap.
    ```bash
    rustscan -a 192.168.1.10 -- -sC -sV
    ```

3.  **Escanear puertos concretos o un rango:**
    ```bash
    rustscan -a example.com -p 80,443,8080
    rustscan -a 192.168.1.10 -r 1-1000
    rustscan -a 192.168.1.10 --top
    ```

4.  **Escanear varios objetivos desde archivo y salida limpia:**
    ```bash
    rustscan -a objetivos.txt -g -o puertos.txt
    ```

5.  **Ajustar velocidad y reintentos en redes lentas:**
    ```bash
    rustscan -a 192.168.1.10 -b 2500 -t 2000 --tries 2 --scan-order random
    ```
    *   `-b`: batch size (puertos en paralelo, por defecto 4500).
    *   `-t`: timeout en ms antes de dar un puerto por cerrado.
    *   `--tries`: reintentos por puerto.

### 3. Opciones Comunes Adicionales

-   `-a, --addresses`: CIDRs, IPs, hosts o archivo, separados por coma.
-   `-p, --ports`: lista concreta `80,443,8080`.
-   `-r, --range`: rango `1-1000`.
-   `--top`: top 1000 puertos.
-   `-e, --exclude-ports` / `-x, --exclude-addresses`: exclusiones.
-   `-g, --greppable`: solo puertos, sin nmap.
-   `--scripts`: `none`, `default`, `custom` (qué nmap ejecutar).
-   `--udp`: escaneo UDP (solo puertos que responden).
-   `--no-banner`, `-n, --no-config`: salida y config.

## Otras Consideraciones

-   **Ruidoso por Diseño:** Abre miles de conexiones por segundo. El propio banner advierte: no lo uses contra infraestructura sensible sin permiso, puedes tumbar servicios frágiles.
-   **No reemplaza a Nmap:** RustScan encuentra puertos, nmap los fingerprinta. Úsalos juntos: RustScan para velocidad, nmap para `-sV -sC -O`.
-   **Límite de Archivos Abiertos:** Si falla con muchos puertos, ajusta `-b` hacia abajo o sube el ulimit con `-u 10000`.
-   **Legalidad y Ética:** Escáner activo. **Úsalo solo contra tus redes o con autorización explícita y por escrito.**

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
