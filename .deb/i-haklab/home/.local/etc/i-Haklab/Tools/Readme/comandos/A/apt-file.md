## Buscar archivos dentro de paquetes

## Syntax
```sh
apt-file [options] [action] [pattern]
apt-file -f [options] search [file...]
apt-file -D [options] search [debian-package-name.deb...]
```
## Actions

- `find` Lo mismo que **search**
- `list` Enumere todos los archivos contenidos en paquetes cuyos nombres coincidan con el patrón.  Se enumera un archivo por línea.
- `purge` Borre los archivos "Contenido-" del directorio de caché de archivos apt.  Si recibe algún error en la lista o en la búsqueda, es una buena idea realizar una limpieza y luego una actualización.
- `search`Busque un archivo cuyo nombre coincida con el patrón, dentro de todos los paquetes disponibles.  No se buscan nombres de directorios, sólo nombres de archivos. 
- `update` Actualice la caché de usuario de apt-file del contenido del paquete de todas las fuentes APT configuradas.



