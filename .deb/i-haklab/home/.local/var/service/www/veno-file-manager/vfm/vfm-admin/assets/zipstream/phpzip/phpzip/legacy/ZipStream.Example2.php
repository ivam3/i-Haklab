
<?php
set_error_handler("customError");
error_reporting(E_ALL | E_STRICT);
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 1);

$errors = "";

/*
 * A test to see if it was possible to recreate the result of
 *  Issue #7, if not the cause.
 * And a demonstration on why the author of the script calling zip
 *  needs to be diligent not to add extra characters to the output.
 */


// To use the new namespaces, you need a bootstrapper/autoloader, examples are provided here.
// The changes to your Zip use are limited to two lines after that is in place.
// Require your bootstrap.php, or the autoload.php, and change the class instantiation from nwe ZipStream( to
// new \PHPZip\Zip\Stream\ZipStream(
// The parameters are unchanged.

require_once('bootstrap.php'); // include_once("ZipStream.php");

$zip = new \PHPZip\Zip\Stream\ZipStream('test.zip'); // $zip = new ZipStream("test.zip");

/*
 * As seen in the output, the above construct with a PHP end and start tag after
 * creating the ZipStream is a bad idea. The Zip file will be starting with a
 * space followed by the newline characters.
 */
$zip->addDirectory("test");
$zip->addDirectoryContent("testData" . DIRECTORY_SEPARATOR . "test","test");
$rv = $zip->finalize();

// If non-fatal errors occurred during execution, this will append them
//  to the end of the generated file.
// It'll create an invalid Zip file, however chances are that it is invalid
//  already due to the error happening in the first place.
// The idea is that errors will be very easy to spot.
if (!empty($errors)) {
	echo "\n<pre>\n**************\n*** ERRORS ***\n**************\n\n$errors\n</pre>\n";
}

function customError($error_level, $error_message, $error_file, $error_line) {
	global $errors;
	switch ($error_level) {
		case 1:	 $e_type = 'E_ERROR'; $exit_now = true; break;
		case 2:	 $e_type = 'E_WARNING'; break;
		case 4:	 $e_type = 'E_PARSE'; break;
		case 8:	 $e_type = 'E_NOTICE'; break;
		case 16:	$e_type = 'E_CORE_ERROR'; $exit_now = true; break;
		case 32:	$e_type = 'E_CORE_WARNING'; break;
		case 64:	$e_type = 'E_COMPILE_ERROR'; $exit_now = true; break;
		case 128:   $e_type = 'E_COMPILE_WARNING'; break;
		case 256:   $e_type = 'E_USER_ERROR'; $exit_now = true; break;
		case 512:   $e_type = 'E_USER_WARNING'; break;
		case 1024:  $e_type = 'E_USER_NOTICE'; break;
		case 2048:  $e_type = 'E_STRICT'; break;
		case 4096:  $e_type = 'E_RECOVERABLE_ERROR'; $exit_now = true; break;
		case 8192:  $e_type = 'E_DEPRECATED'; break;
		case 16384: $e_type = 'E_USER_DEPRECATED'; break;
		case 30719: $e_type = 'E_ALL'; $exit_now = true; break;
		default:	$e_type = 'E_UNKNOWN'; break;
	}

	$errors .= "[$error_level: $e_type]: $error_message\n	in $error_file ($error_line)\n\n";
}

return $rv;
