function rmcache
  for dir in $TMPDIR ~/.BurpSuite/burpbrowser ~/go/pkg/mod/cache ~/.maltego/v4.3.1/var/cache
    if ls -d $dir >/dev/null 2>/dev/null
      rm -rf $dir 2>/dev/null
      mkdir -p $dir 2>/dev/null
    end
  end
  yes|apt autoremove
  dpkg -l|grep '^rc'|awk '{print $2}'|xargs dpkg --purge 2>/dev/null
  echo "Termux cache was removed."
end
