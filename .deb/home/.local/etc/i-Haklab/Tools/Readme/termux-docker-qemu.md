# Docker y Virtualización en Termux con `termux-docker-qemu` 🐳💻

El proyecto **`termux-docker-qemu`** (v0.9.5) es una solución de virtualización avanzada desarrollada por **Ivam3** (parte del ecosistema **i-HakLab**) diseñada para ejecutar el demonio de Docker y máquinas virtuales Linux (Alpine) de manera estable y de alto rendimiento dentro de Termux. 

Esta herramienta resuelve la limitación estructural del kernel de Android (el cual carece de soporte nativo para `cgroups`, namespaces y módulos necesarios para correr Docker nativamente en el dispositivo).

---

## ⚠️ Clarificación Importante: `termux-docker-qemu` vs `qemufy`

Es fundamental no confundir estas dos herramientas de virtualización de la suite i-HakLab:

* **`termux-docker-qemu`**: Diseñado exclusivamente para desplegar e interactuar con máquinas virtuales ligeras de Alpine Linux (x86_64, x86, aarch64, armv7) con soporte nativo de red, aceleración VirtIO y almacenamiento compartido para ejecutar contenedores **Docker** en Termux.
* **`qemufy`**: Creado específicamente para convertir e importar imágenes de máquinas virtuales de plataformas de retos CTF/ciberseguridad (como **TheHackersLabs**, VulnHub, etc.) originalmente en formatos de VMware (`.vmdk`) o VirtualBox (`.ova`), convirtiéndolas al formato `.qcow2` para auditar localmente en la red desde Termux.

---

## 🚀 1. Sintaxis de Ejecución y Modos de Operación

La sintaxis del comando permite ejecutar el entorno en modo headless (consola serial/SSH) o con diversos modos de visualización gráfica (SDL, VNC o TCP Bridge):

```bash
termux-docker-qemu <nombre_sistema>
termux-docker-qemu <nombre_sistema> x11 [sdl|vnc|tcp]
```

### Modos Disponibles:

1. **Modo Consola / Headless (Recomendado para Docker CLI y SSH)**:
   ```bash
   termux-docker-qemu alpine
   ```
   *(Ejecuta QEMU en modo `-nographic`. Ideal para consumo mínimo de RAM/CPU. Los servicios y Docker quedan accesibles por red local o SSH).*

2. **Menú Interactivo Gráfico**:
   ```bash
   termux-docker-qemu alpine x11
   ```
   *(Muestra un menú interactivo en la terminal para elegir entre SDL, VNC o TCP Bridge).*

3. **Modo SDL / VirGL 3D (Aceleración GPU por Hardware)**:
   ```bash
   termux-docker-qemu alpine x11 sdl
   ```
   *(Abre una ventana mediante **Termux:X11** empleando `-device virtio-vga-gl` y `-display sdl,gl=on`. Pasa las instrucciones de renderizado 3D de la VM directamente a la GPU del dispositivo Android. Detecta automáticamente la resolución de pantalla usando `xrandr`).*

4. **Modo Direct X11 TCP Bridge (Ultra Ligero)**:
   ```bash
   termux-docker-qemu alpine x11 tcp
   ```
   *(Ejecuta QEMU en modo `-nographic` sin sobrecarga de renderizado de cuadros, creando un puente TCP con `socat` en el puerto `6000` hacia el socket UNIX de Termux:X11. Genera el script `/termux2alpine/x11_env.sh` dentro de la VM).*
   *Uso dentro de Alpine:*
   ```sh
   source /termux2alpine/x11_env.sh
   xfce4-terminal &   # o xfce4-session &
   ```

5. **Modo VNC**:
   ```bash
   termux-docker-qemu alpine x11 vnc
   ```
   *(Inicia el servidor VNC integrado de QEMU en la dirección `localhost:5900` para conectarse usando clientes VNC externos como RealVNC).*

---

## 📶 2. Mapeo de Puertos por Defecto

Al iniciar la máquina virtual de Alpine, QEMU establece reenvíos de puertos (`hostfwd`) desde el host (`localhost` en Termux) hacia la interfaz de red interna de la VM:

| Puerto local (Termux) | Puerto interno (VM Alpine) | Servicio / Uso Asignado |
| :--- | :--- | :--- |
| **`2222`** | `22` | **SSH** (`ssh root@localhost -p 2222`) |
| **`8080`** | `80` | **HTTP** (Servidores web / Nginx / Apache / Contenedores) |
| **`2121`** | `21` | **FTP** (Transferencia rápida de archivos) |
| **`8000`** | `8000` | **API / Dev** (Microservicios o paneles web de desarrollo) |
| **`1080`** | `1080` | **SOCKS Proxy** / Túneles de red |
| **`5900`** | `5900` | **VNC** (Escritorio remoto, activo en modo `x11 vnc`) |

