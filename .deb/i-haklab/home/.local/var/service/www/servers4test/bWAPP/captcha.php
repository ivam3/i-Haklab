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

$captcha = random_string();
$_SESSION["captcha"] = $captcha;

// Creates the canvas
// Creates a new image
// image = imagecreate(233, 49);

// Creates the canvas
// Creates an image from a existing image
$image = imagecreatefrompng("images/captcha.png");

// Sets up some colors for use on the canvas
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$orange = imagecolorallocate($image, 222, 77, 14);

// Loads a font (GDF)
// $font = imageloadfont("fonts/atommicclock.gdf");

// Loads a font (TTF)
$font = "fonts/arial.ttf";

// Writes the string (GDF)
// imagestring($image, $font, 0, 0, $captcha, $orange);
// imagestring($image, $font, 40, 10, $captcha, $black);

// Writes the string (TTF)
// imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
imagettftext($image, 20, 0, 75, 38, $orange, $font, $captcha);
        
// Output the image to the browser
header ("Content-type: image/png");
imagepng($image);

// Cleans up after yourself
imagedestroy($image)

?>