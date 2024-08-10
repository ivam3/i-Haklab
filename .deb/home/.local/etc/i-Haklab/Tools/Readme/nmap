
:::::::::::::::::::::::::::::::::::::: NMAP QUICK GUIDE ::::::::::::::::::::::::::::::::::::::

nmap -iL ips.txt					|	Scan ips in .txt file
nmap -p							|	Scan an specific port
nmap -p 20-30						|	Scan ports between 20 at 30
nmap -p-						| 	Scan all 65,535 ports
nmap -F							|	Fast scan
nmap -sT						|	Scan TCP connect
nmap -sS						|	Scan sync(puertos abiertos)
nmap -sP						|	Localiza equipos activos
nmap -sN						|	Null scan
nmap -sF						|	Scan FIN
nmap -v							|	Verbose
nmap -sU 						|	Scan UDP
nmap -sX						|	scan XMAS
nmap -A							|	All=show SO/type of service
nmap -sV						|	Scan only active service
nmap -sV --version-intesity 0-5				|	Add intesity level at scan
nmap -P0 -p- -sL <IPzombie> <IPvictima>			|	Scan idle
sudo nmap -sP						|	Show all IPs in the network
nmap -oN						|	Save results in .txt file
nmap -oX						|	Sava results in .xml file
nmap -sC						|	Run an specific script
nmap --script-help=ssl-heartbleed https://m.example.com	|	Scan some webpage
nmap --script=msrpc-enum 				|	enumerar servicios de Microsoft
nmap --script=all					|	Scan all scripts
nmap -sU -A -PN -n -pU68 --script=all 192.168.0.0	|	DDoS Attack
## NMAP CHEAT SHEET

- Target Specification
```bash
nmap 192.168.1.1	#Scan a single IP
nmap 192.168.1.1 192.168.2.1	#Scan specific IPs
nmap 192.168.1.1-254	#Scan a range
nmap scanme.nmap.org	#Scan a domain
nmap 192.168.1.0/24	#Scan using CIDR notation
nmap -iL targets.txt	#Scan targets from a file
nmap -iR 100	#Scan 100 random hosts
nmap –exclude 192.168.1.1	#Exclude listed hosts
```

- Nmap Scan Techniques
```bash
nmap 192.168.1.1 -sS	#TCP SYN port scan (Default)
nmap 192.168.1.1 -sT	#TCP connect port scan (Default without root privilege)
nmap 192.168.1.1 -sU	#UDP port scan
nmap 192.168.1.1 -sA	#TCP ACK port scan
nmap 192.168.1.1 -sW	#TCP Window port scan
nmap 192.168.1.1 -sM	#TCP Maimon port scan
```

- Host Discovery
```bash
nmap 192.168.1.1-3 -sL	#No Scan. List targets only
nmap 192.168.1.1/24 -sn	#Disable port scanning. Host discovery only.
nmap 192.168.1.1-5 -Pn	#Disable host discovery. Port scan only.
nmap 192.168.1.1-5 -PS22-25,80	#TCP SYN discovery on port x. Port 80 by default
nmap 192.168.1.1-5 -PA22-25,80	#TCP ACK discovery on port x. Port 80 by default
nmap 192.168.1.1-5 -PU53	#UDP discovery on port x.Port 40125 by default
nmap 192.168.1.1-1/24 -PR	#ARP discovery on local network
nmap 192.168.1.1 -n	#Never do DNS resolution
```

- Port Specification
```bash
nmap 192.168.1.1 -p 21	#Port scan for port x
nmap 192.168.1.1 -p 21-100	#Port range
nmap 192.168.1.1 -p U:53,T:21-25,80	#Port scan multiple TCP and UDP ports
nmap 192.168.1.1 -p- #Port scan all ports
nmap 192.168.1.1 -p http,https	#Port scan from service name
nmap 192.168.1.1 -F	#Fast port scan (100 ports)
nmap 192.168.1.1 –top-ports 2000	#Port scan the top x ports
nmap 192.168.1.1 -p-65535	#Leaving off initial port in range makes the scan start at port 1
nmap 192.168.1.1 -p0-	#Leaving off end port in range makes the scan go through to port 65535
```

