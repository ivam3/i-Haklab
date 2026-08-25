# Polenum

## ¿Qué es Polenum?

Polenum es una herramienta de ciberseguridad escrita en Python que **extrae la política de contraseñas de una máquina Windows** utilizando la librería **Impacket**. Es una herramienta clásica del arsenal de pruebas de penetración de redes Windows (post-explotación / reconocimiento de dominio).

La política de contraseñas de un dominio Windows incluye parámetros críticos como:

-   Longitud mínima de contraseña.
-   Complejidad requerida (mayúsculas, minúsculas, números, símbolos).
-   Historial de contraseñas (cuántas contraseñas anteriores se recuerdan).
-   Bloqueo de cuenta (número de intentos fallidos y duración).
-   Antigüedad mínima y máxima de la contraseña.

## ¿Para qué es útil la herramienta?

Conocer la política de contraseñas de un dominio es **esencial antes de realizar ataques de fuerza bruta o de diccionario** (por ejemplo, con `kerbrute`, `crackmapexec` o `hashcat`):

-   **Ajustar los ataques:** Si sabes que la longitud mínima es 8 y que se exige complejidad, puedes generar diccionarios o reglas de mutación acordes, ahorrando tiempo.
-   **Evaluar la seguridad:** Permite auditar si la política del dominio cumple con buenas prácticas o normativas.
-   **Post-explotación:** Una vez obtenidas credenciales de un usuario con permisos, se consulta la política para planificar el siguiente movimiento.

## ¿Cómo se usa?

Polenum necesita credenciales válidas de un usuario del dominio y la dirección de la máquina Windows (normalmente el controlador de dominio).

**Sintaxis básica:**
```bash
polenum -u <usuario> -p <contraseña> -d <dominio/o IP>
```

**Ejemplo:**
```bash
polenum -u ivam3 -p 'Password123!' -d 192.168.1.10
```

**Formato compacto (user:pass@host):**
```bash
polenum ivam3:Password123!@192.168.1.10
```

## Consideraciones Adicionales

-   **Protocolos:** Soporta los protocolos `445/SMB` y `139/SMB` para consultar el SAMR.
-   **Dependencia de Impacket:** La herramienta usa `impacket.dcerpc.v5` (SAMR/DCERPC). En Termux/i-HakLab se instala automáticamente vía `pip install impacket`.
-   **Autorización:** Solo debe usarse contra sistemas para los que tengas autorización explícita de realizar pruebas de seguridad.
-   **Estado del proyecto:** El repositorio upstream (`Wh1t3Fox/polenum`) está sin mantenimiento activo pero sigue siendo funcional con Python 3 e Impacket moderno.

---
*Nota: La información proporcionada aquí es para fines educativos y de pruebas de seguridad autorizadas.*