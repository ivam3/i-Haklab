
# Informacion 

1. `apt install wget`: Este comando instala la herramienta `wget`, que se utiliza para descargar archivos desde la web. Es similar a un gestor de descargas.

2. `mkdir -p $PREFIX/etc/apt/sources.list.d`: Este comando crea un directorio llamado `sources.list.d` en la ruta `$PREFIX/etc/apt/`. `$PREFIX` es una variable que generalmente apunta al directorio de instalación de Termux.

3. `wget https://raw.githubusercontent.com/ivam3/termux-packages/gh-pages/ivam3-termux-packages.list -O $PREFIX/etc/apt/sources.list.d/ivam3-termux-packages.list`: Aquí, `wget` se utiliza para descargar un archivo llamado `ivam3-termux-packages.list` desde GitHub y guardarlo en el directorio `sources.list.d` recién creado.

4. `apt update`: Este comando actualiza la lista de paquetes disponibles en los repositorios de Termux. Es similar a actualizar el catálogo de aplicaciones disponibles.

5. `yes|apt upgrade`: El comando `apt upgrade` actualiza todos los paquetes instalados en el sistema. El `yes` que precede al comando `apt upgrade` simplemente envía la entrada "yes" (sí) automáticamente cuando se le solicita la confirmación de actualización.

6. `apt install i-haklab`: Por último, este comando instala nustro laboratorio `i-haklab`

# Todo junto (Recomendado)

```sh 
apt install wget && \
mkdir -p $PREFIX/etc/apt/sources.list.d && \
wget https://raw.githubusercontent.com/ivam3/termux-packages/gh-pages/ivam3-termux-packages.list -O $PREFIX/etc/apt/sources.list.d/ivam3-termux-packages.list && \
apt update && yes|apt upgrade && \
apt install i-haklab
```