- Service and Version Detection
```bash
nmap 192.168.1.1 -sV	#Attempts to determine the version of the service running on port
nmap 192.168.1.1 -sV –version-intensity 8	#Intensity level 0 to 9. Higher number increases possibility of correctness
nmap 192.168.1.1 -sV –version-light	#Enable light mode. Lower possibility of correctness. Faster
nmap 192.168.1.1 -sV –version-all	#Enable intensity level 9. Higher possibility of correctness. Slower
nmap 192.168.1.1 -A	#Enables OS detection(-O), version detection(-sV), script scanning(-sC), and traceroute
```

- OS Detection
```bash
nmap 192.168.1.1 -O	#Remote OS detection using TCP/IP stack fingerprinting
nmap 192.168.1.1 -O –osscan-limit	#If at least one open and one closed TCP port are not found it will not try OS detection against host
nmap 192.168.1.1 -O –osscan-guess	#Makes Nmap guess more aggressively
nmap 192.168.1.1 -O –max-os-tries 1	#Set the maximum number x of OS detection tries against a target
nmap 192.168.1.1 -A	#Enables OS detection, version detection, script scanning, and traceroute
```

- Timing and Performance
```bash
nmap 192.168.1.1 -T0	#Paranoid (0) Intrusion Detection System evasion
nmap 192.168.1.1 -T1	#Sneaky (1) Intrusion Detection System evasion
nmap 192.168.1.1 -T2	#Polite (2) slows down the scan to use less bandwidth and use less target machine resources
nmap 192.168.1.1 -T3	#Normal (3) which is default speed
nmap 192.168.1.1 -T4	#Aggressive (4) speeds scans; assumes you are on a reasonably fast and reliable network
nmap 192.168.1.1 -T5	#Insane (5) speeds scan; assumes you are on an extraordinarily fast network
```

- Timing and Performance Switches
```bash
–host-timeout <time>	1s; 4m; 2h	#Give up on target after this long
–min-rtt-timeout/max-rtt-timeout/initial-rtt-timeout <time>	1s; 4m; 2h	#Specifies probe round trip time
–min-hostgroup/max-hostgroup <size<size>	50; 1024	#Parallel host scan group sizes
–min-parallelism/max-parallelism <numprobes>	10; 1	#Probe parallelization
–max-retries <tries>	3	#Specify the maximum number of port scan probe retransmissions
–min-rate <number>	100	#Send packets no slower than <number> per second
–max-rate <number>	100	#Send packets no faster than <number> per second
```

- NSE Scripts
```bash
nmap 192.168.1.1 -sC	#Scan with default NSE scripts. Considered useful for discovery and safe
nmap 192.168.1.1 –script default	#Scan with default NSE scripts. Considered useful for discovery and safe
nmap 192.168.1.1 –script=banner	#Scan with a single script. Example banner
nmap 192.168.1.1 –script=http*	#Scan with a wildcard. Example http
nmap 192.168.1.1 –script=http,banner	#Scan with two scripts. Example http and banner
nmap 192.168.1.1 –script “not intrusive”	#Scan default, but remove intrusive scripts
nmap –script snmp-sysdescr –script-args snmpcommunity=admin 192.168.1.1	#NSE script with arguments
```

- Useful NSE Script Examples
```bash
nmap -Pn –script=http-sitemap-generator scanme.nmap.org	#http site map generator
nmap -n -Pn -p 80 –open -sV -vvv –script banner,http-title -iR 1000	#Fast search for random web servers
nmap -Pn –script=dns-brute domain.com	#Brute forces DNS hostnames guessing subdomains
nmap -n -Pn -vv -O -sV –script=smb-enum*,smb-ls,smb-mbenum,smb-os-discovery,smb-s*,smb-vuln*,smbv2* -vv 192.168.1.1	#Safe SMB scripts to run
nmap –script whois* domain.com	#Whois query
nmap -p80 –script http-unsafe-output-escaping scanme.nmap.org	#Detect cross site scripting vulnerabilities
nmap -p80 –script http-sql-injection scanme.nmap.org	#Check for SQL injections
```

