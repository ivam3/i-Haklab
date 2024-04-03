# Heramientas relacionadas 

- smdmap
- nmap 


# Enumeracion de recursos

- `-L` Listar los recursos
- `-N` Omitir contraseñas 

```bash
smbclient -L <IP> -N 
```

# Protocolo NT1 

- `-option` Espesificamos una option para smb 

```bash
smbclient -L 192.168.10.123 -N --option='client min protocol=NT1'
```


