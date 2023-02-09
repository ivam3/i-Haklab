function rmcache
  rm -rf ~/.cache 2>/dev/null
  rm -rf $TMPDIR/* 2>/dev/null
  dpkg -l|grep '^rc'|awk '{print $2}'|xargs dpkg --purge 2>/dev/null
  echo "Termux cache was removed."
end
