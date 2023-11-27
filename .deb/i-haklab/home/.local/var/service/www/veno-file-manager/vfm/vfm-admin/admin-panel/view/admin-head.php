<?php
/**
 * VFM - veno file manager: admin-panel/view/admin-head.php
 * main php setup
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon: https://codecanyon.net/item/veno-file-manager-host-and-share-files/6114247
 * @link      http://filemanager.veno.it/
 */
if (version_compare(phpversion(), '5.5', '<')) {
    header('Content-type: text/html; charset=utf-8');
    exit('<h2>Veno File Manager 3 requires PHP >= 5.5</h2><p>Current: PHP '.phpversion().', please update your server settings.</p>');
}
if (!defined('VFM_APP')) {
    return;
}

require_once 'config.php';

if ($_CONFIG['debug_mode'] === true) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL ^ E_NOTICE);
}
if ($_CONFIG['firstrun'] === true) {
    header('Location:setup.php');
    exit;
}

require_once '_content/users/users.php';

require_once '_content/users/remember.php';

require_once 'translations/en.php';

require_once 'class.php';

require_once 'class/class.admin.php';

$setUp = new SetUp('');
$gateKeeper = new GateKeeper();
$gateKeeper->init('', '_admin');
$admin = new Admin();
$updater = new Updater();

$script_url = $setUp->getConfig('script_url', '../');

if (!$gateKeeper->isSuperAdmin()) {
    header('Location:'.$script_url);
    exit;
}

global $baselang;
$baselang = $_TRANSLATIONS;

$jsonindex = "translations/index.json";
$translations_index = json_decode(file_get_contents($jsonindex), true);
global $translations_index;

$posteditlang = filter_input(INPUT_POST, "editlang", FILTER_UNSAFE_RAW);
$postnewlang = filter_input(INPUT_POST, "newlang", FILTER_UNSAFE_RAW);
$thelang = ($posteditlang ? $posteditlang : "en");
$thenewlang = ($postnewlang ? $postnewlang : null);
$editlang = ($thenewlang ? $thenewlang : $thelang);

global $_TRANSLATIONSEDIT;

if ($posteditlang) {
    include 'translations/'.$editlang.'.php';
    $_TRANSLATIONSEDIT = $_TRANSLATIONS;
} else {
    $_TRANSLATIONSEDIT = $baselang;
}
$lang = $setUp->lang;
require 'translations/'.$lang.'.php';

global $translations;
$translations = $admin->getLanguages();
$activesec = "home";

$allsections = array(
    'superadmin_can_statistics' => 'appearance',
    'superadmin_can_users' => 'users',
    'superadmin_can_translations' => 'translations',
    'superadmin_can_statistics' => 'logs',
);

$get_section = filter_input(INPUT_GET, 'section', FILTER_UNSAFE_RAW);
$get_action = filter_input(INPUT_GET, 'action', FILTER_UNSAFE_RAW);

if (!$get_section && !GateKeeper::canSuperAdmin('superadmin_can_preferences') ) {

    $default_section = false;

    foreach ($allsections as $key => $section) {
        if (GateKeeper::canSuperAdmin($key)) {
            $default_section = $section;
            break;
        }
    }
    if ($default_section) {
        $get_section = $default_section;
    }
}

switch ($get_section) {
// Appearance
case 'appearance':
    if (GateKeeper::canSuperAdmin('superadmin_can_appearance')) {
        $activesec = "appearance";
        include_once 'admin-head-appearance.php';
    }
    break;
// Users
case 'users':
    if (GateKeeper::canSuperAdmin('superadmin_can_users')) {
        $activesec = "users";
        include_once 'admin-head-users.php';
    }
    break;
// Translations
case 'translations':
    if (GateKeeper::canSuperAdmin('superadmin_can_translations')) {
        $activesec = "lang";
        include_once 'admin-head-translations.php';
    }
    break;
// Statistics
case 'logs':
    if (GateKeeper::canSuperAdmin('superadmin_can_statistics')) {
        $activesec = "log";
    }
    break;
// General settings
default:
    if (GateKeeper::canSuperAdmin('superadmin_can_preferences')) {
        include_once 'admin-head-settings.php';
    }
    break;
}
// var_dump($_SESSION['success']);