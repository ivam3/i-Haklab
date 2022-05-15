<?php
/**
 *
 * @author Greg Kappatos
 *
 * This class serves as a concrete exception.
 * It will be thrown if the output length of fwrite() does not match
 * the input length. So far, this only occurs in Core\AbstractZipArchive::addStreamData()
 *
 */

namespace PHPZip\Zip\Exception;

use PHPZip\Zip\Core\AbstractException;

class LengthMismatch extends AbstractException {

    private $_expected = null;
    private $_written = null;

    /**
     * Constructor
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param array $config Configuration array containing expected and written
     */
    public function __construct(array $config){
        $this->_expected = (string)$config['expected'];
        $this->_written = (string)$config['written'];

        $message = sprintf(
            '%s %s %s %s',
            'Length Mismatch Error: Expected',
            $this->_expected,
            'bytes, wrote',
            $this->_written
        );

        parent::__construct($message);
    }

    public function getExpected(){
        return $this->_expected;
    }

    public function getWritten(){
        return $this->_written;
    }
}