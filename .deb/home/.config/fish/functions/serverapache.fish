function serverapache
	if test (count $argv) -eq 0 >/dev/null
		echo -en "\e[33mUsage:\e[0m serverapache <start|stop|restart>"
	else
    apachectl $argv
    if test (pidof httpd) >/dev/null
      echo -en "\e[32mserver:\e[0m http://127.0.0.1:8080"
      sleep 1
      termux-open-url http://127.0.0.1:8080
    end
	end
end
