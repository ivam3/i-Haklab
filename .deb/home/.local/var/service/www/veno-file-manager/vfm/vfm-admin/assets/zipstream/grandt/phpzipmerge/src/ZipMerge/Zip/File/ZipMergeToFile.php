<?php
/**
 * ZipMerge will allow the user to combine multiple Zip files into one, while streaming the result directly to
 *  the client.
 * The contents of the Zip Files added will NOT be re-compressed.
 *
 * The primary use is for the user to be able to pre-assemble often used, static content, saving server time on
 *  subsequent use.
 * Another use case is to combine collections of for existing packages/collections of data the client may have
 *  purchased, and allow them to download these on the fly in a single file.
 * @author Grandt
 */

namespace ZipMerge\Zip\File;


use com\grandt\BinStringStatic;
use ZipMerge\Zip\Core\AbstractZipWriter;
use ZipMerge\Zip\Core\Header\EndOfCentralDirectory;
use ZipMerge\Zip\Core\Header\ZipFileEntry;
use ZipMerge\Zip\Stream\ZipMerge;

class ZipMergeToFile extends AbstractZipWriter {
    private $_zipMerge = null;
    private $_zipFileName = null;
    private $_zipFile = null;

    protected $cdRec = array(); // central directory
    protected $offset = 0;
    protected $isFinalized = false;
    protected $eocd = null;
    protected $streamChunkSize = 65536; // 64kb

    /**
     * @param $fileName
     */
    public function __construct($fileName) {
        $this->_zipMerge = new ZipMerge(null);
        $this->eocd = new EndOfCentralDirectory();

        $this->_zipFileName = $fileName;

        if (is_file($fileName)) {
            unlink($fileName);
        }

        $this->_zipFile = fopen($fileName, "x+b");
    }

    public function __destruct() {
        $this->_zipMerge = null;
    }

    /**
     * Append the contents of an existing zip file to the current, WITHOUT re-compressing the data within it.
     *
     * @param string $file the path to the zip file to be added.
     * @param string $subPath place the contents in the $subPath sub-folder, default is '', and places the
     *        content in the root of the new zip file.
     */
    public function appendZip($file, $subPath = '') {
        $this->_zipMerge->appendZip($file, $subPath, $this);
    }

    public function setFileComment($comment) {
        $this->eocd->zipComment = $comment;
    }

    public function finalize() {
        if (!$this->isFinalized) {
            $files = $this->_zipMerge->finalize();

            $this->eocd->cdrStart = $this->_zipMerge->getEntryOffset();
            $this->eocd->cdrLength = 0;
            $this->eocd->cdrCount1 = 0;

            foreach ($files as $fileEntry) {
                /* @var $fileEntry ZipFileEntry */
                $this->eocd->cdrCount1++;
                $cd = $fileEntry->getCentralDirectoryHeader();

                $this->eocd->cdrLength += BinStringStatic::_strlen($cd);
                $this->zipWrite($cd);
            }

            $this->eocd->cdrCount2 =  $this->eocd->cdrCount1;
            $this->zipWrite(''. $this->eocd);

            $this->isFinalized = true;
            fclose($this->_zipFile);
            return true;
        }
        return false;
    }

    /**
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param string $data
     */
    public function zipWrite($data) {
        fwrite($this->_zipFile, $data);
        fflush($this->_zipFile);
    }
}