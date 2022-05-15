<?php
/**
 *
 * @author A. Grandt <php@grandt.com>
 * @author Greg Kappatos
 *
 * This class serves as an abstract superclass for zip archives.
 *
 */

namespace PHPZip\Zip\Core;

use com\grandt\BinStringStatic;
use PHPZip\Zip\Listener\ZipArchiveListener as ZipArchiveListener;
use PHPZip\Zip\Exception\IncompatiblePhpVersion as IncompatiblePhpVersionException;
use PHPZip\Zip\Exception\InvalidPhpConfiguration as InvalidPhpConfigurationException;
use PHPZip\Zip\Exception\HeadersSent as HeadersSentException;
use PHPZip\Zip\Exception\BufferNotEmpty as BufferNotEmptyException;
use PHPZip\Zip\Exception\LengthMismatch as LengthMismatchException;
use ZipMerge\Zip\Core\AbstractZipWriter;
use ZipMerge\Zip\Core\Header\ZipFileEntry;
use ZipMerge\Zip\Stream\ZipMerge;


abstract class AbstractZipArchive extends AbstractZipWriter {
    const APP_NAME = 'PHPZip';
    const VERSION = "2.0.8";
    const MIN_PHP_VERSION = 5.3; // for namespaces

    const CONTENT_TYPE = 'application/zip';

    const NULL_BYTE = "\x00";
    const NULL_WORD = "\x00\x00"; // Two nul bytes, used often enough.
    const NULL_DWORD = "\x00\x00\x00\x00";

    const ZIP_CENTRAL_FILE_HEADER = "PK\x01\x02"; // Central file header signature
    const ZIP_LOCAL_FILE_HEADER = "PK\x03\x04"; // Local file header signature
    const ZIP_LOCAL_DATA_DESCRIPTOR = "PK\x07\x08"; // Local Header, data descriptor
    const ZIP_END_OF_CENTRAL_DIRECTORY = "PK\x05\x06"; // End of Central directory record

    const HEADER_UNIX_TYPE_1 = 'UX';            // \x55\x58 or 0x5855 It has been replaced by the extended-timestamp extra block 'UT' (0x5455) and the Unix type 2 extra block 'Ux' (0x7855).
    const HEADER_UNIX_TYPE_2 = 'Ux';            // \x55\x78 or 0x7855
    const HEADER_UNIX_TYPE_3 = 'ux';            // \x75\x78 or 0x7875
    const HEADER_EXTENDED_TIMESTAMP = 'UT';     // \x55\x54 or 0x5455
    const HEADER_UNICODE_PATH = 'up';           // \x75\x70 or 0x7075
    const HEADER_UNICODE_COMMENT = 'uc';        // \x75\x63 or 0x6375

    const EXT_FILE_ATTR_DIR = 010173200020;     // Permission 755 drwxr-xr-x = (((S_IFDIR | 0755) << 16) | S_DOS_D);
    const EXT_FILE_ATTR_FILE = 020151000040;    // Permission 644 -rw-r--r-- = (((S_IFREG | 0644) << 16) | S_DOS_A);

    const ATTR_VERSION_TO_EXTRACT = "\x14\x00"; // Version needed to extract = 20 (File is compressed using Deflate compression)
    const ATTR_MADE_BY_VERSION = "\x1E\x03";    // Made By Version

    const DEFAULT_GZ_TYPE = "\x08\x00";         // Compression type 8 = deflate
    const DEFAULT_GP_FLAGS = self::NULL_WORD;     // General Purpose bit flags for compression type 8 it is: 0=Normal, 1=Maximum, 2=Fast, 3=super fast compression.

    const DEFAULT_GZ_TYPE_STORED = self::NULL_WORD;  // Compression type 0 = stored
    const DEFAULT_GP_FLAGS_STORED = self::NULL_WORD; // Compression type 0 = stored

    // UID 1000, GID 0
    const EXTRA_FIELD_NEW_UNIX_GUID = "ux\x0B\x00\x01\x04\xE8\x03\x00\x00\x04\x00\x00\x00\x00"; // \x75\x78 3rd gen Unis GUID
    const EXTRA_FIELD_NEW_UNIX_GUID_CD = "ux\x00\x00"; // \x75\x78 3rd gen Unis GUID CD record version must have length 0.

