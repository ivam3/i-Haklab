<?php
/**
 *
 * @author Greg Kappatos
 *
 * This class serves as a concrete exception.
 * It will be thrown if the output buffer contains data while
 * trying to perform any operations with this library.
 *
 */

namespace PHPZip\Zip\Exception;

use PHPZip\Zip\Core\AbstractException;

class BufferNotEmpty extends AbstractException {

    private $_outputBuffer = null;
    private $_fileName = null;

    /**
     * Constructor
     *
     * @author A. Grandt <php@grandt.com>
      * @author Greg Kappatos
     *
     * @param array $config Configuration array containing outputBuffer and fileName
     */
    public function __construct(array $config){
        $this->_outputBuffer = $config['outputBuffer'];
        $this->_fileName = isset($config['fileName']) ? $config['fileName'] : null;

        $message = is_null($this->_fileName) ? '' : "Unable to send '{$this->_fileName}'. ";
        $message .= "Output buffer contains the following text (typically warning or errors):\n{$this->_outputBuffer}";

        parent::__construct($message);
    }

    public function getOutputBuffer(){
        return $this->_outputBuffer;
    }

    public function getFileName(){
        return $this->_fileName;
    }
}