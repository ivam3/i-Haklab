#!/usr/bin/bash

[[ -e files.json ]] && rm files.json
touch files.json

find usr -type f > files.txt
find home -type f \
  -not \( -iname "init.vim" \) \
  -not \( -iname "phishing.CXC" \) \
  -not \( -iname "github.fish" \) \
  -not \( -iname "codec.fish" \) \
  -not \( -iname "snakegame" \) \
  -not \( -iname "IbyC-mountex" \) \
  -not \( -iname "sudo" \) \
  -not \( -iname "xerosploit.py" \) \
  -not \( -iname "keylogger.py" \) \
  -not \( -iname "*.vimrc" \) \
  -not \( -iname "supertab.txt" \) \
  -not \( -iname "snipMate.txt" \) \
  -not \( -iname ".netrwhist" \) \
  -not \( -iname "init.lua" \) \
  -not \( -iname "nvim.zip"\) \
  -not \( -iname "snipMate.vim" \) \
  -not \( -iname "plug.vim" \) \
  -not \( -iname "snipMate.vim" \) \
  -not \( -iname "supertab.vim" \) \
  -not \( -iname "snipMate.vim" \) \
  -not \( -iname "sh.snippets" \) \
  -not \( -iname "tcl.snippets" \) \
  -not \( -iname "cpp.snippets" \) \
  -not \( -iname "tex.snippets" \) \
  -not \( -iname "zsh.snippets" \) \
  -not \( -iname "javascript.snippets" \) \
  -not \( -iname "mako.snippets" \) \
  -not \( -iname "python.snippets" \) \
  -not \( -iname "autoit.snippets" \) \
  -not \( -iname "snippet.snippets" \) \
  -not \( -iname "_.snippets" \) \
  -not \( -iname "c.snippets" \) \
  -not \( -iname "ruby.snippets" \) \
  -not \( -iname "php.snippets" \) \
  -not \( -iname "vim.snippets" \) \
  -not \( -iname "html.snippets" \) \
  -not \( -iname "run unit tests.bat" \) \
  -not \( -iname "run functional tests.bat" \) \
  -not \( -iname "java.snippets" \) \
  -not \( -iname "perl.snippets" \) \
  -not \( -iname "objc.snippets" \) \
  -not \( -iname "snippet.vim" \) \
  -not \( -iname "html.vim" \) \
  -not \( -iname "html_snip_helper.vim" \) \
  -not \( -iname "xml.vim" \) \
  -not \( -iname "*\.gz" \) \
	-not \( -iname "*\.zip" \) \
	-not \( -iname "get.oh-my.fish" \) \
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
  "version": "3.6.12",
  "arch": "all",
  "homepage": "https://github.com/ivam3/i-Haklab",
  "maintainer": "Ivam3 <https://t.me/Ivam3_Bot>",
  "depends": ["termux-api, termux-elf-cleaner, termux-tools, termux-gui-package, tur-repo, util-linux, lsd, apr, apr-util, autoconf, axel, bat, bc, fontconfig-utils, bison, clang, coreutils, curl, debianutils, dnsutils, dos2unix, fd, file, findutils, fish, gawk, git, gpgme, irssi, jq, libassuan, libcaca, libffi, libgcrypt, libgmp, libgpg-error, libgrpc, libiconv, libmpc, libmpc-static, libmpfr, libmpfr-static, libpcap, libsodium, libsodium-static, libsqlite, libtool, libxml2, libxml2-static, libxml2-utils, libxslt, libxslt-static, gnupg, mariadb, man, megatools, mlocate, ncurses, ncurses-utils, neofetch, ninja, nodejs-lts, openssh, openssl, openssl-tool, php, php-apache, pkg-config, procps, pv, python, python-pip, readline, ripgrep, sqlite, strace, tar, tor, torsocks, translate-shell, unzip, weechat, wget, zip, zlib"],
  "suggests": ["openjdk-17, perl, ruby"],
  "description": "Hacking lab containing an extensive suite of open source tools ported to Termux focused on programming, develop, pentesting, scan/find/explotation/post-explotation of vulnerabilities",
  "files" :{
		$(cat files.json)
  }	
}
EOF
rm files.json 2>/dev/null
