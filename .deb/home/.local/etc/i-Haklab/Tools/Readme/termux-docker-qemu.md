# Docker y Virtualización en Termux con `termux-docker-qemu` 🐳💻

El proyecto **`termux-docker-qemu`** (v0.10.0) es una solución de virtualización avanzada desarrollada por **Ivam3** (parte del ecosistema **i-HakLab**) diseñada para ejecutar el demonio de Docker y máquinas virtuales Linux (Alpine) de manera estable y de alto rendimiento dentro de Termux.

Esta herramienta resuelve la limitación estructural del kernel de Android (el cual carece de soporte nativo para `cgroups`, namespaces y módulos necesarios para correr Docker nativamente en el dispositivo).

---

## ⚠️ Clarificación Importante: `termux-docker-qemu` vs `qemufy`

Es fundamental no confundir estas dos herramientas de virtualización de la suite i-HakLab:

* **`termux-docker-qemu`**: Diseñado exclusivamente para desplegar e interactuar con máquinas virtuales ligeras de Alpine Linux (x86_64, x86, aarch64, armv7) con soporte nativo de red, aceleración VirtIO y almacenamiento compartido para ejecutar contenedores **Docker** en Termux.
* **`qemufy`**: Creado específicamente para convertir e importar imágenes de máquinas virtuales de plataformas de retos CTF/ciberseguridad (como **TheHackersLabs**, VulnHub, etc.) originalmente en formatos de VMware (`.vmdk`) o VirtualBox (`.ova`), convirtiéndolas al formato `.qcow2` para auditar localmente en la red desde Termux.

---

## 🚀 1. Sintaxis de Ejecución y Modos de Operación

La sintaxis del comando permite ejecutar el entorno en modo headless (consola serial/SSH) o con diversos modos de visualización gráfica (SDL, VNC o TCP Bridge), además de gestionar el acceso SSH y las instantáneas del disco:

```bash
termux-docker-qemu <nombre_sistema>
termux-docker-qemu <nombre_sistema> x11 [sdl|vnc|tcp]
termux-docker-qemu <nombre_sistema> ssh [comando...]
termux-docker-qemu ssh-setup [nombre_sistema]
termux-docker-qemu <nombre_sistema> snapshot [nombre]
termux-docker-qemu <nombre_sistema> snapshots
termux-docker-qemu <nombre_sistema> restore <nombre>
termux-docker-qemu <nombre_sistema> snapshot-delete <nombre>
termux-docker-qemu --help
```

### Modos Disponibles:

1. **Modo Consola / Headless (Recomendado para Docker CLI y SSH)**:
   ```bash
   termux-docker-qemu alpine
   ```
   *(Ejecuta QEMU en modo `-nographic`. Ideal para consumo mínimo de RAM/CPU. Los servicios y Docker quedan accesibles por `127.0.0.1` o por SSH).*

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
   *(Inicia el servidor VNC integrado de QEMU en `127.0.0.1:5900` para conectarse usando clientes VNC externos como RealVNC).*

6. **Acceso SSH (sin consola gráfica)**:
   ```bash
   termux-docker-qemu alpine ssh
   termux-docker-qemu alpine ssh 'docker ps'
   ```
   *(Abre una sesión SSH o ejecuta un comando puntual dentro de la VM. Ver la sección 4).*

7. **Preparar la llave SSH**:
   ```bash
   termux-docker-qemu ssh-setup
   ```
   *(Crea la llave del dispositivo si no existe y muestra la línea que hay que autorizar dentro del guest. Ver la sección 4).*

---

## 📶 2. Mapeo de Puertos por Defecto

Al iniciar la máquina virtual de Alpine, QEMU establece reenvíos de puertos (`hostfwd`) desde el host hacia la interfaz de red interna de la VM. **Por defecto escuchan solo en `127.0.0.1`** (loopback del teléfono):

| Puerto local (Termux) | Puerto interno (VM Alpine) | Servicio / Uso Asignado |
| :--- | :--- | :--- |
| **`2222`** | `22` | **SSH** (`ssh root@127.0.0.1 -p 2222`) |
| **`8080`** | `80` | **HTTP** (Servidores web / Nginx / Apache / Contenedores) |
| **`2121`** | `21` | **FTP** (Transferencia rápida de archivos) |
| **`8000`** | `8000` | **API / Dev** (Microservicios o paneles web de desarrollo) |
| **`1080`** | `1080` | **SOCKS Proxy** / Túneles de red |
| **`5900`** | `5900` | **VNC** (Escritorio remoto, activo en modo `x11 vnc`) |