    protected $zipComment = null;
    protected $cdRec = array(); // central directory
    protected $offset = 0;
    protected $isFinalized = false;
    protected $addExtraField = true;

    protected $streamChunkSize = 0;
    protected $streamFilePath = null;
    protected $streamTimestamp = null;
    protected $streamFileComment = null;
    protected $streamFile = null;
    protected $streamData = null;
    protected $streamFileLength = 0;
    protected $streamExtFileAttr = null;

    /**
     * A custom temporary folder, or a callable that returns a custom temporary file.
     * @var string|callable
     */
    public static $temp = null;

    private $_listeners = array();
    private $_phpConfigurationWatch = array(
        // 'mbstring.func_overload' => '0' // throw an exception if setting in php.ini is not '0'
    );

    /**
     * Constructor.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param boolean $streamChunkSize Size of each chunk
     *
     * @throws \PHPZip\Zip\Exception\InvalidPhpConfiguration In case of errors
     */
    protected function __construct($streamChunkSize) {
        $this->streamChunkSize = $streamChunkSize;

        if (count($this->_phpConfigurationWatch) > 0) {
            foreach ($this->_phpConfigurationWatch as $k => $v) {
                $s = (string)$v;
                if (@ini_get($k) !== $s) {
                    $this->_throwException(new InvalidPhpConfigurationException(array(
                        'setting' => $k,
                        'expected' => $s,
                    )));
                    break; // technically not needed.
                }
            }
        }
    }

    /**
     * Extra fields on the Zip directory records are Unix time codes needed for compatibility on the default Mac zip archive tool.
     * These are enabled as default, as they do no harm elsewhere and only add 26 bytes per file added.
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param bool $setExtraField true (default) will enable adding of extra fields, anything else will disable it.
     */
    public function setExtraField($setExtraField = true) {
        $this->addExtraField = ($setExtraField === true);
    }

    /**
     * Set Zip archive comment.
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param string $newComment New comment. null to clear.
     *
     * @return bool $success
     */
    public function setComment($newComment = null) {
        if ($this->isFinalized) {
            return false;
        }

        $this->zipComment = $newComment;

        return true;
    }

    /**
     * Add an empty directory entry to the zip archive.
     * Basically this is only used if an empty directory is added.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param string $directoryPath Directory Path and name to be added to the archive.
     * @param int    $timestamp     (Optional) Timestamp for the added directory, if omitted or set to 0, the current time will be used.
     * @param string $fileComment   (Optional) Comment to be added to the archive for this directory. To use $fileComment, $timestamp must be given.
     * @param int    $extFileAttr   (Optional) The external file reference, use generateExtAttr to generate this.
     *
     * @return bool  $success
     */
    public function addDirectory($directoryPath, $timestamp = 0, $fileComment = null, $extFileAttr = self::EXT_FILE_ATTR_DIR) {
        // TODO: get rid of magic numbers.
        $result = false;

        if (!$this->isFinalized) {
            $directoryPath = str_replace("\\", '/', $directoryPath);
            $directoryPath = rtrim($directoryPath, '/');

        if (BinStringStatic::_strlen($directoryPath) > 0) {
                $this->buildZipEntry($directoryPath.'/',
                    $fileComment,
                    self::DEFAULT_GZ_TYPE_STORED,
                    self::DEFAULT_GP_FLAGS_STORED,
                    $timestamp,
                    "\x00\x00\x00\x00",
                    0, 0, $extFileAttr);
                $result = true;
            }
        }
        return $result;
    }

