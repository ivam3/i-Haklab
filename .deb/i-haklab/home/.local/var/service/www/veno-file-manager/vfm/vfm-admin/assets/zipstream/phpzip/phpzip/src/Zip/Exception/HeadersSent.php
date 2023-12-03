<?php
/**
 *
 * @author Greg Kappatos
 *
 * This class serves as a concrete exception.
 * It will be thrown if any headers have been sent, or if any
 * output has been printed or echoed.
 *
 */

namespace PHPZip\Zip\Exception;

use PHPZip\Zip\Core\AbstractException;

class HeadersSent extends AbstractException {

    private $_headerFile = null;
    private $_headerLine = null;
    private $_fileName = null;

    /**
     * Constructor
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param array $config Configuration array containing headerFile, headerLine and fileName
     */
    public function __construct(array $config){
        $this->_headerFile = $config['headerFile'];
        $this->_headerLine = $config['headerLine'];
        $this->_fileName = isset($config['fileName']) ? $config['fileName'] : null;

        $message = is_null($this->_fileName) ? '' : "Unable to send '{$this->_fileName}'. ";
        $message .= "Headers have already been sent from '{$this->_headerFile}' in line {$this->_headerLine}";

        parent::__construct($message);
    }

    public function getHeaderFile(){
        return $this->_headerFile;
    }

    public function getHeaderLine(){
        return $this->_headerLine;
    }

    public function getFileName(){
        return $this->_fileName;
    }
}