# Muse Code (@meta/muse-code)

## ¿Qué es Muse Code?

**Muse Code** es el agente de inteligencia artificial de **Meta** para la terminal que permite generar, modificar y depurar código mediante comandos en lenguaje natural. Está pensado para que los desarrolladores interactúen con modelos de IA de forma nativa desde la consola, sin salir de su flujo de trabajo.

En el ecosistema i-HakLab se distribuye como el paquete `muse-code`, empaquetado para Termux con soporte para ejecutarse bajo `proot` (esto resuelve las limitaciones de aislamiento de datos de las apps de Android).

## ¿Para qué es útil?

- Generar y editar código a partir de descripciones en lenguaje natural
- Explicar fragmentos de código complejos
- Refactorizar y depurar scripts existentes
- Ejecutar comandos y gestionar flujos de trabajo de desarrollo desde la terminal
- Integrar capacidades de IA de Meta en el entorno móvil de Termux

## ¿Cómo se usa?

**Instalación:**

```bash
apt install muse-code
```

**Uso básico:**

```bash
muse-code
# o el alias:
muse
```

**Ejemplo: ejecutar un comando puntual**

```bash
muse-code exec "Crea un script bash que haga backup de una carpeta"
```

## Consideraciones Adicionales

- Requiere conexión a Internet para funcionar.
- Se ejecuta bajo `proot` para sortear el aislamiento de datos de Android.
- El launcher se auto-actualiza a la versión más reciente de Muse en cada ejecución (comprueba actualizaciones cada hora en segundo plano).
- El alias `muse` es un enlace directo al wrapper de `muse-code`.

---

*Nota: Herramienta integrada en el ecosistema i-HakLab como paquete de Termux.*
