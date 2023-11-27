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

include("security.php");
include("security_level_check.php");
include("connect_i.php");

$login = $_SESSION["login"];

$sql = "SELECT * FROM users WHERE login = '" . $login . "'";

$recordset = $link->query($sql);             

if(!$recordset)
{

    die("Error: " . $link->error);

}

$row = $recordset->fetch_object();

header("Content-Type: text/plain");

if($row)
{

    $secret = $row->secret;

    echo "Your secret: " . $secret;          

}

$link->close();

?>