*Nota: La red virtual asigna dinámicamente el segmento de red según las interfaces activas (ej. `192.168.X.X` o subred interna `10.0.2.X`).*

---

## ⚡ 3. Arquitectura y Optimizaciones de Rendimiento

`termux-docker-qemu` incluye configuraciones avanzadas de aceleración VirtIO para maximizar la velocidad de lectura/escritura y procesamiento:

* **Multiprocesamiento y CPU**: Asigna automáticamente todos los núcleos del dispositivo (`cpus=$(nproc)`) habilitando extensiones `qemu64,+avx,+avx2`.
* **Memoria RAM Asignada**: Configurable durante la instalación (por defecto `12 GB` / `12288 MB`).
* **Disco de alto rendimiento**: Emplea almacenamiento en formato nativo **QCOW2** con controlador `virtio-blk-pci`, descartado dinámico (`discard=on`) y caché optimizado (`cache=unsafe`).
* **Red VirtIO**: Interfaz de red de baja latencia mediante `virtio-net-pci`.
* **Generación de Entropía (VirtIO-RNG)**: Dispositivo `virtio-rng-pci` integrado para evitar bloqueos por falta de entropía durante la generación de claves SSH, TLS o inicio de contenedores Docker.

---

## 📁 4. El Volumen Compartido: `termux2alpine`

Para transferir archivos sin necesidad de servidores de red externos, `termux-docker-qemu` configura un volumen compartido mediante VirtFS (protocolo 9p).

### Características y Uso:
* **Ruta en Termux (Host)**:
  `~/.local/share/termux-docker-qemu/alpine/termux2alpine`
* **Ruta en Alpine (Guest)**:
  `/termux2alpine` (automontado al iniciar el sistema a través de `/etc/fstab`).
* **Sincronización de Terminal**: El script sincroniza automáticamente las dimensiones de las filas y columnas de la terminal (`stty size > screen.txt`) para ajustar el tamaño de pantalla al iniciar la sesión.
* **Integración de Entorno X11**: En modo TCP Bridge, se escribe automáticamente en este volumen el archivo `x11_env.sh` con la variable `DISPLAY` correspondiente a la IP del gateway host.

---

## ⚙️ 5. Instalación y Entorno Interno (`postinst` y Scripts)

El instalador `postinst` permite seleccionar la arquitectura (`x86_64`, `x86`, `aarch64`, `armv7`) y la versión de Alpine Linux (desde **v3.16** hasta **v3.24**).

### Componentes Internos Automáticos:
1. **`ashrc.sh`**:
   * Configura automáticamente los servidores DNS (`8.8.8.8`).
   * Automonta el volumen compartido VirtFS 9p en `/termux2alpine`.
   * Habilita repositorios APK (incluyendo `@testing`).
   * Configura `pip` para instalaciones en entorno de sistema (`break-system-packages = true`).
   * Instala, habilita e inicia el servicio **Docker** (`service docker start` y `rc-update add docker`).
   * Opcionalmente instala y configura un entorno de terminal con `tmux`.
2. **`alpineX11.sh`**:
   * Script para aprovisionar el entorno gráfico completo (XFCE4, XFCE4 Terminal, DBus, LightDM, Firefox).
   * Instala los controladores de aceleración GPU 3D Mesa (`mesa-dri-gallium`, `mesa-egl`, `mesa-gl`).

---

## 🛠️ 6. Atajos de Teclado Útiles (QEMU)

Cuando la VM se ejecuta en modo consola / headless (`-nographic`):

| Combinación | Acción |
| :--- | :--- |
| **`Ctrl + a` seguido de `x`** | Forzar salida y cerrar la emulación QEMU |
| **`Ctrl + a` seguido de `h`** | Mostrar el menú de ayuda y consola de monitoreo de QEMU |

---

## 📦 7. Información del Paquete

| Campo | Detalle |
| :--- | :--- |
| **Nombre** | `termux-docker-qemu` |
| **Versión** | `0.9.5` |
| **Arquitectura** | `all` |
| **Mantenedor** | [Ivam3](https://t.me/Ivam3_Bot) |
| **Ecosistema** | Parte de [i-HakLab](https://github.com/Ivam3/i-HakLab) / termux-packages |
| **Dependencias** | `openssh`, `wget`, `samba`, `procps`, `net-tools`, `xorg-xrandr`, `xfwm4`, `xdotool`, `termux-x11-nightly`, `qemu-utils`, `qemu-common`, `qemu-system-x86-64` |

