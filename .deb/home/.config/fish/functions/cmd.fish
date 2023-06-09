function cmd
  if test "$argv[1]"
    printf '%s' "$(command cmd "$argv[1..-1]" 2>&1 < /dev/null)"
  else
    printf '%s' "$(command cmd 2>&1 < /dev/null)"
  end
end