    /**
     * Add a file to the archive at the specified location and file name.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param string $data        File data.
     * @param string $filePath    File path and name to be used in the archive.
     * @param int    $timestamp   (Optional) Timestamp for the added file, if omitted or set to 0, the current time will be used.
     * @param string $fileComment (Optional) Comment to be added to the archive for this file. To use $fileComment, $timestamp must be given.
     * @param bool   $compress    (Optional) Compress file, if set to false the file will only be stored. Default true.
     * @param int    $extFileAttr (Optional) The external file reference, use generateExtAttr to generate this.
     *
     * @return bool  $success
     */
    public function addFile($data, $filePath, $timestamp = 0, $fileComment = null, $compress = null, $extFileAttr = self::EXT_FILE_ATTR_FILE) {
        if ($this->isFinalized) {
            return false;
        }

        if (is_resource($data) && get_resource_type($data) === 'stream') {
            $this->addLargeFile($data, $filePath, $timestamp, $fileComment, $extFileAttr);
            return false;
        }

        $gzData = '';
        $gzType = self::DEFAULT_GZ_TYPE;
        $gpFlags = self::DEFAULT_GP_FLAGS;
        $dataLength = BinStringStatic::_strlen($data);
        $fileCRC32 = pack("V", crc32($data));
        $gzLength = $dataLength;

        if ($compress) {
            $gzTmp = gzcompress($data);
            // gzcompress adds a 2 byte header and 4 byte Adler-32 CRC at the end, which we can't use.
            $gzData = substr($gzTmp, 2, -4);
            // The 2 byte header does contain useful data,
            // though in this case the 2 parameters we'd be interested in will
            // always be 8 for compression type, and 2 for General purpose flag.
            $gzLength = BinStringStatic::_strlen($gzData);
        }

        if ($gzLength >= $dataLength) {
            $gzLength = $dataLength;
            $gzData = $data;

            $gzType = self::DEFAULT_GZ_TYPE_STORED;
            $gpFlags = self::DEFAULT_GP_FLAGS_STORED;
        }

        $this->onBeginAddFile(array(
            'gzLength' => $gzLength,
        ));

        $this->buildZipEntry($filePath, $fileComment, $gpFlags, $gzType, $timestamp, $fileCRC32, $gzLength, $dataLength, $extFileAttr);

        $this->onEndAddFile(array(
            'gzData' => $gzData,
        ));

        $this->_notifyListeners(null, array(
            'data' => $data,
        ));

        return true;
    }

    /**
     * Add the content to a directory.
     *
     * @author Adam Schmalhofer <Adam.Schmalhofer@gmx.de>
     * @author A. Grandt <php@grandt.com>
     *
     * @param string $realPath       Path on the file system.
     * @param string $zipPath        File path and name to be used in the archive.
     * @param bool   $recursive      Add content recursively, default is true.
     * @param bool   $followSymlinks Follow and add symbolic links, if they are accessible, default is true.
     * @param array  &$addedFiles     Reference to the added files, this is used to prevent duplicates, default is an empty array.
     *                               If you start the function by parsing an array, the array will be populated with the $realPath
     *                               and $zipPath kay/value pairs added to the archive by the function.
     * @param bool   $overrideFilePermissions Force the use of the file/dir permissions set in the $extDirAttr
     *                               and $extFileAttr parameters.
     * @param int    $extDirAttr     Permissions for directories.
     * @param int    $extFileAttr    Permissions for files.
     */
    public function addDirectoryContent($realPath, $zipPath, $recursive = true, $followSymlinks = true, &$addedFiles = array(),
                                        $overrideFilePermissions = false, $extDirAttr = self::EXT_FILE_ATTR_DIR, $extFileAttr = self::EXT_FILE_ATTR_FILE) {
        if (file_exists($realPath) && !isset($addedFiles[realpath($realPath)])) {
            if (is_dir($realPath)) {
                $this->addDirectory(
                    $zipPath,
                    0,
                    null,
                    $overrideFilePermissions ? $extDirAttr : ZipUtils::getFileExtAttr($realPath)
                );
            }

            $addedFiles[realpath($realPath)] = $zipPath;

            $iter = new \DirectoryIterator($realPath);

            foreach ($iter as $file) {
                /* @var $file \DirectoryIterator */
                if ($file->isDot()) {
                    continue;
                }

                $newRealPath = $file->getPathname();
                $newZipPath = \RelativePath::pathJoin($zipPath, $file->getFilename());

                if (file_exists($newRealPath) && ($followSymlinks || !is_link($newRealPath))) {
                    if ($file->isFile()) {
                        $addedFiles[realpath($newRealPath)] = $newZipPath;
                        $this->addLargeFile(
                            $newRealPath,
                            $newZipPath,
                            0,
                            null,
                            $overrideFilePermissions ? $extFileAttr : ZipUtils::getFileExtAttr($newRealPath)
                        );
                    } else if ($recursive) {
                        $this->addDirectoryContent(
                            $newRealPath,
                            $newZipPath,
                            $recursive,
                            $followSymlinks,
                            $addedFiles,
                            $overrideFilePermissions,
                            $extDirAttr,
                            $extFileAttr
                        );
                    } else {
                        $this->addDirectory(
                            $zipPath,
                            0,
                            null,
                            $overrideFilePermissions ? $extDirAttr : ZipUtils::getFileExtAttr($newRealPath)
                        );
                    }
                }
            }
        }
    }

