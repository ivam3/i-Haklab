 [hostname (1)](https://translate.google.com/website?sl=auto&tl=es&u=http://manpages.ubuntu.com/manpages/precise/en/man1/hostname.1.html) : muestra o establece el nombre de host del sistema

-a,  --alias

       Muestra el nombre de alias del host (si se usa). Esta opción está obsoleta y no debe usarse

       nunca más.

-b,  --boot 

       Establece siempre un nombre de host; esto permite que el archivo especificado por -F no exista o esté vacío, en el cual

       En caso de que se utilice el nombre de host predeterminado localhost si aún no se ha establecido ninguno.

-d,  --domain 

       Muestra el nombre del dominio DNS. No use el comando domainname para obtener el nombre de dominio DNS

       porque mostrará el nombre de dominio NIS y no el nombre de dominio DNS. En su lugar, utilice dnsdomainname .

       Consulte las advertencias en la sección EL  FQDN anterior y evite usar esta opción.

-F,  --file  filename 

       Lee el nombre de host del archivo especificado. Los comentarios (líneas que comienzan con un '#') se ignoran.

-f,  --fqdn,  --largo

       Muestre el FQDN (nombre de dominio completo). Un FQDN consta de un nombre de host corto y el DNS

       nombre de dominio. A menos que esté utilizando bind o NIS para búsquedas de host, puede cambiar el FQDN y el DNS

       nombre de dominio (que es parte del FQDN) en el [archivo / etc / hosts](about:blank) . Consulte las advertencias en la sección   EL 

       FQDN anterior y evite usar esta opción; use hostname  --all-fqdns en su lugar.

-A,  --todos-fqdns

       Muestra todos los FQDN de la máquina. Esta opción enumera todas las direcciones de red configuradas en todos

       configura interfaces de red y las traduce a nombres de dominio DNS. Direcciones que no pueden ser

       traducidos (es decir, porque no tienen una entrada DNS inversa adecuada) se omiten. Tenga en cuenta que

       diferentes direcciones pueden resolverse con el mismo nombre, por lo tanto, la salida puede contener duplicados

       entradas. No haga suposiciones sobre el orden de la salida.

-h,  --help 

       Imprime un mensaje de uso y sale.

-i,  --ip-address

       Muestra la (s) dirección (es) de red del nombre de host. Tenga en cuenta que esto solo funciona si el nombre de host

       ser resuelto. Evite usar esta opción; use hostname  --all-ip-address en su lugar.

-I,  --todas-las-direcciones-IP

       Muestra todas las direcciones de red del host. Esta opción enumera todas las direcciones configuradas en todos

       interfaces de red. Se omiten la interfaz de bucle invertido y las direcciones locales de enlace IPv6. Contrariamente a

       opción -i , esta opción no depende de la resolución del nombre. No haga suposiciones sobre el

       orden de salida.

-s,  --short 

       Muestra el nombre de host corto. Este es el nombre de host cortado en el primer punto.

-V,  --version 

       Imprime la información de la versión en la salida estándar y finaliza correctamente.

-v,  --verbose 

       Sea detallado y cuente lo que está sucediendo.

-y,  --yp,  --nis 

       Muestra el nombre de dominio NIS. Si se da un parámetro (o --file  nombre ) y luego raíz también puede establecer una

       nuevo dominio NIS.