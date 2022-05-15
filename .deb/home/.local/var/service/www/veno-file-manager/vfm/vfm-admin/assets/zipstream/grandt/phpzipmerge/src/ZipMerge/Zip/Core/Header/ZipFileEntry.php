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
use ZipMerge\Zip\Core\ExtraField\AbstractExtraField;
use ZipMerge\Zip\Core\ExtraField\ExtendedTimeStampExtraField;
use ZipMerge\Zip\Core\ExtraField\GenericExtraField;
use ZipMerge\Zip\Core\ExtraField\UnicodeCommentExtraField;
use ZipMerge\Zip\Core\ZipUtils;

class ZipFileEntry extends AbstractZipHeader {
    public $versionMadeBy = AbstractZipHeader::ATTR_MADE_BY_VERSION;
    public $versionNeeded = AbstractZipHeader::ATTR_VERSION_TO_EXTRACT;

    public $originalLFH = null;
    public $originalCDR = null;
    
    public $offset;
    public $dataOffset;

    public $gpFlags;
    public $gzType;
    public $dosTime;
    public $fileCRC32;
    public $gzLength;
    public $dataLength;
    public $entryEndOffset;

    public $path = '';
    public $isDirectory = false;
    public $comment = '';

    public $extraFieldsArray = array();

    public $discNumberStart = AbstractZipHeader::NULL_WORD;
    public $internalFileAttributes = AbstractZipHeader::NULL_WORD;
    public $externalFileAttributes = AbstractZipHeader::NULL_DWORD;

    public function __construct($handle = null) {
        if ($handle != null) {
            $this->parseHeader($handle);
        }
    }
    