    /**
     * Append the contents of an existing zip file to the current, WITHOUT re-compressing the data within it.
     *
     * @param string $file the path to the zip file to be added.
     * @param string $subPath place the contents in the $subPath sub-folder, default is '', and places the
     *        content in the root of the new zip file.
     */
    public function appendZip($file, $subPath = '') {
        $zipMerge = new ZipMerge(null);
        $zipMerge->appendZip($file, $subPath, $this);
        $files = $zipMerge->finalize();

        /* @var $files array */
        foreach ($files as $fileEntry) {
            /* @var $fileEntry ZipFileEntry */
            $fileEntry->offset = $this->offset;
            $this->cdRec[] = $fileEntry->getCentralDirectoryHeader();
            $this->offset += BinStringStatic::_strlen( $fileEntry->getLocalHeader()) + $fileEntry->gzLength;
        }
    }

    /**
     * Add a file to the archive at the specified location and file name.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param string $dataFile    File name/path.
     * @param string $filePath    File path and name to be used in the archive.
     * @param int    $timestamp   (Optional) Timestamp for the added file, if omitted or set to 0, the current time will be used.
     * @param string $fileComment (Optional) Comment to be added to the archive for this file. To use $fileComment, $timestamp must be given.
     * @param int    $extFileAttr (Optional) The external file reference, use generateExtAttr to generate this.
     *
     * @return bool  $success
     */
    public function addLargeFile($dataFile, $filePath, $timestamp = 0, $fileComment = null, $extFileAttr = self::EXT_FILE_ATTR_FILE) {
        $result = false;

        if (!$this->isFinalized) {

            if (is_string($dataFile) && is_file($dataFile)) {
                $this->processFile($dataFile, $filePath, $timestamp, $fileComment, $extFileAttr);
            } else if (is_resource($dataFile) && get_resource_type($dataFile) == "stream") {
                $fh = $dataFile;
                $this->openStream($filePath, $timestamp, $fileComment, $extFileAttr);

                while (!feof($fh)) {
                    $this->addStreamData(fread($fh, $this->streamChunkSize));
                }
                $this->closeStream();
            }
            $result = true;
        }

        $this->_notifyListeners(null, array(
            'file' => $dataFile,
            'result' => $result,
        ));

        return $result;
    }

    /**
     * Create a stream to be used for large entries.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param string $filePath    File path and name to be used in the archive.
     * @param int    $timestamp   (Optional) Timestamp for the added file, if omitted or set to 0, the current time will be used.
     * @param string $fileComment (Optional) Comment to be added to the archive for this file. To use $fileComment, $timestamp must be given.
     * @param int    $extFileAttr (Optional) The external file reference, use generateExtAttr to generate this.
     *
     * @throws \PHPZip\Zip\Exception\IncompatiblePhpVersion Throws an exception in case of errors
     *
     * @return bool $success
     */
    public function openStream($filePath, $timestamp = 0, $fileComment = null, $extFileAttr = self::EXT_FILE_ATTR_FILE) {

        $result = false;

        if (!function_exists('sys_get_temp_dir')) {
            $this->_throwException(new IncompatiblePhpVersionException(array(
                'appName' => self::APP_NAME,
                'appVersion' => self::VERSION,
                'minVersion' => self::MIN_PHP_VERSION,
            )));
        }

        if (!$this->isFinalized) {
            $this->onOpenStream();

            if (BinStringStatic::_strlen($this->streamFilePath) > 0) {
                $this->closeStream();
            }

            $this->streamFile = self::getTemporaryFile();
            $this->streamData = fopen($this->streamFile, "wb");
            $this->streamFilePath = $filePath;
            $this->streamTimestamp = $timestamp;
            $this->streamFileComment = $fileComment;
            $this->streamFileLength = 0;
            $this->streamExtFileAttr = $extFileAttr;

            $result = true;
        }

        $this->_notifyListeners(null, array(
            'file' => $this->streamFile,
            'result' => $result,
        ));

        return $result;
    }

