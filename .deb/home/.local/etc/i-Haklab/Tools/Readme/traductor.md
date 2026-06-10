# trans (Translate Shell)

## ¿Qué es trans?

**trans** (Translate Shell) es una potente utilidad de línea de comandos para realizar traducciones de texto utilizando diversos motores, principalmente Google Translate. Permite traducciones rápidas de palabras, frases o incluso archivos completos directamente desde la terminal.

## ¿Para qué es útil la herramienta?

Es una herramienta indispensable para usuarios de terminal que trabajan en entornos multilingües:

*   **Traducción Instantánea:** Traducir texto sin abrir un navegador.
*   **Identificación de Idiomas:** Detecta automáticamente el idioma de entrada.
*   **Modo Diccionario:** Proporciona definiciones detalladas y sinónimos.
*   **Integración con Scripts:** Fácil de usar en automatizaciones y tuberías de bash.

## ¿Cómo se usa? (Ejemplos básicos)

**Ejemplo 1: Traducción simple al español**

```bash
trans :es "Hello friend"
```

**Ejemplo 2: Modo breve (solo la traducción)**

```bash
trans -b :es "Welcome to i-Haklab"
```

**Ejemplo 3: Traducir un archivo**

```bash
trans :es file://ruta/al/archivo.txt
```

## Script Personalizado: traductor

En este sistema, se ha incluido un script personalizado para facilitar el acceso a un entorno de traducción interactivo:

**Ubicación:** `@/data/data/com.termux/files/home/.local/bin/traductor`

**Uso:**
Simplemente ejecuta el comando `traductor` en tu terminal para iniciar una shell interactiva de traducción:

```bash
traductor
```

Este script utiliza una implementación optimizada basada en `gawk` para ofrecer una experiencia fluida y rápida sin dependencias pesadas.

## Consideraciones Adicionales

*   **Conexión a Internet:** Requiere acceso a la red para consultar los motores de traducción.
*   **Privacidad:** El texto enviado se procesa a través de servicios de terceros (como Google Translate).
*   **Atajos:** Puedes usar alias en tu `.bashrc` o `.zshrc` para personalizar aún más tu flujo de trabajo con `trans`.

---
*Nota: Esta herramienta integra la potencia de la traducción global en el ecosistema i-Haklab.*
