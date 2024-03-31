[[curl]]

Lee documentos HTML de los _archivos de entrada

```
curl -s 10.10.11.167 | html2text | grep htb | tr -d ' *'
Carpediem.htb
```

