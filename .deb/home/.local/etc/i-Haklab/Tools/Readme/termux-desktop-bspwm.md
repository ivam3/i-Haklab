# Documentación del Escritorio bspwm para Termux:X11

Este documento proporciona una visión general completa del escritorio `termux-desktop-bspwm`: un entorno tiling moderno, ligero y controlado por teclado para Termux:X11.

## 1. ¿Qué es bspwm?

**bspwm** es un gestor de ventanas *tiling* basado en partición binaria del espacio. A diferencia de xfce (flotante, con barra de título y botones), aquí las ventanas se reparten solas toda la pantalla y se controlan con el teclado: no hay botones de minimizar/maximizar/cerrar, hay atajos (`super+w` cerrar, `super+m` monocle, `super+f` fullscreen).

## 2. ¿Qué es sxhkd y por qué se usa en bspwm?

**sxhkd** (*Simple X Hotkey Daemon*) es el demonio de atajos de teclado. bspwm no trae atajos propios: sxhkd escucha las combinaciones (definidas en `~/.config/sxhkd/sxhkdrc`) y ejecuta `bspc` u otras apps. Sin sxhkd corriendo, bspwm no responde al teclado.

> **Nota:** `super` = tecla Windows (logo) o Cmd (⌘) en Mac. Si tu teclado no la envía a Termux:X11, usa la columna de respaldo con `alt`.

---

## 3. Componentes Instalados

| Componente | Paquete | Descripción |
| :--- | :--- | :--- |
| **bspwm** | `bspwm` | **Gestor de ventanas tiling principal.** |
| **sxhkd** | `sxhkd` | **Demonio de atajos de teclado.** |
| **kitty** | `kitty` | **Terminal principal** (GPU, transparencia). |
| **xfce4-terminal** | `xfce4-terminal` | Terminal de respaldo. |
| **rofi** | `rofi` | **Lanzador de apps y comandos** (tema gruvbox-dark-hard). |
| **polybar** | `polybar` | **Barra superior**: escritorios, CPU, RAM, batería, WiFi, hora, volumen. |
| **picom** | `picom` | **Compositor**: transparencia y vsync. |
| **dmenu** | `dmenu` | Menú genérico (respaldo de rofi). |
| **feh** | `feh` | Gestor de fondo de pantalla. |
| **xsetroot** | `xorg-xsetroot` | Cursor normal + color sólido de respaldo. |

---

## 4. Gestión de Ventanas y Escritorios

Hay 2 escritorios (`I`–`II`). Firefox se va solo al `II`.

### Dividir pantalla entre ventanas
1. Abre la primera app (ocupa todo).
2. Preselecciona el lado: `super+ctrl+h/j/k/l` (verás el contorno).
3. Abre la segunda app → cae en ese lado. Pantalla dividida.
4. Proporción previa: `super+ctrl+5` (50%), `super+ctrl+7` (70%), etc.

---

## 5. Atajos de Teclado Personalizados

### Apps y sesión
| Atajo | Respaldo `alt` | Descripción |
| :--- | :--- | :--- |
| `super+Return` | `alt+Return` | **Abrir terminal kitty.** |
| `super+shift+Return` | — | Abrir terminal xfce4 (respaldo). |
| `super+espacio` | `alt+espacio` | **Lanzador rofi (apps).** |
| `super+shift+espacio` | — | Lanzador rofi (comandos). |
| `super+Escape` | — | **Recargar atajos sxhkd.** |
| `super+shift+q` | `alt+shift+q` | **Salir de bspwm** (cierra la sesión, no mata X11). |
| `super+shift+r` | — | Reiniciar bspwm. |
| `Print` | — | Captura (xfce4-screenshooter). |

### Ventanas: cerrar y estados
| Atajo | Descripción |
| :--- | :--- |
| `super+w` | **Cerrar ventana.** |
| `super+shift+w` | Matar ventana (forzado). |
| `super+m` | **Alternar tiled / monocle** (maximizar). |
| `super+t` / `super+shift+t` / `super+s` / `super+f` | Tiled / pseudo-tiled / flotante / **fullscreen**. |
| `super+g` | Intercambiar con la ventana más grande. |
| `super+y` | Enviar nodo marcado al preseleccionado. |

