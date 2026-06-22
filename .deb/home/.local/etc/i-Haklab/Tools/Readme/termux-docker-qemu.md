# Docker y Virtualización en Termux con `termux-docker-qemu` 🐳💻

El proyecto **`termux-docker-qemu`** es una solución avanzada desarrollada por **Ivam3** para poder ejecutar el demonio de Docker de manera estable dentro de un entorno emulado en Termux. Esto sortea la limitación del kernel de Android (el cual carece de soporte nativo para `cgroups` y namespaces necesarios para correr Docker de manera nativa).

---

## ⚠️ Clarificación Importante: `termux-docker-qemu` vs `qemufy`

Es fundamental no confundir estas dos herramientas de virtualización de la suite, ya que persiguen objetivos totalmente distintos:

* **`termux-docker-qemu`**: Diseñado exclusivamente para levantar una máquina virtual ligera de Alpine Linux con soporte nativo de red y almacenamiento para correr y administrar contenedores **Docker** en Termux de forma optimizada.
* **`qemufy`**: Creado específicamente con el fin de convertir imágenes de máquinas virtuales de plataformas de retos de ciberseguridad (como **TheHackersLabs** o similares) que se distribuyen originalmente en formatos para VMware (`.vmdk`) o VirtualBox (`.ova`), convirtiéndolas al formato `.qcow2` compatible con QEMU para poder resolver los retos CTF a nivel local (LAN) desde Termux.

---

## 🚀 1. Sintaxis de Ejecución

Para iniciar la máquina virtual con el entorno Docker, ejecuta el comando de la suite indicando el sistema operativo de la máquina virtual (por defecto, `alpine`) y, opcionalmente, si deseas salida gráfica (`x11`):

```bash
termux-docker-qemu <nombre_sistema_operativo> [x11]
```

### Ejemplos de uso:
* **Ejecución estándar (Terminal no gráfica - recomendado)**:
  ```bash
  termux-docker-qemu alpine
  ```
  *(Inicia la VM en modo `-nographic` empleando la salida serial de la terminal, lo que reduce el consumo de memoria RAM y CPU).*
* **Ejecución con entorno gráfico**:
  ```bash
  termux-docker-qemu alpine x11
  ```
  *(Inicia la VM con salida de pantalla virtual VNC en la dirección `:0` para cuando se requiere visualizar software de escritorio dentro del sistema emulado).*

---

## 📶 2. Mapeo de Puertos por Defecto

Cuando la máquina virtual de Alpine inicia, QEMU establece un túnel de red de reenvío de puertos (`hostfwd`) hacia la IP de `localhost` en Termux. Esto permite interactuar con los servicios de la VM directamente desde tu terminal local de Termux o el navegador de tu celular:

| Puerto local en Termux | Puerto dentro de la VM (Alpine) | Servicio Asignado |
| :--- | :--- | :--- |
| **`2222`** | `22` | **SSH** (Acceso seguro a la terminal de la VM) |
| **`8080`** | `80` | **HTTP** (Servidor web local / Nginx / Apache de tus contenedores) |
| **`2121`** | `21` | **FTP** (Transferencia rápida de archivos) |
| **`8000`** | `8000` | Puerto de desarrollo general ( APIs o microservicios) |
| **`5900`** | `5900` | **VNC** (Salida de pantalla de la VM, activo solo en modo `x11`) |

---

## 📁 3. El Volumen Compartido: `termux2alpine`

Para facilitar la transferencia de scripts, exploits, diccionarios de contraseñas u otros archivos entre Termux y la máquina virtual emulada, `termux-docker-qemu` monta un puente directo de almacenamiento mediante el controlador VirtFS de QEMU.

### Características:
* **Ruta en Termux**: El directorio local compartido se encuentra ubicado en:
  `~/.local/share/termux-docker-qemu/alpine/termux2alpine`
* **Tag de Montaje**: El directorio se monta en la VM utilizando el tag de seguridad **`termux2alpine`** (o `termux2<sistema_operativo>`).
* **Cómo usarlo**: Todo archivo que deposites en la ruta anterior dentro de Termux se verá reflejado instantáneamente dentro de la máquina virtual de Alpine en su respectivo directorio de montaje local, simplificando el flujo de trabajo sin requerir servidores de red externos.
