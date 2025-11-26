# EvilURL

## ¿Qué es EvilURL?

EvilURL es una herramienta de ciberseguridad, escrita en Python, diseñada para generar y detectar **URLs maliciosas que utilizan ataques de homógrafos IDN**. Es una herramienta utilizada en pruebas de penetración y phishing para crear nombres de dominio que son visualmente idénticos o muy similares a dominios legítimos, pero que en realidad son completamente diferentes.

## ¿Qué es un Ataque de Homógrafos IDN?

Un ataque de homógrafos (o "homograph attack" en inglés) explota el hecho de que muchos caracteres de diferentes alfabetos en Unicode se ven exactamente iguales. Por ejemplo, la letra "a" del alfabeto latino (`U+0061`) es visualmente idéntica a la letra "а" del alfabeto cirílico (`U+0430`).

Los **Nombres de Dominio Internacionalizados (IDN)** son el sistema que permite usar estos caracteres no latinos en los nombres de dominio. Un atacante puede registrar un dominio que reemplace uno o más caracteres de un dominio legítimo con sus homógrafos de otro alfabeto.

**Ejemplo:**
*   Dominio legítimo: `apple.com`
*   Dominio malicioso: `аpple.com` (donde la primera "a" es en realidad una letra cirílica)

Para un usuario, estos dos dominios son visualmente indistinguibles en la barra de direcciones del navegador. El navegador, sin embargo, los ve como dos dominios completamente diferentes. El dominio malicioso se traduce a un formato especial llamado "Punycode" (en este caso, `xn--pple-43d.com`).

## ¿Para qué es útil la herramienta?

EvilURL se utiliza tanto para fines ofensivos (simulados) como defensivos:

*   **Generación de Dominios para Phishing:** Un pentester puede usar EvilURL para generar una lista de posibles dominios homógrafos para un dominio objetivo (por ejemplo, `paypal.com`). Luego, puede comprobar si alguno de esos dominios maliciosos está disponible para ser registrado y utilizarlo en una campaña de phishing para demostrar el riesgo a un cliente.
*   **Detección de URLs de Phishing:** EvilURL también puede analizar una URL para detectar si contiene caracteres de diferentes alfabetos mezclados, lo que es un fuerte indicador de un posible ataque de homógrafos.
*   **Concienciación y Educación:** Es una herramienta excelente para demostrar cómo funcionan estos ataques y concienciar sobre los peligros de hacer clic en enlaces sin verificar su destino real.

## ¿Cómo se usa? (Ejemplo conceptual)

EvilURL es una herramienta de línea de comandos. Su uso principal es proporcionar un nombre de dominio y dejar que la herramienta genere las posibles variaciones maliciosas.

**Sintaxis conceptual para generar URLs:**
```bash
python evilurl.py -d [dominio_legitimo]
```

**Ejemplo:**
```bash
python evilurl.py -d google.com
```

**Salida de ejemplo:**
```
[+] Dominio original: google.com

[+] Variaciones homográficas generadas:
gооgle.com  (Punycode: xn--ggle-55d.com)  <-- las 'o' son cirílicas
gоogle.com   (Punycode: xn--ggle-l4d.com)   <-- la primera 'o' es cirílica
goоgle.com   (Punycode: xn--gogle-l4d.com)   <-- la segunda 'o' es cirílica
... y muchas otras combinaciones ...
```
El pentester puede entonces tomar estas variantes y usar un script para comprobar cuáles de ellas están disponibles para ser registradas.

## Consideraciones Adicionales

*   **Defensa del Navegador:** Los navegadores modernos han implementado defensas contra este ataque. Generalmente, si un nombre de dominio mezcla caracteres de diferentes alfabetos de una manera sospechosa, el navegador mostrará la versión en Punycode (`xn--...`) en la barra de direcciones en lugar de la versión Unicode, alertando así al usuario de que algo no es normal. Sin embargo, estas defensas no son perfectas y los atacantes siempre buscan formas de eludirlas.
*   **El Engaño Visual:** La eficacia de este ataque radica puramente en el engaño visual. Es una técnica de ingeniería social muy potente.
*   **Legalidad:** Registrar un dominio que imita a una marca conocida con la intención de engañar a los usuarios es ilegal y una infracción de marca registrada. EvilURL debe usarse solo con fines éticos y de investigación.

---
*Nota: La información proporcionada aquí es para fines educativos y de concienciación sobre seguridad. No utilices esta herramienta para actividades maliciosas.*
