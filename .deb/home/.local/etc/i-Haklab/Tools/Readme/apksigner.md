# apksigner

## ¿Qué es apksigner?

`apksigner` es una herramienta oficial de línea de comandos proporcionada dentro del **Android SDK Build-Tools**. Su propósito es firmar archivos de paquete de Android (APK) y verificar que las firmas de un APK sean válidas.

La firma de una aplicación es un paso de seguridad fundamental en el ecosistema de Android. Sirve para dos propósitos principales:

1.  **Autenticidad:** Confirma que el desarrollador que dice haber creado la aplicación es quien realmente lo hizo.
2.  **Integridad:** Asegura que el contenido del APK no ha sido modificado o corrompido desde que fue firmado.

El sistema Android no instalará ni actualizará una aplicación si su firma es inválida o no coincide con la firma de la versión previamente instalada.

## ¿Para qué es útil la herramienta?

`apksigner` es esencial tanto para el desarrollo como para la seguridad de las aplicaciones de Android:

*   **Firmar aplicaciones para lanzamiento:** Antes de que puedas subir una aplicación a la Google Play Store o distribuirla de cualquier otra forma, debe estar firmada con una clave de lanzamiento privada.
*   **Verificar la integridad de un APK:** Permite comprobar si un archivo APK ha sido manipulado. Esto es útil para los analistas de seguridad que examinan aplicaciones de terceros o para los usuarios que descargan aplicaciones de fuentes no oficiales.
*   **Confirmar la correcta firma:** Un desarrollador puede usar `apksigner` para asegurarse de que ha firmado su aplicación correctamente y que será aceptada por los dispositivos Android.
*   **Gestionar esquemas de firma:** Android ha introducido varios esquemas de firma a lo largo del tiempo (v1, v2, v3, v4). `apksigner` es capaz de aplicar y verificar estos esquemas de firma, garantizando la compatibilidad con diferentes versiones de Android.

## ¿Cómo se usa? (Ejemplos básicos)

`apksigner` se encuentra en el directorio de las Build-Tools de tu instalación del Android SDK (por ejemplo, `<sdk-path>/build-tools/<version>/apksigner`).

### 1. Firmar un APK

Para firmar un APK, necesitas un **keystore**, que es un archivo que contiene tus claves criptográficas.

**Sintaxis básica:**

```bash
apksigner sign --ks [tu-keystore.jks] --out [app-firmada.apk] [app-sin-firmar.apk]
```

**Ejemplo:**

Supongamos que tienes un keystore llamado `mi-clave-de-lanzamiento.jks` y un APK llamado `app-release-unsigned.apk`.

```bash
apksigner sign --ks mi-clave-de-lanzamiento.jks --out app-release.apk app-release-unsigned.apk
```

La herramienta te pedirá la contraseña del keystore y la contraseña de la clave para poder proceder con la firma.

### 2. Verificar la firma de un APK

Esta es la operación más común para fines de auditoría.

**Sintaxis básica:**

```bash
apksigner verify [archivo.apk]
```

**Ejemplo:**

Para verificar la firma de una aplicación llamada `app-a-verificar.apk`:

```bash
apksigner verify app-a-verificar.apk
```

Si la firma es válida, el comando no producirá ninguna salida y terminará con un código de salida 0. Si hay un problema, arrojará un error explicando el fallo.

**Para obtener un informe más detallado:**

Puedes usar el flag `-v` (verbose) para obtener más información sobre los esquemas de firma aplicados y los certificados.

```bash
apksigner verify -v --print-certs app-a-verificar.apk
```
Esto mostrará los detalles del certificado del firmante (como el `SHA-256 digest`), lo cual es muy útil para comparar si dos APKs fueron firmados por el mismo desarrollador.

## Consideraciones Adicionales

*   **Keystore de Depuración vs. Lanzamiento:** Durante el desarrollo, Android Studio utiliza un keystore de depuración genérico para firmar las aplicaciones. Para lanzar una aplicación al público, DEBES crear tu propio keystore privado y mantenerlo seguro. **Perder tu keystore de lanzamiento significa que no podrás publicar actualizaciones de tu aplicación.**
*   **`jarsigner` vs `apksigner`:** `jarsigner` es una herramienta más antigua de Java que también puede firmar APKs (usando el esquema v1). Sin embargo, `apksigner` es la herramienta recomendada ya que es compatible con los esquemas de firma más nuevos y seguros (v2, v3, v4), que ofrecen una mayor protección y tiempos de instalación más rápidos.

---
*Nota: La seguridad de tu clave de firma es de máxima importancia para la distribución de aplicaciones de Android. Trata tu keystore de lanzamiento como un activo extremadamente sensible.*
