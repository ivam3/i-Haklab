if status --is-login
bash /data/data/com.termux/files/home/.local/libexec/passwd get
end

function on_exit --on-event fish_exit
echo 'Have a nice hacking day!!'
sleep 1
end

set USER i-Haklab
set fish_theme bira
set -g theme_nerd_fonts yes
set DISPLAY :0
set PULSE_SERVER 127.0.0.1
set PATH /data/data/com.termux/files/usr/bin:/data/data/com.termux/files/home/.local/bin
set HOME /data/data/com.termux/files/home
set GOPATH /data/data/com.termux/files/home/go
set GOROOT /data/data/com.termux/files/usr/lib/go
set JAVA_HOME /data/data/com.termux/files/usr/opt/openjdk
set LD_LIBRARY_PATH /data/data/com.termux/files/usr/lib:/data/data/com.termux/files/home/.local/lib
set TOOLS /data/data/com.termux/files/home/.local/share
alias bat="bat -f --theme 'Visual Studio Dark+'"