*Nota: cada puerto del host se puede cambiar con `QEMU_SSH_PORT`, `QEMU_HTTP_PORT`, `QEMU_FTP_PORT`, `QEMU_APP_PORT`, `QEMU_VNC_PORT` y `QEMU_SOCKS_PORT`.*

*Nota: la red de la VM es SLIRP/NAT con subred fija `10.0.2.0/24` (la guest recibe `10.0.2.15` y ve al host como `10.0.2.2`). Esa IP **no** es accesible desde fuera de la VM: desde Termux siempre se usa `127.0.0.1:<puerto>`.*

*Nota: `QEMU_BIND=0.0.0.0` hace que **todos** los reenvíos escuchen en la red local (útil para conectarse desde una PC con `ssh -p 2222 root@<IP-del-teléfono>`). Como también expone HTTP, FTP, SOCKS y VNC, para uso remoto conviene más un túnel SSH.*

---

## ⚡ 3. Arquitectura y Optimizaciones de Rendimiento

`termux-docker-qemu` incluye configuraciones avanzadas de aceleración VirtIO para maximizar la velocidad de lectura/escritura y procesamiento, y se adapta al hardware de cada dispositivo:

* **Multiprocesamiento y CPU**: Usa `min(nproc, 4)` vCPUs (TCG no escala con más núcleos) con el modelo `qemu64,+ssse3,+sse4.1,+sse4.2,+popcnt`. **AVX/AVX2 queda deshabilitado a propósito**: la emulación AVX2 de TCG está incompleta y provoca `Illegal instruction` (afecta a Bun/opencode, partes de Firefox, etc.). Si un programa realmente necesita AVX, usar `QEMU_CPU=max` asumiendo el riesgo.
* **Memoria RAM Asignada**: Se calcula en cada arranque como la mitad de `MemTotal + SwapTotal` (redondeada y limitada a un rango de **1 GiB a 12 GiB**), así que un teléfono de 4 GiB recibe una guest pequeña y uno de 24 GiB con zram recibe una más grande. Se puede fijar con `QEMU_RAM` (en MiB).
* **Disco de alto rendimiento**: Emplea almacenamiento en formato nativo **QCOW2** con controlador `virtio-blk-pci`, descartado dinámico (`discard=on`) y `cache=writeback` por defecto (respeta los flushes). `QEMU_CACHE=unsafe` es más rápido pero puede corromper el qcow2 si Android mata QEMU.
* **Red VirtIO**: Interfaz de red de baja latencia mediante `virtio-net-pci`.
* **Generación de Entropía (VirtIO-RNG)**: Dispositivo `virtio-rng-pci` integrado para evitar bloqueos por falta de entropía durante la generación de claves SSH, TLS o inicio de contenedores Docker.
* **Argumentos extra**: `QEMU_EXTRA_ARGS` permite añadir opciones sueltas a QEMU; `QEMU_PRINT=1` imprime el comando ensamblado y sale.

---

## 🔐 4. Acceso SSH a la VM

La llave SSH es **por dispositivo**: no viene incluida en el paquete ni se comparte entre usuarios. `ssh-setup` la crea en el primer uso y solo muestra la mitad pública.

### Preparar la llave

```bash
termux-docker-qemu ssh-setup
```

* Si no existe, genera un par **ed25519 sin passphrase** en `~/.ssh/id_alpine_qemu` (configurable con `QEMU_SSH_KEY`).
* Si existe la privada pero falta la `.pub`, la reconstruye en vez de regenerar la llave.
* Imprime una línea lista para pegar en la consola del guest:

```sh
apk add openssh
mkdir -p /root/.ssh && chmod 700 /root/.ssh
echo 'ssh-ed25519 AAAA... termux-docker-qemu' >> /root/.ssh/authorized_keys
chmod 600 /root/.ssh/authorized_keys
rc-update add sshd && rc-service sshd restart
```

### Conectar

```bash
termux-docker-qemu alpine ssh
termux-docker-qemu alpine ssh 'docker ps'
```

Equivale a `ssh -i ~/.ssh/id_alpine_qemu -p 2222 root@127.0.0.1`. El usuario se cambia con `QEMU_SSH_USER` y el puerto con `QEMU_SSH_PORT`.

---

