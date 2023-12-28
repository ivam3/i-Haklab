### Sintaxis 
`ps [opción]`

`**PID**`El ID de proceso único
`**TTY**` Tipo de terminal en el que el usuario ha iniciado sesión


### Ejemplo 

Busca por nombre 
```sh
ps -C command_name
```

Seleccionar por tty.  Esto selecciona los procesos asociados con el tty mencionado:

```sh
ps t tty
ps -t tty
ps --tty tty
```

# CÓDIGOS DE ESTADO DE PROCESO

Estos son los diferentes valores que mostrarán los especificadores de salida s, stat y state (encabezado "STAT" o "S") para describir el estado de un proceso:
`D`  sueño ininterrumpido (generalmente IO)
`R`  en ejecución o ejecutable (en cola de ejecución)
`S`  sueño interrumpible (esperando a que se complete un evento)
`T`  se detuvo, ya sea por una señal de control de trabajo o porque está siendo rastreado.
`W`  Paginación W (no válida desde el kernel 2.6.xx)
`X`  muerto (nunca debería ser visto)
`Z`  Proceso Z desaparecido ("zombi"), terminado pero no cosechado por su padre.

Para formatos BSD y cuando se utiliza la palabra clave stat, se pueden mostrar caracteres adicionales:
`<` alta prioridad (no es agradable para otros usuarios)
`N` de baja prioridad (agradable para otros usuarios)
`L` tiene páginas bloqueadas en la memoria (para E/S personalizadas y en tiempo real)
`s` es un líder de sesión
`l` es multiproceso (usando CLONE_THREAD, como lo hacen los pthreads NPTL)
`+` está en el grupo de procesos de primer plano.
