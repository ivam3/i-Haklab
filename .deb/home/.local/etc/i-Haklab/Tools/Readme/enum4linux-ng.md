# enum4linux-ng (Next Generation)

## ¿Qué es enum4linux-ng?

`enum4linux-ng` es la reescritura moderna y "de próxima generación" de la clásica herramienta `enum4linux`. Mientras que la original estaba escrita en Perl, `enum4linux-ng` está escrita en **Python** y viene con una serie de mejoras y nuevas características, manteniendo el mismo propósito fundamental: **enumerar información de sistemas Windows y Samba** a través del protocolo SMB.

Al igual que su predecesor, actúa como un envoltorio inteligente para las herramientas del conjunto de Samba, pero añade más funcionalidades y ofrece una experiencia de usuario mejorada.

## ¿En qué se diferencia de `enum4linux`?

`enum4linux-ng` no es solo una actualización, sino una reescritura que añade varias mejoras clave:

*   **Escrito en Python:** Lo hace más fácil de mantener y extender para la comunidad moderna.
*   **Salida Estructurada:** Puede exportar todos los resultados en formatos legibles por máquinas como **JSON** y **YAML**, lo que es extremadamente útil para integrar `enum4linux-ng` en cadenas de herramientas y scripts automatizados.
*   **Enumeración Inteligente:** Es más dinámico. Por ejemplo, si detecta que un servicio como LDAP no está disponible, omitirá las comprobaciones de LDAP, haciendo el escaneo más rápido y eficiente.
*   **Salida Coloreada:** La presentación de los resultados en la consola está coloreada, lo que facilita la lectura e identificación de hallazgos importantes.
*   **Implementación Nativa:** Incluye su propia implementación de algunas comprobaciones, como la enumeración de la política de contraseñas (similar a `polenum`), en lugar de depender de herramientas externas.
*   **Soporte Mejorado:** Ofrece mejor soporte para diferentes métodos de autenticación y es activamente mantenido.

## ¿Para qué es útil la herramienta?

`enum4linux-ng` cumple los mismos objetivos que su predecesor, pero de una manera más robusta y flexible. Es una herramienta esencial en la fase de reconocimiento de una prueba de penetración interna para:

*   Enumerar usuarios, grupos y máquinas de un dominio.
*   Descubrir recursos compartidos (shares) y sus permisos.
*   Obtener información detallada del sistema operativo y del dominio/grupo de trabajo.
*   Extraer la política de contraseñas.
*   Identificar relaciones de confianza entre dominios.
*   Enumerar servicios e impresoras.

## ¿Cómo se usa? (Ejemplo básico)

La sintaxis es similar a la de otras herramientas de línea de comandos, pero con un enfoque en los verbos y las opciones.

**Sintaxis básica:**
```bash
python enum4linux-ng.py [opciones] <IP_objetivo>
```

### Ejemplo 1: Escaneo completo (modo "all")

Este es el uso más común y ejecuta todas las comprobaciones posibles contra el objetivo.

```bash
python enum4linux-ng.py -A 192.168.1.100
```
*   `-A` o `-all`: Ejecuta todos los módulos de enumeración.

### Ejemplo 2: Guardar la salida en JSON

Esta es una de las grandes ventajas de la versión `ng`.

```bash
python enum4linux-ng.py -A -oJ resultados_escaneo 192.168.1.100
```
*   `-oJ resultados_escaneo`: Guarda la salida en un archivo llamado `resultados_escaneo.json`.

### Ejemplo 3: Ejecutar con credenciales

Si se han obtenido credenciales válidas, se pueden utilizar para realizar una enumeración autenticada, que suele revelar mucha más información.

```bash
python enum4linux-ng.py -A -u 'dominio\usuario' -p 'contraseña123' 192.168.1.100
```

## Consideraciones Adicionales

*   **Herramienta de Elección:** Para nuevos proyectos y en sistemas modernos, `enum4linux-ng` es generalmente la herramienta preferida sobre la versión original en Perl debido a su mantenimiento activo, flexibilidad y salida estructurada.
*   **Detección:** Al igual que la versión original, `enum4linux-ng` es una herramienta "ruidosa" que realiza una gran cantidad de consultas al objetivo. Es probable que sea detectada por sistemas de monitoreo de seguridad (IDS/IPS).
*   **Legalidad:** No se debe utilizar contra ningún sistema para el que no se tenga autorización explícita.

---
*Nota: La información proporcionada aquí es para fines educativos y de seguridad ética. Utiliza esta herramienta de forma responsable.*
