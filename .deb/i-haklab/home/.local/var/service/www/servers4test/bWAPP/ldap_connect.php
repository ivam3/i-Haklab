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
include("admin/settings.php");

$bugs = file("bugs.txt");

if(isset($_POST["form_bug"]) && isset($_POST["bug"]))
{
        
            $key = $_POST["bug"]; 
            $bug = explode(",", trim($bugs[$key]));
            
            // Debugging
            // print_r($bug);
            
            header("Location: " . $bug[1]);
            
            exit;
   
}
 
if(isset($_POST["form_security_level"]) && isset($_POST["security_level"]))    
{
    
    $security_level_cookie = $_POST["security_level"];
    
    switch($security_level_cookie)
    {

        case "0" :

            $security_level_cookie = "0";
            break;

        case "1" :

            $security_level_cookie = "1";
            break;

        case "2" :

            $security_level_cookie = "2";
            break;

        default : 

            $security_level_cookie = "0";
            break;

    }

    if($evil_bee == 1)
    {

        setcookie("security_level", "666", time()+60*60*24*365, "/", "", false, false);

    }
    
    else        
    {
      
        setcookie("security_level", $security_level_cookie, time()+60*60*24*365, "/", "", false, false);
        
    }

    header("Location: ldap_connect.php");
    
    exit;

}

if(isset($_COOKIE["security_level"]))
{

    switch($_COOKIE["security_level"])
    {
        
        case "0" :
            
            $security_level = "low";
            break;
        
        case "1" :
            
            $security_level = "medium";
            break;
        
        case "2" :
            
            $security_level = "high";
            break;
        
        case "666" :

            $security_level = "666";
            break;
        
        default :
            
            $security_level = "low";
            break;

    }
    
}

else
{
     
    $security_level = "not set";
    
}

$message = "";
$login = "bee@bwapp.local";
$password = "";
$server = "";
$dn = "DC=bwapp,DC=local";

if(isset($_REQUEST["clear"]))
{
  
    // Clears the LDAP settings
    $_SESSION["ldap"] = array();
    
    $message = "<font color=\"green\">Settings cleared successfully!</font>";
    
}

if(isset($_REQUEST["set"]) && isset($_REQUEST["login"]) && isset($_REQUEST["password"]) && isset($_REQUEST["server"]) && isset($_REQUEST["dn"]))   
{
    
    // LDAP connection settings
    $login = $_REQUEST["login"];
    $password = $_REQUEST["password"];
    $server = $_REQUEST["server"];
    $dn = $_REQUEST["dn"];
    
    if($login == "" || $password == "" || $server == "" || $dn == "")
    {
    
        $message = "<font color=\"red\">Please enter all fields!</font>";  
       
    }
    
    else
    {  
      
        // Connects and binds to the LDAP server
        $ds = ldap_connect($server);
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);// Sets the LDAP protocol used by the AD service
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
        $r = @ldap_bind($ds, $login, $password);
        // $r = @ldap_bind($ds, $domain . "\\" . $login, $password);// Pre-Windows 2000 username
        // $r = @ldap_bind($ds);// Anonymous login. Needs some adjustments in AD!
       
        // Debugging
        // Prints TRUE if the credentials are valid
        // print_r($r);

        if(!$r)
        {
            
            $message = "<font color=\"red\">Invalid credentials or invalid server!</font>";
        
        }

        else
        {
            
            $filter = "(cn=*)"; 
            
            // Checks if the base DN has a valid syntax
            if(!($search=@ldap_search($ds, $dn, $filter)))
            {
          
               $message = "<font color=\"red\">Base DN invalid syntax!</font>";             
               
            }
            
            else
            {
                
                // Checks if the base DN is valid
                $number_returned = ldap_count_entries($ds,$search);
                
                if($number_returned == 0)
                {
                    
                    $message = "<font color=\"red\">Base DN invalid!</font>";
                    
                }
                
                // If the connection settings are valid
                else
                {

                    $_SESSION["ldap"]["login"] = $login;
                    $_SESSION["ldap"]["password"] = $password;
                    $_SESSION["ldap"]["server"] = $server;
                    $_SESSION["ldap"]["dn"] = $dn;                    
                    
                    // $message = "<font color=\"green\">Valid connection settings!</font>";

                    header("Location: ldapi.php");

                    exit;
                    
                }
            
            }

        }

        ldap_close($ds);
      
    }

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

<title>bWAPP - LDAP Connection Settings</title>

<script language="javascript">   

function clear()
{

    location.href="<?php echo($_SERVER["SCRIPT_NAME"]); ?>?clear=yes";

}

</script>

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

    <h1>LDAP Connection Settings</h1>

    <p>
        
    Configure your LDAP connection settings (requires the PHP LDAP extension).<br />
    The credentials will be sent in clear text!   
    
    </p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <p><label for="login">Login:</label><br />
        <input type="text" id="login" name="login" value="<?php echo isset($_SESSION["ldap"]["login"])?$_SESSION["ldap"]["login"]:$login;?>" size="20" autocomplete="off"></p>

        <p><label for="password">Password:</label><br />
        <input type="password" id="password" name="password" value="<?php echo isset($_SESSION["ldap"]["password"])?"":$password;?>" size="20" autocomplete="off"></p>
        
        <p><label for="server">Server:</label><br />
        <input type="text" id="server" name="server" value="<?php echo isset($_SESSION["ldap"]["server"])?$_SESSION["ldap"]["server"]:$server;?>" size="20"></p>
        
        <p><label for="dn">Base DN:</label><br />
        <input type="text" id="dn" name="dn" value="<?php echo isset($_SESSION["ldap"]["dn"])?$_SESSION["ldap"]["dn"]:$dn;?>" size="20"></p>

        <button type="submit" name="set" value="submit" style="height:30px;width:60px">Set</button>
        
        <input type="reset" value="Reset" onclick="javascript:clear()" style="height:30px;width:60px">&nbsp;&nbsp;<?php echo $message;?>

    </form>

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