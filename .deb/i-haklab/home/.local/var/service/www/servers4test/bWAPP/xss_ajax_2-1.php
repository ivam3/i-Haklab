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
include("selections.php");

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
<script src="js/json2.js"></script>

<title>bWAPP - XSS</title>

</head>

<body onload="process()">
    
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

    <h1>XSS - Reflected (AJAX/JSON)</h1>

    <p>

    <label for="title">Search for a movie:</label>
    <input type="text" id="title" name="title">
    
    </p>

    <div id="result"></div>
    
    <script>
    
        // Stores the reference to the XMLHttpRequest object
        var xmlHttp = createXmlHttpRequestObject(); 

        // Retrieves the XMLHttpRequest object
        function createXmlHttpRequestObject() 
        {	
            // Stores the reference to the XMLHttpRequest object
            var xmlHttp;
            // If running Internet Explorer 6 or older
            if(window.ActiveXObject)
            {
                try
                {
                    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                catch (e)
                {
                    xmlHttp = false;
                }
            }
            // If running Mozilla or other browsers
            else
            {
                try
                {
                    xmlHttp = new XMLHttpRequest();
                }
                catch (e)
                {
                    xmlHttp = false;
                }
            }
            // Returns the created object or displays an error message
            if(!xmlHttp)
                alert("Error creating the XMLHttpRequest object.");
            else 
                return xmlHttp;
        }

        // Makes an asynchronous HTTP request using the XMLHttpRequest object 
        function process()
        {
            // Proceeds only if the xmlHttp object isn't busy
            if(xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
            {
                // Retrieves the movie title typed by the user on the form
                // title = document.getElementById("title").value;
                title = encodeURIComponent(document.getElementById("title").value);
                // Executes the 'xss_ajax_1-2.php' page from the server
                xmlHttp.open("GET", "xss_ajax_2-2.php?title=" + title, true);  
                // Defines the method to handle server responses
                xmlHttp.onreadystatechange = handleServerResponse;
                // Makes the server request
                xmlHttp.send(null);
            }
            else
                // If the connection is busy, try again after one second  
                setTimeout("process()", 1000);
        }

        // Callback function executed when a message is received from the server
        function handleServerResponse()
        {
            // Move forward only if the transaction has completed
            if(xmlHttp.readyState == 4)
            {
                // Status of 200 indicates the transaction completed successfully
                if(xmlHttp.status == 200)
                {
                    // Extracts the JSON retrieved from the server
<?php

                if($_COOKIE["security_level"] == "2")
                {

?>
                    JSONResponse = JSON.parse(xmlHttp.responseText);
<?php

                }

                else
                {
?>
                    JSONResponse = eval("(" + xmlHttp.responseText + ")");
<?php

                    }

?>
                    // Generates HTML output
                    // var result = "";
                    // Obtains the value of the JSON response
                    result = JSONResponse.movies[0].response;
                    // Iterates through the arrays and create an HTML structure
                    //for (var i=0; i<JSONResponse.movies.length; i++)
                    //    result += JSONResponse.movies[i].response + "<br/>";
                    // Obtains a reference to the <div> element on the page
                    // Displays the data received from the server
                    document.getElementById("result").innerHTML = result;
                    // Restart sequence
                    setTimeout("process()", 1000);
                } 
                // A HTTP status different than 200 signals an error
                else 
                {
                    alert("There was a problem accessing the server: " + xmlHttp.statusText);
                }
            }
        }

    </script>

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