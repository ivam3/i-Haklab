# SQLite3

## ¿Qué es SQLite3?

**SQLite3** es un motor de base de datos relacional, ligero, embebido y sin servidor.
A diferencia de otros sistemas de bases de datos, SQLite almacena toda la información
en **un solo archivo**, lo que lo hace ideal para aplicaciones locales, móviles,
embebidas y entornos con recursos limitados.

No requiere instalación de servicios adicionales ni configuración compleja.

---

## Características principales

- Motor de base de datos embebido
- No requiere servidor
- Base de datos en un solo archivo
- Soporta SQL estándar
- Muy bajo consumo de recursos
- Ampliamente utilizado en Android, navegadores y aplicaciones de escritorio

---

## Instalación

### En Linux / Termux

```bash
pkg install sqlite
```

**Verificar instalación:**

```bash 
sqlite3 --version
```

---

### Uso básico

**Crear o abrir una base de datos**

```bash 
sqlite3 ejemplo.db
```
Si el archivo no existe, SQLite lo crea automáticamente.


---

### Comandos internos de SQLite (dot commands)

**Comando	Descripción**

.help	Muestra ayuda
.tables	Lista tablas
.schema	Muestra estructura
.headers on	Muestra encabezados
.mode column	Modo tabular
.database	Muestra bases cargadas
.exit	Salir


**Ejemplo recomendado:**

.headers on
.mode column


---

### Tipos de datos en SQLite

**SQLite es dinámico, pero soporta los siguientes tipos principales:**

- INTEGER

- REAL

- TEXT

- BLOB

- NULL



---

**Creación de tablas**

```bash
CREATE TABLE usuarios (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nombre TEXT NOT NULL,
  email TEXT UNIQUE,
  edad INTEGER,
  creado_en DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

**Insertar datos**

```bash 
INSERT INTO usuarios (nombre, email, edad)
VALUES ('Ana', 'ana@email.com', 25);
```

**Insertar múltiples registros:**

```bash 
INSERT INTO usuarios (nombre, email, edad) VALUES
('Luis', 'luis@email.com', 30),
('María', 'maria@email.com', 28);
```

---

### Consultas SELECT

**Consulta básica**

```bash 
SELECT * FROM usuarios;
```

**Seleccionar columnas específicas**
```bash 
SELECT nombre, email FROM usuarios;
```

**Condiciones WHERE**

```bash 
SELECT * FROM usuarios WHERE edad > 25;
```

**Operadores comunes**

- =

- !=

- <, >, <=, >=

- LIKE

- IN

- BETWEEN

- IS NULL


**Ejemplo:**

```bash 
SELECT * FROM usuarios WHERE email LIKE '%gmail.com';
```

---

**Ordenamiento y límites**

```bash 
SELECT * FROM usuarios
ORDER BY edad DESC
LIMIT 5;
```

---

**Actualizar registros**

```bash 
UPDATE usuarios
SET edad = 26
WHERE nombre = 'Ana';
```

---

**Eliminar registros**

```bash 
DELETE FROM usuarios
WHERE edad < 18;
```

**Eliminar todos los registros:**

```bash 
DELETE FROM usuarios;
```

---

**Relaciones y claves foráneas**

```bash 
PRAGMA foreign_keys = ON;
```  

**Ejemplo:**

```bash 
CREATE TABLE pedidos (
  id INTEGER PRIMARY KEY,
  usuario_id INTEGER,
  total REAL,
  FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
);
```

---

**Índices***

```bash 
CREATE INDEX idx_email ON usuarios(email);
```

---

### Transacciones 

**BEGIN TRANSACTION;**

```bash 
INSERT INTO usuarios (nombre) VALUES ('Carlos');
COMMIT;
```

**Cancelar cambios:**
```bash 
ROLLBACK;
```

---

### Exportar e importar datos

**Exportar a SQL**

```bash 
sqlite3 ejemplo.db .dump > backup.sql
```

**Importar SQL**

```bash 
sqlite3 nueva.db < backup.sql
```

---

**Uso desde scripts Bash:**

```bash 
sqlite3 ejemplo.db "SELECT nombre FROM usuarios;"
```

**Guardar salida:**

```bash 
sqlite3 ejemplo.db "SELECT * FROM usuarios;" > salida.txt
```

---

### Buenas prácticas

Usar índices en columnas consultadas frecuentemente
Usar transacciones para múltiples operaciones
Evitar alta concurrencia
Respaldar el archivo .db regularmente


---

### Casos de uso comunes

Aplicaciones móviles
Proyectos personales
Herramientas CLI
Bases de datos locales
Pruebas y prototipos


---

### Limitaciones

No ideal para múltiples escrituras concurrentes
No diseñado para ambientes distribuidos
Sin control de usuarios nativo


---

### Recursos

https://sqlite.org/docs.html
https://www.sqlite.org/lang.html

