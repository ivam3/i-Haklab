#   
if test -f "$PREFIX/etc/apt/sources.list.d/ivam3-termux-packages.list" 
    #  --->  Nada  por   ahora   
else
  echo "ADVERTENCIA: ivam3-termux-packages.list NO existe. Asegúrate de instalarlo."
end  

if status is-interactive
  # Commands to run in interactive sessions can go here
	# Example :
  #  if CONDITION; COMMANDS_TRUE ...;
	#  [else if CONDITION2; COMMANDS_TRUE2 ...;]
	#  [else; COMMANDS_FALSE ...;]
	#  end
end
