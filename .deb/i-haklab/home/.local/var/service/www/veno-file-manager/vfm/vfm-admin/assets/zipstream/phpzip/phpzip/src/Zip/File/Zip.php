<?php
/**
 *
 * @author A. Grandt <php@grandt.com>
 * @author Greg Kappatos
 *
 * This class serves as a concrete zip file archive.
 *
 */

namespace PHPZip\Zip\File;

use com\grandt\BinStringStatic;
use PHPZip\Zip\Core\AbstractZipArchive;

class Zip extends AbstractZipArchive {

    const MEMORY_THRESHOLD = 1048576; // 1 MB - Auto create temp file if the zip data exceeds this
    const STREAM_CHUNK_SIZE = 65536; // 64 KB

    private $_zipData = null;
    private $_zipFile = null;

    /**
     * Constructor.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param boolean $useZipFile Write temp zip data to tempFile? Default FALSE
     *
     * @throws \PHPZip\Zip\Exception\InvalidPhpConfiguration In case of errors
     */
    public function __construct($useZipFile = false) {
        parent::__construct(self::STREAM_CHUNK_SIZE);

        if ($useZipFile) {
            $this->_zipFile = tmpfile();
        } else {
            $this->_zipData = '';
        }
    }

    /**
     * Destructor.
     * Perform clean up actions.
     *
     * @author A. Grandt <php@grandt.com>
     */
    public function __destruct() {
        if (is_resource($this->_zipFile)) {
            fclose($this->_zipFile);
        }

        $this->_zipData = null;
    }

    /**
     * Set zip file to write zip data to.
     * This will cause all present and future data written to this class to be written to this file.
     * This can be used at any time, even after the Zip Archive have been finalized. Any previous file will be closed.
     * Warning: If the given file already exists, it will be overwritten.
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param string $fileName
     *
     * @return bool Success
     */
    public function setZipFile($fileName) {
        if (is_file($fileName)) {
            unlink($fileName);
        }

        $fd = fopen($fileName, "x+b");

        if (is_resource($this->_zipFile)) {
            rewind($this->_zipFile);

            while (!feof($this->_zipFile)) {
                fwrite($fd, fread($this->_zipFile, $this->streamChunkSize));
            }

            fclose($this->_zipFile);
        } else {
            fwrite($fd, $this->_zipData);
            $this->_zipData = null;
        }

        $this->_zipFile = $fd;
        return true;
    }

    /**
     * Alias for setZipFile
     *
     * @param $fileName
     *
     * @return bool
     */
    public function saveZipFile($fileName) {
        return $this->setZipFile($fileName);
    }

    /**
     * Get the handle resource for the archive zip file.
     * If the zip haven't been finalized yet, this will cause it to become finalized
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @return resource zip file handle
     */
    public function getZipFile() {
        if (!$this->isFinalized) {
            $this->finalize();
        }

        $this->zipFlush();
        rewind($this->_zipFile);
        return $this->_zipFile;
    }

    /**
     * Send the archive as a zip download
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param String $fileName      The name of the Zip archive, in ISO-8859-1 (or ASCII) encoding,
     *                              ie. "archive.zip". Optional, defaults to null, which means that
     *                              no ISO-8859-1 encoded file name will be specified.
     * @param String $contentType   Content mime type. Optional, defaults to "application/zip".
     * @param String $utf8FileName  The name of the Zip archive, in UTF-8 encoding. Optional, defaults
     *                              to null, which means that no UTF-8 encoded file name will be specified.
     * @param bool   $inline        Use Content-Disposition with "inline" instead of "attachment". Optional, defaults to false.
     *
     * @return bool $success
     */
    public function sendZip($fileName = null, $contentType = self::CONTENT_TYPE, $utf8FileName = null, $inline = false) {
        if (!$this->isFinalized) {
            $this->finalize();
        }

        if ($this->buildResponseHeader($fileName, $contentType, $utf8FileName, $inline)) {
            return true;
        }
        return false;
    }

