<?php
/**
 * VFM - veno file manager: /admin-panel/ajax/session.php
 *
 * Clear /thumbnails/ folder
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
require_once '../../config.php';
require_once '../../class/class.setup.php';
require_once '../../class/class.utils.php';
require_once '../../class/class.gatekeeper.php';

$setUp = new SetUp('../../');

if (!GateKeeper::isSuperAdmin() ) {
    die('Permission Denied');
}

foreach (glob('../../_content/thumbs/*.jpg', GLOB_NOSORT) as $deletable) {
    unlink($deletable);
}
echo 'success';

exit;
