<?php

/*

bWAPP, or a buggy web application, is a free and open source deliberately insecure web application.
It helps security enthusiasts, developers and students to discover and to prevent web vulnerabilities.
bWAPP covers all major known web vulnerabilities, including all risks from the OWASP Top 10 project!
It is for educational purposes only.

Enjoy!

Malik Mesellem
Twitter: @MME_IT

© 2013 MME BVBA. All rights reserved.

*/

if(isset($_POST["data"]))
{

    $req_dump = $_POST["data"];
    $fp = fopen("xdx.log", "w");
    fwrite($fp, $req_dump);
    fclose($fp);
    exit;

}

?>
<!DOCTYPE html>
<html>
 
<object type="application/x-shockwave-flash" data="xdx.swf" width="1" height="1">
    
    <param name="movie" value="xdx.swf" />

</object>

</html>