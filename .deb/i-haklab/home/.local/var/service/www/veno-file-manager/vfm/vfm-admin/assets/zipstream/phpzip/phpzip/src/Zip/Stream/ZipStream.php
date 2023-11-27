<?php
/**
 *
 * @author A. Grandt <php@grandt.com>
 * @author Greg Kappatos
 *
 * This class serves as a concrete zip stream archive.
 *
 */

namespace PHPZip\Zip\Stream;

use PHPZip\Zip\Core\AbstractZipArchive;

class ZipStream extends AbstractZipArchive {

    const STREAM_CHUNK_SIZE = 16384; // 16 KB
    private $maxStreamBufferLength = 1048576;

    /**
     * Constructor.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param String $fileName The name of the Zip archive, in ISO-8859-1 (or ASCII) encoding, ie. "archive.zip". Optional, defaults to NULL, which means that no ISO-8859-1 encoded file name will be specified.
     * @param String $contentType Content mime type. Optional, defaults to "application/zip".
     * @param String $utf8FileName The name of the Zip archive, in UTF-8 encoding. Optional, defaults to NULL, which means that no UTF-8 encoded file name will be specified.
     * @param bool   $inline Use Content-Disposition with "inline" instead of "attached". Optional, defaults to FALSE.
     *
     * @throws \PHPZip\Zip\Exception\BufferNotEmpty, HeadersSent, IncompatiblePhpVersion, InvalidPhpConfiguration In case of errors
     */
    public function __construct($fileName = '', $contentType = self::CONTENT_TYPE, $utf8FileName = null, $inline = false) {
        parent::__construct(self::STREAM_CHUNK_SIZE);
        $this->buildResponseHeader($fileName, $contentType, $utf8FileName, $inline);
    }

    /**
     * Destructor.
     * Perform clean up actions. 
     * Please note that frameworks are absolutely prohibited from sending ANYTHING to the output after the Zip is sent.
     *
     * @author A. Grandt <php@grandt.com>
     */
    public function __destruct(){
        $this->isFinalized = true;
        $this->cdRec = null;
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
    public function onBuildZipEntry(array $params){
        print($params['zipEntry']);
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
    public function onBeginAddFile(array $params){
        // Do nothing.
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
    public function onEndAddFile(array $params){
        print($params['gzData']);
    }

    /**
     * Called by superclass when specialised action is needed
     * at the start of sending the zip stream response header.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     */
    public function onBeginBuildResponseHeader(){
        // Do nothing.
    }

    /**
     * Called by superclass when specialised action is needed
     * at the end of sending the zip stream response header.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     */
    public function onEndBuildResponseHeader(){
        //header("Connection: Keep-Alive");
        $this->zipFlushBuffer();
    }

    /**
     * Called by superclass when specialised action is needed
     * while opening a stream.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     */
    public function onOpenStream(){
        // Do nothing.
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
    public function onProcessFile(array $params){
        print($params['data']);
        $this->zipFlushBuffer();
    }

    /**
     * Verify if the memory buffer is about to be exceeded.
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param int $gzLength length of the pending data.
     */
    public function zipVerifyMemBuffer($gzLength) {
        if (ob_get_length() !== FALSE && ob_get_length() > $this->maxStreamBufferLength) {

            ob_flush();

            while (ob_get_length() > $this->maxStreamBufferLength) {
                usleep(500000);
            }
        }
    }

    /**
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param string $data
     */
    public function zipWrite($data) {
        print($data);
    }

    /**
     * Flush Zip Data stored in memory, to a temp file.
     *
     * @author A. Grandt <php@grandt.com>
     *
     */
    public function zipFlush() {
        // Does nothing.
    }

    /**
     *
     * @author A. Grandt <php@grandt.com>
     *
     */
    public function zipFlushBuffer() {
        flush();
        $this->zipVerifyMemBuffer(0);
    }

    /**
     * @return int
     */
    public function getMaxStreamBufferLength() {
        return $this->maxStreamBufferLength;
    }

    /**
     * @param int $maxStreamBufferLength
     */
    public function setMaxStreamBufferLength($maxStreamBufferLength) {
        $this->maxStreamBufferLength = $maxStreamBufferLength;
    }
}
