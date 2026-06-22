# Entorno de Escritorio Gráfico XFCE en Termux (`desktop`) 🖥️🎭

El proyecto **`termux-desktop-xfce`** es una integración avanzada de la suite que permite ejecutar el entorno de escritorio ligero **XFCE4** directamente sobre tu dispositivo Android de forma nativa. 

A diferencia de las soluciones tradicionales de virtualización basadas en VNC que introducen una alta latencia y pérdida de calidad, esta integración aprovecha los servidores de ventanas **`termux-x11`** y **`Xwayland`** para interactuar directamente con la interfaz del sistema operativo, logrando la máxima fluidez, sincronización de portapapeles y salida de audio integrada.

---

## 🚀 1. Ejecución del Entorno: El Comando `desktop`

El proceso de arranque, configuración de variables e inicio de los subprocesos gráficos se encuentra automatizado a través del comando **`desktop`**.

### Sintaxis de uso:
* **Arrancar con Termux-X11 (Servidor nativo - Recomendado)**:
  ```bash
  desktop
  ```
* **Arrancar empleando Xwayland (Alternativa de compatibilidad)**:
  ```bash
  desktop Xwayland
  ```

---

## ⚙️ 2. Flujo Interno de Ejecución del Script

Cuando ejecutas el comando `desktop`, el sistema realiza los siguientes pasos en segundo plano:

1. **Configuración del Entorno de Ventanas**:
   Define las variables de entorno de Linux necesarias para el renderizado gráfico y el soporte de teclado:
   ```bash
   export DISPLAY=:0
   export XDG_RUNTIME_DIR=${TMPDIR}
   export XKB_CONFIG_ROOT=${PREFIX}/share/xkeyboard-config-2/
   ```

2. **Verificación Automática de Dependencias**:
   El script comprueba que las herramientas requeridas estén instaladas. Si faltan submódulos, se clona el repositorio de soporte de Termux-X11 y se inicializan de forma transparente para el usuario.

3. **Inicio del Servidor de Audio (PulseAudio)**:
   Se levanta el servicio de audio configurando el módulo de red nativo sobre TCP local para redireccionar el sonido de las aplicaciones del escritorio hacia el hardware del móvil Android:
   ```bash
   pulseaudio --start --exit-idle-time=-1
   pacmd load-module module-native-protocol-tcp auth-ip-acl=127.0.0.1 auth-anonymous=1
   ```

4. **Lanzamiento de la Interfaz del Visor Android**:
   Mediante comandos de actividad de Android (`am`), se levanta automáticamente la aplicación visor instalada en el dispositivo:
   ```bash
   am start -n com.termux.x11/com.termux.x11.MainActivity
   ```

5. **Lanzamiento del Servidor de Ventanas**:
   Se inicia en segundo plano el servidor gráfico correspondiente (`termux-x11 :0` o `Xwayland :0`).

6. **Arranque de la Sesión de Escritorio**:
   Finalmente, se ejecuta la sesión de XFCE4 redirigiendo la salida hacia el display configurado:
   ```bash
   xfce4-session --display=:0
   ```

7. **Apagado Limpio al Finalizar**:
   Una vez que sales de la sesión de escritorio XFCE4, el script detiene automáticamente PulseAudio y cierra de forma limpia todos los procesos de visualización que queden en segundo plano para conservar batería y memoria RAM.
