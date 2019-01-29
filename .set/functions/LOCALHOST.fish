function LOCALHOST
	ifconfig wlan0 | grep -oE '([0-9]{1,3}\.){3}[0-9]{1,3}' | grep -v 255
end
