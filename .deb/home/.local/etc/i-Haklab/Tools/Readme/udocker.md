# udocker

## ¿Qué es udocker?

`udocker` es una herramienta que permite ejecutar contenedores de Docker en entornos de usuario sin privilegios de root. No requiere que un demonio como Docker esté instalado o en ejecución, lo que la hace ideal para sistemas restringidos como servidores compartidos, entornos HPC (High Performance Computing) o terminales como Termux en Android.

## ¿Para qué es útil la herramienta?

Esta herramienta es útil para:

*   **Ejecutar contenedores sin root:** Permite a los usuarios descargar y ejecutar aplicaciones empaquetadas en imágenes de Docker sin necesidad de permisos administrativos.
*   **Portabilidad:** Facilita el despliegue de software complejo en sistemas donde Docker no está disponible o no se puede instalar.
*   **Seguridad:** Al ejecutarse en el espacio de usuario, reduce la superficie de ataque en comparación con el demonio de Docker que corre como root.
*   **Entornos Restringidos:** Es la solución predilecta para ejecutar herramientas de seguridad o entornos de desarrollo en Termux.

## ¿Cómo se usa? (Ejemplos básicos)

El uso de `udocker` es similar al de Docker, pero con algunas diferencias en los parámetros de interactividad.

**Sintaxis básica para ejecutar de forma interactiva:**
En `udocker`, no existe el parámetro combinado `-it`. Para obtener un shell interactivo, se debe pasar la bandera de interactividad (`-i`) al final del comando o al shell que se desea invocar.

**Equivalente a `docker run -it --rm ghcr.io/anomalyco/opencode`:**
```bash
udocker run --rm --entrypoint="/bin/bash" ghcr.io/anomalyco/opencode -i
```
O también:
```bash
udocker run --rm ghcr.io/anomalyco/opencode /bin/bash -i
```

**Ejemplos de comandos comunes:**

1.  **Buscar una imagen:**
    ```bash
    udocker search debian
    ```

2.  **Descargar una imagen:**
    ```bash
    udocker pull alpine
    ```

3.  **Crear y ejecutar un contenedor con nombre:**
    ```bash
    udocker create --name=mi_kali kali-linux/kali-rolling
    udocker run mi_kali
    ```

4.  **Montar un directorio local (Volumen):**
    ```bash
    udocker run --volume=/sdcard:/data mi_kali
    ```

5.  **Listar imágenes y contenedores:**
    ```bash
    udocker images
    udocker ps -m -s
    ```

6.  **Borrar un contenedor:**
    ```bash
    udocker rm mi_kali
    ```

