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
    
    <h1>XML/XPath Injection (Search)</h1>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]); ?>" method="GET">

        <p>

        <label for="genre">Search movies by genre:</label>
        <select name="genre">
                    
                <option value="action">Action</option>";
                <option value="horror">Horror</option>";
                <option value="sci-fi">Science Fiction</option>";

        </select> 

        <button type="submit" name="action" value="search">Search</button>

        </p>

    </form>

    <table id="table_yellow">

        <tr height="40" bgcolor="#ffb717" align="center">

            <td width="10">#</td>
            <td width="200"><b>Movie</b></td>

        </tr>
<?php

if(isset($_REQUEST["genre"])) 
{
    
    $genre = $_REQUEST["genre"];
    $genre = xmli($genre);
   
    // Loads the XML file
    $xml = simplexml_load_file("passwords/heroes.xml");
     
    // XPath search
    // $result = $xml->xpath("//hero[genre = '$genre']/movie");
    $result = $xml->xpath("//hero[contains(genre, '$genre')]/movie");
    
    // Case insensitive search
    // $result = $xml->xpath("//hero[contains(translate(genre, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), translate('$genre', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'))]/movie");
    
    // $upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZÆØÅ";
    // $lower = "abcdefghijklmnopqrstuvwxyzæøå";
    
    // $result = $xml->xpath("//hero[contains(translate(genre, '$upper', '$lower'), translate('$genre', '$upper', '$lower'))]/movie");

    // Debugging
    // print_r($result);  
    // echo $result[0][0];  
    // echo $result[0]->login;

    if($result)
    {    

        foreach($result as $key => $row)       
        {

            // print_r($row);    

?>

        <tr height="40">

            <td align="center"><?php echo $key + 1?></td>
            <td><?php echo $row;?></td>

        </tr>         
<?php        

        }        

    }

    else
    {

?>

        <tr height="40">

            <td colspan="5" width="210">No movies were found!</td>
 
        </tr>     
<?php        

    }

}

else
{

?>

        <tr height="40">

            <td colspan="5" width="210"></td>

        </tr>
<?php

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