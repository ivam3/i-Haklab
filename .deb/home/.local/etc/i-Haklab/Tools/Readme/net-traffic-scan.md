# net-traffic-scan

## ¿Qué es net-traffic-scan?

**net-traffic-scan** es un monitor de tráfico TCP/UDP para Termux que funciona **sin root**.
Como las apps Android normales (`untrusted_app`) no pueden leer `/proc/net` (Permission denied)
ni usar `netstat`/`ss` completos, la herramienta ejecuta la lectura **dentro de `adb shell`**
(bypass readproc) y muestra las conexiones en una tabla con cuadrícula Unicode, con historial
de IPs vistas. Es un **direct command** de i-HakLab: se invoca como `net-traffic-scan`.

- **Requisitos**: `adb` (paquete `android-tools`), depuración inalámbrica activada y
  dispositivo emparejado (`adb pair` + `adb connect`). Sin dispositivos en estado `device`,
  el comando muestra la guía de emparejamiento y sale.
- **Historial**: `~/.local/share/traffic` (fallback `/data/local/tmp/traffic`).

## ¿Para qué es útil?

*   **Ver conexiones activas sin root**: qué IPs/puertos toca el dispositivo en tiempo real.
*   **Auditoría rápida**: detectar conexiones inesperadas durante pentesting o análisis de apps.
*   **Depuración**: validar que un túnel/proxy (ngrok, localtunnel, Tor) cursa tráfico.

## ¿Cómo se usa? (Ejemplos básicos)

**Escaneo continuo (tabla con cuadrícula)**

```bash
net-traffic-scan
```

**Una sola iteración (depuración)**

```bash
net-traffic-scan --once
```

**Salida plana sin bordes (para parsear con grep/awk)**

```bash
net-traffic-scan --no-grid
```

**Validar adb sin ejecutar el payload**

```bash
net-traffic-scan --dry-run
```

## Opciones

| Opción | Descripción |
| :--- | :--- |
| `--grid` | Salida con cuadrícula Unicode (por defecto). |
| `--no-grid` | Salida plana sin bordes. |
| `--once` | Una sola iteración en el dispositivo (depuración). |
| `--dry-run` | Valida adb sin ejecutar el payload. |

## Consideraciones Adicionales

*   **Sin root, sin `netstat`**: el payload se copia a `/data/local/tmp/net-traffic-scan.sh`
    en el dispositivo y se ejecuta vía `adb shell`; con varios dispositivos conectados se
    selecciona con `adb -s <serial>`.
*   **Caché local**: usa `/data/local/tmp/.net_cache` e `current_ips.tmp` para el diff de IPs.
*   **Historial persistente** en `~/.local/share/traffic` (antes `/sdcard/Download/traffic`).

---
*Nota: monitor de tráfico sin root del ecosistema i-HakLab (bypass ADB readproc).*
