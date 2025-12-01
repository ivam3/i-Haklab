function npm
    pushd $HOME
	if test "$argv[1]" = "install" -o "$argv[1]" = "reinstall"
		for i in $argv[2..-1]
            if test "$i" = "n8n" 
                # INSTALL DEPENDENCIES 
                for p in nodejs-lts libsqlite sqlite
                    echo "(_>) Installing $p ..."
                    yes|apt install $p >/dev/null 2>/dev/null
                end 
                # INSTALL NPM GLOBAL PACKAGES 
                for m in pm2 gyp node-gyp
                    echo "(_>) Installing $m ..."
                    npm install -g $m
                end 
                # PREPARE ENVIRONMENT 
                echo "(_>) Preparing n8n environment ..."
                mkdir -p $HOME/{.n8n,.gyp} 
                echo "{'variables':{'android_ndk_path':''}}" > $HOME/.gyp/include.gypi 
            end

            echo "(_>) Installing $i ..."
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
    popd 2>/dev/null
end
