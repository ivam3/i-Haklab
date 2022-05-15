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

/**
 * 
 *            -Info-ZIP Unicode Path Extra Field:
 *            =================================
 *
 *            Stores the UTF-8 version of the entry path as stored in the
 *            local header and central directory header.
 *            (Last Revision 20070912)
 *
 *            Value         Size        Description
 *            -----         ----        -----------
 *    (UPath) 0x7075        Short       tag for this extra block type ("up")
 *            TSize         Short       total data size for this block
 *            Version       Byte        version of this extra field, currently 1
 *            NameCRC32     Long        CRC-32 checksum of standard name field
 *            UnicodeName   variable    UTF-8 version of the entry file name
 *
 *            Currently Version is set to the number 1.  If there is a need
 *            to change this field, the version will be incremented.  Changes
 *            may not be backward compatible so this extra field should not be
 *            used if the version is not recognized.
 *
 *            The NameCRC32 is the standard zip CRC32 checksum of the File Name
 *            field in the header.  This is used to verify that the header
 *            File Name field has not changed since the Unicode Path extra field
 *            was created.  This can happen if a utility renames the entry but
 *            does not update the UTF-8 path extra field.  If the CRC check fails,
 *            this UTF-8 Path Extra Field should be ignored and the File Name field
 *            in the header should be used instead.
 *
 *            The UnicodeName is the UTF-8 version of the contents of the File
 *            Name field in the header, without any trailing NUL.  The standard
 *            name field in the Zip entry header remains filled with the entry
 *            name coded in the local machine's extended ASCII system charset.
 *            As UnicodeName is defined to be UTF-8, no UTF-8 byte order mark
 *            (BOM) is used.  The length of this field is determined by
 *            subtracting the size of the previous fields from TSize.
 *            If both the File Name and Comment fields are UTF-8, the new General
 *            Purpose Bit Flag, bit 11 (Language encoding flag (EFS)), should be
 *            used to indicate that both the header File Name and Comment fields
 *            are UTF-8 and, in this case, the Unicode Path and Unicode Comment
 *            extra fields are not needed and should not be created.  Note that,
 *            for backward compatibility, bit 11 should only be used if the native
 *            character set of the paths and comments being zipped up are already
 *            in UTF-8.  The same method, either general purpose bit 11 or extra
 *            fields, should be used in both the Local and Central Directory Header
 *            for a file.
 *
 *            Utilisation rules:
 *            1. This field shall never be created for names consisting solely of
 *               7-bit ASCII characters.
 *            2. On a system that already uses UTF-8 as system charset, this field
 *               shall not repeat the string pattern already stored in the Zip
 *               entry's standard name field. Instead, a field of exactly 9 bytes
 *               (70 75 05 00 01 and 4 bytes CRC) should be created.
 *               In this form with 5 data bytes, the field serves as indicator
 *               for the UTF-8 encoding of the standard Zip header's name field.
 *            3. This field shall not be used whenever the calculated CRC-32 of
 *               the entry's standard name field does not match the provided
 *               CRC checksum value.  A mismatch of the CRC check indicates that
 *               the standard name field was changed by some non-"up"-aware
 *               utility without synchronizing this UTF-8 name e.f. block.
 * 
 */
class UnicodePathExtraField extends AbstractUnicodeExtraField {
    public function __construct($handle = null) {
        parent::__construct($handle);
        if ($handle == null) {
            $this->header = parent::HEADER_UNICODE_PATH;
        }
    }
    
    /**
     * @return string The version of the field for the Local Header.
     */
    public function getLocalField() {
        return parent::HEADER_UNICODE_PATH . pack('vV', BinStringStatic::_strlen($this->utf8Data) + 5, $this->CRC32) .  $this->version . $this->utf8Data;
    }

    /**
     * @return string The version of the field for the Central Header.
     */
    public function getCentralField() {
        return $this->getLocalField();        
    }
}
