
# Phonemizer (Posiblemente "Phomber")

## ¿Qué es Phonemizer?

Phonemizer es una herramienta y biblioteca de Python diseñada para convertir texto escrito en su representación fonética (fonemas) en varios idiomas. Actúa como una interfaz unificada para diferentes motores de fonemización (backends) como `espeak`, `espeak-mbrola` y `festival`, que son capaces de generar secuencias de fonemas para un texto dado.

Los fonemas son las unidades de sonido más pequeñas en un idioma que pueden distinguir una palabra de otra. Convertir texto a fonemas es un paso fundamental en muchas aplicaciones de procesamiento de voz, como la síntesis de voz (Text-to-Speech - TTS) o el reconocimiento de voz.

## ¿Para qué es útil la herramienta?

Aunque no es una herramienta de ciberseguridad o de sistema en el sentido tradicional, Phonemizer es invaluable en campos que involucran el procesamiento del lenguaje y puede tener aplicaciones en áreas más específicas:

-   **Síntesis de Voz (TTS):** Esencial para sistemas que necesitan "hablar" texto, como asistentes virtuales, sistemas de navegación o aplicaciones de accesibilidad.
-   **Reconocimiento de Voz:** Ayuda a los sistemas a entender el lenguaje hablado, mapeando los sonidos a su representación escrita.
-   **Análisis Lingüístico:** Para investigadores y lingüistas que estudian la fonética y fonología de diferentes idiomas.
-   **Educación:** Para aprender la pronunciación correcta de palabras en diferentes idiomas.
-   **Aplicaciones Potenciales en OSINT/Seguridad (Nicho):** Podría ser utilizado en análisis de voz, identificación de patrones lingüísticos en datos de texto para OSINT, o en la creación de ataques de spoofing de voz si se combina con otras herramientas (aunque esto es un uso muy específico y avanzado).

## ¿Cómo se usa?

Phonemizer se usa principalmente como una biblioteca de Python, aunque también puede tener una interfaz de línea de comandos.

### 1. Instalación de Prerrequisitos

1.  **Instalar Python:** Asegúrate de tener Python 3.6 o superior y `pip` instalados en tu sistema.

2.  **Instalar Motores Backend (ej. espeak-ng):** Phonemizer requiere que los motores de fonemización (backends) estén instalados en tu sistema. Por ejemplo, para usar `espeak-ng` (un backend común que proporciona IPA - Alfabeto Fonético Internacional):

    ```bash
    # En sistemas basados en Debian/Ubuntu
    sudo apt install espeak-ng
    ```
    Consulta la documentación de Phonemizer para otros backends.

3.  **Instalar Phonemizer:**
    ```bash
    pip install phonemizer
    ```

### 2. Uso como Biblioteca de Python

```python
from phonemizer import phonemize

# Texto para fonemizar
textos_a_procesar = [
    "Hello world! How are you?",
    "Hola mundo! Cómo estás?"
]

# Fonemizar el texto en inglés (US) usando el backend espeak
fonemas_en_ingles = phonemize(
    textos_a_procesar[0],
    language='en-us',
    backend='espeak',
    preserve_punctuation=True, # Mantener puntuación
    strip=True # Eliminar espacios en blanco al principio/final
)
print(f"Fonemas en inglés: {fonemas_en_ingles}")

# Fonemizar el texto en español usando el backend espeak
fonemas_en_espanol = phonemize(
    textos_a_procesar[1],
    language='es',
    backend='espeak',
    preserve_punctuation=True,
    strip=True
)
print(f"Fonemas en español: {fonemas_en_espanol}")
```

**Salida esperada:**

```
Fonemas en inglés: ['həˈloʊ wɜːld! haʊ ɑːr juː?']
Fonemas en español: ['ˈoˌla ˈmũndo! ˈkoˌmo ɛsˈtas?']
```

### 3. Personalización de la Salida

Puedes personalizar los separadores de fonemas, palabras y sílabas:

```python
from phonemizer import phonemize
from phonemizer.separator import Separator

fonemas_personalizados = phonemize(
    ["Example text"],
    language='en-us',
    backend='espeak',
    separator=Separator(phone='-', word=' ', syllable='|'),
    strip=True,
    preserve_punctuation=False # No mantener puntuación para este ejemplo
)
print(f"Fonemas con separadores personalizados: {fonemas_personalizados}")
```

**Salida esperada:**

```
Fonemas con separadores personalizados: ['ɪɡ-ˈzæm-pəl t-ɛk-st']
```

## Otras Consideraciones

-   **Soporte de Idiomas y Backends:** La calidad y el soporte para idiomas pueden variar significativamente entre los diferentes backends. Es importante elegir el backend y el idioma correctos para tus necesidades.
-   **IPA (International Phonetic Alphabet):** Muchos backends de Phonemizer (especialmente `espeak-ng`) producen salida en formato IPA, que es un sistema estandarizado para representar sonidos del habla.
-   **Dependencias Externas:** Recuerda que Phonemizer es una biblioteca "wrapper"; necesitarás instalar los motores de fonemización externos (como `espeak-ng`) por separado.
