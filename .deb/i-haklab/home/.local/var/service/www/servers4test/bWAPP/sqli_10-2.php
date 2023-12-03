<?php

/*

bWAPP, or a buggy web application, is a free and open source deliberately insecure web application.
It helps security enthusiasts, developers and students to discover and to prevent web vulnerabilities.
bWAPP covers all major known web vulnerabilities, including all risks from the OWASP Top 10 project!
It is for security-testing and educational purposes only.

Enjoy!

Malik Mesellem
Twitter: @MME_IT

David Bloom
Twitter: @philophobia78

bWAPP is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (http://creativecommons.org/licenses/by-nc-nd/4.0/). Copyright © 2014 MME BVBA. All rights reserved.

*/

include("security.php");
include("security_level_check.php");
include("functions_external.php");
include("connect.php");

function sqli($data)
{

    switch ($_COOKIE["security_level"])
    {

        case "0" :

            $data = no_check($data);
            break;

        case "1" :

            $data = sqli_check_1($data);
            break;

        case "2" :

            $data = sqli_check_2($data);
            break;

        default :

            $data = no_check($data);
            break;
    }

    return $data;
}

if(!empty($_GET["title"]))
{

    // Retrieves the movie title
    $title = $_GET["title"];

    // Constructs the query
    $sql = "SELECT * FROM movies WHERE title LIKE '%" . sqli($title) . "%'";

    // Queries the database
    $recordset = mysql_query($sql, $link);

    // Fetches the result
    if(mysql_num_rows($recordset) != 0)
    {

        while($row = mysql_fetch_array($recordset))
        {

            $movies[] = $row;

        }

    }

    else
    {

        $movies = array();

    }

}

else
{

    $movies = array();

}

header("Content-Type: text/json; charset=utf-8");

// Encodes the result to JSON
echo json_encode($movies);

?>