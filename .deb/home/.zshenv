# Este archivo se obtiene en todas las invocaciones del shell.
# Si la bandera -f está presente o si la opción no_rcs 
# se establecido dentro de este archivo, todos los demás archivos de inicialización
# se omiten
#
# Este archivo debe contener comandos para configurar el comando.
# ruta de búsqueda, además de otras variables de entorno importantes
# Este archivo no debe contener comandos que produzcan
# salida
#
# Orden global: zshenv, zprofile, zshrc, zlogin

##### Historia de ZSH ########

ZSH="$HOME/.zsh"
export HISTFILE=$ZSH/cache/history     # Mantenga nuestro directorio de inicio ordenado guardando el archivo hist en otro lugar
export SAVEHIST=10000                  # Gran historia
export HISTSIZE=10000                  # Gran historia
export HISTORY_IGNORE="(ls|cd|pwd|exit|sudo reboot|history|cd -|cd ..)"


#### 

export  USER=i-Haklab
export  DISPLAY=:0
export  PULSE_SERVER=127.0.0.1
export  GOPATH="/data/data/com.termux/files/home/go"
export  GOROOT="/data/data/com.termux/files/usr/lib/go"
export  JAVA_HOME="/data/data/com.termux/files/usr/opt/openjdk"
export  LD_LIBRARY_PATH="/data/data/com.termux/files/usr/lib"
export  LLVM_BUILD="/data/data/com.termux/files/usr/lib"
export  LLVM_HOME="/data/data/com.termux/files/usr/lib/cmake/llvm"
export  ANDROID_ALLOW_UNDEFINED_SYMBOLS="On"
export  TOOLS="/data/data/com.termux/files/home/.local/share"

###### 

export BROWSER="firefox"

#
export JAVA_OPTS='-XX:+IgnoreUnrecognizedVMOptions '


# SDK
export ANDROID_HOME=/data/data/com.termux/files/home/.local/share/android-sdk-linux # Ruta al directorio del Android SDK
export PATH=$ANDROID_HOME/tools:$ANDROID_HOME/tools/bin:$PATH
export PATH=$ANDROID_HOME/platform-tools:$PATH
export PATH=$ANDROID_HOME/emulator:$PATH
export PATH=$ANDROID_HOME/build-tools/versión:$PATH  # Reemplaza 'versión' con la versión real
export PATH=$ANDROID_HOME/platforms/android-xx:$PATH  # Reemplaza 'xx' con la versión real
export ANDROID_SDK_ROOT=$ANDROID_HOME


# NDK
export NDK=/data/data/com.termux/files/home/.local/share/android-ndk # Ruta al directorio del Android NDK
export PATH=$NDK:$PATH
export LD=$NDK/toolchains/llvm/prebuilt/linux-x86_64/bin/ld
export AR=$NDK/toolchains/llvm/prebuilt/linux-x86_64/bin/ar
export AS=$NDK/toolchains/llvm/prebuilt/linux-x86_64/bin/as
export RANLIB=$NDK/toolchains/llvm/prebuilt/linux-x86_64/bin/ranlib
export STRIP=$NDK/toolchains/llvm/prebuilt/linux-x86_64/bin/strip
export CFLAGS="-fPIE -fPIC"
export CXXFLAGS="-fPIE -fPIC"
export LDFLAGS="-pie"

##### vcpkg #####
export VCPKG_FORCE_SYSTEM_BINARIES=1
export VCPKG_ROOT="${HOME}/.local/share/vcpkg"
export PATH=$PATH:$VCPKG_ROOT
export CMAKE_MAKE_PROGRAM=/data/data/com.termux/files/usr/bin/ninja
export ANDROID_NDK_HOME=$NDK
