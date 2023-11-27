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
include("functions_external.php");

function xss($data)
{
         
    switch($_COOKIE["security_level"])
    {
        
        case "0" :
            
            $data = no_check($data);            
            break;
        
        case "1" :
            
            $data = xss_check_4($data);
            break;
        
        case "2" : 
                       
            $data = xss_check_3($data);            
            break;
        
        default :
            
            $data = no_check($data);            
            break;   

    }       

    return $data;

}

if(isset($_GET["title"]))
{

    // Creates the movie table
    $movies = array("CAPTAIN AMERICA", "IRON MAN", "SPIDER-MAN", "THE INCREDIBLE HULK", "THE WOLVERINE", "THOR", "X-MEN");

    // Retrieves the movie title
    $title = $_GET["title"];

    // Generates the XML output
    header("Content-Type: text/xml; charset=utf-8");

    // Generates the XML header
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>";

    // Creates the <response> element
    echo "<response>";

    // Generates the output depending on the movie title received from the client
    if(in_array(strtoupper($title), $movies))
        echo "Yes! We have that movie...";
    else if(trim($title) == "")
        echo "HINT: our master really loves Marvel movies :)";
    else
        echo xss($title) . "??? Sorry, we don't have that movie :(";

    // Closes the <response> element
    echo "</response>";

}

else 
{
    
    echo "<font color=\"red\">Try harder :p</font>";
    
}

?>