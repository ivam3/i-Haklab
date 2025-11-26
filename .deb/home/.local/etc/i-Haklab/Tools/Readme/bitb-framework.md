# BITB-Framework (Browser-in-the-Browser)

## ¿Qué es el BITB-Framework?

El término **BITB-Framework** se refiere a un conjunto de herramientas, plantillas y scripts diseñados para facilitar la creación de ataques de phishing del tipo **"Browser-in-the-Browser" (BITB)**.

Un ataque BITB es una técnica de phishing sofisticada y visualmente muy convincente. En lugar de redirigir a un usuario a un dominio falso, el ataque simula una nueva ventana de navegador *dentro* de la pestaña del navegador actual. Esta "ventana" falsa se utiliza para mostrar una página de inicio de sesión fraudulenta (por ejemplo, una que imita el inicio de sesión de Google, Microsoft o Apple) y robar las credenciales del usuario.

## ¿Para qué es útil la herramienta?

Los frameworks de BITB son utilizados principalmente para:

*   **Pruebas de Phishing y Red Teaming:** Los equipos de seguridad utilizan estas herramientas para simular ataques de phishing avanzados y evaluar la concienciación de los empleados o la eficacia de las defensas de una organización. Debido a su realismo, los ataques BITB suelen tener una alta tasa de éxito.
*   **Fines Educativos y de Investigación:** Estos frameworks se publican para que la comunidad de seguridad pueda entender la anatomía de este tipo de ataque, concienciar al público y desarrollar contramedidas.
*   **Ataques Maliciosos:** Los ciberdelincuentes utilizan estas técnicas para robar credenciales de cuentas de alto valor, especialmente aquellas protegidas por autenticación de múltiples factores (MFA), ya que el ataque también puede intentar capturar los tokens de sesión.

## ¿Cómo funciona el ataque?

El framework proporciona todo el código (HTML, CSS y JavaScript) necesario para crear una ilusión convincente.

1.  **La Plantilla:** El framework contiene plantillas que imitan a la perfección las ventanas emergentes de inicio de sesión de servicios populares (Google, Facebook, etc.). Estas plantillas recrean cada detalle visual: la barra de título, la URL falsa, el icono del candado de SSL y los botones de la ventana.

2.  **El `iframe`:** La ventana falsa se muestra sobre la página legítima en la que se encuentra el usuario. El formulario de inicio de sesión real (el malicioso) se carga dentro de un `<iframe>` (un elemento HTML que incrusta otra página web).

3.  **La Interacción del Usuario:** El usuario, al ver lo que parece ser una ventana de inicio de sesión de un proveedor de confianza, introduce su nombre de usuario y contraseña.

4.  **El Robo de Credenciales:** Dado que el formulario está controlado por el atacante, las credenciales introducidas se envían al servidor del atacante en lugar de al servicio legítimo.

**Ejemplo Visual del Engaño:**

Imagina que estás en un sitio web (`sitio-confiable.com`) y haces clic en "Iniciar sesión con Google".

*   **Comportamiento Normal:** Se abre una **ventana emergente real** del navegador, separada de la original, donde cargas `accounts.google.com`. Puedes arrastrar esta ventana fuera de la ventana principal.
*   **Ataque BITB:** **No se abre una ventana real.** En su lugar, aparece una ventana **falsa**, dibujada con HTML/CSS, *dentro* de la pestaña de `sitio-confiable.com`. Aunque visualmente parece una ventana separada, no puedes arrastrarla fuera de la pestaña del navegador principal. La URL que muestra es falsa (es solo texto), y el contenido es el `iframe` malicioso del atacante.

![Diagrama conceptual del ataque BITB](https://miro.medium.com/max/1400/1*5bV2fE01h63y2G_iF0i25A.png)
*(Fuente: mrd0x)*

## ¿Cómo se usa un framework de BITB?

Generalmente, el uso implica:

1.  **Clonar el repositorio:** Descargar el framework desde su repositorio (por ejemplo, en GitHub).
2.  **Configurar la plantilla:** Elegir la plantilla deseada (por ejemplo, 'Google') y configurarla para que apunte al endpoint del atacante donde se recibirán las credenciales.
3.  **Desplegar:** Subir los archivos a un servidor web controlado por el atacante.
4.  **Engañar a la víctima:** Hacer que la víctima visite una página que active la falsa ventana emergente.

## Consideraciones Adicionales

*   **Dificultad de Detección:** Estos ataques son muy difíciles de detectar para un usuario promedio, ya que la URL del navegador principal sigue siendo la del sitio legítimo y la "ventana emergente" parece auténtica.
*   **Cómo Protegerse:** Una de las pocas formas de detectar este engaño es intentar arrastrar la ventana emergente de inicio de sesión fuera de la ventana principal del navegador. Si no puedes hacerlo, es una ventana falsa.
*   **Legalidad y Ética:** La creación y el despliegue de páginas de phishing son ilegales. Estas herramientas solo deben utilizarse con fines de investigación y pruebas de seguridad autorizadas.

---
*Nota: La información proporcionada aquí es para fines educativos y de concienciación sobre seguridad. No utilices estas técnicas para actividades maliciosas.*
