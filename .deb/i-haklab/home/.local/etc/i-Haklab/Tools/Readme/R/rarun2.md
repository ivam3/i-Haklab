https://man.archlinux.org/man/rarun2.1.en






## Ejemplo

Ejecuta pwn1 con un patrón De Bruijn como primer argumento, dentro del depurador de radare2, y fuerza 32 bits
```bash
r2 -b 32 -d program=pwn1 arg1=$(ragg2 -P 120 -r)
```

RUNS /bin/ls con la salida de exploit.py dirigida a STDIN
```bash
r2 -d program=/bin/ls stdin=$(python3 exploit.py)
```

r2 -r profile.rr2  -d DearQA.DearQA
 ```sh
cat profile.rr2
#!/usr/bin/rarun2
stdin="aaa\naaa\n"
 ```
