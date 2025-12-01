function apt
	if test "$argv[1]" = "install" -o "$argv[1]" = "reinstall" -o "$argv[1]" = "search"

		for i in $argv[2..-1]
			switch $i
				
				case bloodhound frida h8mail hashid holehe objection octosuite orbitaldump osrframework phoneintel scrapy shodan snscrape speedtest-cli sqlmap wfuzz
                    set method "python3 -m pip install"
					echo -en "\e[31mE:\e[0m $i is a python module, you should try it with \e[33m'$method $i'\e[0m\n"
                    echo "(_>) you want me to run it for you? "
                    while true
                        read -p "(y/n): " yesornot
                        switch $yesornot
                            case y Y yes YES
                                eval $method $i
                                break
                            case n N no NO
                                echo "Aborting ..."
                                break
                            case '*'
                                echo "Please answer y or n."
                        end
                    end
                    continue # Continue to the next package in the for loop

				
                case bettercap aquatone
                    set method "gem install"
					echo -en "\e[31mE:\e[0m $i is a ruby gem, you should try it with \e[33m'$method $i'\e[0m\n"
                    echo "(_>) you want me to run it for you? "
                    while true
                        read -p "(y/n): " yesornot
                        switch $yesornot
                            case y Y yes YES
                                eval $method $i
                                break
                            case n N no NO
                                break
                            case '*'
                                echo "Please answer y or n."
                        end
                    end
                    continue # Continue to the next package in the for loop

				
				case bash-obfuscate localtunnel n8n twifo-cli
                    set method "npm install -g"
					echo -en "\e[31mE:\e[0m $i is a nodejs module, you should try it with \e[33m'$method $i'\e[0m\n"
                    echo "(_>) you want me to run it for you? "
                    while true
                        set yesornot (read -P "(y/n): ")
                        switch $yesornot
                            case y Y yes YES
                                eval $method $i
                                break
                            case n N no NO
                                break
                            case '*'
                                echo "Please answer y or n."
                        end
                    end
                    continue # Continue to the next package in the for loop


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
