<?php
error_reporting(E_ALL | E_STRICT);
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 1);

include "../vendor/autoload.php";

$outFile = "ZipMerge.File.test1.zip";

$zipMerge = new \ZipMerge\Zip\File\ZipMergeToFile($outFile);
$zipMerge->appendZip("../testData/500k.zip", "TrueCryptRandomFile/");
$zipMerge->appendZip("../testData/test.zip", "A-book");
/*
$handle = fopen("ZipStreamExample1.zip", 'r');
$zipMerge->appendZip($handle, "ZipStreamExample1.zip");
fclose($handle);
*/
$zipMerge->finalize();

print "<p>File $outFile written</p>\n";
