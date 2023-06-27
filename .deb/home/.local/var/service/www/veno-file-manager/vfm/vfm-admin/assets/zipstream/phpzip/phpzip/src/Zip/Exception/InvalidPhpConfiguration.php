<?php
/**
 *
 * @author Greg Kappatos
 *
 * This class serves as a concrete exception.
 * It will be thrown if an invalid setting is detected in php.ini
 * that will prevent this library from operating properly.
 *
 */

namespace PHPZip\Zip\Exception;

use PHPZip\Zip\Core\AbstractException;

class InvalidPhpConfiguration extends AbstractException {

    private $_setting = null;
    private $_expected = null;
    private $_actual = null;

    /**
     * Constructor
     *
     * @author Greg Kappatos
     *
     * @param array $config Configuration array containing php.ini settings: setting and expected (value)
     */
    public function __construct(array $config){
        $this->_setting = $config['setting'];
        $this->_expected = $config['expected'];
        $this->_actual = (string)@ini_get($this->_setting);

        $message = sprintf(
            '%s %s "%s" %s %s %s',
            'Invalid PHP Configuration: ',
            $this->_setting,
            $this->_actual,
            'Please change this setting to',
            $this->_expected,
            'to continue.'
        );

        parent::__construct($message);
    }

    public function getSetting(){
        return $this->_setting;
    }

    public function getExpected(){
        return $this->_expected;
    }

    public function getActual(){
        return $this->_actual;
    }
}