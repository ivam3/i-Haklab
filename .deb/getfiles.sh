#!/usr/bin/bash

[[ -e files.json ]] && rm files.json
touch files.json

find usr -type f > files.txt
find home -type f \
	-not \( -iname "*\.zip" \) \
	-not \( -iname "get.oh-my.fish" \) \
	-not \( -iname "*config.inc.php" \) \
	-not \( -iname "*httpd.php" \) \
	-not \( -iname "*httpd.conf" \) \
	-not \( -iname "proxychains.conf" \) \
	-not \( -iname "checker.py" \) \
	-not \( -iname "openurl.js" \) \
	-not \( -iname "searchsploit_rc" \) \
	-not \( -iname "fixbigdecimal" \) \
	-not \( -iname "PyMiR" \) \
	-not \( -iname "RuGIR" \) \
	-not \( -iname "nrauf" \) \
	-not \( -iname "IbyC-fixer" \) \
	-not \( -iname "*torrc" \) >> files.txt
declare -a files=$(cat files.txt)

for i in ${files[*]}
do
	echo -en "\t\t+$i+: +/data/data/com.termux/files/$i+\n" >> files.json
done
sed -i 's|+|"|g' files.json
sed -i 's|$|,|g' files.json
ln=$(wc -l files.json|awk -F " " '{print $1}')
sed -i "$ln {s/,/ /}" files.json
rm files.txt

cat <<- EOF > manifiest.json
{
  "name": "i-haklab",
  "version": "3.5.0",
  "arch": "all",
  "homepage": "https://github.com/ivam3/i-Haklab",
  "maintainer": "Ivam3 <https://t.me/Ivam3_Bot>",
  "depends": ["termux-api, termux-elf-cleaner, termux-tools, util-linux, x11-repo, apr, apr-util, autoconf, axel, bat, bc, bison, clang, cmake, coreutils, curl, debianutils, dns2tcp, dnsutils, file, findutils, fish, gawk, git, gnupg, gpgme, hexedit, htop-legacy, irssi, libassuan, libcaca, libffi, libgcrypt, libgmp, libgpg-error, libgrpc, libiconv, libmpc, libmpc-static, libmpfr, libmpfr-static, libpcap, libsodium, libsodium-static, libsqlite, libtool, libxml2, libxml2-static, libxml2-utils, libxslt, libxslt-static, make, man, megatools, mlocate, ncurses, ncurses-utils, neofetch, ninja, nmap, openjdk-17, openssh, openssl, openssl-tool, perl, php, php-apache, pkg-config, proxychains-ng, pulseaudio, pv, python, python2, readline, ruby, rust, sqlite, strace, tar, tmux, torsocks, translate-shell, unzip, vim, w3m, weechat, wget, youtubedr, zip, zlib"],
  "suggests": "Termux, Wayland, App",
  "description": "Hacking lab containing an extensive suite of open source tools ported to Termux focused on programming, develop, pentesting, scan/find/explotation/post-explotation of vulnerabilities",
  "files" :{
		$(cat files.json)
  }	
}
EOF
rm files.json 2>/dev/null