    /**
     * Get the zip file contents
     * If the zip haven't been finalized yet, this will cause it to become finalized
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @return string zip data
     */
    public function getZipData() {
        $result = null;

        if (!$this->isFinalized) {
            $this->finalize();
        }

        if (!is_resource($this->_zipFile)) {
            $result = $this->_zipData;
        } else {
            rewind($this->_zipFile);
            $stat   = fstat($this->_zipFile);
            $result = fread($this->_zipFile, $stat['size']);
        }

        return $result;
    }

    /**
     * Return the current size of the archive
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @return int Size of the archive
     */
    public function getArchiveSize() {
        if (!is_resource($this->_zipFile)) {
            return BinStringStatic::_strlen($this->_zipData);
        }

        $stat = fstat($this->_zipFile);
        return $stat['size'];
    }

    /*
     * ************************************************************************
     * Superclass callbacks.
     * ************************************************************************
     */

    /**
     * Called by superclass when specialised action is needed
     * while building a zip entry.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param array $params Array that contains zipEntry.
     */
    public function onBuildZipEntry(array $params) {
        $this->zipWrite($params['zipEntry']);
    }

    /**
     * Called by superclass when specialised action is needed
     * at the start of adding a file to the archive.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param array $params Array that contains gzLength.
     */
    public function onBeginAddFile(array $params) {
        if (!is_resource($this->_zipFile) && ($this->offset + $params['gzLength']) > self::MEMORY_THRESHOLD) {
            $this->zipFlush();
        }
    }

    /**
     * Called by superclass when specialised action is needed
     * at the end of adding a file to the archive.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param array $params Array that contains gzData.
     */
    public function onEndAddFile(array $params) {
        $this->zipWrite($params['gzData']);
    }

    /**
     * Called by superclass when specialised action is needed
     * at the start of sending the zip file response header.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     */
    public function onBeginBuildResponseHeader() {
        if (!$this->isFinalized) {
            $this->finalize();
        }
    }

    /**
     * Called by superclass when specialised action is needed
     * at the end of sending the zip file response header.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     */
    public function onEndBuildResponseHeader() {
        header('Connection: close');
        header('Content-Length: ' . $this->getArchiveSize());

        if (!is_resource($this->_zipFile)) {
            echo $this->_zipData;
        } else {
            rewind($this->_zipFile);

            while (!feof($this->_zipFile)) {
                echo fread($this->_zipFile, $this->streamChunkSize);
            }
        }
    }

    /**
     * Called by superclass when specialised action is needed
     * while opening a stream.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     */
    public function onOpenStream() {
        $this->zipFlush();
    }

    /**
     * Called by superclass when specialised action is needed
     * while processing a file.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param array $params Array that contains data.
     */
    public function onProcessFile(array $params) {
        $this->zipWrite($params['data']);
    }

    /**
     * Verify if the memory buffer is about to be exceeded.
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param int $gzLength length of the pending data.
     */
    public function zipVerifyMemBuffer($gzLength) {
        if (!is_resource($this->_zipFile) && ($this->offset + $gzLength) > self::MEMORY_THRESHOLD) {
            $this->zipFlush();
        }
    }

    /**
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param string $data
     */
    public function zipWrite($data) {
        if (!is_resource($this->_zipFile)) {
            $this->_zipData .= $data;
        } else {
            fwrite($this->_zipFile, $data);
            fflush($this->_zipFile);
        }
    }

    /**
     * Flush Zip Data stored in memory, to a temp file.
     *
     * @author A. Grandt <php@grandt.com>
     *
     */
    public function zipFlush() {
        if (!is_resource($this->_zipFile)) {
            $this->_zipFile = tmpfile();
            fwrite($this->_zipFile, $this->_zipData);
            $this->_zipData = null;
        }
    }

    /**
     *
     * @author A. Grandt <php@grandt.com>
     *
     */
    public function zipFlushBuffer() {
        // Does nothing.
    }
}
