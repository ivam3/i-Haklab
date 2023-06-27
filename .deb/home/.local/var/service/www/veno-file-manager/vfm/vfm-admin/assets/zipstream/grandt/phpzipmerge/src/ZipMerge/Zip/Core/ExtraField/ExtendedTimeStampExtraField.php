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
use ZipMerge\Zip\Core\ZipUtils;

/**
 *         -Extended Timestamp Extra Field:
 *          ==============================
 * 
 *          The following is the layout of the extended-timestamp extra block.
 *          (Last Revision 19970118)
 * 
 *          Local-header version:
 * 
 *          Value         Size        Description
 *          -----         ----        -----------
 *  (time)  0x5455        Short       tag for this extra block type ("UT")
 *          TSize         Short       total data size for this block
 *          Flags         Byte        info bits
 *          (ModTime)     Long        time of last modification (UTC/GMT)
 *          (AcTime)      Long        time of last access (UTC/GMT)
 *          (CrTime)      Long        time of original creation (UTC/GMT)
 * 
 *          Central-header version:
 * 
 *          Value         Size        Description
 *          -----         ----        -----------
 *  (time)  0x5455        Short       tag for this extra block type ("UT")
 *          TSize         Short       total data size for this block
 *          Flags         Byte        info bits (refers to local header!)
 *          (ModTime)     Long        time of last modification (UTC/GMT)
 * 
 *          The central-header extra field contains the modification time only,
 *          or no timestamp at all.  TSize is used to flag its presence or
 *          absence.  But note:
 * 
 *              If "Flags" indicates that Modtime is present in the local header
 *              field, it MUST be present in the central header field, too!
 *              This correspondence is required because the modification time
 *              value may be used to support trans-timezone freshening and
 *              updating operations with zip archives.
 * 
 *          The time values are in standard Unix signed-long format, indicating
 *          the number of seconds since 1 January 1970 00:00:00.  The times
 *          are relative to Coordinated Universal Time (UTC), also sometimes
 *          referred to as Greenwich Mean Time (GMT).  To convert to local time,
 *          the software must know the local timezone offset from UTC/GMT.
 * 
 *          The lower three bits of Flags in both headers indicate which time-
 *          stamps are present in the LOCAL extra field:
 * 
 *                bit 0           if set, modification time is present
 *                bit 1           if set, access time is present
 *                bit 2           if set, creation time is present
 *                bits 3-7        reserved for additional timestamps; not set
 * 
 *          Those times that are present will appear in the order indicated, but
 *          any combination of times may be omitted.  (Creation time may be
 *          present without access time, for example.)  TSize should equal
 *          (1 + 4*(number of set bits in Flags)), as the block is currently
 *          defined.  Other timestamps may be added in the future.
 */
class ExtendedTimeStampExtraField extends AbstractExtraField {
    public $length = 1;
    public $flags = 0;
    public $isModTimeSet = false;
    public $isAcTimeSet = false;
    public $isCrTimeSet = false;
    protected $modTime = null;
    protected $acTime = null;
    protected $crTime = null;
    
    public function __construct($handle = null) {
        parent::__construct();
        $this->header = parent::HEADER_EXTENDED_TIMESTAMP;
        if ($handle != null) {
            fread($handle, 2);
            $arr = unpack('vlength/cflags', fread($handle, 3));
            $this->length                    = $arr['length'];
            $this->flags                    = $arr['flags'] & 0xff;
            $consumed = 1;
            $this->isModTimeSet = ZipUtils::testBit($this->flags, 0);
            $this->isAcTimeSet = ZipUtils::testBit($this->flags, 1);
            $this->isCrTimeSet = ZipUtils::testBit($this->flags, 2);

            if ($this->isModTimeSet && $consumed < $this->length) {
                $arr = unpack('V', fread($handle, 4));
                $this->modTime                    = $arr[1];
                $consumed += 4;
            }
            if ($this->isAcTimeSet && $consumed < $this->length) {
                $arr = unpack('V', fread($handle, 4));
                $this->acTime                    = $arr[1];
                $consumed += 4;
            }
            if ($this->isCrTimeSet && $consumed < $this->length) {
                $arr = unpack('V', fread($handle, 4));
                $this->crTime                    = $arr[1];
            }
        }
    }
    
    public function setModTime($modTime = null) {
        $this->modTime = $modTime;
        $this->isModTimeSet = $modTime != null && $modTime > 0;
    }
    
    public function setAccessTime($acTime = null) {
        $this->acTime = $acTime;
        $this->isAcTimeSet = $acTime != null && $acTime > 0;
    }

    public function setCreateTime($crTime = null) {
        $this->crTime = $crTime;
        $this->isCrTimeSet = $crTime != null && $crTime > 0;
    }
    
    /**
     * @return string The version of the field for the Local Header.
     */
    public function getLocalField() {
        $ts = ($this->isModTimeSet ? pack('V', $this->modTime) : '') 
            . ($this->isAcTimeSet ? pack('V', $this->acTime) : '') 
            . ($this->isCrTimeSet ? pack('V', $this->crTime) : '');
        $flags = 0;
        ZipUtils::setBit($flags, 0, $this->isModTimeSet);
        ZipUtils::setBit($flags, 1, $this->isAcTimeSet);
        ZipUtils::setBit($flags, 2, $this->isCrTimeSet);
        
        return parent::HEADER_EXTENDED_TIMESTAMP . pack('vc', 1 +  BinStringStatic::_strlen($ts), $flags) . $ts;
    }

    /**
     * @return string The version of the field for the Central Header.
     */
    public function getCentralField() {
        $ts = ($this->isModTimeSet ? pack('V', $this->modTime) : '');
        $flags = 0;
        ZipUtils::setBit($flags, 0, $this->isModTimeSet);
        ZipUtils::setBit($flags, 1, $this->isAcTimeSet);
        ZipUtils::setBit($flags, 2, $this->isCrTimeSet);
        
        return parent::HEADER_EXTENDED_TIMESTAMP . pack('vc', 1 +  BinStringStatic::_strlen($ts), $flags) . $ts;
    }
}
