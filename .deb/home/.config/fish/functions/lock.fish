function lock
	if test ! $(command -v cacafire) >/dev/null
		yes|apt install libcaca
	end
	cacafire
	reset 2>/dev/null
end