## 💾 5. Instantáneas del disco (QCOW2)

Las instantáneas internas de QCOW2 son baratas (copy-on-write: solo guardan los bloques modificados) y permiten volver atrás tras una actualización fallida del guest sin reinstalar nada:

```bash
termux-docker-qemu alpine snapshot antes-de-actualizar
termux-docker-qemu alpine snapshots
termux-docker-qemu alpine restore antes-de-actualizar
termux-docker-qemu alpine snapshot-delete antes-de-actualizar
```

La VM debe estar detenida antes de crear, restaurar o borrar una instantánea.

---

## 📁 6. El Volumen Compartido: `termux2alpine`

Para transferir archivos sin necesidad de servidores de red externos, `termux-docker-qemu` configura un volumen compartido mediante VirtFS (protocolo 9p).

### Características y Uso:
* **Ruta en Termux (Host)**:
  `~/.local/share/termux-docker-qemu/alpine/termux2alpine`
* **Ruta en Alpine (Guest)**:
  `/termux2alpine` (automontado al iniciar el sistema a través de `/etc/fstab`).
* **Sincronización de Terminal**: El script sincroniza automáticamente las dimensiones de las filas y columnas de la terminal (`stty size > screen.txt`) para ajustar el tamaño de pantalla al iniciar la sesión.
* **Integración de Entorno X11**: En modo TCP Bridge, se escribe automáticamente en este volumen el archivo `x11_env.sh` con la variable `DISPLAY=10.0.2.2:0` (la IP del gateway host en SLIRP).

---

## ⚙️ 7. Instalación y Actualizaciones

Al instalar puedes elegir la arquitectura (`x86_64`, `x86`, `aarch64`,
`armv7`) y la versión de Alpine Linux (desde **v3.16** hasta **v3.24**).

La máquina virtual queda preconfigurada con:

1. **Red y DNS listos** para salir a internet sin tocar nada.
2. **Carpeta compartida** con Termux en `/termux2alpine` (montada sola al arrancar).
3. **Docker instalado y arrancado** como servicio (listo para `docker run`).
4. Opcionalmente, **entorno gráfico completo** (XFCE4, terminal, Firefox) con aceleración 3D, y terminal `tmux`.

### Actualizar sin perder datos

Desde la **v0.10.0** el paquete nunca borra la VM:

* El `prerm` no elimina nada (solo muestra dónde están los datos si desinstalas).
* Si al instalar ya existe un `*.qcow2`, el `postinst` termina de inmediato con *"Existing data was not modified"*.
* Para volver a ver los menús de instalación sin borrar el disco: `TERMUX_DOCKER_QEMU_REINSTALL=1 pkg reinstall termux-docker-qemu`.
* Para empezar de cero, borra el disco a mano (`rm -f ~/.local/share/termux-docker-qemu/alpine/alpine.qcow2`) y reinstala.

> ⚠️ Si vienes de **0.9.5 o anterior**, ese `prerm` sí borraba la VM al actualizar. Antes de `pkg upgrade`, neutralízalo temporalmente:
> ```bash
> : > "$PREFIX/var/lib/dpkg/info/termux-docker-qemu.prerm"
> ```
> y haz una instantánea/copia del `.qcow2` por si acaso.

---

## 🛠️ 8. Atajos de Teclado Útiles (QEMU)

Cuando la VM se ejecuta en modo consola / headless (`-nographic`):

| Combinación | Acción |
| :--- | :--- |
| **`Ctrl + a` seguido de `x`** | Forzar salida y cerrar la emulación QEMU |
| **`Ctrl + a` seguido de `h`** | Mostrar el menú de ayuda y consola de monitoreo de QEMU |

---

## 📦 9. Información del Paquete

| Campo | Detalle |
| :--- | :--- |
| **Nombre** | `termux-docker-qemu` |
| **Versión** | `0.10.0` |
| **Arquitectura** | `all` |
| **Mantenedor** | [Ivam3](https://t.me/Ivam3_Bot) |
| **Ecosistema** | Parte de [i-HakLab](https://github.com/Ivam3/i-HakLab) / termux-packages |
| **Dependencias** | `openssh`, `wget`, `samba`, `procps`, `coreutils`, `xorg-xrandr`, `xfwm4`, `xdotool`, `termux-x11-nightly`, `qemu-utils`, `qemu-common`, `qemu-system-x86-64` |

---

*Nota: Herramienta integrada en el ecosistema i-Haklab.*
