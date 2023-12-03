<?php
/**
 *
 * @author A. Grandt <php@grandt.com>
 * @author Greg Kappatos
 *
 * Because phpunit prints it's header during tests, it causes PHPZip to
 * throw exceptions (HeadersSent and BufferNotEmpty). I decided to ditch
 * those tests and just create manual ones.
 *
 */

$loader = require __DIR__ . '/../vendor/autoload.php';

use PHPZip\Zip\Core\ZipUtils;
use \PHPZip\Zip\Stream\ZipStream;

class ZipArchiveStreamTest /*extends \PHPUnit_Framework_TestCase*/ {

	public function test1(){

		error_reporting(E_ALL | E_STRICT);
		ini_set('error_reporting', E_ALL | E_STRICT);
		ini_set('display_errors', 1);
		//
		//// Example. Zip all .html files in the current directory and save to current directory.
		// Make a copy, also to the current dir, for good measure.
		//$mem = ini_get('memory_limit');
		//$extime = ini_get('max_execution_time');
		//
		////ini_set('memory_limit', '512M');
		ini_set('max_execution_time', 600);

		//include_once("ZipStream.php");
		//print_r(ini_get_all());

		//$fileTime = date("D, d M Y H:i:s T");

		$chapter1 = "Chapter 1\n"
			. "Lorem ipsum\n"
			. "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec magna lorem, mattis sit amet porta vitae, consectetur ut eros. Nullam id mattis lacus. In eget neque magna, congue imperdiet nulla. Aenean erat lacus, imperdiet a adipiscing non, dignissim eget felis. Nulla facilisi. Vivamus sit amet lorem eget mauris dictum pharetra. In mauris nulla, placerat a accumsan ac, mollis sit amet ligula. Donec eget facilisis dui. Cras elit quam, imperdiet at malesuada vitae, luctus id orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque eu libero in leo ultrices tristique. Etiam quis ornare massa. Donec in velit leo. Sed eu ante tortor.\n";

		//$zip = new ZipStream("ZipStreamExample1.zip");
		$zip = new ZipStream('ZipStreamExample1.zip');

		$zip->setComment("Example Zip file for Large file sets.\nCreated on " . date('l jS \of F Y h:i:s A'));
		$zip->addFile("Hello World!\r\n", "Hello.txt");

		$zip->openStream("big one3.txt");
		$zip->addStreamData($chapter1."\n\n\n");
		$zip->addStreamData($chapter1."\n\n\n");
		$zip->addStreamData($chapter1."\n\n\n");
		$zip->closeStream();

		// For this test you need to create a large text file called "big one1.txt"
		if (file_exists("big one1.txt")) {
			$zip->addLargeFile("big one1.txt", "big one2a.txt", 0, null, ZipUtils::getFileExtAttr("big one1.txt"));

			$fhandle = fopen("big one1.txt", "rb");
			$zip->addLargeFile($fhandle, "big one2b.txt");
			fclose($fhandle);
		}

		$zip->addDirectory("Empty Dir");

		//Dir test, using the stream option on $zip->addLargeFile
		$fileDir = './';
		@$handle = opendir($fileDir);
		if ($handle) {
			while (false !== ($file = readdir($handle))) {
				if (($file != '.') && ($file != '..') && is_file($file)) {
					$zip->addLargeFile(($fileDir . $file), "dirTest/".$file, filectime($fileDir . $file));
				}
			}
		}

		// Add a directory, first recursively, then the same directory, but without recursion.
		// Naturally this requires you to change the path to ../test to point to a directory of your own.
		$zip->addDirectory("recursiveDir/");
		$zip->addDirectoryContent("../../test", "recursiveDir/test");
		$zip->addDirectoryContent("../../test", "recursiveDir/testFlat", FALSE);
		/*
		$addedFiles = array();
		$zip->addDirectoryContent("../test", "recursiveDir/testPermisssions", TRUE, TRUE, $addedFiles,
					TRUE, ZipStream::generateExtAttr(4, 4, 0, FALSE), ZipStream::generateExtAttr(4, 4, 0, TRUE));
		*/
		$zip->finalize(); // Mandatory, needed to send the Zip files central directory structure.
	}

	public function test1s(){

		//include_once("ZipStream.php");
		//print_r(ini_get_all());

		//$fileTime = date("D, d M Y H:i:s T");

		$chapter1 = "Chapter 1\n"
			. "Lorem ipsum\n"
			. "Lorem ipsum dolor sit amet, consectetur adipiscing elit.\n";

		//$zip = new ZipStream("ZipStreamExample1s.zip");
		//$zip = new ZipStream("ZipStreamExample1s_€2,000.zip");
		//$zip = new ZipStream("ZipStreamExample1s_€2,000.zip", "application/zip", "ZipStreamExample1s_€2,000_utf8.zip");
		$zip = new ZipStream("ZipStreamExample1s_€2,000.zip", "application/zip", "ZipStreamExample1s_€2,000_utf8.zip");

		// Archive comments don't really support utf-8. Some tools detect and read it though.
		$zip->setComment("Example Zip file for Large file sets.\nАрхив Комментарий\nCreated on " . date('l jS \of F Y h:i:s A'));

		// A bit of russian (I hope), to test UTF-8 file names.
		$zip->addFile("Привет мир!", "Кириллица имя файла.txt");
		$zip->addFile("Привет мир!", "Привет мир. С комментарий к файлу.txt", 0, "Кириллица файл комментарий");


		$zip->openStream("big one3.txt");
		$zip->addStreamData($chapter1."\n\n\n");
		$zip->addStreamData($chapter1."\n\n\n");
		$zip->addStreamData($chapter1."\n\n\n");
		$zip->closeStream();

		$zip->addDirectory("Empty Dir");

		$zip->finalize(); // Mandatory, needed to send the Zip files central directory structure.

	}

	public function test2(){

		/*
		 * A test to see if it was possible to recreate the result of
		 *  Issue #7, if not the cause.
		 * And a demonstration why the author of the script calling zip
		 *  needs to be diligent not to add extra characters to the output.
		 */
		//include_once("ZipStream.php");

		$zip = new ZipStream("test.zip");

		/*
		 * As seen in the output, the above construct with a PHP end and start tag after
		 * creating the ZipStream is a bad idea. The Zip file will be starting with a
		 * space followed by the newline characters.
		 */
		$zip->addDirectory("test");
		$zip->addDirectoryContent("../../testData/test","test");

		return $zip->finalize();
	}

	public function test3(){

		/*
		 * A test to see if it was possible to recreate the result of
		 *  Issue #7, if not the cause.
		 * And a demonstration why the author of the script calling zip
		 *  needs to be diligent not to add extra characters to the output.
		 */
		//include_once("ZipStream.php");

        //ob_start(null, 65000);
        ob_start();
		$zip = new ZipStream("test3.zip");

		/*
		 * As seen in the output, the above construct with a PHP end and start tag after
		 * creating the ZipStream is a bad idea. The Zip file will be starting with a
		 * space followed by the newline characters.
		 */
		$zip->addDirectory("images");
		$zip->addDirectoryContent("../../testData/images/1","images");

        $zip->finalize();

        if (ob_get_length() > 0) {
            ob_end_flush();
        }
	}
}

$test = new ZipArchiveStreamTest();

//$test->test1();
//$test->test1s();
//$test->test2();
$test->test3();
