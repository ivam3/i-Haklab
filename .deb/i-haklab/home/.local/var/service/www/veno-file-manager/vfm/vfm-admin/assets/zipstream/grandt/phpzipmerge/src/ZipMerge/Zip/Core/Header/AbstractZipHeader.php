<?php
/**
 *
 * @author A. Grandt <php@grandt.com>
 *
 * Classes to assist in handling the header structures in Zip Files.
 *
 */
namespace ZipMerge\Zip\Core\Header;

abstract class AbstractZipHeader {
    const ZIP_CENTRAL_FILE_HEADER      = "PK\x01\x02"; // Central file header signature
    const ZIP_LOCAL_FILE_HEADER        = "PK\x03\x04"; // Local file header signature
    const ZIP_LOCAL_DATA_DESCRIPTOR    = "PK\x07\x08"; // Local Header, data descriptor
    const ZIP_END_OF_CENTRAL_DIRECTORY = "PK\x05\x06"; // End of Central directory record

    const EXT_FILE_ATTR_DIR = "\x10\x40\xed\x41"; // Unix : Dir + mod:755
    const EXT_FILE_ATTR_FILE = "\x00\x40\xa4\x81"; // Unix : File + mod:644

    const ATTR_VERSION_TO_EXTRACT = "\x14\x00"; // Version needed to extract = 20 (File is compressed using Deflate compression)
    const ATTR_MADE_BY_VERSION = "\x1E\x03"; // Made By Version

    const NULL_BYTE = "\x00";
    const NULL_WORD = "\x00\x00";
    const NULL_DWORD = "\x00\x00\x00\x00";

    abstract public function parseHeader($handle);

    public static function pathJoin($dir, $file) {
        $rv = $dir . (empty($dir) || empty($file) ? '' : '/') . $file;
        return str_replace('//', '/', $rv);
    }

    public static function seekPKHeader($handle) {
        $pkHeader = false;
        $curr = fgetc($handle);

        do {
            $prev = $curr;
            $curr = fgetc($handle);

            $pk = $prev == "P" && $curr == "K";
            if ($pk) {
                $b1 = fgetc($handle);
                $b2 = fgetc($handle);

                if ($b1 == "\x01" && $b2 == "\x02") {
                    $pkHeader = self::ZIP_CENTRAL_FILE_HEADER;
                } else if ($b1 == "\x03" && $b2 == "\x04") {
                    $pkHeader = self::ZIP_LOCAL_FILE_HEADER;
                } else if ($b1 == "\x05" && $b2 == "\x06") {
                    $pkHeader = self::ZIP_END_OF_CENTRAL_DIRECTORY;
                } else if ($b1 == "\x07" && $b2 == "\x08") {
                    $pkHeader = self::ZIP_LOCAL_DATA_DESCRIPTOR;
                } else {
                    fseek($handle, -2, SEEK_CUR);
                    $pk = false;
                }
            }
        } while (!$pk && !feof($handle));
        
        fseek($handle, -4, SEEK_CUR);
        
        return $pkHeader;
    }
}