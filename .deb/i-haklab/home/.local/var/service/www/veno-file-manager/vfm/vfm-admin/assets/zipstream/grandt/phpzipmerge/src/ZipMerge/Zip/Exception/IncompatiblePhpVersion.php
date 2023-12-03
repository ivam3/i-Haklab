<?php
/**
 *
 * @author Greg Kappatos
 *
 * This class serves as a concrete exception.
 * It will be thrown if the current PHP version is below the minimum
 * required version.
 *
 */

namespace ZipMerge\Zip\Exception;

use ZipMerge\Zip\Core\AbstractException;

class IncompatiblePhpVersion extends AbstractException {

    private $_minVersion = null;
    private $_currentVersion = null;

    /**
     * Constructor
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param array $config Configuration array containing appName, appVersion and minVersion (PHP)
     */
    public function __construct(array $config){
        $this->_minVersion = (string)$config['minVersion'];
        $this->_currentVersion = (string)phpversion();

        $message =  sprintf(
            '%s %s %s %s %s (%s %s).',
            $config['appName'],
            (string)$config['appVersion'],
            'requires PHP version',
            $this->_minVersion,
            'or above',
            $this->_currentVersion,
            'detected'
        );

        parent::__construct($message);
    }

    public function getMinVersion(){
        return $this->_minVersion;
    }

    public function getCurrentVersion(){
        return $this->_currentVersion;
    }
}