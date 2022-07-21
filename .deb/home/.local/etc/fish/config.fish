# Put system-wide fish configuration entries here
# or in .fish files in conf.d/
# Files in conf.d can be overridden by the user
# by files with the same name in $XDG_CONFIG_HOME/fish/conf.d

# This file is run by all fish instances.
# To include configuration only for login shells, use
# if status is-login
#    ...
# end
# To include configuration only for interactive shells, use
# if status is-interactive
#   ...
# end

function __fish_command_not_found_handler --on-event fish_command_not_found
	/data/data/com.termux/files/usr/libexec/termux/command-not-found $argv[1]
end

if status --is-login
bash /data/data/com.termux/files/home/.local/libexec/i-Haklab.login
end

function on_exit --on-event fish_exit
echo 'Have a nice hacking day!!'
sleep 1
end

set USER i-Haklab
set fish_theme will
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
alias postgresql="pg_ctl -D /data/data/com.termux/files/usr/var/lib/postgresql"

