<?php
set_error_handler("customError");
error_reporting(E_ALL | E_STRICT);
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 1);
/*
$mLast = memory_get_usage(false);
$mpLast = memory_get_peak_usage(false);
$mrLast = memory_get_usage(true);
$mprLast = memory_get_peak_usage(true);
*/
$mLast = 0;
$mpLast = 0;
$mrLast = 0;
$mprLast = 0;

$tStart = gettimeofday();
$tLast = $tStart;

$f = "Mem usage:\r\n\r\nInitial:" . getMem();

$errors = "";

// To use the new namespaces, you need a bootstrapper/autoloader, examples are provided here.
// The changes to your Zip use are limited to two lines after that is in place.
// Require your bootstrap.php, or the autoload.php, and change the class instantiation from nwe ZipStream( to
// new \PHPZip\Zip\Stream\ZipStream(
// The parameters are unchanged.

require_once('bootstrap.php'); // include_once("ZipStream.php");
$f .= "\r\nbootstrapped: " . getMem();

$zip = new \PHPZip\Zip\Stream\ZipStream('test2.zip'); // $zip = new ZipStream("test.zip");
$f .= "\r\nZip initialized: " . getMem();

/*
 * As seen in the output, the above construct with a PHP end and start tag after
 * creating the ZipStream is a bad idea. The Zip file will be starting with a
 * space followed by the newline characters.
 */
$testPath = \RelativePath::pathJoin("..", "testData");

//$zip->addDirectory("images");

//$zip->addDirectoryContent("testData" . DIRECTORY_SEPARATOR . "test","test");
//$zip->addLargeFile(\RelativePath::pathJoin($testPath, "500k.tc"), "test/500k.tc");
//$zip->addLargeFile(\RelativePath::pathJoin($testPath, "750k.tc"), "test/750k.tc");
//$zip->addLargeFile(\RelativePath::pathJoin($testPath, "1m.tc"), "test/1m.tc");
$f .= "\r\n";
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-01.jpg"), "images/rossi-perfectisboring-01.jpg");
$f .= "\r\n01: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-02.jpg"), "images/rossi-perfectisboring-02.jpg");
$f .= "\r\n02: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-03.jpg"), "images/rossi-perfectisboring-03.jpg");
$f .= "\r\n03: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-04.jpg"), "images/rossi-perfectisboring-04.jpg");
$f .= "\r\n04: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-05.jpg"), "images/rossi-perfectisboring-05.jpg");
$f .= "\r\n05: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-06.jpg"), "images/rossi-perfectisboring-06.jpg");
$f .= "\r\n06: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-07.jpg"), "images/rossi-perfectisboring-07.jpg");
$f .= "\r\n07: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-08.jpg"), "images/rossi-perfectisboring-08.jpg");
$f .= "\r\n08: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-09.jpg"), "images/rossi-perfectisboring-09.jpg");
$f .= "\r\n09: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-10.jpg"), "images/rossi-perfectisboring-10.jpg");
$f .= "\r\n10: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-11.jpg"), "images/rossi-perfectisboring-11.jpg");
$f .= "\r\n11: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-12.jpg"), "images/rossi-perfectisboring-12.jpg");
$f .= "\r\n12: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-13.jpg"), "images/rossi-perfectisboring-13.jpg");
$f .= "\r\n13: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-14.jpg"), "images/rossi-perfectisboring-14.jpg");
$f .= "\r\n14: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-15.jpg"), "images/rossi-perfectisboring-15.jpg");
$f .= "\r\n15: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-16.jpg"), "images/rossi-perfectisboring-16.jpg");
$f .= "\r\n16: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-17.jpg"), "images/rossi-perfectisboring-17.jpg");
$f .= "\r\n17: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-18.jpg"), "images/rossi-perfectisboring-18.jpg");
$f .= "\r\n18: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-19.jpg"), "images/rossi-perfectisboring-19.jpg");
$f .= "\r\n19: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-20.jpg"), "images/rossi-perfectisboring-20.jpg");
$f .= "\r\n20: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-21.jpg"), "images/rossi-perfectisboring-21.jpg");
$f .= "\r\n21: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-22.jpg"), "images/rossi-perfectisboring-22.jpg");
$f .= "\r\n22: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-23.jpg"), "images/rossi-perfectisboring-23.jpg");
$f .= "\r\n23: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-24.jpg"), "images/rossi-perfectisboring-24.jpg");
$f .= "\r\n24: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-25.jpg"), "images/rossi-perfectisboring-25.jpg");
$f .= "\r\n25: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-26.jpg"), "images/rossi-perfectisboring-26.jpg");
$f .= "\r\n26: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-27.jpg"), "images/rossi-perfectisboring-27.jpg");
$f .= "\r\n27: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-28.jpg"), "images/rossi-perfectisboring-28.jpg");
$f .= "\r\n28: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-29.jpg"), "images/rossi-perfectisboring-29.jpg");
$f .= "\r\n29: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-30.jpg"), "images/rossi-perfectisboring-30.jpg");
$f .= "\r\n30: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-31.jpg"), "images/rossi-perfectisboring-31.jpg");
$f .= "\r\n31: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-32.jpg"), "images/rossi-perfectisboring-32.jpg");
$f .= "\r\n32: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-33.jpg"), "images/rossi-perfectisboring-33.jpg");
$f .= "\r\n33: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-34.jpg"), "images/rossi-perfectisboring-34.jpg");
$f .= "\r\n34: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-35.jpg"), "images/rossi-perfectisboring-35.jpg");
$f .= "\r\n35: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-36.jpg"), "images/rossi-perfectisboring-36.jpg");
$f .= "\r\n36: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-37.jpg"), "images/rossi-perfectisboring-37.jpg");
$f .= "\r\n37: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-38.jpg"), "images/rossi-perfectisboring-38.jpg");
$f .= "\r\n38: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-39.jpg"), "images/rossi-perfectisboring-39.jpg");
$f .= "\r\n39: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-40.jpg"), "images/rossi-perfectisboring-40.jpg");
$f .= "\r\n40: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-41.jpg"), "images/rossi-perfectisboring-41.jpg");
$f .= "\r\n41: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-42.jpg"), "images/rossi-perfectisboring-42.jpg");
$f .= "\r\n42: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-43.jpg"), "images/rossi-perfectisboring-43.jpg");
$f .= "\r\n43: " . getMem();
$zip->addLargeFile(\RelativePath::pathJoin($testPath, "images/rossi-perfectisboring-44.jpg"), "images/rossi-perfectisboring-44.jpg");
$f .= "\r\n44: " . getMem();

