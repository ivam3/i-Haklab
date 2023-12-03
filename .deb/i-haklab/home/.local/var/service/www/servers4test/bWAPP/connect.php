<?php

/*

bWAPP, or a buggy web application, is a free and open source deliberately insecure web application.
It helps security enthusiasts, developers and students to discover and to prevent web vulnerabilities.
bWAPP covers all major known web vulnerabilities, including all risks from the OWASP Top 10 project!
It is for security-testing and educational purposes only.

Enjoy!

Malik Mesellem
Twitter: @MME_IT

bWAPP is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (http://creativecommons.org/licenses/by-nc-nd/4.0/). Copyright © 2014 MME BVBA. All rights reserved.

*/

// Connection settings
include("config.inc.php");

// Connects to the server
$link = new mysqli($server, $username, $password);

// Checks the connection
if(!$link)
{
    
    // @mail($recipient, "Could not connect to server: ", mysql_error());
    
    die("Could not connect to the server: " . mysql_error());
    
}

// Connects to the database
$database = mysqli_select_db($link, $database);

// Checks the connection
if(!$database)
{
    
    // @mail($recipient, "Could not connect to database: ", mysql_error());
    
    die("Could not connect to the database: " . mysql_error()); 

}

// mysql_close($link);

?>
