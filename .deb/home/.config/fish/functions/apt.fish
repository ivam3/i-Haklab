function apt
	if test "$argv[1]" = "install"
		for i in $argv[2..-1]
			switch $i
				
				case frida h8mail objection osrframework scrapy shodan speedtest-cli sqlmap wfuzz
					echo -en "\e[31mE:\e[0m $i is a python module, you should try it with \e[33m'python -m pip install $i'\e[0m\n"
				
				case bettercap
					echo -en "\e[31mE:\e[0m $i is a ruby gem, you should try it with \e[33m'gem install $i'\e[0m\n"
				
				case localtunnel-server
					echo -e  "\e[31mE:\e[0m $i is a node module, you should try it with \e[33m'npm install -g $i'\e[0m\n"
				
				case '*'
					pkg install $i
					if grep $i /data/data/com.termux/files/home/.local/etc/i-Haklab/Tools/listOfpkg2conf &>/dev/null
					echo "Setting $i ..."
					bash /data/data/com.termux/files/home/.local/libexec/pkg2conf $i
					break
			end
		end
		end
	else
		pkg $argv
	end
end
