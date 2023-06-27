<?php
/**
 * VFM - veno file manager: ajax/zip.php
 *
 * Generate zip archive
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
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
) {
    exit;
}
@set_time_limit(0);
require_once '../config.php';

require_once '../class/class.gatekeeper.php';
require_once '../class/class.zipper.php';
require_once '../class/class.setup.php';
require_once '../class/class.utils.php';

$setUp = new SetUp();
$zipper = new Zipper();
require_once '../translations/'.$setUp->lang.'.php';

// $getfiles = filter_input(INPUT_POST, 'files', FILTER_UNSAFE_RAW);
$getfiles = is_array($_POST['files']) ? filter_var_array($_POST['files'], FILTER_UNSAFE_RAW) : false;
$getfolder = filter_input(INPUT_POST, 'folder', FILTER_UNSAFE_RAW);
$time = filter_input(INPUT_POST, "time", FILTER_UNSAFE_RAW);
$hash = filter_input(INPUT_POST, 'dash', FILTER_UNSAFE_RAW);
$onetime = filter_input(INPUT_POST, 'onetime', FILTER_UNSAFE_RAW);

$alt = $setUp->getConfig('salt');
$altone = $setUp->getConfig('session_name');

$dozip = false;
$folder = false;
$files = false;

if (!$hash) {
    echo json_encode(array('error'=>$setUp->getString('access_denied')));
    exit;
}

if ($getfolder && $hash === md5($alt.$getfolder.$altone)) {
    $folder = base64_decode($getfolder);
    $filename = $folder;
    $dozip = true;
}

if ($getfiles && $hash === md5($alt.$time)) {
    $files = $getfiles;
    $dozip = true;
}

if ($dozip === true) {
    // $zipfolder = $folder ? '../../'.$folder : false;
    // $zippedfile = $zipper->prepareZip($files, $zipfolder, '../');
    $zippedfile = $zipper->prepareZip($files, $folder);
    if ($onetime && $onetime !== '0') {
        $sharefile = dirname(dirname(__FILE__)). '/_content/share/'.$onetime.'.json';
        if (file_exists($sharefile)) {
            unlink($sharefile);
        }
    }
    echo json_encode($zippedfile);
    exit;
}
echo json_encode(array('error'=>$setUp->getString('nothing_found')));
exit;
