# n8n

## ¿Qué es n8n?

n8n (pronunciado "en-ocho-en" o "nodemation") es una herramienta de automatización de flujos de trabajo de código abierto que permite integrar aplicaciones y servicios, automatizar tareas y mover datos entre ellos. Se destaca por su interfaz de usuario visual basada en nodos, donde cada paso de un flujo de trabajo se representa como un "nodo" que se puede arrastrar, soltar y conectar.

A diferencia de otras herramientas de automatización, n8n ofrece la flexibilidad de poder autoalojarse, lo que brinda a los usuarios un control completo sobre sus datos y la privacidad. También es una herramienta "low-code", lo que significa que permite a los usuarios con conocimientos técnicos ampliar su funcionalidad con código JavaScript cuando sea necesario, pero es accesible para usuarios sin experiencia en programación.

## ¿Para qué es útil la herramienta?

n8n es extremadamente útil para automatizar procesos de negocio, integrar sistemas y optimizar flujos de trabajo en una amplia variedad de escenarios:

-   **Automatización de Marketing:** Conectar herramientas de CRM, plataformas de email marketing y redes sociales para automatizar campañas, la captura de leads y la gestión de clientes.
-   **Integración de Datos:** Sincronizar datos entre diferentes bases de datos, hojas de cálculo y aplicaciones en la nube.
-   **Automatización de Tareas Repetitivas:** Convertir tareas manuales y repetitivas en procesos automatizados, liberando tiempo para actividades más estratégicas.
-   **Gestión de Proyectos:** Automatizar la creación de tareas, notificaciones y actualizaciones en herramientas de gestión de proyectos basadas en eventos de otras aplicaciones.
-   **Servicios al Cliente:** Automatizar respuestas a consultas comunes, la creación de tickets de soporte y la gestión de feedback.
-   **Análisis y Reportes:** Recopilar datos de múltiples fuentes, procesarlos y generar informes automatizados.

## ¿Cómo se usa?

n8n se puede usar a través de su servicio en la nube (`n8n Cloud`) o autoalojarse en tu propio servidor. El flujo de trabajo se construye en un editor visual.

### 1. Instalación (Autoalojamiento)

Existen varias formas de autoalojar n8n, las más comunes son con Docker o npm.

-   **Con Docker (Recomendado):**

    ```bash
    docker run -it --rm \
        --name n8n \
        -p 5678:5678 \
        -v ~/.n8n:/home/node/.n8n \
        n8nio/n8n
    ```
    Esto iniciará n8n en un contenedor Docker y lo hará accesible en `http://localhost:5678`.

-   **Con npm:**

    ```bash
    npm install -g n8n
    n8n start
    ```
    Esto instalará n8n globalmente y lo iniciará. Luego podrás acceder a la interfaz web en `http://localhost:5678`.

### 2. Creación de un Flujo de Trabajo (Workflow)

Una vez que n8n está en ejecución y has accedido a su interfaz web (normalmente en `http://localhost:5678`), seguirás estos pasos:

1.  **Iniciar un Nuevo Workflow:** Haz clic en "Add Workflow" o "New" para comenzar un nuevo lienzo.

2.  **Añadir un Nodo Disparador (Trigger Node):** Cada flujo de trabajo debe comenzar con un nodo disparador. Este nodo define cuándo y cómo se inicia el flujo. Ejemplos de disparadores:
    -   `Webhook`: Para iniciar el flujo cuando se recibe una petición HTTP.
    -   `Cron`: Para ejecutar el flujo en intervalos de tiempo programados.
    -   `Gmail Trigger`: Para iniciar el flujo cuando se recibe un nuevo correo en Gmail.
    -   `Form Trigger`: Cuando se envía un formulario web.

    Arrastra el nodo de disparador deseado desde la barra lateral izquierda al lienzo y configúralo.

3.  **Añadir Nodos de Acción:** Después del disparador, añadirás nodos que realizan acciones específicas. Cada nodo representa una integración con una aplicación o una función lógica. Ejemplos:
    -   `Google Sheets`: Para leer o escribir datos en una hoja de cálculo.
    -   `Slack`: Para enviar mensajes a un canal de Slack.
    -   `Email Send`: Para enviar correos electrónicos.
    -   `Function`: Para escribir código JavaScript personalizado y manipular datos.
    -   `IF`: Para añadir lógica condicional al flujo.

    Arrastra los nodos necesarios, conéctalos entre sí y configúralos con los parámetros y credenciales apropiados.

4.  **Flujo de Datos y Transformación:**
    Los datos fluyen de un nodo a otro. n8n te permite visualizar cómo los datos se transforman en cada paso y utilizar expresiones para mapear y manipular datos entre nodos.

5.  **Probar y Depurar:**
    Puedes ejecutar tu flujo de trabajo paso a paso o ejecutar nodos individuales para depurar y asegurarte de que todo funciona como esperas. n8n proporciona un historial de ejecuciones y logs detallados.

6.  **Activar el Workflow:**
    Una vez que estés satisfecho con tu flujo de trabajo, actívalo para que se ejecute automáticamente según la lógica del nodo disparador.

## Otras Consideraciones

-   **Código Abierto vs. Cloud:** La versión autoalojada ofrece total control y privacidad de datos, ideal para empresas que manejan información sensible. n8n Cloud proporciona una solución gestionada sin preocupaciones de infraestructura.
-   **Flexibilidad "Low-Code":** La capacidad de añadir nodos "Function" con JavaScript hace que n8n sea extremadamente flexible para casos de uso complejos que requieren lógica personalizada.
-   **Comunidad y Recursos:** n8n cuenta con una comunidad activa y una excelente documentación, lo que facilita el aprendizaje y la resolución de problemas.
