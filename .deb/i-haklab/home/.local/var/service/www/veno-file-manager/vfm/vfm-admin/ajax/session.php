<?php
/**
 * VFM - veno file manager: ajax/session.php
 *
 * Set session vars
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
require_once '../config.php';
require_once '../class/class.setup.php';
require_once '../class/class.utils.php';
require_once '../class/class.gatekeeper.php';

$setUp = new SetUp();

if (!GateKeeper::isAccessAllowed()) {
    die();
}
// update list view
$listview = filter_input(INPUT_POST, "listview", FILTER_UNSAFE_RAW);
if ($listview) {
    $listdefault = SetUp::getConfig('list_view') ? SetUp::getConfig('list_view') : 'list';
    $listtype = $listview ? $listview : $listdefault;
    $_SESSION['listview'] = $listtype;
}

// update table paging lenght
$ilenght = filter_input(INPUT_POST, "iDisplayLength", FILTER_VALIDATE_INT);
if ($ilenght) {
    $_SESSION['ilenght'] = $ilenght;
}

$sort_col = filter_input(INPUT_POST, "sort_col", FILTER_VALIDATE_INT);
$sort_order = filter_input(INPUT_POST, "sort_order", FILTER_UNSAFE_RAW);
if ($sort_col && $sort_order) {
    $_SESSION['sort_col'] = $sort_col;
    $_SESSION['sort_order'] = $sort_order;
}
$dirlenght = filter_input(INPUT_POST, "dirlenght", FILTER_VALIDATE_INT);
if ($dirlenght) {
    $_SESSION['dirlenght'] = $dirlenght;
}
$sort_dir_col = filter_input(INPUT_POST, "sort_dir_col", FILTER_VALIDATE_INT);
$sort_dir_order = filter_input(INPUT_POST, "sort_dir_order", FILTER_UNSAFE_RAW);
if ($sort_dir_col && $sort_dir_order) {
    $_SESSION['sort_dir_col'] = $sort_dir_col;
    $_SESSION['sort_dir_order'] = $sort_dir_order;
}
exit;
