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

$loader = require '../vendor/autoload.php';

use com\grandt\php\LipsumGenerator;
use PHPZip\Zip\Core\ZipUtils;
use \PHPZip\Zip\File\Zip as ZipArchiveFile;
use PHPZip\Zip\File\Zip;

class ZipArchiveFileTest /*extends \PHPUnit_Framework_TestCase*/ {

	private $_errors = '';

	//	 * runInSeparateProcess
	// --stderr
	//@depends testHeadersSentException
	//@expectedException \Exception

//	public function testHeadersSentException(){
//
//		$zip = new ZipArchiveFile();
//
//		$this->assertInstanceOf('\PHPZip\Zip\File\Zip', $zip, 'Failed to initialise ZipFileArchive.');
//		$this->setExpectedException('\PHPZip\Zip\Exception\HeadersSent');
//		self::_createAndSendZipArchive($zip);
//
//	}
//
//	/*
//	 * @depends testHeadersSentException
//	 */
//	public function testBufferNotEmptyException(){
//
//		$zip = new ZipArchiveFile();
//
//		$this->assertInstanceOf('\PHPZip\Zip\File\Zip', $zip, 'Failed to initialise ZipFileArchive.');
//		echo "\ntest string\n";
//		$this->setExpectedException('\PHPZip\Zip\Exception\BufferNotEmpty');
//		self::_createAndSendZipArchive($zip);
//
//	}

	/*
	 * @runInSeparateProcess
	 * @outputBuffering
	 */
	public function testSendFile(){

		$zip = new ZipArchiveFile();

		//$this->assertInstanceOf('\PHPZip\Zip\File\Zip', $zip, 'Failed to initialise ZipFileArchive.');

		//$this->setRunTestInSeparateProcess(true);

		//ob_start();
		//header_remove();

		//echo sprintf("ob=%s len=%d\n", ob_get_contents(), ob_get_length());

		if (ob_get_length() > 0) {
			ob_clean();
		}
		//ob_flush();

		//var_dump(headers_list());

		self::_createAndSendZipArchive($zip);

		//echo "Actual={$this->getActualOutput()}\n";

	}

	public function test2(){

		// Example. Zip all .html files in the current directory and save to current directory.
		// Make a copy, also to the current dir, for good measure.
		$fileDir = './';

		//include_once("Zip.php");
		//$fileTime = date("D, d M Y H:i:s T");

		//$zip = new Zip();
		$zip = new ZipArchiveFile();

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

	}