    /**
     * Add data to the open stream.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param string $data
     *
     * @throws LengthMismatchException Throws an exception in case of errors
     *
     * @return mixed length in bytes added or false if the archive is finalized or there are no open stream.
     */
    public function addStreamData($data) {
        if ($this->isFinalized || BinStringStatic::_strlen($this->streamFilePath) == 0) {
            return false;
        }

        $dataLength = BinStringStatic::_strlen($data);
        $length = fwrite($this->streamData, $data, $dataLength);

        if ($length != $dataLength) {
            $this->_throwException(new LengthMismatchException(array(
                'expected' => BinStringStatic::_strlen($data),
                'written' => (!$length ? 'NONE!' : $length),
            )));
        }

        $this->streamFileLength += $length;

        return $length;
    }

    /**
     * Close the current stream.
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @return bool $success
     */
    public function closeStream() {
        if ($this->isFinalized || BinStringStatic::_strlen($this->streamFilePath) == 0) {
            return false;
        }

        fflush($this->streamData);
        fclose($this->streamData);

        $this->processFile(
            $this->streamFile,
            $this->streamFilePath,
            $this->streamTimestamp,
            $this->streamFileComment,
            $this->streamExtFileAttr
        );

        $this->streamData = null;
        $this->streamFilePath = null;
        $this->streamTimestamp = null;
        $this->streamFileComment = null;
        $this->streamFileLength = 0;
        $this->streamExtFileAttr = null;

        // Windows is a little slow at times, so a millisecond later, we can unlink this.
        unlink($this->streamFile);
        $this->streamFile = null;

        return true;
    }

