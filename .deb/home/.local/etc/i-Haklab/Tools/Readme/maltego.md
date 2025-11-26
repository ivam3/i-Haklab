
# Maltego

## ¿Qué es Maltego?

Maltego es una herramienta de inteligencia de código abierto (OSINT) y análisis gráfico de enlaces, desarrollada por Paterva. Permite a los investigadores de seguridad, analistas de datos y profesionales de OSINT recopilar, organizar y visualizar información de diversas fuentes públicas y privadas. Su principal fortaleza radica en la capacidad de identificar relaciones y patrones complejos entre diferentes entidades (personas, organizaciones, dominios, direcciones IP, documentos, etc.) a través de una interfaz gráfica intuitiva.

Maltego transforma datos crudos en un gráfico visualmente atractivo y fácil de entender, lo que facilita el análisis de la superficie de ataque y la identificación de conexiones ocultas.

## ¿Para qué es útil la herramienta?

Maltego es una herramienta indispensable para un amplio espectro de profesionales:

-   **Investigación de Ciberseguridad y OSINT:**
    -   **Reconocimiento:** Recopilar información sobre un objetivo (persona, empresa, infraestructura de red) desde fuentes públicas como registros WHOIS, DNS, redes sociales, Shodan, etc.
    -   **Análisis de Amenazas:** Mapear la infraestructura de un atacante, identificar relaciones entre diferentes ataques o campañas de malware.
    -   **Análisis de la Superficie de Ataque:** Visualizar todos los activos relacionados con una organización (dominios, subdominios, IPs, empleados, tecnologías) para identificar posibles puntos de entrada.
-   **Análisis Forense Digital:** Rastrear la actividad digital, identificar conexiones entre sospechosos y analizar la propagación de información.
-   **Inteligencia Empresarial:** Mapear relaciones entre empresas, individuos clave y activos.
-   **Investigación Periodística:** Recopilar y organizar información para investigaciones complejas.

## ¿Cómo se usa?

El uso de Maltego se centra en su interfaz gráfica y el concepto de "Entidades" y "Transforms".

### 1. Instalación y Registro

1.  **Descargar:** Maltego está disponible para Windows, macOS y Linux. Se puede descargar desde el sitio web oficial de Maltego ([maltego.com](https://www.maltego.com/)). A menudo, también viene preinstalado en distribuciones como Kali Linux.
2.  **Registro:** Después de la instalación, necesitarás registrar una cuenta. La "Maltego Community Edition" (CE) es gratuita y muy funcional, aunque tiene algunas limitaciones en la cantidad de "Transforms" que se pueden ejecutar por consulta.

### 2. Creación de un Gráfico

1.  **Nuevo Gráfico:** Abre Maltego y crea un "New Graph" (nuevo gráfico).
2.  **Añadir Entidades:** En la paleta de entidades (a la izquierda), encontrarás diferentes tipos de entidades (Domain, Person, Email Address, IP Address, Website, etc.). Arrastra una entidad inicial a tu gráfico (por ejemplo, un "Domain").

### 3. Ejecución de Transforms

Las "Transforms" son las funciones que recopilan información.

1.  **Seleccionar una Entidad:** Haz clic derecho sobre la entidad que has añadido al gráfico (por ejemplo, el dominio `example.com`).
2.  **Ejecutar Transforms:** En el menú contextual que aparece, selecciona las "Transforms" que deseas ejecutar. Por ejemplo:
    -   `To DNS Name`: Para encontrar registros DNS asociados al dominio.
    -   `To IP Address`: Para encontrar direcciones IP asociadas al dominio.
    -   `To Website`: Para encontrar el sitio web principal.
    -   `To Person from Email Address`: Si ya tienes una dirección de correo, puedes buscar información sobre la persona.

    Maltego ejecutará estas Transforms consultando diversas fuentes de datos en internet (como registradores de dominio, motores de búsqueda, APIs de OSINT, etc.) y añadirá nuevas entidades (IPs, personas, emails) a tu gráfico, conectándolas con la entidad original.

### 4. Análisis y Profundización

-   **Visualización:** El gráfico se actualizará visualmente, mostrando las relaciones entre los datos.
-   **Profundizar:** Puedes seguir haciendo clic derecho en las nuevas entidades y ejecutando más "Transforms" para expandir tu investigación. Por ejemplo, desde una "IP Address" puedes buscar el "ASN" (Autonomous System Number) o "Whois Information".
-   **Filtros y Vistas:** Maltego ofrece diferentes diseños de gráficos y filtros para ayudarte a organizar y entender grandes volúmenes de información.

## Otras Consideraciones

-   **Community Edition (CE):** La versión gratuita CE es una excelente manera de empezar, pero tiene limitaciones como el número de resultados por Transform y la velocidad. Las versiones de pago ofrecen más funcionalidades y acceso a una gama más amplia de fuentes de datos.
-   **Fuentes de Datos (Hub):** Maltego integra "Hubs" que son colecciones de Transforms que acceden a diferentes fuentes de datos, algunas gratuitas y otras de pago.
-   **Ética y Legalidad:** Maltego es una herramienta de OSINT. Solo debe utilizarse para recopilar información que es pública y accesible. Su uso debe ser ético y legal, respetando siempre la privacidad de las personas y las leyes aplicables. No debe utilizarse para la vigilancia no autorizada o actividades ilegales.
