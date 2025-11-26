# unshc

## ¿Qué es unshc?

`unshc` es la contraparte de `shc` (Shell Script Compiler). Es una herramienta diseñada para realizar **ingeniería inversa** en los archivos binarios generados por `shc`. Su objetivo es **recuperar el script de shell original** que fue ofuscado y "compilado" dentro del ejecutable.

Mientras que `shc` busca proteger y ocultar un script, `unshc` busca deshacer esa protección.

## ¿Para qué es útil?

`unshc` es una herramienta utilizada por analistas de seguridad, participantes de CTF y, en algunos casos, por administradores de sistemas.

*   **Análisis de Seguridad y Malware:** Si un analista encuentra un archivo binario sospechoso y determina que fue creado con `shc`, puede usar `unshc` para extraer el script subyacente y analizar su comportamiento para determinar si es malicioso.
*   **Pruebas de Penetración:** Demuestra que `shc` no es una medida de seguridad infalible. Un pentester puede usar `unshc` para recuperar el código fuente de un script protegido y buscar vulnerabilidades o información sensible (como contraseñas o claves hardcodeadas) en él.
*   **Desafíos CTF:** Es una herramienta común en los desafíos de "Capture The Flag" de la categoría de ingeniería inversa.
*   **Recuperación de Código Fuente:** Si un desarrollador pierde el código fuente original de un script importante pero todavía tiene el binario compilado con `shc`, podría usar `unshc` como último recurso para intentar recuperarlo.

## ¿Cómo se usa? (Ejemplo básico)

El uso de `unshc` es muy directo. Se le proporciona el archivo binario generado por `shc` como argumento.

**Sintaxis:**
```bash
unshc /ruta/al/script.sh.x
```

**Ejemplo:**

1.  Primero, supongamos que tenemos un binario llamado `mi_script.sh.x` que fue creado con `shc`.

2.  Para recuperar el script original, simplemente ejecuta:
    ```bash
    unshc mi_script.sh.x
    ```

3.  `unshc` analizará el binario, extraerá los datos encriptados, los desencriptará y creará un nuevo archivo de shell en el mismo directorio (a menudo con un nombre como `mi_script.sh.x.sh`) que contiene el código fuente recuperado.

## Consideraciones Adicionales

*   **Prueba de Concepto:** La existencia de `unshc` demuestra que `shc` es una herramienta de **ofuscación**, no de cifrado robusto. No se debe confiar en `shc` para proteger secretos verdaderamente importantes.
*   **Versiones:** Puede haber diferentes versiones de `unshc` que funcionen mejor con binarios creados por versiones específicas de `shc`. Si una versión de `unshc` no funciona, probar con otra podría tener éxito.
*   **Legalidad y Ética:** El uso de `unshc` para realizar ingeniería inversa en software propietario sin el permiso del autor puede ser ilegal. Debe usarse de forma ética, por ejemplo, para analizar malware o en el contexto de una prueba de penetración autorizada.

---
*Nota: `unshc` es el recordatorio perfecto de que la "seguridad por oscuridad" (ocultar algo para protegerlo) rara vez es una estrategia de seguridad efectiva por sí sola.*
