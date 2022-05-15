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

include("admin/settings.php");

session_start();

$addresses = array();
@list($ip, $len) = explode('/', $AIM_subnet);

if(($min = ip2long($ip)) !== false)
{

    $max = ($min | (1<<(32-$len))-1);
    for($i = $min; $i < $max; $i++)
    $addresses[] = long2ip($i);

}

if(in_array($_SERVER["REMOTE_ADDR"], $AIM_IPs) or in_array($_SERVER["REMOTE_ADDR"], $addresses))
{

    ini_set("display_errors", 0);

    $_SESSION["login"] = "A.I.M.";
    $_SESSION["admin"] = "1";

}

if(!(isset($_SESSION["login"]) && $_SESSION["login"]))
{
    
    header("Location: login.php");
    
    exit;
   
}

?>