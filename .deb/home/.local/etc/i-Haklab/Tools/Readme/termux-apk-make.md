# termux-apk-make

## ¿Qué es termux-apk-make?

`termux-apk-make` es una herramienta para **compilar aplicaciones Android directamente desde Termux**, sin necesidad de Android Studio. Automatiza la cadena completa: compilación de recursos con `aapt2`, compilación Java con `javac`, conversión a DEX, empaquetado del APK, alineado y firma automática.

Tu proyecto solo necesita la estructura estándar (`AndroidManifest.xml`, `src/` con `.java` y `res/` con recursos) y el comando `compil-apk-termux` genera el APK final en `tu_proyecto/build/final.apk`.

En i-Haklab se distribuye como paquete `termux-apk-make` desde el repositorio de la comunidad `demon_hunter (victor028)`, listo para usar tras instalar.

## ¿Para qué es útil la herramienta?

`termux-apk-make` convierte Termux en un mini entorno de desarrollo Android:

*   **Compilar sin PC:** genera APKs instalables usando solo el teléfono.
*   **Automatizar el pipeline:** recursos, `javac`, DEX (`d8`), empaquetado, `zipalign` y firma en un solo comando.
*   **Soporte nativo:** incluye soporte para librerías nativas (`.so`) en el empaquetado.
*   **Aprendizaje:** ideal para practicar el ciclo de compilación Android y entender cada etapa sin un IDE pesado.

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado (`pkg install termux-apk-make`), prepara tu proyecto con esta estructura:

```bash
mi-proyecto/
├── AndroidManifest.xml
├── src/
│   └── com/ejemplo/MainActivity.java
└── res/
    ├── layout/activity_main.xml
    └── values/strings.xml
```

### 1. Compilar el proyecto

```bash
compil-apk-termux ~/mi-proyecto
```

El APK final se genera en:

```bash
ls ~/mi-proyecto/build/final.apk
```

### 2. Instalar el APK generado

```bash
termux-open ~/mi-proyecto/build/final.apk
```

### 3. Firmar para producción con tu propio keystore

El paquete incluye un keystore de prueba (`password` como contraseña). Para release genera el tuyo:

```bash
keytool -genkey -v -keystore my-release-key.keystore -alias mi_alias -keyalg RSA -keysize 2048 -validity 10000
apksigner sign --ks my-release-key.keystore --out app-release.apk ~/mi-proyecto/build/final.apk
apksigner verify -v app-release.apk
```

## Consideraciones Adicionales

*   **Dependencias:** requiere `spin`, `aapt2`, `openjdk-21`, `d8`, `zip` y `unzip`, instaladas automáticamente con el paquete.
*   **Espacio en disco:** asegúrate de tener suficiente almacenamiento para clases, DEX y recursos intermedios en `build/`.
*   **Estructura válida:** verifica que `AndroidManifest.xml`, paquete Java y `res/` sean válidos; un error de XML detiene la compilación.
*   **Firma de prueba vs. release:** no subas a Play Store APKs firmados con el keystore de prueba; usa siempre tu propio keystore y guárdalo.

---
*Nota: La información proporcionada aquí es para fines educativos y de desarrollo.*