    public function parseHeader($handle) {
        $pk = fread($handle, 4);
        if ($pk == AbstractZipHeader::ZIP_LOCAL_FILE_HEADER) {
            /*
            * local file header signature     4 bytes  (0x04034b50)
            * version needed to extract       2 bytes
            * general purpose bit flag        2 bytes
            * compression method              2 bytes
            * last mod file time + file date  4 bytes
            * crc-32                          4 bytes
            * compressed size                 4 bytes
            * uncompressed size               4 bytes
            * file name length                2 bytes
            * extra field length              2 bytes
            * ---------------------------------------
            *                                30 bytes
             */
            $this->offset = (int)ftell($handle) - 4;

            $this->versionNeeded            = fread($handle, 2);
            $arr = unpack("v2wa", fread($handle, 4));
            $this->gpFlags                    = $arr['wa1'];
            $this->gzType                    = $arr['wa2'];
            $this->dosTime                    = fread($handle, 4);
            $arr = unpack("V3dwa/v2wa", fread($handle, 16));
            $this->fileCRC32                = $arr['dwa1'];
            $this->gzLength                    = $arr['dwa2'];
            $this->dataLength                = $arr['dwa3'];
            $filePathLength                    = $arr['wa1'];
            $localExtraFieldLength            = $arr['wa2'];

            $this->path = fread($handle, $filePathLength);
            $this->dataOffset = 30 + $filePathLength + $localExtraFieldLength;

            if ($localExtraFieldLength > 0) {
                $eoef = ftell($handle) + $localExtraFieldLength;
                while (ftell($handle) < $eoef) {
                    $ef = AbstractExtraField::decodeField($handle);
                    /* @var $ef AbstractExtraField */
                    $this->extraFieldsArray[$ef->header] = $ef;
                }
            }

            $hasDataDescriptor = $this->gpFlags & 4 == 4;

            if ($hasDataDescriptor) {
                $pkHeader = AbstractZipHeader::seekPKHeader($handle);
                if ($pkHeader !== self::ZIP_LOCAL_DATA_DESCRIPTOR) {
                    fseek($handle, -12, SEEK_CUR);
                }
                $arr = unpack("Vdwa", fread($handle, 12));
                $this->fileCRC32                = $arr['dwa1'];
                $this->gzLength                    = $arr['dwa2'];
                $this->dataLength                = $arr['dwa3'];
            } else {
                fseek($handle, $this->gzLength, SEEK_CUR);
            }
            $this->isDirectory = !$hasDataDescriptor && $this->dataLength == 0 && $this->fileCRC32 == 0;
        } else if ($pk == AbstractZipHeader::ZIP_CENTRAL_FILE_HEADER) {
            /*
            * 
            * central file header signature   4 bytes  (0x02014b50)
            * version made by                 2 bytes
            * version needed to extract       2 bytes
            * general purpose bit flag        2 bytes
            * compression method              2 bytes
            * last mod file time              2 bytes
            * last mod file date              2 bytes
            * crc-32                          4 bytes
            * compressed size                 4 bytes
            * uncompressed size               4 bytes
            * file name length                2 bytes
            * extra field length              2 bytes
            * file comment length             2 bytes
            * disk number start               2 bytes
            * internal file attributes        2 bytes
            * external file attributes        4 bytes
            * relative offset of local header 4 bytes
            * ----------------------------------------
            *                                46 bytes
            *
            *  file name (variable size)
            *  extra field (variable size)
            *  file comment (variable size)
             */
            
            // $this->offset = (int)ftell($handle) - 4;

            $this->versionMadeBy            = fread($handle, 2);
            $this->versionNeeded            = fread($handle, 2);
            $arr = unpack("v2wa", fread($handle, 4));
            $this->gpFlags                  = $arr['wa1'];
            $this->gzType                   = $arr['wa2'];
            $this->dosTime                  = fread($handle, 4);
            $arr = unpack("V3dwa/v3wa", fread($handle, 18));
            // $this->fileCRC32                = $arr['dwa1'];
            // $this->gzLength                 = $arr['dwa2'];
            // $this->dataLength               = $arr['dwa3'];
            $filePathLength                 = $arr['wa1'];
            $centralExtraFieldLength        = $arr['wa2'];
            $fileCommentLength              = $arr['wa3'];
            $this->discNumberStart          = fread($handle, 2);
            $this->internalFileAttributes   = fread($handle, 2);
            $this->externalFileAttributes   = fread($handle, 4);
            // $arr = unpack("V", fread($handle, 4));
            // $this->relativeOffsetOfLocalHeader    = $arr[1];

            // $this->path = fread($handle, $filePathLength);

            fseek($handle, 4+$filePathLength, SEEK_CUR);

            if ($centralExtraFieldLength > 0) {
                $eoef = ftell($handle) + $centralExtraFieldLength;
                while (ftell($handle) < $eoef) {
                    $ef = AbstractExtraField::decodeField($handle, false);
                    /* @var $ef AbstractExtraField */

                    if (in_array($ef->header, $this->extraFieldsArray)) {
                        $ef2 = $this->extraFieldsArray[$ef->header];
                        $ef2->centralData = $ef->centralData;
                    } else {
                        $this->extraFieldsArray[$ef->header] = $ef;
                    }
                }
            }

            if ($fileCommentLength > 0) {
                $this->comment = fread($handle, $fileCommentLength);
            }
        } else {
            fseek($handle, -4, SEEK_CUR);
        }
    }
    
        public function addExtraField($extraField) {
        $this->extraFieldsArray[$extraField->header] = $extraField;
    }

    public function addPath($path) {
        $this->path = AbstractZipHeader::pathJoin($path, $this->path);
        if (in_array(AbstractExtraField::HEADER_UNICODE_PATH, $this->extraFieldsArray)
            && isset($this->extraFieldsArray[AbstractExtraField::HEADER_UNICODE_PATH])) {
            $ef = $this->extraFieldsArray[AbstractExtraField::HEADER_UNICODE_PATH];
            $ef->CRC32 = crc32($this->path);
            $ef->utf8Data = AbstractZipHeader::pathJoin($path, $ef->utf8Data);
        }
    }

    public function getLocalHeader() {
        $ef = '';
        foreach ($this->extraFieldsArray as $value) {
            /* @var $value AbstractExtraField */
            $ef .= $value->getLocalField();
        }

        $lf = AbstractZipHeader::ZIP_LOCAL_FILE_HEADER . $this->versionNeeded;
        $lf .= pack("vv", $this->gpFlags, $this->gzType);
        $lf .= $this->dosTime;
        $lf .= pack("VVV", $this->fileCRC32, $this->gzLength, $this->dataLength);
        $lf .= pack("v", BinStringStatic::_strlen($this->path));
        $lf .= pack("v", BinStringStatic::_strlen($ef));

        $lf .= $this->path;
        $lf .= $ef;
        
        return $lf;        
    }

