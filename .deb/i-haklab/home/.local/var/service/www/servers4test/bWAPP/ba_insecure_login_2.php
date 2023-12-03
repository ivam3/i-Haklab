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

    header("Location: ba_insecure_login.php");
    
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

// Debugging
// print_r($_REQUEST);

if(isset($_REQUEST["secret"]))   
{ 
        
    if($_REQUEST["secret"] == "hulk smash!")
    {
        
        $message = "<font color=\"green\">The secret was unlocked: HULK SMASH!</font>";
        
    }
    
    else        
    {

        $message = "<font color=\"red\">Still locked... Don't lose your temper Bruce!</font>";

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

<title>bWAPP - Broken Authentication</title>

<script language="javascript">   

function unlock_secret()
{

    var bWAPP = "bash update killed my shells!"

    var a = bWAPP.charAt(0);  var d = bWAPP.charAt(3);  var r = bWAPP.charAt(16);
    var b = bWAPP.charAt(1);  var e = bWAPP.charAt(4);  var j = bWAPP.charAt(9);
    var c = bWAPP.charAt(2);  var f = bWAPP.charAt(5);  var g = bWAPP.charAt(4);
    var j = bWAPP.charAt(9);  var h = bWAPP.charAt(6);  var l = bWAPP.charAt(11);
    var g = bWAPP.charAt(4);  var i = bWAPP.charAt(7);  var x = bWAPP.charAt(4);
    var l = bWAPP.charAt(11); var p = bWAPP.charAt(23); var m = bWAPP.charAt(4);
    var s = bWAPP.charAt(17); var k = bWAPP.charAt(10); var d = bWAPP.charAt(23);
    var t = bWAPP.charAt(2);  var n = bWAPP.charAt(12); var e = bWAPP.charAt(4);
    var a = bWAPP.charAt(1);  var o = bWAPP.charAt(13); var f = bWAPP.charAt(5);
    var b = bWAPP.charAt(1);  var q = bWAPP.charAt(15); var h = bWAPP.charAt(9);
    var c = bWAPP.charAt(2);  var h = bWAPP.charAt(2);  var i = bWAPP.charAt(7);
    var j = bWAPP.charAt(5);  var i = bWAPP.charAt(7);  var y = bWAPP.charAt(22);
    var g = bWAPP.charAt(1);  var p = bWAPP.charAt(4);  var p = bWAPP.charAt(28);
    var l = bWAPP.charAt(11); var k = bWAPP.charAt(14);
    var q = bWAPP.charAt(12); var n = bWAPP.charAt(12);
    var m = bWAPP.charAt(4);  var o = bWAPP.charAt(19);

    var secret = (d + "" + j + "" + k + "" + q + "" + x + "" + t + "" +o + "" + g + "" + h + "" + d + "" + p);

    if(document.forms[0].passphrase.value == secret)
    { 
              
        // Unlocked
        location.href="<?php echo($_SERVER["SCRIPT_NAME"]); ?>?secret=" + secret;

    }
    
    else
    {
        
        // Locked
        location.href="<?php echo($_SERVER["SCRIPT_NAME"]); ?>?secret=";
                
    }

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

    <h1>Broken Auth. - Insecure Login Forms</h1>

    <p>Enter the correct passphrase to unlock the secret.</p>

    <form>   

        <p><label for="name">Name:</label><font color="white">brucebanner</font><br />
        <input type="text" id="name" name="name" size="20" value="brucebanner" /></p> 

        <p><label for="passphrase">Passphrase:</label><br />
        <input type="password" id="passphrase" name="passphrase" size="20" /></p>

        <input type="button" name="button" value="Unlock" onclick="unlock_secret()" /><br />

    </form>

    </br >    
    <?php echo $message;?>    
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