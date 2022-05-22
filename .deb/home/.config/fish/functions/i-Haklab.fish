function i-Haklab
	if test (count $argv) -eq 0 >/dev/null
		set argv help
	else if test $argv[1] = "password"
		set argv passwd pass
	else if ! ls /data/data/com.termux/files/home/.local/libexec/i-Haklab/$argv[1] &>/dev/null
		echo -en "\e[31m(➤_)\e[0m missing argument, type i-Haklab help for helpper"
	end
	bash /data/data/com.termux/files/home/.local/libexec/i-Haklab/$argv[1] $argv[2..-1]
end

