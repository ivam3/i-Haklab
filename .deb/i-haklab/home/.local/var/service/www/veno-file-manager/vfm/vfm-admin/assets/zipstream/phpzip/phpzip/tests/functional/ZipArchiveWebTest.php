<?php
/**
 *
 * @author Greg Kappatos
 *
 * Not used yet.
 *
 */

define('TEST_BASE_URL', 'http://workshop.dev/PHPZip/tests/index.php');

class ZipArchiveWebTest extends \PHPUnit_Extensions_SeleniumTestCase {

	protected $captureScreenshotOnFailure = true;
	protected $screenshotPath = 'D:/Websites/!workshop/PHPZip/tests/screenshots';
	protected $screenshotUrl = 'http://workshop.dev/PHPZip/tests/screenshots';

	protected function setup(){

		$this->setBrowserUrl(TEST_BASE_URL);

	}

	public function testFileArchive(){

		$this->open();
		$this->assertEquals(true, true);

		$ela = new \PHPZip\Zip\File\Zip();


	}

//	public function testStreamArchive(){
//
//		$this->open();
//		$this->assertEquals(true, true);
//
//	}

}