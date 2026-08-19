# Azure CLI

## ¿Qué es Azure CLI?

Azure CLI (Interface de Línea de Comandos de Azure) es la herramienta oficial de Microsoft para gestionar los recursos de Azure desde la terminal. Permite a los administradores y profesionales de la seguridad interactuar con los servicios de Microsoft Azure mediante comandos, sin necesidad de usar el portal web.

Está escrita en Python y se instala mediante `pip`, lo que la hace disponible para una amplia variedad de plataformas, incluida Termux.

## ¿Para qué es útil la herramienta?

Azure CLI es esencial para automatizar y gestionar la infraestructura en la nube de Azure. Sus principales usos son:

*   **Gestión de recursos:** Crear, listar, actualizar y eliminar máquinas virtuales, bases de datos, redes y otros servicios de Azure.
*   **Automatización y scripting:** Permite integrar la gestión de Azure en scripts y pipelines de CI/CD, facilitando el despliegue repetible de infraestructura (Infrastructure as Code).
*   **Auditoría y seguridad:** Consultar configuraciones de seguridad, políticas, logs y roles de acceso (RBAC), así como detectar recursos expuestos o mal configurados.
*   **Acceso programático:** Autenticarse con Azure Active Directory y operar con los servicios desde la línea de comandos, ideal para tareas de pentesting de entornos cloud autorizados.
*   **Integración con otras herramientas:** Combinable con `jq`, `grep` y otras utilidades de terminal para procesar la salida JSON de Azure.

## ¿Cómo se usa? (Ejemplos básicos)

**1. Iniciar sesión en Azure**

```bash
az login
```

Abre un navegador para autenticarte con tu cuenta de Azure.

**2. Listar suscripciones**

```bash
az account list --output table
```

**3. Crear un grupo de recursos**

```bash
az group create --name MiGrupo --location eastus
```

**4. Listar máquinas virtuales**

```bash
az vm list --output table
```

**5. Obtener ayuda sobre un comando**

```bash
az --help
az vm create --help
```

## Consideraciones Adicionales

*   **Dependencia de Python:** Azure CLI se instala con `pip` y requiere Python 3.10 o superior (disponible en Termux a través de tur-repo).
*   **Autenticación:** La mayoría de los comandos requieren una sesión iniciada (`az login`). En entornos no interactivos se puede usar un *service principal* con `az login --service-principal`.
*   **Salida JSON:** Por defecto Azure CLI devuelve JSON, lo que facilita su procesamiento en scripts.
*   **Uso ético:** Solo opera sobre suscripciones y recursos sobre los que tengas autorización. La gestión de infraestructura ajena sin permiso es ilegal.

---
*Nota: La información proporcionada aquí es para fines educativos y de análisis de seguridad.*