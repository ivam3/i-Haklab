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

include("connect_i.php");

$message = "";

if(isset($_GET["user"]) && isset($_GET["activation_code"]) )
{
    
    $login = $_GET["user"];
    $login = mysqli_real_escape_string($link, $login);    
    
    $activation_code = $_GET["activation_code"];
    $activation_code = mysqli_real_escape_string($link, $activation_code);               
                
    $sql = "SELECT * FROM users WHERE login = '" . $login . "' AND BINARY activation_code = '" . $activation_code . "'";
                
    // Debugging
    // echo $sql;    

    $recordset = $link->query($sql);             
                             
    if(!$recordset)
    {

        die("Error: " . $link->error);

    }
                
    // Debugging                 
    // echo "<br />Affected rows: ";                
    // printf($link->affected_rows);
                
    $row = $recordset->fetch_object();   
                                                                           
    if($row)
    {

        // Debugging              
        // echo "<br />Row: "; 
        // print_r($row); 
                    
        $sql = "UPDATE users SET activation_code = NULL, activated = 1 WHERE login = '" . $login . "'";

        // Debugging
        // echo $sql;      

        $recordset = $link->query($sql);

        if(!$recordset)
        {

            die("Error: " . $link->error);

        }
                    
        // Debugging                  
        // echo "<br />Affected rows: ";                
        // printf($link->affected_rows);

        $message = "<font color=\"green\">User activated!</font>";

    }
                
    else
    {

        $message = "<font color=\"red\">User not or already activated!</font>";

    }

}

else

{
    
    $message = "<font color=\"red\">Not a valid input!</font>";

}

?>
<!DOCTYPE html>
<html>
    
<head>
        
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Architects+Daughter">-->
<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
<script src="js/html5.js"></script>

<title>bWAPP - User Activation</title>

</head>

<body>
    
<header>

<h1>bWAPP</h1>

<h2>an extremely buggy web app !</h2>

</header>    

<div id="menu">
      
    <table>
        
        <tr>
            
            <td><a href="login.php">Login</a></td>
            <td><font color="#ffb717">User Activation</font></td>            
            
        </tr>
        
    </table>   
   
</div> 

<div id="main">

    <h1>User Activation</h1>

    <p><?php

    echo $message;

    $link->close();

    ?></p>

</div>
    
<div id="side">    
    
    <a href="http://twitter.com/MME_IT" target="blank_" class="button"><img src="./images/twitter.png"></a>
    <a href="http://be.linkedin.com/in/malikmesellem" target="blank_" class="button"><img src="./images/linkedin.png"></a>
    <a href="http://www.facebook.com/pages/MME-IT-Audits-Security/104153019664877" target="blank_" class="button"><img src="./images/facebook.png"></a>
    <a href="http://itsecgames.blogspot.com" target="blank_" class="button"><img src="./images/blogger.png"></a>

</div>     
    
<div id="disclaimer">
          
    <p>bWAPP is licensed under <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank"><img style="vertical-align:middle" src="./images/cc.png"></a> &copy; 2014 MME BVBA / Follow <a href="http://twitter.com/MME_IT" target="_blank">@MME_IT</a> on Twitter and ask for our cheat sheet, containing all solutions! / Need an exclusive <a href="http://www.mmebvba.com" target="_blank">training</a>?</p>
   
</div>
    
<div id="bee">
    
    <img src="./images/bee_1.png">
    
</div>
      
</body>
    
</html>