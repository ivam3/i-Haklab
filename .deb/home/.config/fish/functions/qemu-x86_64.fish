function qemu-x86_64 
   export  QEMU_LD_PREFIX=$HOME/.local/share/container/ 
   unset LD_PRELOAD 
   $PREFIX/bin/qemu-x86_64 $argv
   export  LD_PRELOAD=$PREFIX/lib/libtermux-exec.so 
end