$f .= "\r\n\r\nFinal:" . getMem();

$zip->addFile($f, "mem.txt");
$rv = $zip->finalize();

// If non-fatal errors occurred during execution, this will append them
//  to the end of the generated file.
// It'll create an invalid Zip file, however chances are that it is invalid
//  already due to the error happening in the first place.
// The idea is that errors will be very easy to spot.
if (!empty($errors)) {
	echo "\n<pre>\n**************\n*** ERRORS ***\n**************\n\n$errors\n</pre>\n";
}

function getMem() {
    global $tLast;
    global $tStart;
    global $mLast;
    global $mrLast;
    global $mpLast;
    global $mprLast;

    $m = memory_get_usage(false);
    $mp = memory_get_peak_usage(false);
    $mr = memory_get_usage(true);
    $mpr = memory_get_peak_usage(true);

    $md = $m - $mLast;
    $mpd = $mp - $mpLast;
    $mrd = $mr - $mrLast;
    $mprd = $mpr - $mprLast;

    $mLast = $m;
    $mpLast = $mp;
    $mrLast = $mr;
    $mprLast = $mpr;

    $tTemp = gettimeofday();
    $tS    = $tStart['sec'] + (((int)($tStart['usec'] / 100)) / 10000);
    $tL    = $tLast['sec'] + (((int)($tLast['usec'] / 100)) / 10000);
    $tT    = $tTemp['sec'] + (((int)($tTemp['usec'] / 100)) / 10000);

    $tLast = $tTemp;
/*
    return  sprintf("\r\n+%08.04f; Δ+%08.04f; ", ($tT - $tS), ($tT - $tL))
    . sprintf("\r\n  - Alloc.....: %08.02f kiB (Real: %08.02f kiB)", (memory_get_usage()/1024), (memory_get_usage(true)/1024))
    . sprintf("\r\n  - Peak alloc: %08.02f kiB (Real: %08.02f kiB)", (memory_get_peak_usage()/1024), (memory_get_peak_usage(true)/1024));
*/
    return  sprintf("\r\n+%08.04f; +%08.04f; ", ($tT - $tS), ($tT - $tL))
        . sprintf("\r\n  - Alloc.....: %10s kiB (Δ%10s) | Real: %10s kiB (Δ%10s)", number_format($m/1024,2),  ($md<0?'-':'+').number_format($md/1024,2),  number_format($mr/1024,2),  ($md<0?'-':'+').number_format($mrd/1024,2))
        . sprintf("\r\n  - Peak alloc: %10s kiB (Δ%10s) | Real: %10s kiB (Δ%10s)", number_format($mp/1024,2), ($md<0?'-':'+').number_format($mpd/1024,2), number_format($mpr/1024,2), ($md<0?'-':'+').number_format($mprd/1024,2));
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