	public function test3(){

		set_error_handler(__CLASS__ . '::_customError');
		error_reporting(E_ALL | E_STRICT);
		ini_set('error_reporting', E_ALL | E_STRICT);
		ini_set('display_errors', 1);

		//$errors = "";

		// Example. Zip all .html files in the current directory and send the file for Download.
		// Also adds a static text "Hello World!" to the file Hello.txt
		$fileDir = './';
		ob_start(); // This is only to show that ob_start can be called, however the buffer must be empty when sending.

		//include_once("Zip.php");
		//$fileTime = date("D, d M Y H:i:s T");

		// Set a temp file to use, instead of the default system temp file directory.
		// The temp file is used if the generated Zip file is becoming too large to hold in memory.
		//Zip::$temp = "./tempFile";

		// Setting this to a function to create the temp files requires PHP 5.3 or newer:
		//Zip::$temp = function() { return tempnam(sys_get_temp_dir(), 'Zip');};
		//Zip::$temp = function() { return "./tempFile_" . rand(100000, 999999);};
		ZipArchiveFile::$temp = function() { return "./tempFile_" . rand(100000, 999999);};

		//$zip = new Zip();
		$zip = new ZipArchiveFile();

		// Archive comments don't really support utf-8. Some tools detect and read it though.
		$zip->setComment("Example Zip file.\nCreated on " . date('l jS \of F Y h:i:s A'));
		// A bit of russian (I hope), to test UTF-8 file names.
		$zip->addFile("Hello World!", "hello.txt");

		@$handle = opendir($fileDir);
		if ($handle) {
			while (false !== ($file = readdir($handle))) {
				if (strpos($file, ".php") !== false) {
					$pathData = pathinfo($fileDir . $file);
					$fileName = $pathData['filename'];

					$zip->addFile(file_get_contents($fileDir . $file), $file, filectime($fileDir . $file), NULL, TRUE, ZipArchiveFile::getFileExtAttr($file));
				}
			}
		}

		// Uses my Lipsum generator from https://github.com/Grandt/PHPLipsumGenerator
		if (class_exists ('LipsumGenerator')) {
			$lg = new LipsumGenerator();
			$zip->openStream("big one3.txt");
			for ($i = 1 ; $i <= 20 ; $i++) {
				$zip->addStreamData("Chapter $i\r\n\r\n" . $lg->generate(300, 2500) . "\r\n");
			}
			$zip->closeStream();
		}

		//trigger_error("Cannot divide by zero", E_USER_ERROR);

		$zip->sendZip("ZipExample3.zip", "application/zip", "ZipExample3.zip");

		// If non-fatal errors occurred during execution, this will append them
		//  to the end of the generated file.
		// It'll create an invalid Zip file, however chances are that it is invalid
		//  already due to the error happening in the first place.
		// The idea is that errors will be very easy to spot.
		if (!empty($this->_errors)) {
			echo "\n\n**************\n*** ERRORS ***\n**************\n\n$this->_errors";
		}

	}

//	public function testFileArchive(){
//
//		//$this->assertEquals(true, true);
//
//		// Example. Zip all .html files in the current directory and send the file for Download.
//		// Also adds a static text "Hello World!" to the file Hello.txt
//		$fileDir = './';
//
//		// This is only to show that ob_start can be called, however the buffer must be empty when sending.
//		ob_start();
//
//		echo "elaaaaaaaaaaaaaaaaaaaaa\n";
//
//		//$fileTime = date("D, d M Y H:i:s T");
//		$zip = new ZipArchiveFile();
//
//		$this->assertInstanceOf('\PHPZip\Zip\File\Zip', $zip, 'Failed to initialise ZipFileArchive.');
//
//		// Archive comments don't really support utf-8. Some tools detect and read it though.
//		$zip->setComment("Example Zip file.\nАрхив Комментарий\nCreated on " . date('l jS \of F Y h:i:s A'));
//
//		// A bit of russian (I hope), to test UTF-8 file names.
//		$zip->addFile("Привет мир!", "Кириллица имя файла.txt");
//		$zip->addFile("Привет мир!", "Привет мир. С комментарий к файлу.txt", 0, "Кириллица файл комментарий");
//		$zip->addFile("Hello World!", "hello.txt");
//
//		@$handle = opendir($fileDir);
//		if ($handle) {
//			/* This is the correct way to loop over the directory. */
//			while (false !== ($file = readdir($handle))) {
//				if (strpos($file, ".php") !== false) {
//					$pathData = pathinfo($fileDir . $file);
//					$fileName = $pathData['filename'];
//
//					$zip->addFile(file_get_contents($fileDir . $file), $file, filectime($fileDir . $file), null, true, ZipArchiveFile::getFileExtAttr($file));
//				}
//			}
//		}
//
//		// Add a directory, first recursively, then the same directory, but without recursion.
//		// Naturally this requires you to change the path to ../test to point to a directory of your own.
//		// $zip->addDirectoryContent("testData/test", "recursiveDir/test");
//		// $zip->addDirectoryContent("testData/test", "recursiveDir/testFlat", FALSE);
//
//		//$zip->sendZip("ZipExample1.zip");
//		//$zip->sendZip("ZipExample1_€2,000.zip");
//		$zip->sendZip("ZipExample1_€2,000.zip", "application/zip", "ZipExample1_€2,000_utf8.zip");
//
//
//	}

	private static function _createAndSendZipArchive(ZipArchiveFile $zip, $fileDir = './'){

		// Archive comments don't really support utf-8. Some tools detect and read it though.
		$zip->setComment("Example Zip file.\nАрхив Комментарий\nCreated on " . date('l jS \of F Y h:i:s A'));

		// A bit of russian (I hope), to test UTF-8 file names.
		$zip->addFile("Привет мир!", "Кириллица имя файла.txt");
		$zip->addFile("Привет мир!", "Привет мир. С комментарий к файлу.txt", 0, "Кириллица файл комментарий");
		$zip->addFile("Hello World!", "hello.txt");

		@$handle = opendir($fileDir);
		if ($handle) {
			while (false !== ($file = readdir($handle))) {
				if (strpos($file, ".php") !== false) {
					$pathData = pathinfo($fileDir . $file);
					$fileName = $pathData['filename'];

					$zip->addFile(file_get_contents($fileDir . $file), $file, filectime($fileDir . $file), null, true, ZipUtils::getFileExtAttr($file));
				}
			}
		}

		// Add a directory, first recursively, then the same directory, but without recursion.
		// Naturally this requires you to change the path to ../test to point to a directory of your own.
		// $zip->addDirectoryContent("testData/test", "recursiveDir/test");
		// $zip->addDirectoryContent("testData/test", "recursiveDir/testFlat", FALSE);

		//$zip->sendZip("ZipExample1.zip");
		//$zip->sendZip("ZipExample1_€2,000.zip");
		$zip->sendZip("ZipExample1_€2,000.zip", "application/zip", "ZipExample1_€2,000_utf8.zip");

	}

	private function _customError($error_level, $error_message, $error_file, $error_line) {

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

		$this->_errors .= "[$error_level: $e_type]: $error_message\n    in $error_file ($error_line)\n\n";

	}

}

$test = new ZipArchiveFileTest();

$test->testSendFile();
//$test->test2();
//$test->test3();

/*foreach (get_class_methods(get_class()) as $method)
	if (substr($method, 0, 4) === 'test')
		$test->$method();*/
