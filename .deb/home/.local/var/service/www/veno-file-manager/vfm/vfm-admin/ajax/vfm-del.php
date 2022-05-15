<?php
/**
 * VFM - veno file manager remover
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
require_once dirname(dirname(__FILE__)).'/config.php';
require_once dirname(dirname(__FILE__)).'/_content/users/users.php';

require_once dirname(dirname(__FILE__)).'/class/class.actions.php';
require_once dirname(dirname(__FILE__)).'/class/class.downloader.php';
require_once dirname(dirname(__FILE__)).'/class/class.file.php';
require_once dirname(dirname(__FILE__)).'/class/class.setup.php';
require_once dirname(dirname(__FILE__)).'/class/class.utils.php';
require_once dirname(dirname(__FILE__)).'/class/class.gatekeeper.php';
require_once dirname(dirname(__FILE__)).'/class/class.logger.php';
require_once dirname(dirname(__FILE__)).'/class/class.location.php';

$setUp = new SetUp();
require dirname(dirname(__FILE__)).'/translations/'.$setUp->lang.'.php';
$gateKeeper = new GateKeeper();
$downloader = new Downloader();
$actions = new Actions();

$getcloud = filter_input(INPUT_POST, "setdel", FILTER_UNSAFE_RAW);

$hash = filter_input(INPUT_POST, "h", FILTER_UNSAFE_RAW);
$time = filter_input(INPUT_POST, "t", FILTER_UNSAFE_RAW);
$salt = $setUp->getConfig('salt');

if ($hash && $time
    && $gateKeeper->isUserLoggedIn() 
    && $gateKeeper->isAllowed('delete_enable')
) {
    
    if (md5($salt.$time) === $hash
        && $downloader->checkTime($time) == true
        && $getcloud
    ) {
        $getcloud = explode(",", $getcloud);
        $totfiles = count($getcloud);
        foreach ($getcloud as $pezzo) {
            if ($downloader->checkFile($pezzo, '../') === true) {
                $myfile = "../../".urldecode(base64_decode($pezzo));
                $actions->deleteFile($myfile, true);
            }
        }
        echo "ok";
        exit;
    } else {
        echo $setUp->getString('not_allowed');
    }
} else {
    echo "Not enough data";
}
exit;
