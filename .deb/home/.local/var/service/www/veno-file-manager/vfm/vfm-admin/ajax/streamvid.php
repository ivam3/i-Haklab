<?php
/**
 * VFM - veno file manager: ajax/streamvid.php
 *
 * Stream videos
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon
 * @link      http://filemanager.veno.it/
 */
require_once '../config.php';
require_once '../class/class.setup.php';
require_once '../class/class.gatekeeper.php';
$setUp = new SetUp();

if (!GateKeeper::isAccessAllowed() && $setUp->getConfig('share_playvideo') !== true) {
    die('access denied');
}
$get = filter_input(INPUT_GET, 'vid', FILTER_UNSAFE_RAW);
$path = '../../'.urldecode(base64_decode($get));
require_once '../class/class.videostream.php';
$stream = new VideoStream($path);

if ($get && $stream->checkVideo() == true) {
    $stream->_start();
}
exit;