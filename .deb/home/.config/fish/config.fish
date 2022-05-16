if status is-interactive
  # Commands to run in interactive sessions can go here
	# Example :
  #  if CONDITION; COMMANDS_TRUE ...;
	#  [else if CONDITION2; COMMANDS_TRUE2 ...;]
	#  [else; COMMANDS_FALSE ...;]
	#  end

  if test -f /data/data/com.termux/files/usr/bin/fish
	if ! grep -oE "i-Haklab" /data/data/com.termux/files/usr/etc/fish/config.fish >/dev/null
		and ! -h /data/data/com.termux/files/usr/etc/fish/config.fish
			echo -en "\e[33mWARNING:\e[0m Setting shell ..."
			rm /data/data/com.termux/files/usr/etc/fish/config.fish
			ln -s /data/data/com.termux/files/home/.local/etc/fish/config.fish /data/data/com.termux/files/usr/etc/fish/config.fish
	end
	chsh -s fish
  else
	echo -en "\e[33mWARNING:\e[0m Shell missing, installing ..."
	yes|apt install fish &>/dev/null 2>/dev/null
	exit
  end
end
