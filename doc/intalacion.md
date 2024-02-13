
# Intalacion 

1 - Sirve para recuperar material en línea.

```
apt install wget 
```

2 - Instalacion  

```sh 
apt install wget && \
mkdir -p $PREFIX/etc/apt/sources.list.d && \
wget https://raw.githubusercontent.com/ivam3/termux-packages/gh-pages/ivam3-termux-packages.list -O $PREFIX/etc/apt/sources.list.d/ivam3-termux-packages.list && \
apt update && yes|apt upgrade && \
apt install i-haklab
```
