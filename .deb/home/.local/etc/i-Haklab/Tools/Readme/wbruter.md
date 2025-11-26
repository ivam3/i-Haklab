# WBruter

## ¿Qué es WBruter?

WBruter es una herramienta de línea de comandos diseñada para realizar **ataques de fuerza bruta** contra varios tipos de objetivos. Su función más específica es intentar descifrar el código PIN de 4 dígitos de un dispositivo Android (principalmente enfocado en Huawei y Samsung) a través de la interfaz de depuración USB (ADB).

Además de esta función, también incluye módulos para realizar ataques de diccionario contra otros servicios.

## ¿Para qué es útil?

WBruter es una herramienta de ataque que intenta adivinar contraseñas o PINs probando miles o millones de combinaciones.

*   **Ataque a PIN de Android:** Su principal atractivo es la capacidad de intentar desbloquear un teléfono Android probando todos los PINs posibles de 0000 a 9999. Esto, sin embargo, tiene limitaciones importantes (ver más abajo).
*   **Ataques de Diccionario:** Puede ser utilizado para intentar adivinar la contraseña de:
    *   Cuentas de Gmail.
    *   Servidores FTP.
    *   Archivos comprimidos protegidos con contraseña (RAR, ZIP).

Es una herramienta utilizada en pruebas de penetración para demostrar la debilidad de las contraseñas cortas o comunes.

## ¿Cómo se usa? (Ejemplo conceptual)

WBruter se ejecuta desde la terminal y presenta un menú donde el usuario elige el tipo de ataque que desea realizar.

**Flujo de trabajo típico para un ataque a un PIN de Android:**

1.  **Habilitar la Depuración USB:** La depuración USB debe estar previamente habilitada en el dispositivo Android objetivo y el dispositivo debe estar autorizado en el PC del atacante.
2.  **Conectar el dispositivo:** Se conecta el teléfono al ordenador mediante un cable USB.
3.  **Ejecutar WBruter:**
    ```bash
    python wbruter.py
    ```
4.  **Seleccionar la opción de ataque:** En el menú, se elige la opción para el ataque de fuerza bruta al PIN de Android.
5.  **Iniciar el ataque:** La herramienta comenzará a enviar los códigos PIN al dispositivo a través de ADB, uno por uno, hasta encontrar el correcto o hasta que el dispositivo bloquee los intentos.

Para otros ataques (Gmail, FTP, etc.), se seleccionaría la opción correspondiente y se le proporcionaría a la herramienta un nombre de usuario y una lista de contraseñas (diccionario).

## Consideraciones Adicionales

*   **Limitaciones del Ataque a PIN:** Los sistemas Android modernos tienen protecciones robustas contra este tipo de ataques. Después de un pequeño número de intentos fallidos, el sistema introduce retardos de tiempo cada vez más largos (30 segundos, 1 minuto, 5 minutos, etc.), haciendo que un ataque de fuerza bruta completo sea **extremadamente lento e impráctico**. Podría llevar días o semanas probar todas las combinaciones.
*   **Depuración USB Requerida:** El ataque a Android solo funciona si la depuración USB ya está habilitada y autorizada, lo cual es una barrera de seguridad significativa. No se puede usar en un teléfono encontrado al azar.
*   **Efectividad en Otros Servicios:** La efectividad contra servicios como Gmail es muy baja, ya que Google implementa mecanismos de bloqueo de cuenta (como CAPTCHAs y bloqueos temporales) después de unos pocos intentos fallidos.
*   **Legalidad:** Intentar acceder a un dispositivo, una cuenta de correo o un servidor FTP sin el permiso explícito del propietario es ilegal.

---
*Nota: WBruter es principalmente una herramienta educativa para demostrar el concepto de los ataques de fuerza bruta. En la práctica, su efectividad contra sistemas modernos y seguros es muy limitada debido a las contramedidas de seguridad existentes.*
