
# SMB 

- `-p` Indicamos puerto 
- `--script` Indicamos script a usar 

```
nmap -p 139,445 --script smb-enum-shares <IP> 
```


# Busque algunos servidores web a través de proxy

```bash
proxychains nmap -sT -PO -p 80 -iR 
```

Solo los redireccionamientos abiertos que están vinculados directamente en el sitio web de destino se pueden descubrir de esta manera. Si un redirector abierto no está vinculado, no se detectará.

```bash
nmap --script=http-open-redirect <target>
```

 a través de proxy)
