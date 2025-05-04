
- Referencia de servicios de accesibilidad 
```
aapt d xmltree <apk> AndroidManifest.xml | grep -E "accessibility"
```

- Actividad principal 
```
aapt dump badging basic_rev.apk | grep launchable-activity
```

- Ver el nombre de el paquete 
```
aapt dump badging <apk> | grep package:\ name
```

- Volcado permiso 
```sh
aapt d permissions <apk>
```

