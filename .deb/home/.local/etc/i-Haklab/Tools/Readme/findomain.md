# findomain

## ¿Qué es findomain?

findomain es el enumerador de subdominios más rápido, escrito en Rust y multiplataforma. Su objetivo es descubrir tantos subdominios como sea posible para un dominio dado sin perder tiempo, usando principalmente técnicas OSINT contra múltiples fuentes públicas (crt.sh, certspotter, VirusTotal, ThreatCrowd, urlscan, SecurityTrails, etc.).

A diferencia de herramientas Python como Sublist3r, es un binario compilado muy veloz, con resolución DNS propia, modo monitorización, chequeo de estado HTTP y escáner de puertos integrado. Su proyecto upstream es `https://findomain.app/`.

## ¿Para qué es útil la herramienta?

findomain es fundamental en la fase de reconocimiento de pentest, auditoría y Bug Bounty:

-   **Mapeo de Superficie de Ataque:** Descubre subdominios olvidados o poco mantenidos que suelen ser la puerta de entrada.
-   **Descubrimiento para Bug Bounty:** Amplía el alcance con activos que no aparecen en la web principal.
-   **Validación Rápida:** Con `-r` muestra solo subdominios que resuelven, y con `-i` sus IPs, listos para pasar a `nmap` o `rustscan`.
-   **Monitorización:** Con `-m` vigila un dominio y alerta vía webhook/base de datos cuando aparecen subdominios nuevos.
-   **Triage Web:** Con `--http-status` comprueba qué subdominios tienen web activa.

## ¿Cómo se usa?

### 1. Instalación

En Termux / i-Haklab (repositorio main):

```bash
pkg update
pkg install findomain
```

Verificar instalación:

```bash
findomain --help
```

### 2. Ejemplos de Uso Básico

1.  **Enumeración básica de un dominio:**
    ```bash
    findomain -t example.com
    ```

2.  **Mostrar solo subdominios que resuelven, con IP:**
    ```bash
    findomain -t example.com -r -i
    ```

3.  **Guardar resultados en archivo automático (`example.com.txt`):**
    ```bash
    findomain -t example.com -o
    ```

4.  **Guardar con nombre personalizado:**
    ```bash
    findomain -t example.com -u subdominios.txt
    ```

5.  **Enumerar varios dominios desde archivo:**
    ```bash
    findomain -f dominios.txt -o
    ```

6.  **Comprobar estado HTTP y escanear puertos top:**
    ```bash
    findomain -t example.com -r --http-status --pscan
    ```

### 3. Opciones Comunes Adicionales

-   `-t, --target`: dominio objetivo.
-   `-f, --file`: archivo con lista de dominios.
-   `-r, --resolved`: solo subdominios que resuelven.
-   `-i, --ip`: muestra la IP de los resueltos.
-   `-o, --output`: guarda en `objetivo.txt` automático.
-   `-u, --unique-output`: guarda en archivo con nombre propio.
-   `-w, --wordlist`: activa bruteforce con diccionario.
-   `--pscan`, `--iport`, `--lport`: escáner de puertos (por defecto 0-1000).
-   `--http-status`: comprueba código HTTP de cada subdominio.
-   `--exclude-sources`: excluye fuentes concretas.
-   `-q, --quiet`: salida limpia solo con subdominios.

## Otras Consideraciones

-   **Técnica Mayormente Pasiva:** Consulta fuentes de terceros, es sigiloso, aunque la resolución DNS y `--pscan` sí generan tráfico directo.
-   **Complemento, no reemplazo:** Combínalo con bruteforce activo (`gobuster`, `amass`) y luego pasa los vivos a `httpx`, `nuclei`, `nikto` o `afrog`.
-   **Resolutores:** Por defecto usa Google, Cloudflare y Quad9. Puedes usar los tuyos con `--resolvers resolvers.txt`.
-   **Legalidad y Ética:** Recopila información pública, su uso es legal, pero explota solo objetivos con autorización explícita y por escrito.

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
