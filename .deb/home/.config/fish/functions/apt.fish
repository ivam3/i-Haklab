function apt
	if test "$argv[1]" = "install" -o "$argv[1]" = "reinstall"
		for i in $argv[2..-1]
			switch $i
				
				case bloodhound frida h8mail hashid holehe objection octosuite orbitaldump osrframework phoneintel scrapy shodan snscrape speedtest-cli sqlmap wfuzz
					echo -en "\e[31mE:\e[0m $i is a python module, you should try it with \e[33m'python -m pip install $i'\e[0m\n"

                case sherlock
                    if ! test $PREFIX/etc/apt/sources.list.d/tur.list
					    echo -en "\e[31mE:\e[0m $i require tur-repo package \e[33m|\e[0m please install it with \e[33m'apt install tur-repo'\e[0m\n"
                    end
				
                case bettercap aquatone
					echo -en "\e[31mE:\e[0m $i is a ruby gem, you should try it with \e[33m'gem install $i'\e[0m\n"
				
				case bash-obfuscate localtunnel n8n twifo-cli
                    if [ "$i" = "n8n" ]
                        set arg2 "--sqlite=\$PREFIX/bin/sqlite3"
                    end

					echo -en "\e[31mE:\e[0m $i is a nodejs module, you should try it with \e[33m'npm install -g $i $arg2'\e[0m\n"

				case omf
					if command -v fish >/dev/null
						echo "Installing oh-my-fish over fish shell ..."
						curl -fsSL "https://raw.githubusercontent.com/ivam3/i-Haklab/master/.deb/home/.local/etc/i-Haklab/get.oh-my.fish" -o $TMPDIR/omf.fish
						fish $TMPDIR/omf.fish
						rm $TMPDIR/omf.fish
					else
						echo -en "\e[31mE:\e[0m Fish needed, you should try it with \e[33m'apt install fish'\e[0m\n"
					end

				case '*'
					$PREFIX/bin/apt "$argv[1]" $i
					if grep $i /data/data/com.termux/files/home/.local/etc/i-Haklab/Tools/listofpkg2conf &>/dev/null
						bash /data/data/com.termux/files/home/.local/libexec/pkg2conf $i
						break
					end
			end
		end
	else
		$PREFIX/bin/apt $argv
	end
end
