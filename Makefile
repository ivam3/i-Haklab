# Variables 
CC = clang++
CFLAGS = -Wall -fPIC -shared
LDFLAGS = -L. -Wl,-rpath=. -Wall
LIBRARIES = -lbelow_zero_v$(V)

all: i-haklab 


# ejecutable dinamico Haaa 
i-haklab: i-haklab.cpp  i-haklab.so
	@echo [+] Creando ejecutable	
	$(CC)  -o $@  $^ 


# Bibloteca dinamica
i-haklab.so: i-haklab.o i-haklab.so
	@echo [+] Creando bibloteca dinamica	
	$(CC)  $(CFLAGS) -o $@ $<


# Crear objeto dinamico
i-haklab.o: ./lib/optparse.h ./lib/i-haklab_cpp.h 

	@echo [+] Creando objeto
	$(CC)  -c -fPIC  $<


# Bprrar 
.PHONY: clean
clean:


#NOTA: Se hacen uso de las siguientes opciones:

#-Wall          Para mostrar warnings (puede quitarse si se desea)
#-Wl,rpath=.    Directorio donde el enlazador debe buscar la biblioteca
#-L.            Directorio donde se hallan los archivos de cabecera
#-l  Biblioteca a enlazar (libaritmetica.so: observa que se elimina el prefijo lib y el sufijo .so)

