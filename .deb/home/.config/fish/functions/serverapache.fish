function serverapache
	if test (count $argv) -eq 0 >/dev/null
		echo -en "\e[33mUsage:\e[0m serverapache <start|stop|restart>"
	else
   apachectl $argv
	end
end
