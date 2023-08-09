function gitbrowsering
  if ! command -v python >/dev/null
    apt install python -y;clear
  end
	python $HOME/.local/libexec/gitbrowsering.py $argv
end
