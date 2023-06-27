function pm
  if test "$argv[1]"
    printf '%s' "$(command pm "$argv[1..-1]" 2>&1 < /dev/null)"
  else
    printf '%s' "$(command pm "-h" 2>&1 < /dev/null)"
  end
end