### Foco y movimiento (`h`=izq, `j`=abajo, `k`=arriba, `l`=der)
| Atajo | Descripción |
| :--- | :--- |
| `super+h/j/k/l` | Mover el **foco** en esa dirección. |
| `super+shift+h/j/k/l` | **Mover la ventana** en esa dirección. |
| `super+c` / `super+shift+c` | Siguiente / anterior ventana del desktop. |
| `super+Tab` | Última ventana. |
| `super+o` / `super+i` | Historial de foco (atrás / adelante). |
| `super+p/b/,/.` | Foco por salto (padre, hermano, primero, segundo). |

### Escritorios (I–II)
| Atajo | Descripción |
| :--- | :--- |
| `super+1..2` | **Ir al desktop** N. |
| `super+shift+1..2` | **Mandar la ventana** al desktop N. |
| `super+[` / `super+]` | Desktop anterior / siguiente. |
| `super+grave` (acento) | Último desktop. |

### Flags de nodo
| Atajo | Descripción |
| :--- | :--- |
| `super+ctrl+m` | Marcar nodo. |
| `super+ctrl+x` | Bloquear nodo. |
| `super+ctrl+y` | Sticky (visible en todos los desktops). |
| `super+ctrl+z` | Privado. |

### Preselección (división manual)
| Atajo | Descripción |
| :--- | :--- |
| `super+ctrl+h/j/k/l` | **Preseleccionar dirección** (ahí cae la próxima app). |
| `super+ctrl+1..9` | **Preseleccionar proporción** (0.1–0.9). |
| `super+ctrl+espacio` | Cancelar preselección del nodo. |
| `super+ctrl+shift+espacio` | Cancelar preselección del desktop. |

### Mover y redimensionar
| Atajo | Descripción |
| :--- | :--- |
| `super+alt+h/j/k/l` | **Expandir** ventana hacia ese lado. |
| `super+alt+shift+h/j/k/l` | **Contraer** ventana. |
| `super+flechas` | Mover ventana flotante (20px). |

---

## 6. Comandos `bspc` Esenciales (sin atajo)

Útiles desde cualquier terminal con `DISPLAY=:0`:

| Comando | Descripción |
| :--- | :--- |
| `bspc query -D --names` | Listar escritorios. |
| `bspc query -N` | Listar IDs de ventanas abiertas. |
| `bspc rule -l` | Listar reglas por app. |
| `bspc config border_width` | Ver valor actual de una opción. |
| `bspc config window_gap 16` | Cambiar el gap en vivo. |
| `bspc wm -r` | Reiniciar bspwm (recarga `bspwmrc`). |
| `pkill -USR1 -x sxhkd` | Recargar `sxhkdrc` sin reiniciar. |
| `pkill -SIGUSR1 -x kitty` | Recargar `kitty.conf` en terminales abiertas. |

---

## 7. Estructura de la Configuración

- **`~/.config/bspwm/bspwmrc`**: escritorios, bordes, gaps, reglas, autostart (sxhkd, fondo, picom, polybar).
- **`~/.config/bspwm/wallpaper.jpg`**: fondo fijo (ver §10).
- **`~/.config/sxhkd/sxhkdrc`**: todos los atajos (§5).
- **`~/.config/polybar/config.ini`**: barra + módulos. **`launch.sh`**: lanzador (espera socket, exporta `BSPWM_SOCKET`). **`battery.sh` / `wifi.sh`**: batería y WiFi vía Termux:API.
- **`~/.config/picom/picom.conf`**: compositor (log en `~/.config/picom/picom.log`).
- **`~/.config/kitty/kitty.conf`**: terminal (§8).
- **`~/.config/rofi/config.rasi`**: ajustes rofi (el tema va por CLI `-theme`, ver §9).
- **`~/bin/startbspwm`**: lanzador.

---

## 8. Terminal (kitty)

