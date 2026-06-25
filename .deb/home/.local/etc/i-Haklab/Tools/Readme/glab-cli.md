# GLab CLI (glab)

## ¿Qué es GLab CLI?

**GLab** (o `glab`) es la herramienta oficial de línea de comandos de GitLab, de código abierto, que permite gestionar repositorios, issues, merge requests, pipelines CI/CD, releases y más directamente desde la terminal, sin necesidad de cambiar de ventana.

## ¿Para qué es útil la herramienta?

GLab es indispensable para desarrolladores y equipos que usan GitLab:

-   **Gestión de Merge Requests:** Crea, revisa, aprueba y fusiona MRs sin salir de la terminal.
-   **Issues y tableros:** Crea, asigna, etiqueta y comenta issues directamente desde la CLI.
-   **CI/CD Pipelines:** Visualiza, cancela y reintenta pipelines y jobs de GitLab CI.
-   **Repositorios:** Clona, fork, y gestiona repos remotos con comandos simplificados.
-   **Releases:** Crea y gestiona releases y tags desde la terminal.
-   **Soporte multi-instancia:** Compatible con GitLab.com, GitLab Dedicated y GitLab Self-Managed.
-   **Autenticación múltiple:** Permite autenticarse contra varias instancias de GitLab simultáneamente.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado, autentícate y comienza a gestionar tu proyecto GitLab:

**Ejemplo 1: Iniciar sesión en GitLab.com**

```bash
glab auth login
```
*(Te pedirá tu token de acceso personal de GitLab).*

**Ejemplo 2: Iniciar sesión en una instancia auto-gestionada**

```bash
glab auth login --hostname gitlab.miempresa.com
```

**Ejemplo 3: Listar merge requests asignados a ti**

```bash
glab mr list --assignee @me
```

**Ejemplo 4: Crear un issue con etiquetas**

```bash
glab issue create --title "Corregir login" --label "bug,urgente" --assignee @me
```

**Ejemplo 5: Ver el estado del pipeline actual**

```bash
glab ci status
```

**Ejemplo 6: Crear un release**

```bash
glab release create v1.2.0 --name "Versión 1.2.0" --notes "Cambios: ..."
```

**Ejemplo 7: Hacer una llamada directa a la API de GitLab**

```bash
glab api groups/:id/projects
```

## Consideraciones Adicionales

-   **Token de acceso:** Necesitas un Personal Access Token de GitLab con los scopes adecuados (`api`, `read_repository`, `write_repository`).
-   **Múltiples cuentas:** GLab soporta autenticación simultánea contra varias instancias de GitLab.
-   **Alias:** Puedes crear alias personalizados con `glab alias set`.
-   **API directa:** Usa `glab api` para hacer llamadas arbitrarias a la API REST de GitLab.
-   **Integración con Git:** GLab puede configurarse como credential helper para Git.

---
*Nota: Esta herramienta integra la gestión completa de GitLab desde la terminal en el ecosistema i-Haklab.*
