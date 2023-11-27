Shodan Cheat Sheets

I am sharing my personal Shodan Cheat Sheet that contains many shodan Search Filters or Shodan Dorks that will help you to use the Shodan search engine like a pro. It will help you to get targeted results easily.

It is very different than content search engines like Google, Bing, or Yahoo. This type of search engine crawl for data on web pages and then indexes it for searching while Shodan interrogates ports and grabs the resulting banners, then indexes the banners for searching.

If you are in the Cybersecurity field, you should well known about the Shodan search engine. Shodan is an IoT search engine that helps find specific types of computers (routers, webcams, servers, etc.) on the internet using a variety of filters. It’s a great resource to provide passive reconnaissance on a target or as a measuring tool.


Server:
Find the devices or servers that contain a specific server header flag. You can research vulnerable servers.

server: "apache 2.2.3"
or you can use directly the flag apache 2.2.3

Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
hostname:
Find devices with specific hostname worldwide. The hostname is a label that’s assigned to a device connected to a network that is used to spot the device in various kinds of transmission, like the World Wide Web. You can use multiple filters altogether included in the shodan cheat sheet to narrow your search.

server: "apache" hostname:"google"

Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
net:
Find devices or machines based on an IP address or /x CIDR. This filter can also be used to find the IP range or certain IP addresses and subnet masks.

net:34.98.0.0/16

Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
os:
Find devices based on the operating system. You can find all the devices that have some specific operating systems. It will help penetration testers to find for vulnerable machines with specific operating system filters.

os:"windows xp"
Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
port:
Find devices based on open ports. “port” filter will allow narrows the search of the machines with some specific open ports.

proftpd port:21

Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
org:
This filter will allow you to locate the devices of any specific organization.

org:"Google"

Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
You can use multiple filters shown in the shodan cheat sheet with org filter to narrow the search or sort the results among the millions.

city:
Find devices in a particular city. For example, if you want to narrow the search for Mumbai city only then you can use,

city:"Mumbai"

Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
country:
Find devices in a particular country. For example, if you want to narrow the search for India only then you can use,

country:"IN"

Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
geo:
Find devices by giving geographical coordinates according to certain longitudes and latitudes that are within a given radius.

geo:"48.1667,-100.1667"

Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
before/after:
The ‘after’ and ‘before’ filter helps you to devices after and before a particular date.

The format allowed is dd/mm/yyyy

nginx before:13/04/2020 after:13/04/2018
has_screenshot:
This filter will only return results that have a screenshot available.

has_screenshot:true city:"George Town"

Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
Wifi Passwords:
Helps to find the cleartext wifi passwords in Shodan.

html:"def_wirelesspassword"


Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
Surveillance Cams:
Get the data for surveillance cams with username: admin and password: password

NETSurveillance uc-httpd


Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
Or you can also use the below command

Android Webcam Server
Citrix:
Find Citrix Gateway.

title:"citrix gateway"


Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
Windows RDP Password:
But may contain secondary windows auth

"\x03\x00\x00\x0b\x06\xd0\x00\x00\x124\x00"


Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
Misconfigured WordPress Sites:
The wp-config.php if accessed can give out the database credentials.

http.html:"* The wp-config.php creation script uses this file"
You can access the main WordPress configuration file and capture sensitive information like credentials or AUTH_KEY of misconfigured sites.


Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
Mongo DB servers:
This dork filter will give you info about Mongo DB servers.

"MongoDB Server Information" port:27017 -authentication


Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
FTP servers allowing anonymous access:
Get the data for fully Anonymous access.

"220" "230 Login successful." port:21
Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
Jenkins:
Find for all Jenkins Unrestricted Dashboard

x-jenkins 200


Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
Open ATM:
This filter will allow for ATM Access availability.

NCR Port:"161"


Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
Android Root Bridge:
Find android root bridges with port 5555.

"Android Debug Bridge" "Device" port:5555


Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
Telnet Access:
Find devices that required passwords for telnet access.

port:23 console gateway


Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
Etherium Miners:
Shows the miners running ETH.

"ETH - Total speed"

Shodan Cheat Sheet & Shodan Dorks for IoT Search Engine
The shodan command-line interface (CLI) is a command-line library for the Shodan IoT search engine. You can install using this simple python’s pip command,

$  pip install shodan
Once the shodan tool is installed you need to initialize the environment variable with the private API key, you can get form shodan account settings.

$  shodan init PRIVATE_API_KEY
Shodan Cheat Sheet & Shodan Command line Interface(CLI) for IoT Search Engine
Shodan Cheat Sheet & Shodan Command line Interface(CLI) for IoT Search Engine
Shodan CLI Cheat Sheet
you can run just the shodan command to get the help. This is most popular command, will give you the full list of commands that can be used futher for recon process.

$  shodan
Shodan Cheat Sheet & Shodan Command line Interface(CLI) for IoT Search Engine
myip
This command will provide users public internet-facing ip address.

$ shodan myip
 49.34.120.0


Shodan Cheat Sheet & Shodan Command line Interface(CLI) for IoT Search Engine
host
Get the information about the host. You can get information like where it’s located, what ports are open, and which organization owns the IP.

$  shodan host shodan host 63.X.X.X


Shodan Cheat Sheet & Shodan Command line Interface(CLI) for IoT Search Engine
count
It will return the number of results for a search query.

$  shodan count Apache Tomcat/8.5.13
 106
$  shodan port:22 country:IN
 348612


Shodan Cheat Sheet & Shodan Command line Interface(CLI) for IoT Search Engine
search
Shodan search command lets you search Shodan and view the results in a terminal-friendly and user-friendly way. By default it will display data of fields in specific format of (the IP, port, hostnames and data). You can use the –fields parameter to specify the fields you want to view the result in.

*Note: You need “Shodan Pro” to use this command.

$  shodan search --fields ip_str,port,org Apache Tomcat/8.5.13


Shodan Cheat Sheet & Shodan Command line Interface(CLI) for IoT Search Engine
download
Search for Shodan results and download the results into a file that is JSON formated banner lines.

By default the limit of results is set to 1,000 results, if you want to download more than that then you can use the –limit flag with your query.

Shodan command lets you save the results in a file and you can process them afterward using the parse command.

$  shodan download Apache Tomcat/8.5.13


Shodan Cheat Sheet & Shodan Command line Interface(CLI) for IoT Search Engine
parse
You can use the parse command to analyze a file that was generated using the download command. Shodan command-line interface lets you filter out the fields that you’re interested in, convert the JSON to use defined format.

Use –fields flags to specify the fields you are interested in. Flag –separator can be used to specify the use defined separator between the fields specified.

$  shodan parse --fields ip_str,port,org --separator " - " Apache.json.gz


Shodan Cheat Sheet & Shodan Command line Interface(CLI) for IoT Search Engine
*Note: You need “Shodan Pro” to use some of the above shodan command-line commands.

Final Words,
You can use all these all shodan filters for your recon research and penetration testing works. This filter can be used as an advanced filter by using combined multiple filters together.

