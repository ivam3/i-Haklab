
# RansoMux

## ¿Qué es RansoMux?

RansoMux es una herramienta de código abierto diseñada para simular los efectos de un ataque de ransomware, específicamente adaptada para entornos como Termux en dispositivos Android. Su propósito principal es educativo y de demostración. La herramienta permite crear una "broma de ransomware" o una simulación para concienciar sobre los riesgos del ransomware, mostrando cómo podría verse una pantalla de bloqueo de ransomware.

**Es crucial entender que RansoMux no cifra archivos reales ni causa daños permanentes al sistema.** Está diseñado para ser inofensivo y viene con una funcionalidad de desbloqueo seguro.

## ¿Para qué es útil la herramienta?

RansoMux es útil en los siguientes contextos:

-   **Educación y Concienciación:** Para enseñar a las personas sobre la apariencia y el comportamiento de las pantallas de ransomware sin exponerlos a los riesgos de un ataque real.
-   **Demostraciones de Seguridad:** Profesionales de la seguridad pueden utilizarla para ilustrar el impacto visual de un ataque de ransomware durante presentaciones o entrenamientos.
-   **Pruebas de Respuesta a Incidentes (Simuladas):** Aunque no cifra datos reales, puede usarse para simular la fase inicial de un ataque de ransomware para probar la respuesta de un usuario o de un equipo de seguridad.
-   **Investigación:** Para investigadores que estudian la interfaz de usuario y la psicología de los ataques de ransomware.

## ¿Cómo se usa?

RansoMux se opera a través de la línea de comandos, típicamente en Termux en un dispositivo Android.

### 1. Instalación

1.  **Instalar Termux:** Asegúrate de tener la aplicación Termux instalada en tu dispositivo Android.
2.  **Actualizar Paquetes:** Abre Termux y actualiza los paquetes.
    ```bash
    pkg update && pkg upgrade
    ```
3.  **Instalar Python y Git:**
    ```bash
    pkg install python git
    ```
4.  **Clonar el repositorio de RansoMux:**
    ```bash
    git clone https://github.com/some_user/RansoMux.git # Sustituye con el repositorio si tienes uno específico
    cd RansoMux
    ```
5.  **Instalar dependencias y ejecutar:**
    ```bash
    pip install -r requirements.txt
    python3 ran.py # O el nombre del script principal
    ```

### 2. Personalización y Ejecución de la Simulación

Una vez ejecutada la herramienta, generalmente te guiará a través de un proceso interactivo para configurar la simulación:

-   **Mensaje de Ransomware:** Podrás personalizar el texto que aparecerá en la pantalla de "ransomware", incluyendo la demanda de rescate y las instrucciones.
-   **Temporizador:** Puedes establecer un temporizador para simular una cuenta atrás.
-   **Función de Desbloqueo:** RansoMux incluirá una forma de "desbloquear" la pantalla (ej. un PIN o una frase secreta) para que la simulación se pueda revertir de forma segura.

### 3. Ejemplo (Conceptual)

```bash
# Después de iniciar el script y configurar las opciones
python3 ran.py --target-message "Tus archivos han sido cifrados! Paga 1 BTC en 24 horas." --timer 180 --unlock-code 1234
```
(Los comandos y opciones exactos pueden variar según la versión de la herramienta).

## Consideraciones muy Importantes

-   **NO CIFRA ARCHIVOS REALES:** Insistimos, RansoMux está diseñado para **NO cifrar archivos reales** ni causar daños permanentes a tu dispositivo. Es una herramienta de simulación.
-   **Ética y Legalidad:** **Nunca debes usar RansoMux o cualquier herramienta de simulación de ransomware con fines maliciosos o sin el consentimiento explícito y por escrito de las personas afectadas.** Utilizar herramientas de ransomware (incluso simuladas) sin autorización es ILEGAL y puede tener graves consecuencias legales.
-   **Prueba en un Entorno Controlado:** Si utilizas esta herramienta para demostraciones, asegúrate de hacerlo en un dispositivo de prueba aislado y nunca en un entorno de producción o en el dispositivo de otra persona sin su pleno consentimiento.
