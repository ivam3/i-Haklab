======= WEP ========
https://clang.llvm.org/docs/ClangFormat.html

====== D ======
Puede respaldar su flujo de trabajo de varias maneras, incluida una herramienta independiente e integraciones de editor.


Una forma sencilla de crear el `.clang-formatarchivo` es:

```Copy code
clang-format -style=llvm -dump-config > .clang-format
````
