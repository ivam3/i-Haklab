
---------------
bWAPP - INSTALL
---------------

It's pretty easy to install bWAPP from scratch...

Another option is to download bee-box.
bee-box is a custom Linux VM (virtual machine) pre-installed with bWAPP.
bee-box gives you several ways to hack and deface the bWAPP website.
It's even possible to hack the bee-box to get root access...
With bee-box you have the opportunity to explore all bWAPP vulnerabilities!


Requirements
////////////

*/ Windows, Linux, Unix, Mac OS,...
*/ a web server (Apache, Nginx, IIS,...)
*/ the PHP extensions
*/ a MySQL installation
*/ (or you could install WAMP or XAMPP)


Installation steps
//////////////////

No! I will not explain how to install Apache/IIS, PHP and MySQL :)

*/ Extract the 'zip' file.

	example on Linux:

		unzip bWAPP.zip

*/ Move the directory 'bWAPP' (and the entire content) to the root of your web server.

*/ Give full permission to the directories 'passwords', 'images', 'documents' and 'logs'. 
   This step is optional but it will give you so much fun when exploiting bWAPP with tools like sqlmap and Metasploit.

	example on Linux:

		chmod 777 passwords/
		chmod 777 images/
		chmod 777 documents/
		chmod 777 logs/

*/ Edit the file 'admin/settings.php' with your own database connection settings.

	example:

		$db_server = "localhost"; 	// your database server (IP/name), here 'localhost'
		$db_username = "root";		// your MySQL user, here 'root'
		$db_password = "";		// your MySQL password, here 'blank'

*/ Browse to the file 'install.php' in the directory 'bWAPP'.

	example: http://localhost/bWAPP/install.php

*/ Click on 'here' (Click 'here' to install bWAPP).

	The database 'bWAPP' will be created and populated.

*/ Go to the login page. If you browse the bWAPP root directory you will be redirected.

	example: http://localhost/bWAPP/
	example: http://localhost/bWAPP/login.php

*/ Login with the default credentials, or make a new user.

	default credentials: bee/bug

*/ You are ready to explore and exploit the bee!


This project is part of the ITSEC GAMES project. ITSEC GAMES are a fun approach to IT security education. 
IT security, ethical hacking, training and fun... all mixed together.
You can find more about the ITSEC GAMES and bWAPP projects on our blog.

We offer a 2-day comprehensive web security course 'Attacking & Defending Web Apps with bWAPP'.
This course can be scheduled on demand, at your location!
More info: http://goo.gl/ASuPa1 (pdf)

Enjoy!

Cheers

Malik Mesellem
Twitter: @MME_IT
