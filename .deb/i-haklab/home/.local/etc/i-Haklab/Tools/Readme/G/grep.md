#  Excluir palabras y patrones

```sh
grep -wv <patron>
```

# Para dos o mas patones 
```sh
grep -wv -e <patron> -e <patron>
```

### Búsqueda reculsiva 
```bash 
grep -iR "cadena a buscar "
```