<?php
set_error_handler("customError");
error_reporting(E_ALL | E_STRICT);
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 1);

$errors = "";

// Example. Zip all .html files in the current directory and save to current directory.
// Make a copy, also to the current dir, for good measure.
$fileDir = './';

// To use the new namespaces, you need a bootstrapper/autoloader, examples are provided here.
// The changes to your Zip use are limited to two lines after that is in place.
// Require your bootstrap.php, or the autoload.php, and change the class instantiation from nwe Zip( to
// new \PHPZip\Zip\File\Zip(
// The parameters are unchanged.

require_once('bootstrap.php'); // include_once("Zip.php");
$fileTime = date("D, d M Y H:i:s T");

$zip = new \PHPZip\Zip\File\Zip(); // $zip = new Zip();
$zip->setZipFile("ZipExample.zip");

$zip->setComment("Example Zip file.\nCreated on " . date('l jS \of F Y h:i:s A'));
$zip->addFile("Hello World!", "hello.txt");

@$handle = opendir($fileDir);
if ($handle) {
    /* This is the correct way to loop over the directory. */
    while (false !== ($file = readdir($handle))) {
        if (strpos($file, ".html") !== false) {
            $pathData = pathinfo($fileDir . $file);
            $fileName = $pathData['filename'];

            $zip->addFile(file_get_contents($fileDir . $file), $file, filectime($fileDir . $file));
        }
    }
}

$zip->finalize(); // as we are not using getZipData or getZipFile, we need to call finalize ourselves.
$zip->setZipFile("ZipExample2.zip");

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
        case 1:     $e_type = 'E_ERROR'; $exit_now = true; break;
        case 2:     $e_type = 'E_WARNING'; break;
        case 4:     $e_type = 'E_PARSE'; break;
        case 8:     $e_type = 'E_NOTICE'; break;
        case 16:    $e_type = 'E_CORE_ERROR'; $exit_now = true; break;
        case 32:    $e_type = 'E_CORE_WARNING'; break;
        case 64:    $e_type = 'E_COMPILE_ERROR'; $exit_now = true; break;
        case 128:   $e_type = 'E_COMPILE_WARNING'; break;
        case 256:   $e_type = 'E_USER_ERROR'; $exit_now = true; break;
        case 512:   $e_type = 'E_USER_WARNING'; break;
        case 1024:  $e_type = 'E_USER_NOTICE'; break;
        case 2048:  $e_type = 'E_STRICT'; break;
        case 4096:  $e_type = 'E_RECOVERABLE_ERROR'; $exit_now = true; break;
        case 8192:  $e_type = 'E_DEPRECATED'; break;
        case 16384: $e_type = 'E_USER_DEPRECATED'; break;
        case 30719: $e_type = 'E_ALL'; $exit_now = true; break;
        default:    $e_type = 'E_UNKNOWN'; break;
    }

    $errors .= "[$error_level: $e_type]: $error_message\n    in $error_file ($error_line)\n\n";
}
?>
<html>
<head>
<title>Zip Test</title>
</head>
<body>
<h1>Zip Test</h1>
<p>Zip files saved, length is <?php echo strlen($zip->getZipData()); ?> bytes.</p>
</body>
</html>