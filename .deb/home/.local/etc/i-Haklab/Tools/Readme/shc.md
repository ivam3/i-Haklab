# shc (Shell Script Compiler)

## ¿Qué es shc?

`shc` es una utilidad de línea de comandos que actúa como un "compilador" de scripts de shell. Su propósito principal es tomar un script de shell (por ejemplo, un archivo `.sh`) y convertirlo en un archivo binario ejecutable.

Sin embargo, no es un compilador en el sentido tradicional como `gcc` para C. En lugar de convertir el script a código máquina, `shc` envuelve el script en un ejecutable de C, lo encripta y lo comprime. Cuando se ejecuta el binario resultante, este desencripta y ejecuta el script original en memoria utilizando el intérprete de shell especificado en el script (como `/bin/bash`).

## ¿Para qué es útil?

La principal razón para usar `shc` es la **ofuscación del código fuente**. Sus usos incluyen:

*   **Proteger la propiedad intelectual:** Si has escrito un script complejo o propietario y necesitas distribuirlo a un cliente o a otro sistema sin revelar el código fuente, `shc` proporciona una capa de protección.
*   **Ocultar información sensible:** Si un script contiene contraseñas, claves de API u otra información sensible (lo cual es una mala práctica, pero a veces ocurre), compilarlo con `shc` puede ayudar a ocultar esa información de una inspección casual.
*   **Evitar modificaciones accidentales:** Al distribuir un script como un binario, se reduce la probabilidad de que un usuario lo modifique accidentalmente y rompa su funcionalidad.

Es importante destacar que `shc` **no** mejora el rendimiento del script. De hecho, introduce una pequeña sobrecarga debido al proceso de desencriptación.

## ¿Cómo se usa? (Ejemplo básico)

El uso de `shc` es bastante sencillo.

**Sintaxis básica:**

```bash
shc -f [archivo_del_script]
```

**Ejemplo:**

1.  Primero, crea un script de shell simple. Llamémoslo `mi_script.sh`:
    ```bash
    #!/bin/bash
    NOMBRE="Mundo"
    echo "Hola, $NOMBRE"
    ```
    No olvides darle permisos de ejecución: `chmod +x mi_script.sh`.

2.  Ahora, compílalo con `shc`:
    ```bash
    shc -f mi_script.sh
    ```

3.  Este comando generará dos nuevos archivos:
    *   `mi_script.sh.x`: El binario ejecutable.
    *   `mi_script.sh.x.c`: El código fuente en C que se usó para compilar el binario (puedes examinarlo para ver cómo funciona `shc`).

4.  Ahora puedes ejecutar el binario directamente:
    ```bash
    ./mi_script.sh.x
    ```
    Y la salida será:
    ```
    Hola, Mundo
    ```

Puedes distribuir `mi_script.sh.x` sin necesidad de enviar el `mi_script.sh` original.

## Consideraciones Adicionales

*   **No es seguridad infalible:** `shc` es una herramienta de ofuscación, no de seguridad criptográfica robusta. Un atacante determinado con herramientas de ingeniería inversa (como `strace`, `gdb`, o herramientas personalizadas como `unshc`) podría, con esfuerzo, recuperar el script original. No lo consideres una protección irrompible.
*   **Dependencia del intérprete:** El binario compilado todavía depende del intérprete de shell especificado en la primera línea del script original (el "shebang"). Si el script comienza con `#!/bin/bash`, el sistema donde se ejecute el binario debe tener `/bin/bash` disponible.
*   **Portabilidad:** Debes compilar el script en la misma arquitectura de destino (o mediante compilación cruzada) donde se ejecutará el binario. Un binario compilado en un sistema x86_64 no funcionará en un sistema ARM, y viceversa.

---
*Nota: Utiliza `shc` como una capa de ofuscación, no como una garantía de seguridad. Para proteger secretos, es mejor utilizar soluciones de gestión de secretos como variables de entorno o bóvedas de secretos.*
