
# Holehe

## ¿Qué es Holehe?

Holehe (pronunciado "ho-le-he", que significa "está ahí" en hebreo) es una herramienta de reconocimiento de código abierto basada en Python. Su propósito principal es verificar si una dirección de correo electrónico está asociada con varias plataformas y servicios en línea. Actúa como una herramienta de OSINT (Inteligencia de Fuentes Abiertas) para mapear la presencia digital de una dirección de correo electrónico.

La herramienta opera simulando procesos de registro, inicio de sesión o recuperación de contraseña en más de 120 servicios en línea. Si un correo electrónico ya está registrado en una de estas plataformas, Holehe lo detecta. Lo hace sin enviar correos electrónicos de verificación ni alertar al propietario del correo electrónico, lo que lo hace discreto.

## ¿Para qué es útil la herramienta?

Holehe es una herramienta valiosa para profesionales de la ciberseguridad, investigadores de OSINT, pentesters y cualquier persona que necesite recopilar información sobre la presencia en línea de una dirección de correo electrónico:

-   **Reconocimiento OSINT:** Permite a los investigadores construir un perfil sobre una persona o entidad, identificando qué servicios en línea utilizan.
-   **Análisis de Seguridad:** Ayuda a entender dónde una dirección de correo electrónico podría haber sido expuesta o dónde un usuario tiene cuentas, lo que puede ser útil en escenarios de spear-phishing o ataques de relleno de credenciales.
-   **Evaluación de la Superficie de Ataque:** Para las organizaciones, puede ayudar a identificar la exposición de direcciones de correo electrónico corporativas en servicios de terceros.
-   **Verificación:** Puede ser utilizado para verificar la validez de una dirección de correo electrónico en ciertos servicios.

## ¿Cómo se usa?

Holehe es una herramienta de línea de comandos.

### 1. Instalación

Asegúrate de tener Python instalado en tu sistema. Luego, puedes instalar Holehe usando `pip`:

```bash
pip install holehe
```

### 2. Uso Básico

Para verificar una dirección de correo electrónico, simplemente ejecuta `holehe` seguido de la dirección de correo:

```bash
holehe ejemplo@dominio.com
```

La herramienta escaneará la dirección contra su lista de servicios y mostrará los resultados en la terminal, indicando si el correo electrónico está registrado (`Used`) o no (`Not Used`) en cada plataforma.

### 3. Opciones Comunes

-   **Módulos Específicos:** Puedes especificar qué servicios quieres verificar, en lugar de escanear todos.
    ```bash
    holehe ejemplo@dominio.com --modules twitter facebook instagram
    ```

-   **Solo Cuentas Usadas:** Muestra solo los servicios donde la dirección de correo electrónico está registrada.
    ```bash
    holehe ejemplo@dominio.com --only-used
    ```

-   **Guardar Resultados:** Exporta la salida a un archivo.
    ```bash
    holehe ejemplo@dominio.com --output resultados.txt
    ```

-   **Salida JSON:** Para una salida estructurada que se pueda procesar fácilmente por otras herramientas o scripts.
    ```bash
    holehe ejemplo@dominio.com --json
    ```

-   **Deshabilitar Recuperación de Contraseña:** Algunos servicios pueden intentar realizar un restablecimiento de contraseña. Esta opción lo previene.
    ```bash
    holehe ejemplo@dominio.com --no-password-recovery
    ```

-   **Ver Ayuda:** Para una lista completa de opciones.
    ```bash
    holehe --help
    ```

## Otras Consideraciones

-   **Ética y Responsabilidad:** Holehe es una herramienta potente para la recopilación de información. Es crucial usarla de manera responsable y ética, respetando la privacidad de las personas. **No la uses para acosar o investigar a individuos sin su consentimiento o una base legal válida.**
-   **Anonimato:** Holehe no requiere claves API ni credenciales, y está diseñado para ser discreto. Sin embargo, siempre existe la posibilidad de que los servicios detecten el comportamiento de escaneo.
-   **Actualizaciones:** Los servicios en línea pueden cambiar sus procesos de registro/inicio de sesión/recuperación, lo que puede afectar la eficacia de Holehe. Es recomendable mantener la herramienta actualizada para asegurar su correcto funcionamiento.
