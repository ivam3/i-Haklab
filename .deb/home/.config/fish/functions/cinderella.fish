function cinderella
	if test (ls /data/data/com.termux/files/home/.local/libexec/cinderella 2>/dev/null)
		bash /data/data/com.termux/files/home/.local/libexec/cinderella $argv
	else
		echo -en "\e[31m(➤_)\e[0m missing argument, type i-Haklab help for helpper\n"
	end
end

