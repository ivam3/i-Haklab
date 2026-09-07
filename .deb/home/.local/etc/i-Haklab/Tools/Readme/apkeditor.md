# APKEditor

## ¿Qué es APKEditor?

`APKEditor` es una potente herramienta de línea de comandos para **editar recursos de aplicaciones Android** sin depender de `aapt`/`aapt2`. Está basada en `ARSCLib` y trabaja directamente sobre el binario del APK.

Expone seis comandos principales: `d` (decode), `b` (build), `m` (merge), `x` (refactor), `p` (protect) e `info`. El binario se ejecuta sobre Java con la sintaxis `APKEditor.jar <comando> -i <entrada> -o <salida>`.

En i-Haklab se distribuye como paquete `apkeditor` desde el repositorio de la comunidad `demon_hunter (victor028)`, listo para usar tras instalar.

## ¿Para qué es útil la herramienta?

`APKEditor` es útil tanto para ingeniería inversa como para construcción y protección de APKs:

*   **Decodificar recursos:** convierte los recursos binarios del APK a `json`, `xml` o `raw` legibles y editables.
*   **Recompilar:** reconstruye el APK desde la carpeta decodificada después de modificar recursos o Smali.
*   **Fusionar splits:** combina APKs divididos (`base.apk` + splits de configuración) o contenedores `XAPK`, `APKM`, `APKS` en un solo APK instalable.
*   **Refactorizar:** renombra entradas de recursos ofuscadas a nombres legibles.
*   **Proteger:** ofusca recursos contra herramientas comunes de decompilación y modificación.
*   **Inspeccionar:** imprime información del APK (paquete, permisos, SDK, recursos, firmas, dex, iconos).

## ¿Cómo se usa? (Ejemplos básicos)

Una vez instalado (`pkg install apkeditor`), el ejecutable es `java -jar` compatible. Consulta la ayuda general con:

```bash
apkeditor -h
```

### 1. Decodificar un APK

```bash
apkeditor d -i mi-app.apk -o mi-app-decodificada
```

Para decodificar solo a XML (útil si el APK no está ofuscado):

```bash
apkeditor d -t xml -i mi-app.apk -o mi-app-xml
```

### 2. Recompilar un APK modificado

```bash
apkeditor b -i mi-app-decodificada -o mi-app-modificada.apk
```

### 3. Fusionar APKs divididos

```bash
apkeditor m -i carpeta-con-splits -o app-fusionada.apk
```

### 4. Mostrar información del APK

```bash
apkeditor info -i mi-app.apk
apkeditor info -v -permissions -i mi-app.apk
```

## El Paso Final: Firmar el APK

**Importante:** el APK generado por `APKEditor` **no está firmado**. Para instalarlo debes firmarlo, por ejemplo con `apksigner`:

```bash
apkeditor b -i mi-app-decodificada -o mi-app-sin-firmar.apk
apksigner sign --ks mi-keystore.jks --out mi-app-firmada.apk mi-app-sin-firmar.apk
apksigner verify -v mi-app-firmada.apk
```

## Consideraciones Adicionales

*   **Dependencia de Java:** requiere `openjdk-21` instalado en Termux.
*   **Memoria:** decodificar DEX grandes puede exigir más memoria; usa `java -Xmx4g -jar` si obtienes `OutOfMemoryError`.
*   **Frameworks:** algunas apps necesitan el framework del fabricante; pásalo con `-framework framework-res.apk`.
*   **Legalidad y Ética:** usa `APKEditor` solo en tus propias aplicaciones o en aquellas para las que tengas permiso explícito de análisis.

---
*Nota: La información proporcionada aquí es para fines educativos y de análisis de seguridad.*
