# Listar aplicasiones 
```sh  
aapt dump badging archivo.apk | awk '/package/{gsub("name=|'\''",""); package=$2} /activity/{gsub("name=|'\''",""); activity=$2} END{print package "/" activity}'
```

# Para verificar permisos
```sh
aapt dump badging `pm path com.termux --user 0 2>&1 </dev/null | cut -d":" -f2` | \grep -o android.permission.DUMP | bat
```

# Volcando permisos
```sh
aapt d permissions <APK> 
```
