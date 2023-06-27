<?php
/**
 * VFM - veno file manager: include/head.php
 * main php setup
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
if (!defined('VFM_APP')) {
    return;
}
if (version_compare(phpversion(), '5.5', '<')) {
    // PHP version too low.
    header('Content-type: text/html; charset=utf-8');
    exit('<h2>Veno File Manager 3 requires PHP >= 5.5</h2><p>Current: PHP '.phpversion().', please update your server settings.</p>');
}

if (!defined('VFM_APP')) {
    return;
}

if (!file_exists('vfm-admin/config.php')) {
    if (!copy('vfm-admin/config-master.php', 'vfm-admin/config.php')) {
        exit("failed to create the main config.php file, check CHMOD on /vfm-admin/");
    }
}

if (!file_exists('vfm-admin/_content/users/users.php')) {
    if (!copy('vfm-admin/_content/users/users-master.php', 'vfm-admin/_content/users/users.php')) {
        exit("failed to create the main users.php file, check CHMOD on /vfm-admin/_content/users/");
    }
}

require_once 'vfm-admin/config.php';

if ($_CONFIG['debug_mode'] === true) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL ^ E_NOTICE);
}

require_once 'vfm-admin/class.php';

// Redirect blacklisted IPs.
Utils::checkIP();

require_once 'vfm-admin/_content/users/users.php';
require_once 'vfm-admin/_content/users/remember.php';
global $translations_index;
$translations_index = json_decode(file_get_contents('vfm-admin/translations/index.json'), true);

$setUp = new SetUp();

if (SetUp::getConfig("firstrun") === true || strlen($_USERS[0]['pass']) < 1) {
    header('Location:vfm-admin/setup.php');
    exit;
}
require_once 'vfm-admin/translations/'.$setUp->lang.'.php';

$updater = new Updater();
$gateKeeper = new GateKeeper();
$gateKeeper->init();

$location = new Location();
$downloader = new Downloader();

$updater->init();
$imageServer = new ImageServer();

require_once 'vfm-admin/_content/users/token.php';
$resetter = new Resetter();
$resetter->init();

if ($gateKeeper->isAccessAllowed()) {
    new Actions($location);
};

$template = new Template();

$getdownloadlist = filter_input(INPUT_GET, "dl", FILTER_UNSAFE_RAW);
$getrp = filter_input(INPUT_GET, "rp", FILTER_UNSAFE_RAW);
$getreg = filter_input(INPUT_GET, "reg", FILTER_UNSAFE_RAW);

$rtl_ext = '';
$rtl_att = '';
$rtl_class = '';
if ($setUp->getConfig("txt_direction") == "RTL") {
    $rtl_att = ' dir="rtl"';
    $rtl_ext = '.rtl';
    $rtl_class = ' rtl';
}
$bodyclass = 'vfm-body d-flex flex-column justify-content-between min-vh-100';
$bodyclass .= ($setUp->getConfig('inline_thumbs') == true) ? ' inlinethumbs' : '';
$bodyclass .= (!$gateKeeper->isAccessAllowed()) ? ' unlogged' : '';
$bodyclass .= ($setUp->getConfig('header_position') == 'below') ? ' pt-5' : '';
$bodyclass .= ' header-'.$setUp->getConfig('header_position');
$bodyclass .= ' role-'.$gateKeeper->getUserInfo('role');
$bodyclass .= $rtl_class;
$bodydata = $setUp->getConfig('audio_notification') ? ' data-ping="'.$setUp->getConfig('audio_notification').'"' : '';
