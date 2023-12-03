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
include("selections.php");
include("functions_external.php");

$entry = "";
$owner = "";
$message = "(requires the PHP SQLite module)";

function sqli($data)
{

    switch($_COOKIE["security_level"])
    {

        case "0" :

            $data = no_check($data);
            break;

        case "1" :

            // Not working with PDO
            // $data = sqlite_escape_string($data);
            // Use a prepared statement instead!
            $data = sqli_check_4($data);
            break;

        case "2" :

            // Not working with PDO
            // $data = sqlite_escape_string($data);
            // Use a prepared statement instead!
            $data = sqli_check_4($data);
            break;

        default :

            $data = no_check($data);
            break;

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

<title>bWAPP - SQL Injection</title>

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

    <h1>SQL Injection - Stored (SQLite)</h1>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <p><label for="entry">Add an entry to our blog:</label><br />
        <textarea name="entry" id="entry" cols="80" rows="3"></textarea></p>

        <button type="submit" name="entry_add" value="add">Add Entry</button>
        <button type="submit" name="entry_delete" value="delete">Delete Entries</button>

        <?php

        if(isset($_POST["entry_add"]))
        {

            $entry = sqli($_POST["entry"]);
            $owner = $_SESSION["login"];

            if($entry == "")
            {

                $message =  "<font color=\"red\">Please enter some text...</font>";

            }

            else
            {

                $db = new PDO("sqlite:".$db_sqlite);

                $sql = "SELECT max(id) as id FROM blog;";

                $recordset = $db->query($sql);

		$row = $recordset->fetch();

		$id = $row["id"];

                $sql = "INSERT INTO blog (id, date, entry, owner) VALUES (" . ++$id . ",'" . date('Y-m-d', time()) . "','" . $entry . "','" . $owner . "');";

		$db->exec($sql);

                $message = "<font color=\"green\">The entry was added to our blog!</font>";

            }

        }

	elseif(isset($_POST["entry_delete"]))
	{

		$db = new PDO("sqlite:".$db_sqlite);

                $sql = "DELETE FROM blog;";

                $db->exec($sql);

		$message = "<font color=\"green\">Your entries were deleted!</font>";
   
	}

        echo "&nbsp;&nbsp;" . $message;

        ?>

    </form>

    <br />

    <table id="table_yellow">

        <tr height="30" bgcolor="#ffb717" align="center">

            <td width="20">#</td>
            <td width="100"><b>Owner</b></td>
            <td width="100"><b>Date</b></td>
            <td width="445"><b>Entry</b></td>

        </tr>

<?php

if(!isset($db))
{

    $db = new PDO("sqlite:".$db_sqlite);
 
}

// Selects all the records
$sql = "SELECT * FROM blog";

$recordset = $db->query($sql);

if(!$recordset)
{

    // die("Error: " . $link->connect_error . "<br /><br />");

?>
        <tr height="50">

            <td colspan="4" width="665"><?php die("Error: " . $db->errorCode()); ?></td>

        </tr>

<?php

}

foreach($recordset as $row)
{

    if($_COOKIE["security_level"] == "2")
    {

?>
        <tr height="40">

            <td align="center"><?php echo $row["id"]; ?></td>
            <td><?php echo $row["owner"]; ?></td>
            <td><?php echo $row["date"]; ?></td>
            <td><?php echo xss_check_3($row["entry"]); ?></td>

        </tr>

<?php

    }

    else

        if($_COOKIE["security_level"] == "1")
        {

?>
        <tr height="40">

            <td align="center"><?php echo $row["id"]; ?></td>
            <td><?php echo $row["owner"]; ?></td>
            <td><?php echo $row["date"]; ?></td>
            <td><?php echo xss_check_4($row["entry"]); ?></td>

        </tr>

<?php

        }

        else
        {

?>
        <tr height="40">

            <td align="center"><?php echo $row["id"]; ?></td>
            <td><?php echo $row["owner"]; ?></td>
            <td><?php echo $row["date"]; ?></td>
            <td><?php echo $row["entry"]; ?></td>

        </tr>

<?php

        }

}

$db = null;

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