    public function getCentralDirectoryHeader() {
        $ef = '';
        foreach ($this->extraFieldsArray as $value) {
            /* @var $value AbstractExtraField */
            $ef .= $value->getCentralField();
        }

        $cd = AbstractZipHeader::ZIP_CENTRAL_FILE_HEADER . $this->versionMadeBy . $this->versionNeeded;
        $cd .= pack("vv", $this->gpFlags, $this->gzType);
        $cd .= $this->dosTime;
        $cd .= pack("VVV", $this->fileCRC32, $this->gzLength, $this->dataLength);
        $cd .= pack("v", BinStringStatic::_strlen($this->path));
        $cd .= pack("v", BinStringStatic::_strlen($ef));
        $cd .= pack("v", BinStringStatic::_strlen($this->comment));
        $cd .= $this->discNumberStart. $this->internalFileAttributes . $this->externalFileAttributes;
        $cd .= pack("V", $this->offset);
        
        $cd .= $this->path;
        $cd .= $ef;
        $cd .= $this->comment;

        return $cd;
    }

    public function prependPath($path) {
        $this->path = AbstractZipHeader::pathJoin($path, $this->path);
        if (in_array(AbstractExtraField::HEADER_UNICODE_PATH, $this->extraFieldsArray)
            && isset($this->extraFieldsArray[AbstractExtraField::HEADER_UNICODE_PATH])) {
            $ef = $this->extraFieldsArray[AbstractExtraField::HEADER_UNICODE_PATH];
            $ef->CRC32 = crc32($this->path);
            $ef->utf8Data = AbstractZipHeader::pathJoin($path, $ef->utf8Data);
        }
    }

    public function setFileComment($comment) {
        $this->comment = $comment;
        if (in_array(AbstractExtraField::HEADER_UNICODE_COMMENT, $this->extraFieldsArray)
            && isset($this->extraFieldsArray[AbstractExtraField::HEADER_UNICODE_COMMENT])) {
            $ef = $this->extraFieldsArray[AbstractExtraField::HEADER_UNICODE_COMMENT];
            $ef->CRC32 = crc32($this->comment);
        }
    }

    public function setUTF8FileComment($comment) {
        if (in_array(AbstractExtraField::HEADER_UNICODE_COMMENT, $this->extraFieldsArray)
            && isset($this->extraFieldsArray[AbstractExtraField::HEADER_UNICODE_COMMENT])) {
            $ef = $this->extraFieldsArray[AbstractExtraField::HEADER_UNICODE_COMMENT];
            $ef->utf8Data = $comment;
        } else {
            $ef = new UnicodeCommentExtraField();
            $ef->CRC32 = crc32($this->comment);
            $ef->utf8Data = $comment;
            $this->extraFieldsArray[AbstractExtraField::HEADER_UNICODE_COMMENT] = $ef;
        }
    }

    public static function createDirEntry($path, $timestamp) {
        $fileEntry = new ZipFileEntry();

        $fileEntry->gzType = 0;
        $fileEntry->gpFlags = 0;
        $fileEntry->fileCRC32 = 0;
        $fileEntry->externalFileAttributes = ZipFileEntry::EXT_FILE_ATTR_DIR;
        $fileEntry->gzLength = 0;
        $fileEntry->dataLength = 0;
        $fileEntry->isDirectory = true;
        $fileEntry->dosTime = ZipUtils::getDosTime($timestamp);
        $fileEntry->path = $path;

        $ef = new ExtendedTimeStampExtraField();
        $ef->setModTime($timestamp);
        $ef->setAccessTime($timestamp);

        $fileEntry->addExtraField($ef);

        $ef = new GenericExtraField();
        $ef->header = AbstractExtraField::HEADER_UNIX_TYPE_3;
        $ef->setFieldData("\x01\x04\xE8\x03\x00\x00\x04\x00\x00\x00\x00", '');

        $fileEntry->addExtraField($ef);

        return $fileEntry;
    }
}
