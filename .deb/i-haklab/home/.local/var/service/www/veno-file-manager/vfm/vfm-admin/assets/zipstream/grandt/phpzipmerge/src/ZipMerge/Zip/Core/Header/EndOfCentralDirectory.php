<?php
/**
 *
 * @author A. Grandt <php@grandt.com>
 *
 * Classes to assist in handling the header structures in Zip Files.
 *
 */

namespace ZipMerge\Zip\Core\Header;

use com\grandt\BinStringStatic;

class EndOfCentralDirectory extends AbstractZipHeader {
    public $offset;

    public $thisDisk = 0;
    public $firstCDDisk = 0;
    public $cdrCount1;
    public $cdrCount2;
    public $cdrLength;
    public $cdrStart;
    public $zipCommentLength = 0;

    public $zipComment = '';

    /**
     * end of central dir signature                                                   4 bytes  (0x06054b50)
     * number of this disk                                                            2 bytes
     * number of the disk with the start of the central directory                     2 bytes
     * total number of entries in the central directory on this disk                  2 bytes
     * total number of entries in the central directory                               2 bytes
     * size of the central directory                                                  4 bytes
     * offset of start of central directory with respect to the starting disk number  4 bytes
     * .ZIP file comment length                                                       2 bytes
     * --------------------------------------------------------------------------------------
     *                                                                               22 bytes
     *
     * @param resource $handle
     */
    public function __construct($handle = null) {
        if ($handle != null) {
            $this->parseHeader($handle);
        }
    }

    public function parseHeader($handle) {
        if ($handle != null) {
            $this->offset = (int)ftell($handle) - 4;

            $arr = unpack("v4wa/V2dwa/vwb", fread($handle, 22));
            $this->thisDisk = $arr['wa1'];
            $this->firstCDDisk = $arr['wa2'];
            $this->cdrCount1 = $arr['wa3'];
            $this->cdrCount2 = $arr['wa4'];
            $this->cdrLength = $arr['dwa1'];
            $this->cdrStart = $arr['dwa2'];
            $this->zipCommentLength = $arr['wb'];

            if ($this->zipCommentLength > 0) {
                $this->zipComment = fread($handle, $this->zipCommentLength);
            }
        }
    }

    public function __toString() {
        $this->zipCommentLength = BinStringStatic::_strlen($this->zipComment);
        $eocd = AbstractZipHeader::ZIP_END_OF_CENTRAL_DIRECTORY;
        $eocd .= pack("vvvv", $this->thisDisk, $this->firstCDDisk, $this->cdrCount1, $this->cdrCount2);
        $eocd .= pack("VVv", $this->cdrLength, $this->cdrStart, $this->zipCommentLength);
        if ($this->zipCommentLength > 0) {
            $eocd .= $this->zipComment;
        } else {
            $eocd .= AbstractZipHeader::NULL_WORD;
        }
        return $eocd;
    }
}