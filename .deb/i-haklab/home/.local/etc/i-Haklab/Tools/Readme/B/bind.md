2. Crear una nueva combinación de teclas

La creación de combinaciones de teclas personalizadas es una característica importante del comando bind en Linux. Con la ayuda de estos, podemos llamar a cualquier función sin usar su nombre completo o ejecutar nuestras macros con una sola tecla. Asignemos la tecla Ctrl+u para imprimir 'hola' en la pantalla.

```bash
bind '"\C-u":"Hello!"'
```
Como puede ver, `Ctrl` está representado por` \C- `en el comando anterior. 


