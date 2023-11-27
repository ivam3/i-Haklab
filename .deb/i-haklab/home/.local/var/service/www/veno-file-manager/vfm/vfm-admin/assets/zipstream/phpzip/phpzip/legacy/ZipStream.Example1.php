<?php
set_error_handler("customError");
error_reporting(E_ALL | E_STRICT);
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 1);

$errors = "";

// Example. Zip all .html files in the current directory and save to current directory.
// Make a copy, also to the current dir, for good measure.
//$mem = ini_get('memory_limit');
$extime = ini_get('max_execution_time');
//
////ini_set('memory_limit', '512M');
ini_set('max_execution_time', 600);

// To use the new namespaces, you need a bootstrapper/autoloader, examples are provided here.
// The changes to your Zip use are limited to two lines after that is in place.
// Require your bootstrap.php, or the autoload.php, and change the class instantiation from nwe ZipStream( to
// new \PHPZip\Zip\Stream\ZipStream(
// The parameters are unchanged.

require_once('bootstrap.php'); // include_once("ZipStream.php");
//print_r(ini_get_all());

$fileTime = date("D, d M Y H:i:s T");

$chapter1 = "Chapter 1\n"
		. "Lorem ipsum\n"
		. "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec magna lorem, mattis sit amet porta vitae, consectetur ut eros. Nullam id mattis lacus. In eget neque magna, congue imperdiet nulla. Aenean erat lacus, imperdiet a adipiscing non, dignissim eget felis. Nulla facilisi. Vivamus sit amet lorem eget mauris dictum pharetra. In mauris nulla, placerat a accumsan ac, mollis sit amet ligula. Donec eget facilisis dui. Cras elit quam, imperdiet at malesuada vitae, luctus id orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque eu libero in leo ultrices tristique. Etiam quis ornare massa. Donec in velit leo. Sed eu ante tortor.\n";

$zip = new \PHPZip\Zip\Stream\ZipStream('ZipStreamExample1.zip'); // $zip = new ZipStream("ZipStreamExample1.zip");

$zip->setComment("Example Zip file for Large file sets.\nCreated on " . date('l jS \of F Y h:i:s A'));
$zip->addFile("Hello World!\r\n", "Hello.txt");

$zip->openStream("big one3.txt");
$zip->addStreamData($chapter1."\n\n\n");
$zip->addStreamData($chapter1."\n\n\n");
$zip->addStreamData($chapter1."\n\n\n");
$zip->closeStream();

// For this test you need to create a large text file called "big one1.txt"
if (file_exists("big one1.txt")) {
	$zip->addLargeFile("big one1.txt", "big one2a.txt", 0, null, \PHPZip\Zip\Core\ZipUtils::getFileExtAttr("big one1.txt"));

	$fhandle = fopen("big one1.txt", "rb");
	$zip->addLargeFile($fhandle, "big one2b.txt");
	fclose($fhandle);
}

$zip->addDirectory("Empty Dir");

//Dir test, using the stream option on $zip->addLargeFile
$fileDir = './';
@$handle = opendir($fileDir);
if ($handle) {
	/* This is the correct way to loop over the directory. */
	while (false !== ($file = readdir($handle))) {
		if (($file != '.') && ($file != '..') && is_file($file)) {
			$zip->addLargeFile(($fileDir . $file), "dirTest/".$file, filectime($fileDir . $file));
		}
	}
}

// Add a directory, first recursively, then the same directory, but without recursion.
// Naturally this requires you to change the path to ../test to point to a directory of your own.
$zip->addDirectory("recursiveDir/");
$zip->addDirectoryContent("../test", "recursiveDir/test");
$zip->addDirectoryContent("../test", "recursiveDir/testFlat", FALSE);

$zip->finalize(); // Mandatory, needed to send the Zip files central directory structure.

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
