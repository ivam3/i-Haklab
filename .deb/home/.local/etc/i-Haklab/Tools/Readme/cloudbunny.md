# CloudBunny

## ¿Qué es CloudBunny?

CloudBunny es una herramienta de seguridad diseñada para un propósito específico: **descubrir la dirección IP real de un servidor web que está protegido por un servicio de proxy inverso o WAF (Web Application Firewall)**, como Cloudflare.

Muchos sitios web utilizan servicios como Cloudflare para protegerse de ataques de denegación de servicio (DDoS), ocultar la IP de su servidor de origen y filtrar tráfico malicioso. Cuando visitas un sitio protegido por Cloudflare, en realidad te estás conectando a un servidor de Cloudflare, no directamente al servidor que aloja el sitio.

CloudBunny intenta eludir esta protección buscando en fuentes de datos históricas y de inteligencia de internet para encontrar registros de la IP real del servidor.

## ¿Para qué es útil la herramienta?

Para un pentester o un analista de seguridad, encontrar la dirección IP real de un servidor es extremadamente valioso. Una vez que se conoce la IP de origen, se pueden realizar una serie de acciones que el WAF normalmente bloquearía:

*   **Escanear Puertos:** Realizar un escaneo de puertos directamente sobre el servidor con herramientas como [Nmap](nmap.md) para descubrir otros servicios abiertos (SSH, FTP, bases de datos, etc.) que no son el servicio web.
*   **Atacar Servicios Directamente:** Intentar explotar vulnerabilidades en esos otros servicios que no están protegidos por el WAF.
*   **Eludir el WAF:** Lanzar ataques directos contra la aplicación web (como Inyección SQL o XSS) que de otro modo serían bloqueados por Cloudflare.
*   **Ataques de Denegación de Servicio (DoS):** Realizar un ataque DoS directamente contra el servidor de origen, que tiene muchos menos recursos para mitigarlo que la red global de Cloudflare.

## ¿Cómo funciona?

CloudBunny no realiza un ataque activo. En su lugar, es una herramienta de **Inteligencia de Fuentes Abiertas (OSINT)**. Funciona consultando bases de datos de terceros que escanean constantemente todo el internet y guardan registros históricos.

Su método principal es:

1.  **Tomar un dominio como entrada:** Por ejemplo, `example.com`.
2.  **Consultar Servicios de Búsqueda:** Busca en servicios como:
    *   **Censys**
    *   **Shodan**
    *   **ZoomEye**
3.  **Analizar Certificados SSL:** Busca certificados SSL históricos asociados con el dominio. A menudo, antes de que un sitio se pusiera detrás de Cloudflare, su certificado SSL estaba directamente asociado a la IP del servidor real. Estos servicios a menudo guardan esa relación histórica.
4.  **Buscar en el Historial de DNS:** Busca registros de DNS pasados para el dominio.

Si alguno de estos servicios tiene un registro de la IP del servidor antes de que se activara la protección de Cloudflare, CloudBunny lo encontrará y lo presentará al usuario.

## ¿Cómo se usa? (Ejemplo conceptual)

CloudBunny es típicamente una herramienta de línea de comandos.

**Sintaxis conceptual:**
```bash
python cloudbunny.py -d [dominio_objetivo]
```

**Ejemplo:**
```bash
python cloudbunny.py -d example.com
```

**Salida de ejemplo:**
```
[*] Buscando la IP real de example.com...
[*] Consultando la base de datos de Censys...
[*] Consultando la base de datos de Shodan...
[+] ¡Posible IP real encontrada! -> 192.168.1.100 (Registrada en Shodan el 2022-01-15)
[+] ¡Posible IP real encontrada! -> 192.168.1.100 (Encontrada en un certificado SSL histórico)
[*] Escaneo completado.
```

## Consideraciones Adicionales

*   **No siempre funciona:** La efectividad de CloudBunny depende de si existe un registro histórico de la IP del servidor. Si un servidor se configuró desde el principio para usar Cloudflare y nunca expuso su IP real, es poco probable que herramientas como esta la encuentren.
*   **Claves de API:** Para obtener los mejores resultados, estas herramientas a menudo requieren que el usuario proporcione claves de API para los servicios que consultan (Shodan, Censys, etc.), ya que las búsquedas gratuitas suelen estar limitadas.
*   **Medidas de Mitigación:** Los administradores de sistemas pueden mitigar este tipo de descubrimiento configurando sus firewalls para que solo acepten tráfico entrante desde las direcciones IP de Cloudflare. De esta manera, aunque un atacante descubra la IP real, no podrá conectarse directamente a ella.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. Utiliza esta herramienta de forma responsable y solo en objetivos para los que tengas permiso.*
