```sh
termux-apt-repo [-h] [--use-hard-links] entrada salida [dist] [comp]
argumentos posicionales:
carpeta de entrada donde se encuentran los archivos .deb
carpeta de salida con árbol de repositorio
dist nombre de la carpeta de distribución. Los archivos deb se colocan en
                  salida/dists/distribución/componente/binario-$ARCH/
nombre comp de la carpeta del componente. Los archivos deb se colocan en
                  salida/dists/distribución/componente/binario-$ARCH/
argumentos opcionales:
-h, --help muestra este mensaje de ayuda y sale
--use-hard-links utiliza enlaces físicos en lugar de copiar archivos deb. No trabajará
                  en un dispositivo Android
-s --sign firmar repositorio con clave GPG
```

# wep
`https://github.com/termux/termux-apt-repo`

