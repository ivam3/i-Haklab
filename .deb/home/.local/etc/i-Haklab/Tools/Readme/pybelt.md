
# pybelt (The Hackers Tool Belt)

## ¿Qué es pybelt?

`pybelt`, también conocido como "The Hackers Tool Belt", es una herramienta de código abierto escrita en Python que consolida diversas funcionalidades de ciberseguridad en un único framework. Está diseñada para facilitar las pruebas de penetración y las evaluaciones de seguridad, proporcionando utilidades para escaneo de puertos, detección de vulnerabilidades web (como inyección SQL y XSS), verificación de hashes, búsqueda de proxies y más.

La herramienta busca ofrecer una solución todo en uno para el "cinturón de herramientas" del hacker ético o pentester.

## ¿Para qué es útil la herramienta?

`pybelt` es útil para profesionales de la ciberseguridad, pentesters, y cualquier persona que realice evaluaciones de seguridad. Sus principales utilidades son:

-   **Escaneo de Red:** Identificar puertos abiertos en un host objetivo.
-   **Análisis de Vulnerabilidades Web:** Detectar inyección SQL y vulnerabilidades de Cross-Site Scripting (XSS) en aplicaciones web.
-   **Análisis de Hashes:** Identificar el tipo de algoritmo de hash de una cadena dada y/o intentar crackear hashes.
-   **Verificación de Google Dorks:** Comprobar la efectividad de Google dorks personalizados.
-   **Reconocimiento:** Algunas funcionalidades pueden usarse para la recopilación de información.

## ¿Cómo se usa?

`pybelt` se ejecuta desde la línea de comandos, ofreciendo diferentes opciones para cada funcionalidad.

### 1. Instalación

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/ekultek/pybelt.git
    cd pybelt
    ```
    (Asegúrate de que estás en el directorio correcto si usas un fork diferente).

2.  **Instalar dependencias:**
    ```bash
    pip install -r requirements.txt
    ```
    Asegúrate de usar `pip` o `pip3` según tu configuración de Python.

### 2. Ejemplos de Uso

Los ejemplos varían ligeramente dependiendo de la versión o fork de `pybelt`, pero la estructura general es la siguiente:

-   **Ayuda (Ver opciones disponibles):**
    ```bash
    python pybelt.py --help
    ```

-   **Escáner de Puertos:**
    Para escanear puertos en un host, por ejemplo `192.168.1.1`.
    ```bash
    python pybelt.py -p 192.168.1.1
    ```

-   **Escáner de Inyección SQL:**
    Para probar una URL en busca de vulnerabilidades de inyección SQL.
    ```bash
    python pybelt.py -s "http://ejemplo.com/pagina.php?id=1"
    ```

-   **Escáner XSS:**
    Para buscar vulnerabilidades de Cross-Site Scripting en una URL.
    ```bash
    python pybelt.py -x "http://ejemplo.com/pagina.php?nombre=test"
    ```

-   **Verificación de Tipo de Hash:**
    Para identificar el algoritmo de un hash desconocido.
    ```bash
    python pybelt.py -v "098f6bcd4621d373cade4e832627b4f6"
    ```

-   **Crackeador de Hashes:**
    Para intentar crackear un hash. Puedes especificar el tipo de hash o dejar que la herramienta lo intente descifrar con varios algoritmos.

    ```bash
    python pybelt.py -c "9a8b1b7eee229046fc2701b228fc2aff:all"
    ```

## Otras Consideraciones

-   **Ética y Legalidad:** `pybelt` es una herramienta ofensiva. Su uso debe ser **estrictamente ético y legal**, siempre con el permiso explícito y por escrito del propietario del sistema objetivo. El uso no autorizado es ilegal y puede tener graves consecuencias.
-   **Actualizaciones:** Al ser un proyecto de código abierto, la continuidad del desarrollo y el soporte pueden variar.
-   **Dependencias:** Asegúrate de tener todas las dependencias (`requests`, `beautifulsoup4`, etc.) instaladas antes de usarla.
