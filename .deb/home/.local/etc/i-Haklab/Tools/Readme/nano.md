# nano

## ¿Qué es nano?

GNU `nano` es un editor de texto pequeño, amigable y fácil de usar para la línea de comandos en sistemas Unix y Linux. Fue diseñado como una alternativa libre a Pico, el editor del cliente de correo Pine. Su principal característica es la simplicidad, mostrando siempre las teclas de acceso directo disponibles en la parte inferior de la pantalla.

## ¿Para qué es útil la herramienta?

`nano` es la herramienta de elección para:

*   **Edición Rápida:** Modificar archivos de configuración sin salir de la terminal.
*   **Principiantes:** Usuarios que no están familiarizados con editores modales complejos como Vim.
*   **Disponibilidad:** Está preinstalado en casi todas las distribuciones Linux y entornos Unix.
*   **Simplicidad:** No requiere memorizar comandos; las instrucciones están en pantalla.

## ¿Cómo se usa? (Ejemplos básicos)

El uso de nano es muy directo. Se controla mediante combinaciones de teclas con `Ctrl` (representado como `^` en la interfaz).

**Ejemplo 1: Abrir o crear un archivo**

```bash
nano archivo.txt
```
Si el archivo existe, lo abre. Si no, comienza uno nuevo en blanco.

**Ejemplo 2: Guardar cambios**

Una vez que has editado el texto:
1.  Presiona `Ctrl + O` (Write Out).
2.  Confirma el nombre del archivo presionando `Enter`.

**Ejemplo 3: Buscar texto**

1.  Presiona `Ctrl + W` (Where Is).
2.  Escribe el texto a buscar y presiona `Enter`.

**Ejemplo 4: Salir**

Presiona `Ctrl + X`. Si tienes cambios sin guardar, te preguntará si quieres guardarlos (Y/N).

## Consideraciones Adicionales

*   **Resaltado de Sintaxis:** Nano soporta resaltado de colores para muchos lenguajes de programación y archivos de configuración (generalmente configurado en `/etc/nanorc` o `~/.nanorc`).
*   **Copiar y Pegar:**
    *   `Ctrl + K`: Corta (elimina) la línea actual.
    *   `Ctrl + U`: Pega (des-corta) el texto cortado.
*   **Números de línea:** Puedes iniciar nano con `nano -c archivo.txt` para ver números de línea constantemente.

---
*Nota: Aunque menos potente que Vim o Emacs para desarrollo complejo, Nano es el editor de facto para ediciones rápidas y sencillas en el servidor.*
