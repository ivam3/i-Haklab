# Variables 
V=_0.1
CXX = clang++
CXXFLAGS = -Wall -fPIC -shared 
LDFLAGS = -L. -Wl,-rpath=. -Wall
LIBRARIES = -lbelow_zero_v$(V) 
OBJ = below_zero_v$(V).o
SRC = src/below_zero_v$(V).cpp
EXE = i-haklab

all: i-haklab clean install

# ejecutable dinamico Haaa 
$(EXE): i-haklab$(V).cpp  below_zero_v$(V).so
	@echo [+] Creando ejecutable	
	$(CXX)  -o $@  $^ -lcurl -lssh -lncurses


# Bibloteca dinamica
below_zero_v$(V).so: $(OBJ) below_zero_v$(V).so
	@echo [+] Creando bibloteca dinamica	
	$(CXX)  $(CXXFLAGS) -o $@ $<


# Crear objeto dinamico
$(OBJ): src/below_zero_v$(V).cpp 
	@echo [+] Creando objeto
	$(CXX)  -c -fPIC  $< -Iinclude -std=c++20
		
# Borrar
clean:
		rm -rf *.o

install:
		mv below_zero_v_0.1.so /data/data/com.termux/files/usr/lib/
			