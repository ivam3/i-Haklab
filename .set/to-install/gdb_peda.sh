#!/usr/bin/bash
IFS=$'\n\t'
source $HOME/.local/share/i-Haklab/.set/var/variables
source $iHAKLAB/.set/functions/functions
yes|apt install git gdb
git clone --quiet https://github.com/longld/peda.git $TOOLS/peda
[[ -e ~/.gdginit ]] && touch ~/.gdbinit
echo "source $TOOLS/peda/peda.py" >> ~/.gdbinit
