# Twifo CLI

## ¿Qué es Twifo CLI?

Twifo CLI es una sencilla herramienta de línea de comandos para **recopilar información de perfiles de usuario de Twitter (ahora X)**. Es una utilidad de OSINT (Inteligencia de Fuentes Abiertas) que permite obtener datos públicos de un usuario de Twitter directamente en la terminal.

## ¿Para qué es útil?

Esta herramienta es útil para la fase de reconocimiento en investigaciones o auditorías de seguridad.

*   **Recopilación Rápida de Datos:** Permite a un investigador obtener rápidamente una instantánea de un perfil de Twitter sin necesidad de abrir un navegador.
*   **OSINT Automatizado:** Al ser una herramienta de línea de comandos, puede ser integrada en scripts para automatizar la recopilación de datos sobre una lista de usuarios de Twitter.
*   **Análisis de Perfiles:** Ayuda a recopilar información que puede ser útil para entender a un objetivo, como su nombre real, ubicación declarada, sitio web, fecha de creación de la cuenta, número de seguidores, etc.

## ¿Cómo se usa? (Ejemplo básico)

Twifo CLI es muy fácil de usar. Se ejecuta desde la terminal especificando el nombre de usuario de Twitter que se desea investigar.

**Sintaxis básica:**
```bash
twifo <nombre_de_usuario>
```

**Ejemplo:**
```bash
twifo elonmusk
```

La herramienta contactará la plataforma de Twitter y devolverá la información pública del perfil en un formato limpio y legible en la terminal.

**Ejemplo de salida (conceptual):**
```
─────────────────
Nombre: Elon Musk
Usuario: @elonmusk
ID: 44196397
─────────────────
📍 Ubicación: Marte
🔗 Sitio Web: http://tesla.com
📅 Se unió: Junio 2009
─────────────────
✓ Verificado: Sí
─────────────────
👨‍👩‍👧‍👦 Siguiendo: 123
 followers: 150M
─────────────────
💬 Tweets: 25.1K
❤️ Me Gusta: 10.5K
─────────────────
Descripción:
...
```

## Consideraciones Adicionales

*   **Dependencia de la Plataforma:** Esta herramienta depende de la estructura de Twitter/X. Si la plataforma cambia la forma en que se accede a los datos públicos, la herramienta puede dejar de funcionar hasta que sea actualizada.
*   **Información Pública:** Twifo CLI solo puede acceder a información que es públicamente visible en el perfil del usuario. No puede obtener tweets protegidos ni mensajes directos.
*   **Límites de Tasa (Rate Limiting):** Realizar muchas peticiones en un corto período de tiempo podría llevar a que Twitter/X bloquee temporalmente tu dirección IP.

---
*Nota: Esta es una herramienta de OSINT simple y efectiva para la recopilación de información básica de perfiles de Twitter.*

---
*Nota: Herramienta integrada en el ecosistema i-Haklab.*
