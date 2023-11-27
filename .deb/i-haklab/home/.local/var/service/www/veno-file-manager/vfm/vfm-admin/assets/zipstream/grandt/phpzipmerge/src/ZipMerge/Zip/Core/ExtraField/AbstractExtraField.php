<?php
/**
 *
 * @author A. Grandt <php@grandt.com>
 *
 * Classes to assist in handling extra fields
 *
 */

namespace ZipMerge\Zip\Core\ExtraField;

use com\grandt\BinStringStatic;

abstract class AbstractExtraField {
    const HEADER_UNIX_TYPE_1 = 'UX';            // \x55\x58 or 0x5855 It has been replaced by the extended-timestamp extra block 'UT' (0x5455) and the Unix type 2 extra block 'Ux' (0x7855).
    const HEADER_UNIX_TYPE_2 = 'Ux';            // \x55\x78 or 0x7855
    const HEADER_UNIX_TYPE_3 = 'ux';            // \x75\x78 or 0x7875
    const HEADER_EXTENDED_TIMESTAMP = 'UT';        // \x55\x54 or 0x5455
    const HEADER_UNICODE_PATH = 'up';            // \x75\x70 or 0x7075
    const HEADER_UNICODE_COMMENT = 'uc';        // \x75\x63 or 0x6375
    
    public $header = null;
    public $length = 0;
    public $localData = "";
    public $centralData = null;

    /**
     * 4.5 Extensible data fields
     * --------------------------
     *
     *    4.5.1 In order to allow different programs and different types
     *    of information to be stored in the 'extra' field in .ZIP
     *    files, the following structure MUST be used for all
     *    programs storing data in this field:
     *
     *        header1+data1 + header2+data2 . . .
     *
     *    Each header should consist of:
     *
     *        Header ID - 2 bytes
     *        Data Size - 2 bytes
     *
     *    Note: all fields stored in Intel low-byte/high-byte order.
     *
     *    The Header ID field indicates the type of data that is in
     *    the following data block.
     *
     *    Header IDs of 0 thru 31 are reserved for use by PKWARE.
     *    The remaining IDs can be used by third party vendors for
     *    proprietary usage.
     *
     * @param resource $handle
     * @param bool $isLocalHeader
     */
    public function __construct($handle = null, $isLocalHeader = true) {
        if ($handle != null) {
            $this->header                    = fread($handle, 2);
            $arr = unpack('v', fread($handle, 2));
            $this->length                    = $arr[1];
            if($isLocalHeader) {
                $this->localData            = fread($handle, $this->length);
            } else {
                $this->centralData            = fread($handle, $this->length);
            }
        }
    }
    
    /**
     * @return string The version of the field for the Local Header.
     */
    abstract public function getLocalField();

    /**
     * @return string The version of the field for the Central Header.
     */
    abstract public function getCentralField();

    /**
     *
     * @param resource $handle
     * @param bool $isLocalHeader default true
     * @return GenericExtraField|UnicodeCommentExtraField|UnicodePathExtraField|ExtendedTimeStampExtraField
     */
    public static function decodeField($handle, $isLocalHeader = true) {
        $header            = fread($handle, 2);
        fseek($handle, -2, SEEK_CUR);
        switch ($header) {
            case self::HEADER_UNICODE_PATH:
                return new UnicodePathExtraField($handle);
            case self::HEADER_UNICODE_COMMENT:
                return new UnicodeCommentExtraField($handle);
            case self::HEADER_EXTENDED_TIMESTAMP:
                return new ExtendedTimeStampExtraField($handle);
            default:
                return new GenericExtraField($handle, $isLocalHeader);
        }
    }

    public static function encodeField($header, $data) {
        if ($header != null) {
            return $header . pack('v',  BinStringStatic::_strlen($data)) . $data;
        }
        return '';
    }

    public function setFieldData($localFieldData, $centralFieldData = null) {
        $this->localData    = $localFieldData;
        $this->centralData    = $centralFieldData;
    }
}
