echo "[*] Compilando ..."
cmake --build  ~/i-Haklab/build/ 
echo "[*] Moviendo todo ..."
cmake --install ~/i-Haklab/build/  --prefix=$PREFIX    
