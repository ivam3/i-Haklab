# Para verificar permisos
```sh
aapt dump badging `pm path com.termux --user 0 2>&1 </dev/null | cut -d":" -f2` | \grep -o android.permission.DUMP | bat
```