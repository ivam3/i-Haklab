function df
	if test ! $(command -v duf) >/dev/null
		yes|apt install duf
	end
	duf $args
end
