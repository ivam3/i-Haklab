function pnpm
    pushd $HOME
	if test "$argv[1]" = "install" -o "$argv[1]" = "update"
		for i in $argv[2..-1]
            if test "$i" = "gemini-cli"
                set i "@google/gemini-cli"
            end
            switch $i 
                case n8n
                    # INSTALL DEPENDENCIES 
                    for p in nodejs-lts libsqlite sqlite
                        echo "(_>) Installing $p ..."
                        yes|apt install $p >/dev/null 2>/dev/null
                    end 
                    # INSTALL NPM GLOBAL PACKAGES 
                    for m in pm2 gyp node-gyp
                        echo "(_>) Installing $m ..."
                        pnpm install -g $m
                    end 
                    # PREPARE ENVIRONMENT 
                    echo "(_>) Preparing n8n environment ..."
                    mkdir -p $HOME/{.n8n,.gyp} 
                    echo "{'variables':{'android_ndk_path':''}}" > $HOME/.gyp/include.gypi 
                    
                case -g --global
                    continue

                case '*'
                    $PREFIX/bin/pnpm "$argv[1]" -g $i
                    if grep $i /data/data/com.termux/files/home/.local/etc/i-Haklab/Tools/listofpkg2conf &>/dev/null  
                        bash /data/data/com.termux/files/home/.local/libexec/pkg2conf $i
                        break 
                    else
                        $PREFIX/bin/npm $argv 
                    end 
            end
        end
	else
		$PREFIX/bin/pnpm $argv
	end
    popd 2>/dev/null
end
