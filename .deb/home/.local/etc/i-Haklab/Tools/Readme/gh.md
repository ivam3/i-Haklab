# GitHub CLI (gh)

## ¿Qué es GitHub CLI?

**GitHub CLI** (`gh`) es la herramienta oficial de línea de comandos de GitHub que permite gestionar repositorios, issues, pull requests, GitHub Actions, releases, gists y más directamente desde la terminal, sin necesidad de abrir el navegador.

## ¿Para qué es útil la herramienta?

`gh` es indispensable para desarrolladores que trabajan con GitHub:

-   **Pull Requests:** Crea, revisa, aprueba y fusiona PRs sin salir de la terminal.
-   **Issues:** Gestiona issues, asígnalos, etiquétalos y comenta directamente.
-   **Repositorios:** Clona, fork, crea y gestiona repos remotos con comandos simples.
-   **GitHub Actions:** Visualiza, cancela y reintenta workflows y Jobs de CI/CD.
-   **Releases y tags:** Publica releases, sube assets y gestiona tags.
-   **Gists:** Crea y gestiona gists públicos o privados.
-   **Autenticación:** Soporta login interactivo, token de acceso personal y GitHub App.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado, autentícate y comienza a gestionar tus repositorios:

**Ejemplo 1: Iniciar sesión en GitHub**

```bash
gh auth login
```
*(Sigue las instrucciones interactivas para autenticarte).*

**Ejemplo 2: Ver y crear issues**

```bash
gh issue list
gh issue create --title "Corregir bug en login" --label "bug"
```

**Ejemplo 3: Gestionar pull requests**

```bash
gh pr list --assignee @me
gh pr create --base main --title "Mi PR" --body "Descripción"
gh pr review --approve
```

**Ejemplo 4: Clonar un repositorio**

```bash
gh repo clone owner/repo
```

**Ejemplo 5: Ver estado de GitHub Actions**

```bash
gh run list
gh run watch
```

**Ejemplo 6: Crear un release**

```bash
gh release create v1.0.0 --title "Versión 1.0.0" --notes "Cambios..."
```

**Ejemplo 7: Ver estado del repositorio actual**

```bash
gh repo view --web
```

## Consideraciones Adicionales

-   **Autenticación:** Usa `gh auth login` para login interactivo o `GITHUB_TOKEN` para entornos CI/CD.
-   **Alias:** Puedes crear alias personalizados con `gh alias set`.
-   **Extensiones:** `gh` soporta extensiones de la comunidad (`gh extension install owner/repo`).
-   **API directa:** Usa `gh api` para hacer llamadas arbitrarias a la API REST de GitHub.
-   **Formato de salida:** Soporta `--json` y `--jq` para salida estructurada en pipelines.

---
*Nota: Esta herramienta integra la gestión completa de GitHub desde la terminal en el ecosistema i-Haklab.*
