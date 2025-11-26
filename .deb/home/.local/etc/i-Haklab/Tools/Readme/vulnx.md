# Vulnx

## ¿Qué es Vulnx?

Vulnx es un **escáner de vulnerabilidades inteligente y un inyector de shells automático**, enfocado principalmente en **Sistemas de Gestión de Contenidos (CMS)**. Es una herramienta de código abierto escrita en Python diseñada para automatizar gran parte del proceso de reconocimiento y explotación inicial.

Su principal característica es que no solo detecta vulnerabilidades, sino que también intenta explotarlas para inyectar una shell, todo de forma automática.

## ¿Para qué es útil?

Vulnx es utilizado por pentesters para acelerar la fase inicial de una auditoría de seguridad en sitios web basados en CMS populares.

*   **Detección de CMS:** Identifica qué CMS está utilizando un sitio web (WordPress, Joomla, Drupal, PrestaShop, etc.).
*   **Recopilación de Información:** Realiza una fase de reconocimiento para obtener datos como subdominios, dirección IP, información del proveedor de hosting, etc.
*   **Búsqueda de Vulnerabilidades con Dorks:** Utiliza "dorks" (consultas de búsqueda avanzadas) para encontrar sitios potencialmente vulnerables a través de motores de búsqueda.
*   **Escaneo de Vulnerabilidades:** Analiza el objetivo en busca de vulnerabilidades conocidas y fallos de configuración comunes en el CMS detectado.
*   **Inyección Automática de Shells:** Si encuentra una vulnerabilidad explotable que permite la subida de archivos, Vulnx intentará subir automáticamente una "shell" (una puerta trasera) para darle al atacante acceso al servidor.
*   **Escaneo de Puertos:** Realiza un escaneo básico de puertos para identificar servicios abiertos en el servidor.

## ¿Cómo se usa? (Ejemplo conceptual)

Vulnx se ejecuta desde la línea de comandos. Su uso implica proporcionar una URL objetivo o un dork para encontrar objetivos.

**Ejemplo 1: Escanear un único sitio web**

```bash
python vulnx.py -u http://example-wordpress.com
```
*   `-u`: Especifica la URL del objetivo.

Vulnx analizará el sitio, intentará detectar el CMS, buscará vulnerabilidades y, si tiene éxito, intentará inyectar una shell.

**Ejemplo 2: Usar Google Dorks para encontrar y atacar objetivos**

```bash
python vulnx.py -d "inurl:/wp-content/plugins/revslider/" -e google
```
*   `-d`: El dork de búsqueda para encontrar sitios con una versión vulnerable de un plugin específico.
*   `-e`: El motor de búsqueda a utilizar.

Este comando buscará en Google sitios que coincidan con el dork y luego los atacará uno por uno.

## Consideraciones Adicionales

*   **Herramienta Agresiva:** A diferencia de los escáneres pasivos, Vulnx es una herramienta **activa y agresiva**. No solo busca, sino que intenta explotar y subir una shell. Esto genera mucho ruido y es fácilmente detectable.
*   **Automatización Peligrosa:** La naturaleza automática de la inyección de shells puede ser peligrosa. Una explotación exitosa en un sistema no autorizado es un delito grave, y la herramienta no pide confirmación para cada paso.
*   **Legalidad y Ética:** Debido a su naturaleza agresiva, Vulnx **jamás** debe usarse en sistemas para los que no se tiene un permiso explícito, por escrito y detallado para realizar una prueba de penetración. Es una herramienta de ataque, no de auditoría pasiva.

---
*Nota: Vulnx es una herramienta poderosa pero peligrosa en manos equivocadas. Su uso debe estar estrictamente limitado a entornos de pentesting legales y autorizados. La automatización de la explotación requiere un alto grado de responsabilidad.*
