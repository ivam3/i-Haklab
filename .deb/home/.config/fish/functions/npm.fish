function npm
	if test "$argv[1]" = "install" -o "$argv[1]" = "update"
        pushd $HOME
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
                        npm install -g $m
                    end 
                    # PREPARE ENVIRONMENT 
                    echo "(_>) Preparing n8n environment ..."
                    mkdir -p $HOME/{.n8n,.gyp} 
                    echo "{'variables':{'android_ndk_path':''}}" > $HOME/.gyp/include.gypi 

                case pnpm
                    corepack enable

                case open-lovable
                    if ls $HOME/.local/share/open-lovable &>/dev/null
                        rm -rf $HOME/.local/share/open-lovable
                    end
                    git clone --quiet https://github.com/firecrawl/open-lovable.git \
                        $HOME/.local/share/open-lovable
                    cd $HOME/.local/share/open-lovable
                    corepack enable
                    $PREFIX/bin/npm $argv[1]
                    break
                    
                case -g --global
                   set g $i 
            end
            $PREFIX/bin/npm $argv[1] $g $i 
            if grep $i /data/data/com.termux/files/home/.local/etc/i-Haklab/Tools/listofpkg2conf &>/dev/null  
                bash /data/data/com.termux/files/home/.local/libexec/pkg2conf $i
            end 
        end

    else if test "$argv[1]" = "uninstall"
        pushd $HOME
		for i in $argv[2..-1]
            switch $i 
                case 'n8n'
                    rm /data/data/com.termux/files/home/.config/fish/functions/n8n.fish 
                
                case -g --global
                    set g $i

                case open-lovable 
                    if ls $HOME/.local/share/open-lovable &>/dev/null
                        rm -rf $HOME/.local/share/open-lovable
                    end
            end
            $PREFIX/bin/npm $argv[1] $g $i 
        end
	else
		$PREFIX/bin/npm $argv
	end
    popd 2>/dev/null
end
