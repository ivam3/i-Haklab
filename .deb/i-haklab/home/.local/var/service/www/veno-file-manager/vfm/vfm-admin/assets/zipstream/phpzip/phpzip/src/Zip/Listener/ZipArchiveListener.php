<?php
/**
 *
 * @author Greg Kappatos
 *
 * This class serves as an observer/listener which can be implemented
 * by any other class who is interested in the PHPZip events.
 * Simply implement the methods and call Stream\ZipStream or
 * File\Zip::addListener($this) from inside your class.
 *
 */

namespace PHPZip\Zip\Listener;

interface ZipArchiveListener {

    /**
     * Event fired after a zip entry has been successfully built.
     *
     * @author Greg Kappatos
     *
     * @param array $params Array that contains file (zipEntry).
     */
    public function onBuildZipEntry(array $params);

    /**
     * Event fired after a stream has been successfully opened.
     *
     * @author Greg Kappatos
     *
     * @param array $params Array that contains file (zipEntry).
     */
    public function onOpenStream(array $params);

    /**
     * Event fired after a file has been successfully added to archive.
     *
     * @author Greg Kappatos
     *
     * @param array $params Array that contains file (zipEntry).
     */
    public function onAddFile(array $params);

    /**
     * Event fired after a large file has been successfully added to archive.
     *
     * @author Greg Kappatos
     *
     * @param array $params Array that contains file (zipEntry).
     */
    public function onAddLargeFile(array $params);

    /**
     * Event fired after a zip archive has been sent.
     *
     * @author Greg Kappatos
     *
     * @param array $params Array that contains file (zipEntry).
     */
    public function onSendZip(array $params);

    /**
     * Event fired before a subclass of \PHPZip\Zip\Core\AbstractException is thrown.
     *
     * @author Greg Kappatos
     *
     * @param array $params Array that contains file (zipEntry).
     */
    public function onException(array $params);

}