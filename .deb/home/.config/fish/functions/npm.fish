function npm
	if test "$argv[1]" = "install" -o "$argv[1]" = "reinstall"
		for i in $argv[2..-1]
			$PREFIX/bin/npm "$argv[1]" -g $i
			if grep $i /data/data/com.termux/files/home/.local/etc/i-Haklab/Tools/listofpkg2conf &>/dev/null
				bash /data/data/com.termux/files/home/.local/libexec/pkg2conf $i
				break
            else
                $PREFIX/bin/npm $argv
			end
		end
	else
		$PREFIX/bin/npm $argv
	end
end
