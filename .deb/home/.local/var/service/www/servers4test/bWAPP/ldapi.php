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

function ldapi($data)
{
         
    switch($_COOKIE["security_level"])
    {
        
        case "0" : 
            
            $data = no_check($data);           
            break;
        
        case "1" :
            
            $data = ldapi_check_1($data);
            break;
        
        case "2" :            
                       
            $data = ldapi_check_1($data);            
            break;
        
        default : 
            
            $data = no_check($data);            
            break;   

    }       

    return $data;

}

if(!(isset($_SESSION["ldap"]["login"]) && $_SESSION["ldap"]["login"]))
{
    
    header("Location: ldap_connect.php");
    
    exit;
   
}

$message = "";

// Retrieves the LDAP connection settings
$login = $_SESSION["ldap"]["login"];
$password = $_SESSION["ldap"]["password"];
$server = $_SESSION["ldap"]["server"];
$dn = $_SESSION["ldap"]["dn"];

// Connects and binds to the LDAP server
$ds = ldap_connect($server);  
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);// Sets the LDAP Protocol used by the AD service
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
$r = ldap_bind($ds, $login, $password);

if($r)
{
    
    // Searches the LDAP attributes for the user who connected to the LDAP server
    // If the login name contains a '\' (= pre-windows 2000 domain name) then we need the SAMAccountName
    // The SAMAccountName is the part after the '\'
    if(strpos($login, "\\") !== false) 
    {      

        // Debugging
        // echo $login . " contains the character \\";
        
        // Breaks the login name in pieces (\). All pieces are put in an array
        $login_array = explode("\\", $login);
    
        // Puts the last part of the array (= the SAMAccountName) in a new variabele
        $samaccountname = $login_array[count($login_array) - 1];
        
        // Sets the fields for $filter        
        $search_for = $samaccountname;// The string to find 
        $search_field = "samaccountname";// The LDAP field to search for the string

    }
    
    else    
    {  
    
        // Sets the fields for $filter  
        $search_for = $login;// The string to find        
        $search_field = "userprincipalname";// The LDAP field to search for the string
    
    }

    // Filters the LDAP search
    $filter = "(&($search_field=$search_for)(objectClass=user))";// Searches a specific user

    // Searches the LDAP database with the configured filter
    $sr = ldap_search($ds, $dn, $filter);

    // Debugging
    // print_r($sr); 

    $info = ldap_get_entries($ds, $sr);

    // Error handling
    error_reporting(E_ALL ^ E_NOTICE);

    // Debugging
    // print_r($info);
    
    $message =  "Welcome " . ucwords($samaccountname = $info[0]["samaccountname"][0]) . ",";
        
}

ldap_close($ds);

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

<title>bWAPP - LDAP Injection</title>

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

    <h1>LDAP Injection (Search)</h1>

    <p><?php echo $message?></p>
    
    <table>
        
        <tr>
        
            <td width="450">

            <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

                <p>

                <label for="user">Search for a user account:</label>

                <input type="user" id="user" name="user" size="25">

                <button type="submit" name="form" value="submit">Search</button>

                </p>

            </form>

            </td>
    
            <td><font size="1"><a href="ldap_connect.php">LDAP Connection Settings</a></font></td>      
    
        </tr>
        
    </table>  
    
    <table id="table_yellow">

        <tr bgcolor="#ffb717" height="40">

            <td align="center" width="65"><b>SID</b></td>
            <td align="center" width="110"><b>SAM Name</b></td>
            <td align="center" width="170"><b>UPN</b></td>
            <td align="center" width="150"><b>Common Name</b></td>
            <td align="center" width="150"><b>Display Name</b></td>
 
        </tr>
<?php

if(isset($_POST["user"]))  
{
    
    // Connects and binds to the LDAP server
    $ds = ldap_connect($server);  
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);// Sets the LDAP Protocol used by the AD service
    ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    $r = ldap_bind($ds, $login, $password);

    if($r)
    {
        
        // Sets the fields for $filter               
        $search_for = $_REQUEST["user"];// The string to find
        $search_for = ldapi($search_for);
        $search_field_1 = "givenname";// The LDAP field to search for the string
        $search_field_2 = "sn";// The LDAP field to search for the string
        $search_field_3 = "userprincipalname";// The LDAP field to search for the string
        // $search_field = "userprincipalname";// The LDAP field to search for the string 
        
        // Filters the LDAP search
        // $filter = "CN=*";// Searches all the 'Common Names'
        // $filter = "($search_field=$search_for*)";// Wildcard is *. Remove it if you want an exact match
        // $filter = "($search_field=$search_for)";// Exact match
        // $filter = "(objectClass=user)";// Searches all the users
        // $filter = "(&($search_field=$search_for)(objectClass=user))";// Searches a specific user
        // $filter = "(&($search_field=$search_for)(objectClass=user)(objectCategory=person))";// Searches a specific user
        // $filter = "(|($search_field=$search_for))";// Injection!!!  
        $filter = "(|($search_field_1=$search_for)($search_field_2=$search_for)($search_field_3=$search_for))";// Injection!!!

        // Common LDAP queries
        // http://www.google.com/support/enterprise/static/gapps/docs/admin/en/gads/admin/ldap.5.4.html
      
        // Retrieves only specific attributes
        $ldap_fields_to_find = array("objectsid", "samaccountname", "userprincipalname", "cn", "displayname");
   
        // Searches the LDAP database
        // $sr = ldap_search($ds, $dn, $filter);
        $sr = ldap_search($ds, $dn, $filter, $ldap_fields_to_find);
                
        // Debugging
        // print_r($sr); 
  
        $info = ldap_get_entries($ds, $sr);
        
        // Error handling
        error_reporting(E_ALL ^ E_NOTICE);
        
        // Debugging
        // print_r($info);
          
        for($x=0; $x<$info["count"]; $x++)
        {        

            $objectsid = bin_sid_to_text($info[$x]["objectsid"][0]);
            $samaccountname = $info[$x]["samaccountname"][0];
            $userprincipalname = $info[$x]["userprincipalname"][0];
            $cn = $info[$x]["cn"][0];            
            $givenname = $info[$x]["displayname"][0];
            
?>

        <tr height="40">

            <td align="center"><?php echo $objectsid?></td>
            <td><?php echo $samaccountname?></td>
            <td><?php echo $userprincipalname?></td>
            <td><?php echo $cn?></td>
            <td><?php echo $givenname?></td>

        </tr>
<?php

        }

    }

    ldap_close($ds);

}

?>

    </table>

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