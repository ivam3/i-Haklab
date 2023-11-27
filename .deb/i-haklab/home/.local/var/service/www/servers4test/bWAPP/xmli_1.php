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
include("selections.php");

ini_set("display_errors", 1);

$message = "";

function xmli($data)
{
    
    if(isset($_COOKIE["security_level"]))
    {

        switch($_COOKIE["security_level"])
        {

            case "0" :

                $data = no_check($data);
                break;

            case "1" :

                $data = xmli_check_1($data);
                break;

            case "2" :

                $data = xmli_check_1($data);
                break;

            default :

                $data = no_check($data);
                break;

        }

    }

    return $data;

}

if(isset($_REQUEST["login"]) & isset($_REQUEST["password"]))
{

    $login = $_REQUEST["login"];
    $login = xmli($login);

    $password = $_REQUEST["password"];
    $password = xmli($password);

    // Loads the XML file
    $xml = simplexml_load_file("passwords/heroes.xml");

    // XPath search
    $result = $xml->xpath("/heroes/hero[login='" . $login . "' and password='" . $password . "']");

    // Debugging
    // print_r($result);
    // echo $result[0][0];
    // echo $result[0]->login;

    if($result)
    {

        $message =  "<p>Welcome <b>" . ucwords($result[0]->login) . "</b>, how are you today?</p><p>Your secret: <b>" . $result[0]->secret . "</b></p>";
 
    }

    else
    {

        $message = "<font color=\"red\">Invalid credentials!</font>";

    }

    // Playing with XML & XPath

    // Loads the XML file
    // $xml = simplexml_load_file("passwords/heroes.xml");

    // Debugging
    // print_r($xml);

    /*
    // Selects 1 attribute
    // $result = $xml->xpath("/heroes/hero/login");
    $result = $xml->xpath("//login");

    // Displays the result
    foreach($result as $row)
    {

        echo "<br />Found " . $row;

    }
    */

    /*
    // Selects all the attributes
    // $result = $xml->xpath("/heroes/hero");
    // $result = $xml->xpath("//hero[movie = 'The Matrix']|//hero/password");

    // print_r($result);

    // Displays the result
    foreach($result as $row)
    {

        // echo "Found "  . $row->login . "<br />";
        echo "<br />Found "  . $row->movie;

    }

    if($result)
    {

        echo "Found";

    }
    */

    /* Other queries
    $result = $xml->xpath("//hero[contains(password, 'trin')]"); // Selects all the attributes where the password contains 'trin'...
    $result = $xml->xpath("//hero[password = 'trinity']"); // Selects all the attributes where the password is 'trinity' ... (exactly)
    $result = $xml->xpath("//hero[login = 'neo' and password = 'trinity']"); // Selects all the attributes where ... and ... (exactly)
    $result = $xml->xpath("//hero[login = 'neo'][password = 'trinity']"); // Selects all the attributes where ... and within ... (query on query)
    $result = $xml->xpath("//hero[movie = 'The Matrix']/login"); // Selects the 'login' where the movie is 'The Matrix' (exactly)
    $result = $xml->xpath("//hero[movie = 'The Matrix']|//hero/password"); // Dangerous! Selects all the attributes from 1 movie and ALL the passwords
    $result = $xml->xpath("//hero[login/text()='" . $_GET["user"] . "' and password/text()='" . $_GET["pass"]  . "']"); // HTTP request params
     */

    /* More about XML and XPatch
    http://php.net/manual/en/simplexmlelement.xpath.php
    http://www.tuxradar.com/practicalphp/12/3/3
    https://www.owasp.org/index.php/XPATH_Injection
    https://www.owasp.org/index.php/XPATH_Injection_Java
    https://www.owasp.org/index.php/Testing_for_XPath_Injection_(OWASP-DV-010)
     */

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

<title>bWAPP - XML/XPath Injection</title>

</head>

<body>

<header>

<h1>bWAPP</h1>

<h2>an extremely buggy web app !</h2>

</header>

<div id="menu">

    <table>

        <tr>

            <td><a href="portal.php">Bugs</a></td>
            <td><a href="password_change.php">Change Password</a></td>
            <td><a href="user_extra.php">Create User</a></td>
            <td><a href="security_level_set.php">Set Security Level</a></td>
            <td><a href="reset.php" onclick="return confirm('All settings will be cleared. Are you sure?');">Reset</a></td>
            <td><a href="credits.php">Credits</a></td>
            <td><a href="http://itsecgames.blogspot.com" target="_blank">Blog</a></td>
            <td><a href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a></td>
            <td><font color="red">Welcome <?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);}?></font></td>

        </tr>

    </table>

</div>

<div id="main">

    <h1>XML/XPath Injection (Login Form)</h1>

    <p>Enter your 'superhero' credentials.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="GET">

        <p><label for="login">Login:</label><br />
        <input type="text" id="login" name="login" size="20" autocomplete="off" /></p>

        <p><label for="password">Password:</label><br />
        <input type="password" id="password" name="password" size="20" autocomplete="off" /></p>

        <button type="submit" name="form" value="submit">Login</button>

    </form>

    <br />
    <?php

    echo $message;

    ?>

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

<div id="security_level">

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <label>Set your security level:</label><br />

        <select name="security_level">

            <option value="0">low</option>
            <option value="1">medium</option>
            <option value="2">high</option>

        </select>

        <button type="submit" name="form_security_level" value="submit">Set</button>
        <font size="4">Current: <b><?php echo $security_level?></b></font>

    </form>

</div>

<div id="bug">

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <label>Choose your bug:</label><br />

        <select name="bug">

<?php

// Lists the options from the array 'bugs' (bugs.txt)
foreach ($bugs as $key => $value)
{

   $bug = explode(",", trim($value));

   // Debugging
   // echo "key: " . $key;
   // echo " value: " . $bug[0];
   // echo " filename: " . $bug[1] . "<br />";

   echo "<option value='$key'>$bug[0]</option>";

}

?>


        </select>

        <button type="submit" name="form_bug" value="submit">Hack</button>

    </form>

</div>

</body>

</html>