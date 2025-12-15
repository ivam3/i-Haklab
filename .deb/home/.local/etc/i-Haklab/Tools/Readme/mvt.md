# MVT (Mobile Verification Toolkit)

## ¿Qué es MVT?

**MVT (Mobile Verification Toolkit)** es una herramienta de análisis forense desarrollada por **Amnesty International** para detectar rastros de spyware y compromisos en dispositivos móviles Android e iOS.

Está enfocada en identificar indicadores de compromiso (IOCs) relacionados con spyware avanzado como Pegasus.

## ¿Para qué es útil?

* Análisis forense móvil
* Detección de spyware
* Auditorías de seguridad
* Investigación digital

## Uso básico en Android

**Verificar conexión ADB:**

```bash
mvt-android check-adb
```

**Extraer datos del dispositivo:**

```bash
mvt-android download-apks --output output/
```

**Ejecutar análisis con IOCs:**

```bash
mvt-android check-adb --iocs iocs/
```

## Consideraciones importantes

No funciona correctamente con USB en Termux
Se recomienda usar ADB vía TCP/IP
No reemplaza un análisis forense profesional
