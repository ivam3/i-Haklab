# OmniRoute (omniroute)

## ¿Qué es OmniRoute?

**OmniRoute** es un gestor de rutas de API, proxy inverso y panel de administración web todo-en-uno construido en Node.js. Proporciona una interfaz web (dashboard) para gestionar y enrutar tráfico HTTP/HTTPS, actuar como gateway API, y exponer servicios locales de forma segura.

## ¿Para qué es útil la herramienta?

OmniRoute es un compañero versátil para desarrolladores y administradores de sistemas:

- **API Gateway:** Centraliza y gestiona múltiples servicios backend bajo un mismo punto de entrada con reglas de enrutamiento dinámicas.
- **Proxy inverso:** Redirige tráfico HTTP/HTTPS hacia servidores internos con balanceo de carga y reescritura de cabeceras.
- **Dashboard web:** Panel de administración accesible desde el navegador para monitorizar rutas, tráfico y estado de servicios.
- **CLI vía web:** Ejecuta comandos del sistema directamente desde el dashboard (anteojos de túnel, gestión de puertos, recarga de servicios).
- **Despliegue rápido:** Ideal para entornos donde se necesita exponer servicios en Android/Termux sin configurar nginx/Apache manualmente.

## Instalación

```bash
# Mediante el wrapper de i-Haklab:
apt install omniroute

# El postinst configura automáticamente:
# 1. Node.js + npm (si no existen)
# 2. Crea el directorio de instalacion en ~/.local/share/omniroute
# 3. Descarga e instala omniroute via npm
# 4. Reconstruye modulos nativos (better-sqlite3)
# 5. Parchea playwright-core para compatibilidad Android
# 6. Instala el binario 'omniroute' en PATH
```

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado, el servidor se inicia con:

```bash
# Iniciar el servidor web
omniroute serve

# Acceder al dashboard
# Abrir en el navegador: http://localhost:20128
```

**Ejemplo 1: Verificar instalacion**

```bash
omniroute --version
```

**Ejemplo 2: Conocer el estado del servicio**

```bash
omniroute status
```

**Ejemplo 3: Gestionar rutas desde el dashboard**

```
1. Iniciar sesion en http://localhost:20128
2. Navegar a Routes -> Add Route
3. Configurar origen (ej: http://localhost:3000) y reglas de proxy
4. Activar la ruta desde el panel
```

## Consideraciones Adicionales

- **Puerto por defecto:** El dashboard corre en el puerto `20128` por defecto (configurable via variables de entorno).
- **Autenticacion:** La primera vez que accedes al dashboard debes establecer una contraseña. Por defecto en versiones recientes el password sugerido es `123456`.
- **Persistencia:** La configuracion y las rutas se almacenan en una base de datos SQLite en `~/.omniroute/`.
- **Navegador / Web Automation:** Para funcionalidades que requieran Chromium (screenshots, snapshot, eval), instala el paquete complementario: `apt install playwright-proot`.
- **Dependencias:** Requiere Node.js 20+ instalado en el sistema.

---
*Nota: Esta herramienta integra un gestor de rutas API y proxy inverso con dashboard web en el ecosistema i-Haklab.*
