function lock
	if test ! $(command -v cacafire) >/dev/null
		yes|apt install libcaca
	end
	cacafire
	bash $HOME/.local/libexec/i-Haklab.login
end
