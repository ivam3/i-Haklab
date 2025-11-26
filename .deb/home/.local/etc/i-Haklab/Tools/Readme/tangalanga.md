# Tangalanga

## ¿Qué es Tangalanga?

Tangalanga es una herramienta de código abierto diseñada para **escanear y encontrar reuniones de Zoom activas y abiertas**. El nombre es una referencia humorística a "Doctor Tangalanga", un comediante argentino famoso por hacer bromas telefónicas.

La herramienta funciona generando IDs de reunión de Zoom de forma aleatoria y comprobando si corresponden a una sesión activa. Si encuentra una reunión válida, puede devolver información sobre ella.

## ¿Para qué es útil?

Esta herramienta fue creada principalmente para la investigación de la seguridad y la concienciación sobre la privacidad en las plataformas de videoconferencia.

*   **Auditoría de Seguridad:** Demuestra el riesgo de utilizar IDs de reunión públicos y no proteger las reuniones con contraseñas, salas de espera u otras medidas de seguridad.
*   **Investigación de la Privacidad:** Pone de manifiesto la facilidad con la que se pueden encontrar reuniones no seguras, exponiendo potencialmente conversaciones privadas o información sensible.
*   **Pentesting (con autorización):** En un contexto de prueba de penetración, podría usarse para verificar si una organización está exponiendo reuniones internas sin las debidas precauciones de seguridad.

## ¿Cómo se usa? (Ejemplo conceptual)

Tangalanga es una herramienta de línea de comandos. Su uso básico implica simplemente ejecutarla para que comience a buscar reuniones.

**Sintaxis básica:**
```bash
python tangalanga.py
```

Al ejecutarla, la herramienta empieza a generar y probar IDs de reunión. Cuando encuentra una válida, normalmente muestra información como el ID de la reunión y, a veces, un enlace para unirse.

Algunas versiones de la herramienta pueden incluir características adicionales como:
*   **Integración con Tor:** Para anonimizar las peticiones y evitar que Zoom bloquee la dirección IP del escáner.
*   **Uso de Múltiples Hilos (Multithreading):** Para acelerar el proceso de escaneo.

## Consideraciones Adicionales

*   **"Zoombombing":** El acto de unirse a una reunión de Zoom sin ser invitado para interrumpirla o espiar se conoce como "Zoombombing". El uso de herramientas como Tangalanga para este propósito es ilegal y una violación de la privacidad.
*   **Medidas de Seguridad de Zoom:** Desde que el "Zoombombing" se convirtió en un problema generalizado, Zoom ha implementado muchas medidas de seguridad por defecto (como las salas de espera y las contraseñas obligatorias) que hacen que herramientas como esta sean mucho menos efectivas. La mayoría de las reuniones ya no son accesibles simplemente adivinando el ID.
*   **Legalidad y Ética:** Escanear en busca de reuniones y, especialmente, unirse a ellas sin permiso, es ilegal y poco ético. Esta herramienta debe ser utilizada únicamente con fines educativos y para concienciar sobre la importancia de asegurar las comunicaciones en línea.

---
*Nota: El uso no autorizado de esta herramienta para acceder a reuniones privadas es un delito. Su valor hoy en día es principalmente educativo para demostrar un vector de ataque que ya ha sido en gran medida mitigado.*
