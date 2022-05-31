function proxy
	if test (count $argv) -eq 0 >/dev/null
		echo (set_color -u yellow)"""usage:"(set_color normal)" proxy "(set_color yellow)"<"(set_color normal)"option or command to execute"(set_color yellow)">

"(set_color -u)"OPTIONS "(set_color normal)"        "(set_color -u yellow)"DESCRIPTON"(set_color normal)"
 start     Enable proxy over tor network
 stop      Disable proxy connection
  ip       Get current proxy IP
 chip      Change current proxy IP

  any      Execute any command over tor proxychain
command    "(set_color -u yellow)"ex:"(set_color -u normal)" proxy nmap -p- -Pn 8.8.8.8"""
	else
		bash /data/data/com.termux/files/home/.local/libexec/proxy $argv
	end
end
