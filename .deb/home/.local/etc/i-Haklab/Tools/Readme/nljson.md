# nljson

## ¿Qué es nljson?

`nljson` es el empaquetado para Termux de la librería **JSON for Modern C++** de `nlohmann` (`https://github.com/nlohmann/json`). Toda la librería consiste en un único header `json.hpp`, sin dependencias externas, escrito en C++11.

En i-Haklab se distribuye como paquete `nljson` desde el repositorio de la comunidad `demon_hunter (victor028)`, ya configurado en el `postinst`. Instala el header en la ruta de includes del sistema para usarlo directamente con `clang`/`g++`.

## ¿Para qué es útil la herramienta?

`nljson` permite añadir soporte JSON a programas C++ con sintaxis intuitiva, similar a usar JSON como tipo nativo:

*   **Desarrollo en C++:** crear, leer, modificar y serializar objetos y arreglos JSON con `json j; j["clave"] = valor;`.
*   **Parseo y serialización:** `json::parse()` para leer y `dump()` para escribir, con pretty-print por indentación.
*   **Acceso estilo STL:** iteradores, `at()`, `find()`, `contains()`, `size()`, `empty()` y range-for.
*   **Formatos extendidos:** JSON Pointer (RFC 6901), JSON Patch (RFC 6902), JSON Merge Patch (RFC 7386) y binarios CBOR, MessagePack, BSON, UBJSON, BJData.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado (`pkg install nljson`), incluye el header en tu código:

```cpp
#include <nlohmann/json.hpp>
using json = nlohmann::json;
```

### 1. Crear y serializar un objeto

```cpp
json j;
j["pi"] = 3.141;
j["happy"] = true;
j["name"] = "Niels";
std::cout << j.dump(4) << std::endl;
```

Compila con:

```bash
g++ -std=c++11 app.cpp -o app
./app
```

### 2. Parsear desde un string

```cpp
json j = json::parse(R"({"happy": true, "pi": 3.141})");
std::string s = j.dump();
```

### 3. Leer JSON desde un archivo

```cpp
#include <fstream>
std::ifstream f("datos.json");
json data = json::parse(f);
std::cout << data["nombre"] << std::endl;
```

## Consideraciones Adicionales

*   **Solo header:** no hay librería que linkear, basta con `#include <nlohmann/json.hpp>`.
*   **Estándar C++:** requiere compilador con soporte C++11 o superior (`clang`, `g++`).
*   **Codificación:** la librería solo soporta UTF-8; usa `error_handler_t::replace` si tus cadenas vienen en otra codificación.
*   **Documentación completa:** API, ejemplos y FAQ en `https://json.nlohmann.me`.

---
*Nota: La información proporcionada aquí es para fines educativos y de desarrollo.*
