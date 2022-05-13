function sudo
	command -v proot >/dev/null || yes|apt install proot
	if test (count $argv) -eq 0 >/dev/null
		echo -en "\e[33mUSAGE : [\e[0msudo su\e[33m]-(\e[0mRun a shell as fake root user\e[33m)\n\t[\e[0msudo some-command\e[33m]-(\e[0mRun command as fake root user\e[33m)\e[0m"
	else if test $argv[1] = "su"
		proot -0 -w ~ termux-chroot $SHELL
	else
		proot -0 -w ~ termux-chroot $argv
	end
end