| Opción | Valor | Descripción |
| :--- | :--- | :--- |
| `font_family` | `Hack Nerd Font Mono` | Fuente con iconos (negrita/cursiva en `auto`). |
| `font_size` | `15.0` | Tamaño (acepta decimales). |
| `background_opacity` | `0.92` | Transparencia sutil (requiere picom vivo). |
| `dynamic_background_opacity` | `yes` | `ctrl+shift+a` alterna sólido/transparente. |
| `cursor_shape` | `beam` | Cursor tipo barra. |
| `scrollback_lines` | `5000` | Historial por terminal. |
| `copy_on_select` | `yes` | Copiar al seleccionar. |
| `confirm_os_window_close` | `0` | Cerrar sin preguntar (`super+w`). |

## 9. Opciones del Sistema (bspwmrc + polybar)

### bspwm (`bspwmrc`)
| Opción | Valor | Descripción |
| :--- | :--- | :--- |
| `border_width` | `2` | Grosor del borde de ventana. |
| `window_gap` | `12` | Separación entre ventanas. |
| `split_ratio` | `0.52` | Proporción del split automático. |
| `borderless_monocle` | `true` | Sin borde en monocle. |
| `gapless_monocle` | `true` | Sin gap en monocle. |
| `focused_border_color` | `#7aa2f7` | Borde de ventana activa. |
| `normal_border_color` | `#3b4261` | Borde de ventanas inactivas. |
| `focus_follows_pointer` | `true` | El foco sigue al ratón. |

### polybar (`config.ini`)
| Módulo | Tipo | Descripción |
| :--- | :--- | :--- |
| `bspwm` | interno | Escritorios I–II (clic para cambiar). Requiere `BSPWM_SOCKET` (lo pone `launch.sh`). |
| `cpu` / `memory` | interno | `%` cada 2–3 s. |
| `battery` | script | `battery.sh` → Termux:API cada 30 s. El módulo interno no sirve en Android (SELinux). |
| `wifi` | script | `wifi.sh` → Termux:API cada 15 s. `internal/network` no tiene permiso (netlink denegado). |
| `date` | interno | `%H:%M %d/%m`. |
| `pulseaudio` | interno | Volumen. Requiere `XDG_RUNTIME_DIR=$TMPDIR` (lo pone `launch.sh`). |
| `font-0/1` | — | `monospace:size=15`. Si subes la fuente, sube `height` (38) a la par. |

---

## 10. Guía de Configuración Manual

### Cambiar el fondo
```sh
cp /ruta/a/tu-imagen.jpg ~/.config/bspwm/wallpaper.jpg
DISPLAY=:0 feh --no-fehbg --bg-fill ~/.config/bspwm/wallpaper.jpg
```
Queda fijo: `bspwmrc` siempre usa ese archivo (o color sólido si falta).

### Cambiar fuente/tamaño de la terminal
Edita `~/.config/kitty/kitty.conf` (`font_family`, `font_size`) y recarga sin cerrar nada:
```sh
pkill -SIGUSR1 -x kitty
```

### Cambiar transparencia
`background_opacity 0.85` en `kitty.conf` (más bajo = más transparente). En vivo: `ctrl+shift+a` alterna. Si kitty avisa *"Failed to enable transparency"*, picom está muerto: `pgrep -x picom || (DISPLAY=:0 picom -b --log-file ~/.config/picom/picom.log &)`.

### Cambiar fuente de polybar
`font-0`/`font-1` en `config.ini` + ajusta `height`, luego:
```sh
DISPLAY=:0 XDG_RUNTIME_DIR=$TMPDIR bash ~/.config/polybar/launch.sh
```

### Añadir un atajo propio
1. Abre `~/.config/sxhkd/sxhkdrc`.
2. Añade el bloque (ejemplo: `super+d` → thunar):
```
super + d
	thunar &
```
3. Recarga: `super+Escape` (o `pkill -USR1 -x sxhkd`).

### Añadir una regla por app
En `bspwmrc` (ejemplo: Telegram siempre flotante) y aplica con `bspc wm -r`:
```sh
bspc rule -a TelegramDesktop state=floating
```
Descubre el nombre de clase con `xprop | grep WM_CLASS` y clic en la ventana.

---
*Nota: Escritorio integrado como `termux-desktop-bspwm` en el ecosistema i-Haklab/termux-packages.*
