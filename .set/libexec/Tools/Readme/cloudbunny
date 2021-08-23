# CloudBunny

CloudBunny is a tool to capture the origin server that uses a WAF as a proxy or protection.

You can read more about the tool here: https://tinyurl.com/y8p48wb3

<p align="center">
<img src="https://i.imgur.com/CyGo02V.gif">
</p>

# How works

In this tool we used three search engines to search domain information: Shodan, Censys and Zoomeye. To use the tools you need the API Keys, you can pick up the following links:

<pre>
<b>Shodan</b> - https://account.shodan.io/
<b>Censys</b> - https://censys.io/account/api
<b>ZoomEye</b> - https://www.zoomeye.org/profile
</pre>

<b>NOTE</b>: In Zoomeye you need to enter the login and password, it generates a dynamic api key and I already do this work for you. Just enter your login and password.

After that you need to put the credentials in the <b>api.conf</b> file.

Install the requirements:

<pre>
$ sudo pip install -r requirements.txt
</pre>

# Usage

By default the tool searches on all search engines (you can set this up by arguments), but you need to put the credentials as stated above. After you have loaded the credentials and installed the requirements, execute:

<pre>
$ python cloudbunny.py -u securityattack.com.br
</pre>

Check our help area:

<pre>
$ python cloudbunny.py -h
</pre>

Change <b>securityattack.com.br</b> for the domain of your choice.

# Example

<pre>

$ python cloudbunny.py -u site_example.com.br

	            /|      __  
	           / |   ,-~ /  
	          Y :|  //  /    
	          | jj /( .^  
	          >-"~"-v"  
	         /       Y    
	        jo  o    |  
	       ( ~T~     j   
	        >._-' _./   
	       /   "~"  |    
	      Y     _,  |      
	     /| ;-"~ _  l    
	    / l/ ,-"~    \  
	    \//\/      .- \  
	     Y        /    Y*  
	     l       I     ! 
	     ]\      _\    /"\ 
	    (" ~----( ~   Y.  )   
	~~~~~~~~~~~~~~~~~~~~~~~~~~    
CloudBunny - Bypass WAF with Search Engines 
Author: Eddy Oliveira (@Warflop)
https://github.com/Warflop 
    
[+] Looking for target on Shodan...
[+] Looking for target on Censys...
[+] Looking for certificates on Censys...
[+] Looking for target on ZoomEye...
[-] Just more some seconds...


+---------------+------------+-----------+----------------------------+
|   IP Address  |    ISP     |   Ports   |        Last Update         |
+---------------+------------+-----------+----------------------------+
|  55.14.232.4  | Amazon.com | [80, 443] | 2018-11-02T16:02:51.074543 |
| 54.222.146.40 | Amazon.com |    [80]   | 2018-11-02T10:16:38.166829 |
| 18.235.52.237 | Amazon.com | [443, 80] | 2018-11-08T01:22:11.323980 |
| 54.237.93.127 | Amazon.com | [443, 80] | 2018-11-05T15:54:40.248599 |
| 53.222.94.157 | Amazon.com | [443, 80] | 2018-11-06T08:46:03.377082 |
+---------------+------------+-----------+----------------------------+
    We may have some false positives :)
</pre>
