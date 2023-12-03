<?php
/**
 *
 * @author A. Grandt <php@grandt.com>
 *
 * Classes to assist in handling extra fields
 *
 */

namespace ZipMerge\Zip\Core\ExtraField;

/**
 * 
 */
abstract class AbstractUnicodeExtraField extends AbstractExtraField {
    public $CRC32;
    public $version = "\x01";
    public $utf8Data;
    
    public function __construct($handle = null) {
        parent::__construct();
        if ($handle != null) {
            $this->header                    = fread($handle, 2);
            $arr = unpack('v', fread($handle, 2));
            $this->length                    = $arr[1];
            $this->version                    = fread($handle, 1);
            $arr = unpack("V", fread($handle, 4));
            $this->CRC32                    = $arr[1];
            $this->utf8Data                    = fread($handle, $this->length-5);
        }
    }
}
