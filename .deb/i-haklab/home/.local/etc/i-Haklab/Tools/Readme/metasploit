The Metasploit Framework is released under a BSD-style license.

You can find documentation on Metasploit and how to use it at:
 https://docs.metasploit.com/

Information about setting up a development environment can be found at:
 https://docs.metasploit.com/docs/development/get-started/setting-up-a-metasploit-development-environment.html

Our bug and feature request tracker can be found at:
 https://github.com/rapid7/metasploit-framework/issues

New bugs and feature requests should be directed to:
  https://r-7.co/MSF-BUGv1

API documentation for writing modules can be found at:
  https://docs.metasploit.com/api/


Quick Guide
--
Metasploit es un framework de pruebas de penetración de código abierto que
proporciona una plataforma para desarrollar y ejecutar exploits contra sistemas
informáticos y redes. A continuación, describo brevemente cada uno de los componentes:

Exploits: son programas o scripts que aprovechan vulnerabilidades en sistemas informáticos
o aplicaciones para obtener acceso no autorizado al sistema o para ejecutar comandos en el sistema afectado.
Los exploits se utilizan en Metasploit para automatizar la ejecución de ataques.

Auxiliary: son módulos que no son exploits propiamente dichos, pero que proporcionan funcionalidades
adicionales para los atacantes. Por ejemplo, los módulos auxiliary pueden ser usados para escanear redes,
recolectar información del sistema, obtener acceso a credenciales o realizar ataques de denegación de servicio.

Post: son módulos que se ejecutan después de que se ha obtenido acceso a un sistema.
Estos módulos permiten a los atacantes realizar acciones posteriores a la explotación de una vulnerabilidad,
como moverse lateralmente en una red, exfiltrar datos, instalar software malicioso o realizar otras
acciones para mantener el acceso al sistema.

Payloads: son fragmentos de código que se entregan al sistema vulnerable para ejecutar un comando o realizar
una acción específica. Los payloads pueden ser utilizados en conjunto con exploits para proporcionar
una funcionalidad adicional, como obtener una shell remota, instalar un backdoor o descargar y ejecutar malware.

Encoders: son módulos que se utilizan para ofuscar payloads y exploits para evitar la detección
por parte de software de seguridad. Los encoders utilizan técnicas de ofuscación como el cifrado,
la compresión o la modificación del código para hacer que los payloads y exploits sean más difíciles
de detectar por software antivirus y de análisis de seguridad.

Nops: son módulos que se utilizan para agregar "no-operation" o instrucciones de "nop" al exploit o payload.
Estas instrucciones no hacen nada en el sistema objetivo, pero pueden ser utilizadas para rellenar
el espacio vacío en el código del exploit o payload. Los nops se utilizan para ajustar el tamaño del exploit
o payload para que encajen en el espacio disponible en la memoria del sistema objetivo.

Evasion: son módulos que se utilizan para evitar la detección por parte de software de seguridad.
Los módulos de evasión se utilizan para alterar los patrones de los payloads y exploits, evitando
así la detección por parte de los sistemas de defensa y los antivirus. Los módulos de evasión
pueden utilizarse para evadir técnicas como la detección de firmas y el análisis de comportamiento.

Msfconsole y msfvenom son dos herramientas principales en Metasploit Framework
que se utilizan para diferentes propósitos.

Msfconsole es la interfaz de línea de comandos (CLI) principal de Metasploit.
Permite a los usuarios interactuar con el framework, cargar módulos, lanzar exploits,
ejecutar payloads y realizar otras acciones relacionadas con la explotación y la prueba de penetración.
Msfconsole es una herramienta interactiva que proporciona una amplia variedad de comandos para el análisis,
la explotación y la postexplotación de sistemas y redes.

Msfvenom, por otro lado, es una herramienta independiente de la interfaz de línea de comandos
que se utiliza para generar payloads personalizados para su uso en exploits.
Los payloads son el código que se entrega al sistema objetivo después de que se ha explotado
una vulnerabilidad. Msfvenom puede generar payloads para diferentes arquitecturas de sistemas operativos
y puede codificarlos en diferentes formatos, como archivos binarios, scripts de shell,
códigos fuente y otros formatos personalizados. Los payloads generados por msfvenom se utilizan
para ejecutar comandos en sistemas remotos, obtener acceso remoto y realizar otras acciones de postexplotación.

En resumen, mientras que msfconsole es la interfaz de línea de comandos principal para
interactuar con Metasploit, msfvenom es una herramienta especializada para generar payloads
personalizados para su uso en exploits.


Using Metasploit
--
Metasploit can do all sorts of things. The first thing you'll want to do
is start `msfconsole`, but after that, you'll probably be best served by
reading [Metasploit Unleashed][unleashed], the [great community
resources](https://metasploit.github.io), or take a look at the
[Using Metasploit](https://docs.metasploit.com/docs/using-metasploit/basics/using-metasploit.html)
page on the documentation website.


