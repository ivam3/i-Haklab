# tor

## ¿Qué es tor?

Tor (The Onion Router) es un software libre y una red abierta que ayuda a defenderse contra el análisis de tráfico, una forma de vigilancia de la red que amenaza la libertad personal y la privacidad. Tor dirige el tráfico de Internet a través de una red voluntaria mundial de miles de repetidores para ocultar la ubicación y el uso del usuario.

## ¿Para qué es útil la herramienta?

*   **Anonimato:** Oculta la dirección IP de origen al visitar sitios web o usar servicios de internet.
*   **Evasión de Censura:** Permite acceder a sitios web bloqueados por proveedores de servicios o gobiernos.
*   **Servicios Onion:** Permite acceder a sitios web ocultos (con terminación `.onion`) que solo existen dentro de la red Tor y ofrecen anonimato tanto al visitante como al servidor.
*   **Privacidad:** Dificulta que los sitios web rastreen la actividad del usuario a lo largo del tiempo.

## ¿Cómo se usa? (Ejemplos básicos)

En la línea de comandos, `tor` actúa como un proxy SOCKS local.

**Ejemplo 1: Iniciar el servicio Tor**

```bash
tor
```
Una vez iniciado, Tor abrirá un proxy SOCKS (por defecto en `127.0.0.1:9050`). Verás logs indicando el proceso de conexión ("Bootstrapped 100%: Done").

**Ejemplo 2: Usar con otras herramientas**

Para usar Tor, debes configurar tus aplicaciones para usar el proxy SOCKS en el puerto 9050.
*   Con `curl`: `curl --socks5 127.0.0.1:9050 https://check.torproject.org`
*   Con `proxychains`: Configura `proxychains` para apuntar al puerto 9050 y ejecuta `proxychains comando`.

**Ejemplo 3: Generar un hash de contraseña (para servicios ocultos)**

```bash
tor --hash-password mi_contraseña
```

## Consideraciones Adicionales

*   **No es infalible:** Usar Tor no garantiza el anonimato si la aplicación que usas filtra datos (como peticiones DNS) fuera del túnel Tor.
*   **Velocidad:** Navegar a través de Tor es notablemente más lento que una conexión directa debido a los saltos múltiples alrededor del mundo.
*   **Nodos de Salida:** El tráfico entre el último nodo de Tor y el destino final no está cifrado por Tor (aunque sí por HTTPS si se usa). El nodo de salida puede ver el tráfico si no va cifrado.

---
*Nota: Para navegación web general, se recomienda encarecidamente usar "Tor Browser" en lugar de configurar manualmente otro navegador, ya que incluye protecciones adicionales contra huellas digitales (fingerprinting).*
