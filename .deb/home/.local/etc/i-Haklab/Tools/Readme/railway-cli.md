# Railway CLI (@railwayapp/cli)

## ¿Qué es Railway CLI?

**Railway CLI** es la herramienta de línea de comandos oficial de [Railway.app](https://railway.app), una plataforma moderna de infraestructura en la nube que permite aprovisionar servicios, bases de datos y dominios, y desplegar aplicaciones directamente desde la terminal.

## ¿Para qué es útil la herramienta?

Railway CLI es esencial para desarrolladores que despliegan aplicaciones en Railway:

-   **Despliegue rápido:** Sube tu código a Railway con un solo comando (`railway up`) sin necesidad de configurar Dockerfiles o YAML complejos.
-   **Gestión de entornos:** Administra entornos de producción, staging y desarrollo con variables de entorno independientes.
-   **Base de datos integrada:** Aprovisiona bases de datos PostgreSQL, MySQL, Redis, MongoDB y otros servicios directamente desde la CLI.
-   **Dominios personalizados:** Configura dominios custom y certificados SSL automáticos para tus servicios.
-   **Ejecución remota:** Ejecuta comandos locales usando las variables de entorno de un servicio remoto con `railway run`.
-   **Integración con CI/CD:** Autenticación mediante tokens de proyecto ideal para pipelines de GitHub Actions, GitLab CI, etc.
-   **Soporte para agentes de IA:** Railway CLI incluye soporte nativo para configurar agentes como OpenCode o Claude Code.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado, autentícate y despliega tu primer proyecto:

**Ejemplo 1: Iniciar sesión**

```bash
railway login
```
*(Abre el navegador para autenticarte con tu cuenta de Railway).*

**Ejemplo 2: Desplegar un proyecto desde el directorio actual**

```bash
railway init && railway up
```

**Ejemplo 3: Desplegar usando un token de proyecto (CI/CD)**

```bash
RAILWAY_TOKEN=xxx railway up
```

**Ejemplo 4: Ejecutar un comando local con variables de entorno del servicio**

```bash
railway run --service api --environment production -- npm run migrate
```

**Ejemplo 5: Gestionar dominios personalizados**

```bash
railway domain create midominio.com
railway domain list
```

**Ejemplo 6: Ver logs en tiempo real**

```bash
railway logs
```

## Consideraciones Adicionales

-   **Autenticación:** Usa `railway login` para autenticación interactiva o `RAILWAY_TOKEN` para entornos automatizados.
-   **Proyecto vinculado:** Ejecuta `railway link` dentro de un directorio para asociarlo a un proyecto existente.
-   **Costos:** Railway opera con modelo de pago por uso. Revisa su panel de precios en railway.app para más detalles.
-   **Regiones:** Puedes especificar la región de despliegue con `railway region set`.

---
*Nota: Esta herramienta integra despliegue cloud directo desde la terminal en el ecosistema i-Haklab.*
