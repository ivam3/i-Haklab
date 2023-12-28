
`pm uninstall -k --user 0 <name of package>`

#### Ejemplo: 

Si desea desinstalar la aplicación de Facebook,  `pm uninstall -k --user 0 com.facebook.katanay` 

#### Para cambiar permisos

```sh
<<<`pm dump com.termux --user 0 2&>1 </dev/null | grep -m1 permission.DUMP`
```