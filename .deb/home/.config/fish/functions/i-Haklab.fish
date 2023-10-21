function i-Haklab
  if test (count $argv) -gt 0
    if test -f /data/data/com.termux/files/home/.local/libexec/i-Haklab/$argv[1]
		  bash /data/data/com.termux/files/home/.local/libexec/i-Haklab/$argv[1] $argv[2..-1]
    else
		  echo -en "\e[31m(➤_)\e[0m invalid argument, type i-Haklab help for helpper\n"
    end
  else
		echo -en "\e[31m(➤_)\e[0m missing argument, type i-Haklab help for helpper\n"
  end
end

