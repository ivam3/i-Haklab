Siempre que sepamos los nombres de usuario y las contraseñas de un usuario en su sistema actual y un usuario en el sistema remoto. Por ejemplo, copiemos un archivo de ejemplo de nuestra máquina a una máquina remota, que he presentado cuidadosamente en la siguiente tabla:

Variables

La dirección IP del sistema remoto 

Usuario en el sistema remoto

Nombre del archivo en el sistema local

Nombre con el que deseamos almacenar el archivo en el sistema remoto

scp important.txt ubuntu@192.168.1.30:/home/ubuntu/transferred.txt

Sintaxis para usar scp para copiar un archivo desde una computadora remota en la que no estamos conectados 

Variables

Dirección IP del sistema remoto
Usuario en el sistema remoto
Nombre del archivo en el sistema remoto
Nombre con el que deseamos almacenar el archivo en nuestro sistema

scp ubuntu@IP:/home/ubuntu/documents.txt notes.txt 


