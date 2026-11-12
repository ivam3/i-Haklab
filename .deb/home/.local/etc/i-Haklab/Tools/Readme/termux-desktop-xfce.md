# XFCE Graphical Desktop Environment on Termux (`desktop`) 🖥️🎭

The **`termux-desktop-xfce`** project is an advanced integration that runs the
lightweight **XFCE4** desktop environment natively on Android.

Unlike traditional VNC-based virtualization, which adds latency and reduces
image quality, this integration uses the **`termux-x11`** display server to
interact directly with the Android interface. This provides smooth rendering,
clipboard synchronization and integrated audio output.

---

## 🚀 1. Starting the Environment: The `desktop` Command

The startup sequence, environment variables and graphical subprocesses are
automated by the **`desktop`** command.

### Usage:

* **Start the desktop (native Termux-X11 - recommended):**

  ```bash
  i-Haklab desktop
  ```

> The old `i-Haklab Xwayland` option was replaced by
> `i-Haklab desktop`.

---

## ⚙️ 2. Internal Script Execution Flow

When you run `desktop`, the system performs the following steps in the
background:

1. **Window environment configuration**:
   Defines the Linux environment variables required for graphical rendering and
   keyboard support:

   ```bash
   export DISPLAY=:0
   export XDG_RUNTIME_DIR=${TMPDIR}
   export XKB_CONFIG_ROOT=${PREFIX}/share/xkeyboard-config-2/
   ```

2. **Automatic dependency check**:
   The script verifies that the required tools are installed. If support
   submodules are missing, it clones the Termux-X11 support repository and
   initializes it transparently.

3. **Start the audio server (PulseAudio)**:
   Starts the audio service and configures the native TCP module so desktop
   applications can send sound to the Android device:

   ```bash
   pulseaudio --start --exit-idle-time=-1
   pacmd load-module module-native-protocol-tcp auth-ip-acl=127.0.0.1 auth-anonymous=1
   ```

4. **Launch the Android viewer**:
   Uses Android activity commands (`am`) to open the installed viewer
   application automatically:

   ```bash
   am start -n com.termux.x11/com.termux.x11.MainActivity
   ```

5. **Launch the window server**:
   Starts the selected X server in the background (`termux-x11 :0` by default).

6. **Start the desktop session**:
   Runs the XFCE4 session with output directed to the configured display:

   ```bash
   xfce4-session --display=:0
   ```

7. **Clean shutdown on exit**:
   When you leave the XFCE4 desktop session, the script stops PulseAudio and
   closes the remaining display processes to save battery and RAM.

---
*Note: Tool integrated into the i-HakLab ecosystem.*
