# speedtest-cli (speedtest-cli de Python)

## ¿Qué es speedtest-cli?

`speedtest-cli` es una herramienta de línea de comandos escrita en **Python** que mide la velocidad de conexión a Internet utilizando los servidores de speedtest.net. Se instala mediante `pip` y no requiere dependencias externas más allá de Python 3.

A diferencia de `speedtest-go` (una implementación en Go), `speedtest-cli` es la versión original y más extendida, presente en la mayoría de distribuciones de pentesting y automatización.

## ¿Para qué es útil?

- Medir velocidad de descarga, subida y latencia desde la terminal
- Integrarse en scripts de monitoreo de red
- Generar reportes automatizados (salida en JSON o CSV)
- Ideal para entornos ligeros donde no se desea instalar binarios adicionales

## ¿Cómo se usa?

**Instalación:**

```bash
python3 -m pip install speedtest-cli
```

O mediante el wrapper apt de i-HakLab:

```bash
apt install speedtest-cli
```

**Uso básico:**

```bash
speedtest-cli
```

**Salida en JSON para automatización:**

```bash
speedtest-cli --json
```

**Compartir resultados:**

```bash
speedtest-cli --share
```

## Consideraciones Adicionales

- A diferencia de `speedtest-go`, esta versión requiere Python 3 y sus dependencias pip.
- El wrapper `apt` de i-HakLab redirige la instalación de `speedtest-cli` a `pip` automáticamente.
- Consumo de ancho de banda significativo durante la prueba, similar a cualquier prueba de velocidad.

---

*Nota: Existe también `speedtest-go` como alternativa en Go. Consulta su documentación aparte para más detalles.*