    /**
     * Process the current file.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param string     $dataFile
     * @param string     $filePath
     * @param int         $timestamp
     * @param string     $fileComment
     * @param int         $extFileAttr
     *
     * @return bool     $success
     */
    protected function processFile($dataFile, $filePath, $timestamp = 0, $fileComment = null, $extFileAttr = self::EXT_FILE_ATTR_FILE) {

        // TODO: change the magic numbers below to constants.

        if ($this->isFinalized) {
            return false;
        }

        $tempZip = self::getTemporaryFile();

        $zip = new \ZipArchive;
        $rv = $zip->open($tempZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        if ($rv === true) { // open returns true if successful, however one of the error values is 1, which will also read as true.
            $zip->addFile($dataFile, 'file');
            $zip->close();
        } else {
            // TODO: An error occurred reading the ZipArchive temp file (Seen on Windows installations)
        }

        $handle = fopen($tempZip, "rb");
        $stats = fstat($handle);
        $eof = $stats['size']-72; // set EOF to the position of the end of the zip data, before the CD record.
        // Should probably use 34+gzLength instead.

        fseek($handle, 6); // Skip Zip local file header and version

        $gpFlags = fread($handle, 2);
        $gzType = fread($handle, 2);
        fread($handle, 4); // Skip DOS Time and Date
        $fileCRC32 = fread($handle, 4);

        $v = unpack("Vval", fread($handle, 4));
        $gzLength = $v['val'];

        $v = unpack("Vval", fread($handle, 4));
        $dataLength = $v['val'];

        $this->buildZipEntry($filePath, $fileComment, $gpFlags, $gzType, $timestamp, $fileCRC32, $gzLength, $dataLength, $extFileAttr);

        $pos = 34;
        fseek($handle, $pos); // Position pointer at the start of the actual zip data.

        while (!feof($handle) && $pos < $eof) {
            $len = $this->streamChunkSize;

            if ($pos + $this->streamChunkSize > $eof) {
                $len = $eof - $pos;
            }
            $data = fread($handle, $len);
            $pos += $len;

            $this->onProcessFile(array(
                'data' => $data,
            ));
        }

        fclose($handle);
        unlink($tempZip);

        $this->_notifyListeners(null, array(
            'file' => $dataFile,
        ));

        return true;
    }

    /**
     * Build the Zip file structures
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param string $filePath
     * @param string $fileComment
     * @param string $gpFlags
     * @param string $gzType
     * @param int    $timestamp
     * @param string $fileCRC32
     * @param int    $gzLength
     * @param int    $dataLength
     * @param int    $extFileAttr Use self::EXT_FILE_ATTR_FILE for files, self::EXT_FILE_ATTR_DIR for Directories.
     */
    protected function buildZipEntry($filePath, $fileComment, $gpFlags, $gzType, $timestamp, $fileCRC32, $gzLength, $dataLength, $extFileAttr) {
        $filePath = str_replace("\\", "/", $filePath);
        $fileCommentLength = (empty($fileComment) ? 0 : BinStringStatic::_strlen($fileComment));
        $timestamp = (int)$timestamp;
        $timestamp = ($timestamp == 0 ? time() : $timestamp);

        $dosTime = ZipUtils::getDosTime($timestamp);
        $tsPack = pack("V", $timestamp);

        if (!isset($gpFlags) || BinStringStatic::_strlen($gpFlags) != 2) {
            $gpFlags = self::DEFAULT_GP_FLAGS;
        }

        $isFileUTF8 = mb_check_encoding($filePath, "UTF-8") && !mb_check_encoding($filePath, "ASCII");
        $isCommentUTF8 = !empty($fileComment) && mb_check_encoding($fileComment, "UTF-8") && !mb_check_encoding($fileComment, "ASCII");

        $locExField = "";
        $cenExField = "";

        if ($this->addExtraField) {
            $locExField .= self::HEADER_EXTENDED_TIMESTAMP . "\x09\x00\x03"
                . $tsPack . $tsPack
                . self::EXTRA_FIELD_NEW_UNIX_GUID;
            $cenExField .= self::HEADER_EXTENDED_TIMESTAMP . "\x05\x00\x03"
                . $tsPack
                . self::EXTRA_FIELD_NEW_UNIX_GUID_CD;
        }

        if ($isFileUTF8 || $isCommentUTF8) {
            $flag = 0;
            $gpFlagsV = unpack("vflags", $gpFlags);
            if (isset($gpFlagsV['flags'])) {
                $flag = $gpFlagsV['flags'];
            }
            $gpFlags = pack("v", $flag | (1 << 11));

            if ($isFileUTF8) {
                $utfExField = self::HEADER_UNICODE_PATH // utf8 encoded File path extra field
                    . pack ("v", (5 + BinStringStatic::_strlen($filePath)))
                    . "\x01"
                    . pack("V", crc32($filePath))
                    . $filePath;

                $locExField .= $utfExField;
                $cenExField .= $utfExField;
            }
            if ($isCommentUTF8) {
                $cenExField .= self::HEADER_UNICODE_COMMENT // utf8 encoded file comment extra field
                    . pack ("v", (5 + BinStringStatic::_strlen($fileComment)))
                    . "\x01"
                    . pack("V", crc32($fileComment))
                    . $fileComment;
            }
        }

        $header = $gpFlags . $gzType . $dosTime. $fileCRC32
            . pack("VVv", $gzLength, $dataLength, BinStringStatic::_strlen($filePath)); // File name length

        $zipEntry  = self::ZIP_LOCAL_FILE_HEADER
            . self::ATTR_VERSION_TO_EXTRACT
            . $header
            . pack("v", BinStringStatic::_strlen($locExField)) // Extra field length
            . $filePath // FileName
            . $locExField; // Extra fields

        $this->onBuildZipEntry(array(
            'zipEntry' => $zipEntry,
        ));

        $cdEntry  = self::ZIP_CENTRAL_FILE_HEADER
            . self::ATTR_MADE_BY_VERSION
            . ($dataLength === 0 ? "\x0A\x00" : self::ATTR_VERSION_TO_EXTRACT)
            . $header
            . pack("v", BinStringStatic::_strlen($cenExField)) // Extra field length
            . pack("v", $fileCommentLength) // File comment length
            . self::NULL_WORD // Disk number start
            . self::NULL_WORD // internal file attributes
            . pack("V", $extFileAttr) // External file attributes
            . pack("V", $this->offset) // Relative offset of local header
            . $filePath // FileName
            . $cenExField; // Extra fields

        if (!empty($fileComment)) {
            $cdEntry .= $fileComment; // Comment
        }

        $this->cdRec[] = $cdEntry;
        $this->offset += BinStringStatic::_strlen($zipEntry) + $gzLength;

        $this->_notifyListeners(null, array(
            'file' => $zipEntry,
        ));
    }

    /**
     * Build the base standard response headers, and ensure the content can be streamed.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param String $fileName The name of the Zip archive, in ISO-8859-1 (or ASCII) encoding, ie. "archive.zip". Optional, defaults to null, which means that no ISO-8859-1 encoded file name will be specified.
     * @param String $contentType Content mime type. Optional, defaults to "application/zip".
     * @param String $utf8FileName The name of the Zip archive, in UTF-8 encoding. Optional, defaults to null, which means that no UTF-8 encoded file name will be specified.
     * @param bool   $inline Use Content-Disposition with "inline" instead of "attached". Optional, defaults to false.
     *
     * @throws \PHPZip\Zip\Exception\IncompatiblePhpVersion, BufferNotEmpty, HeadersSent In case of errors
     *
     * @return bool Always returns true (for backward compatibility).
     */
    public function buildResponseHeader($fileName = null, $contentType = self::CONTENT_TYPE, $utf8FileName = null, $inline = false) {
        $ob = null;
        $headerFile = null;
        $headerLine = null;
        $zlibConfig = 'zlib.output_compression';

        $this->onBeginBuildResponseHeader();

        if (!function_exists('sys_get_temp_dir')) {
            $this->_throwException(new IncompatiblePhpVersionException(array(
                'appName' => self::APP_NAME,
                'appVersion' => self::VERSION,
                'minVersion' => self::MIN_PHP_VERSION,
            )));
        }

        $ob = ob_get_contents();
        if ($ob !== false && BinStringStatic::_strlen($ob)) {
            $this->_throwException(new BufferNotEmptyException(array(
                'outputBuffer' => $ob,
                'fileName' => $fileName,
            )));
        }

        if (headers_sent($headerFile, $headerLine)) {
            $this->_throwException(new HeadersSentException(array(
                'headerFile' => $headerFile,
                'headerLine' => $headerLine,
                'fileName' => $fileName,
            )));
        }

        if (@ini_get($zlibConfig)) {
            @ini_set($zlibConfig, 'Off');
        }

        $cd = 'Content-Disposition: ' . ($inline ? 'inline' : 'attachment');

        if ($fileName) {
            $cd .= '; filename="' . $fileName . '"';
        }

        if ($utf8FileName) {
            $cd .= "; filename*=UTF-8''" . rawurlencode($utf8FileName);
        }

        header('Pragma: public');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s T'));
        header('Expires: 0');
        header('Accept-Ranges: bytes');
        header('Content-Type: ' . $contentType);
        header($cd);

        $this->onEndBuildResponseHeader();

        $this->_notifyListeners(null, array(
            'file' => $fileName,
            'utf8FileName' => $utf8FileName,
            'contentType' => $contentType,
        ));

        return true;
    }

    /**
     * Close the archive.
     * A closed archive can no longer have new files added to it.
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @return bool Success
     */
    public function finalize() {
        if (!$this->isFinalized) {
            if (BinStringStatic::_strlen($this->streamFilePath) > 0) {
                $this->closeStream();
            }

            $cd = implode("", $this->cdRec);

            $cdRecSize = pack("v", sizeof($this->cdRec));
            $cdRec = $cd . self::ZIP_END_OF_CENTRAL_DIRECTORY
                . self::NULL_DWORD // really two words, used for split archives: #ofThisDisk . #ofDiskWithCD. Both 0.
                . $cdRecSize . $cdRecSize
                . pack("VV", BinStringStatic::_strlen($cd), $this->offset);

            if (!empty($this->zipComment)) {
                $cdRec .= pack("v", BinStringStatic::_strlen($this->zipComment))
                    . $this->zipComment;
            } else {
                $cdRec .= self::NULL_WORD;
            }

            $this->zipWrite($cdRec);
            $this->zipFlushBuffer();

            $this->isFinalized = true;
            $this->cdRec = null;

            return true;
        }

        return false;
    }

    /**
     * Check PHP version.
     *
     * @author A. Grandt <php@grandt.com>
     */
    public function checkVersion() {
        if (version_compare(PHP_VERSION, self::MIN_PHP_VERSION, '<') || !function_exists('sys_get_temp_dir') ) {
            die ("ERROR: " . self::APP_NAME . " " . self::VERSION . " requires PHP version " . self::MIN_PHP_VERSION . " or above.");
        }
    }

    /*
     * ************************************************************************
     * Abstract methods.
     * ************************************************************************
     */

    /**
     * Called when specialised action is needed
     * while building a zip entry.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param array $params Array that contains zipEntry.
     */
    abstract protected function onBuildZipEntry(array $params);

    /**
     * Called when specialised action is needed
     * at the start of adding a file to the archive.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param array $params Array that contains gzLength.
     */
    abstract protected function onBeginAddFile(array $params);

    /**
     * Called when specialised action is needed
     * at the end of adding a file to the archive.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param array $params Array that contains gzData.
     */
    abstract protected function onEndAddFile(array $params);

    /**
     * Called when specialised action is needed
     * at the start of sending the zip file|stream
     * response headers.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     */
    abstract protected function onBeginBuildResponseHeader();

    /**
     * Called when specialised action is needed
     * at the end of sending the zip file|stream
     * response headers.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     */
    abstract protected function onEndBuildResponseHeader();

    /**
     * Called when specialised action is needed
     * while opening a file|stream.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     */
    abstract protected function onOpenStream();

    /**
     * Called when specialised action is needed
     * while processing a file.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param array $params Array that contains data.
     */
    abstract protected function onProcessFile(array $params);

    /**
     * Verify if the memory buffer is about to be exceeded.
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param int $gzLength length of the pending data.
     */
    abstract public function zipVerifyMemBuffer($gzLength);

    /**
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param string $data
     */
    //abstract public function zipWrite($data);

    /**
     * Flush Zip Data stored in memory, to a temp file.
     *
     * @author A. Grandt <php@grandt.com>
     *
     */
    abstract public function zipFlush();

    /**
     *
     * @author A. Grandt <php@grandt.com>
     *
     */
    abstract public function zipFlushBuffer();

    /*
     * ************************************************************************
     * Listener methods.
     * ************************************************************************
     */

    /**
     * Listen to events fired by this class.
     *
     * @author Greg Kappatos
     *
     * @param ZipArchiveListener $listener Class that implements the ZipArchiveListener interface.
     */
    public function addListener(ZipArchiveListener $listener) {
        $this->_listeners[] = $listener;
    }

    /**
     * Stop listening to events fired by this class.
     *
     * @author Greg Kappatos
     *
     * @param ZipArchiveListener $listener Class that implements the ZipArchiveListener interface.
     */
    public function removeListener(ZipArchiveListener $listener) {
        $key = array_search($listener, $this->_listeners);

        if ($key !== false) {
            unset($this->_listeners[$key]);
        }
    }

    /**
     * Helper method to fire appropriate event.
     *
     * @author Greg Kappatos
     *
     * @param string|null $method (Optional) The name of the event to fire. If this is null, then the calling method is used.
     * @param array       $data Method parameters passed as an array.
     */
    private function _notifyListeners($method = null, array $data = array()) {
        if (is_null($method)) {
            $backtrace = debug_backtrace();
            if (sizeof($backtrace) > 0) {
                $trace = $backtrace[1];
                $method = 'on' . ucwords($trace['function']);
            }
        }

        foreach ($this->_listeners as $listener) {
            if (count($data) > 0) {
                $listener->$method($data);
            } else {
                $listener->$method();
            }
        }
    }

    /**
     * Helper method to fire OnException event for listeners and then throw the appropriate exception.
     *
     * @author Greg Kappatos
     *
     * @param AbstractException $exception Whatever exception needs to be thrown.
     *
     * @throws AbstractException $exception
     */
    private function _throwException(AbstractException $exception) {
        $this->_notifyListeners('onException', array(
            'exception' => $exception,
        ));

        throw $exception;
    }

    /*
     * ************************************************************************
     * Static methods/
     * ************************************************************************
     */

    /**
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @return string The full path to a temporary file.
     */
    public static function getTemporaryFile() {
        if (is_callable(self::$temp)) {
            $file = @call_user_func(self::$temp);

            if (is_string($file) && BinStringStatic::_strlen($file) && is_writable($file)) {
                return $file;
            }
        }

        $dir = (is_string(self::$temp) && BinStringStatic::_strlen(self::$temp)) ? self::$temp : sys_get_temp_dir();

        return tempnam($dir, __NAMESPACE__);
    }
}
