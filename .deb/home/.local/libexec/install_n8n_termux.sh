#!/data/data/com.termux/files/usr/bin/bash
set -euo pipefail

echo "==> Asegúrate de que Termux está instalado desde:"
echo "    - https://github.com/termux/termux-app/releases"
echo "    - o los Termux Packages de IvanByCinderella: https://github.com/IvanByCinderella/termux-packages"
echo "==> No uses la versión de Google Play (obsoleta)."
set -euo pipefail

echo "==> 1) Actualizar Termux"
pkg update -y && pkg upgrade -y

echo "==> 2) Instalar dependencias de compilación y runtime"
pkg install -y nodejs-lts python binutils make clang pkg-config libsqlite ndk-sysroot

echo "==> 3) Solución NDK para node-gyp"
export GYP_DEFINES="android_ndk_path=''"

echo "==> 4) Instalar n8n con SQLite embebido (ruta de Termux)"
npm install -g n8n --sqlite=/data/data/com.termux/files/usr/bin/sqlite3

echo "==> 5) Instalar PM2 (gestor de procesos)"
npm install -g pm2

echo "==> 6) Crear carpeta de datos de n8n (si no existe)"
mkdir -p $HOME/.n8n

echo "==> 7) Añadir resurrect de PM2 al bashrc (si no existe)"
grep -q "pm2 resurrect" "$HOME/.bashrc" || echo "
pm2 resurrect" >> "$HOME/.bashrc"

echo "==> Listo. Ejecuta scripts/start_n8n_pm2.sh para iniciar."