- Firewall / IDS Evasion and Spoofing
```bash
nmap 192.168.1.1 -f	#Requested scan (including ping scans) use tiny fragmented IP packets. Harder for packet filters
nmap 192.168.1.1 –mtu 32	#Set your own offset size
nmap -D 192.168.1.101,192.168.1.102,192.168.1.103,192.168.1.23 192.168.1.1	#Send scans from spoofed IPs
nmap -D decoy-ip1,decoy-ip2,your-own-ip,decoy-ip3,decoy-ip4 remote-host-ip	#Above example explained
nmap -S www.microsoft.com www.facebook.com	#Scan Facebook from Microsoft (-e eth0 -Pn may be required)
nmap -g 53 192.168.1.1	#Use given source port number
nmap –proxies http://192.168.1.1:8080, http://192.168.1.2:8080 192.168.1.1	#Relay connections through HTTP/SOCKS4 proxies
nmap –data-length 200 192.168.1.1	#Appends random data to sent packets
```

- Example IDS Evasion command
```bash
nmap -f -t 0 -n -Pn –data-length 200 -D
192.168.1.101,192.168.1.102,192.168.1.103,192.168.1.23 192.168.1.1
```

- Output (save it)
```bash
nmap 192.168.1.1 -oN normal.file	#Normal output to the file normal.file
nmap 192.168.1.1 -oX xml.file	#XML output to the file xml.file
nmap 192.168.1.1 -oG grep.file	#Grepable output to the file grep.file
nmap 192.168.1.1 -oA results	#Output in the three major formats at once
nmap 192.168.1.1 -oG –	#Grepable output to screen. -oN -, -oX – also usable
nmap 192.168.1.1 -oN file.file –append-output	#Append a scan to a previous scan file
nmap 192.168.1.1 -v	#Increase the verbosity level (use -vv or more for greater effect)
nmap 192.168.1.1 -d	#Increase debugging level (use -dd or more for greater effect)
nmap 192.168.1.1 –reason	#Display the reason a port is in a particular state, same output as -vv
nmap 192.168.1.1 –open	#Only show open (or possibly open) ports
nmap 192.168.1.1 -T4 –packet-trace	#Show all packets sent and received
nmap –iflist	#Shows the host interfaces and routes
nmap –resume results.file	#Resume a scan
```

- Helpful Nmap Output examples
```bash
nmap -p80 -sV -oG – –open 192.168.1.1/24 | grep open	#Scan for web servers and grep to show which IPs are running web servers
nmap -iR 10 -n -oX out.xml | grep “Nmap” | cut -d ” ” -f5 > live-hosts.txt	#Generate a list of the IPs of live hosts
nmap -iR 10 -n -oX out2.xml | grep “Nmap” | cut -d ” ” -f5 >> live-hosts.txt	#Append IP to the list of live hosts
ndiff scanl.xml scan2.xml	#Compare output from nmap using the ndif
xsltproc nmap.xml -o nmap.html	#Convert nmap xml files to html files
grep ” open ” results.nmap | sed -r ‘s/ +/ /g’ | sort | uniq -c | sort -rn | less	#Reverse sorted list of how often ports turn up
```

- Miscellaneous Nmap Flags
```bash
nmap -6 2607:f0d0:1002:51::4	#Enable IPv6 scanning
nmap -h	nmap #help screen
```

- COMMAND	DESCRIPTION
```bash
nmap -iR 10 -PS22-25,80,113,1050,35000 -v -sn	#Discovery only on ports x, no port scan
nmap 192.168.1.1-1/24 -PR -sn -vv	#Arp discovery only on local network, no port scan
nmap -iR 10 -sn -traceroute	#Traceroute to random targets, no port scan
nmap 192.168.1.1-50 -sL –dns-server 192.168.1.1	#Query the Internal DNS for hosts, list targets only
```
