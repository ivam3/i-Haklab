function github
   cat /storage/0095-4180/Android/media/com.termux/Ivam3/repositories/.token | termux-clipboard-set
	 pushd /storage/0095-4180/Android/media/com.termux/Ivam3/repositories/$argv[1]
	 git add --all
	 git commit -m "$argv[2..-1]"
	 git push
	 popd
end
