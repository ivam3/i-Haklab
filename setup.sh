#!/data/data/com.termux/files/usr/bin/bash
IFS=$'\n\t'
trap ctrl_c 2

yes|pkg install wget
wget --tries=20 --quiet \
	https://raw.githubusercontent.com/ivam3/termux-packages/gh-pages/ivam3-termux-packages.list \
	-O ${PREFIX}/etc/apt/sources.list.d/ivam3-termux-packages.list
yes|apt update
yes|apt upgrade
apt install i-haklab

d=$(dirname $0|awk -F "/" '{print $NF}') 
[[ $d = "i-Haklab" ]] && { rm -rf $(dirname $0);}

