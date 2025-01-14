function github
    cat /data/data/com.termux/files/home/Ivam3/repositories/.token | termux-clipboard-set
	pushd /data/data/com.termux/files/home/Ivam3/repositories/$argv[1]
    git add --all
    git commit -m "$argv[2..-1]"
    git push
    popd
end
