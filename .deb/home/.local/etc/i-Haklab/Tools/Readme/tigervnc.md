# tigervnc

## ¿Qué es tigervnc?

TigerVNC es una implementación de alto rendimiento de VNC (Virtual Network Computing), un sistema de intercambio de escritorio gráfico cliente/servidor. Permite controlar remotamente la interfaz gráfica de una computadora desde otro dispositivo. Es conocido por su velocidad y eficiencia en comparación con otras implementaciones de VNC.

## ¿Para qué es útil la herramienta?

*   **Acceso Remoto Gráfico:** Administrar servidores o escritorios Linux de forma visual desde cualquier lugar.
*   **Escritorio en Termux:** En el entorno Android/Termux, TigerVNC es la pieza clave que permite ejecutar un entorno de escritorio completo (como XFCE, LXQt) y visualizarlo en una app de visor VNC en el mismo dispositivo o en una PC.
*   **Soporte Multiplataforma:** Permite conectar clientes y servidores de diferentes sistemas operativos (Windows, Linux, macOS).

## ¿Cómo se usa? (Ejemplos básicos)

El uso típico implica iniciar el servidor en la máquina remota y conectar un cliente.

**Ejemplo 1: Iniciar el servidor VNC (Primera vez)**

La primera vez te pedirá establecer una contraseña.

```bash
vncserver
```
Esto iniciará el servidor, usualmente en el puerto `5901` (display :1).

**Ejemplo 2: Especificar geometría**

Para iniciar un escritorio con una resolución específica:

```bash
vncserver -geometry 1920x1080
```

**Ejemplo 3: Detener el servidor**

Para apagar la sesión gráfica en el display :1:

```bash
vncserver -kill :1
```

**Ejemplo 4: Conexión**

Desde un cliente VNC (en tu PC o móvil), te conectarías a:
`IP_DEL_SERVIDOR:5901`

## Consideraciones Adicionales

*   **Seguridad:** VNC por defecto **no** cifra el tráfico. Las contraseñas y la imagen viajan en texto plano. Es altamente recomendable usar VNC a través de un túnel SSH (`ssh -L 5901:localhost:5901 usuario@servidor`) para cifrar la conexión.
*   **Archivos de inicio:** La configuración de qué entorno gráfico se inicia (XFCE, GNOME, etc.) se define en el archivo `~/.vnc/xstartup`.

---
*Nota: TigerVNC es un fork de TightVNC y es la opción por defecto en muchas distribuciones modernas como Fedora.*
