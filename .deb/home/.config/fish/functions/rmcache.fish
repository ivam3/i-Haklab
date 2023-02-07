function rmcache
	if test "~/.cache"
    rm -rf ~/.cache
  end
  dpkg -l|grep '^rc'|awk '{print $2}'|xargs dpkg --purge 2>/dev/null
end
