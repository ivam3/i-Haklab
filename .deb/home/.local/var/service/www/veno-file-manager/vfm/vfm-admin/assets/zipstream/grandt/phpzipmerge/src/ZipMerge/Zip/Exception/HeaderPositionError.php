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

namespace ZipMerge\Zip\Exception;

use ZipMerge\Zip\Core\AbstractException;

class HeaderPositionError extends AbstractException {

    private $_expected = null;
    private $_actual = null;

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
        $this->_actual = (string)$config['actual'];
        
        $message = sprintf(
            '%s %s %s %s %s',
            (string)($this->_actual - $this->_expected), 
            ' extra bytes before header. Expected pos ',
            $this->_expected,
            ' but found the header at ',
            $this->_actual
        );

        parent::__construct($message);
    }

    public function getExpected(){
        return $this->_expected;
    }

    public function getActual(){
        return $this->_actual;
    }
}