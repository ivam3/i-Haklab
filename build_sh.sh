echo "[*] Compilando ..."
cmake --build build 
echo "[*] Moviendo todo ..."
cmake --install build --prefix=$PREFIX   -j8 
