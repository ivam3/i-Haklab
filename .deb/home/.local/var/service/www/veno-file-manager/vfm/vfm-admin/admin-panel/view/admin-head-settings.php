<?php
/**
 * VFM - veno file manager: admin-panel/view/admin-head-settings.php
 * main general settings setting process
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

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    /**
    * General Settings
    */
    $_CONFIG['script_url'] = filter_input(INPUT_POST, "script_url", FILTER_SANITIZE_URL);

    $_CONFIG['log_file'] = (isset($_POST['log_file']) ? true : false);
    $_CONFIG['enable_prettylinks'] = (isset($_POST['enable_prettylinks']) ? true : false);

    $postappname = filter_input(INPUT_POST, "appname", FILTER_UNSAFE_RAW);

    $selectivext = filter_input(INPUT_POST, "selectivext", FILTER_UNSAFE_RAW);

    if ($selectivext === "allow") {
        $postupload_allow_type = filter_input(INPUT_POST, "upload_allow_type", FILTER_UNSAFE_RAW);
        $postupload_reject_extension = false;
    } else {
        $selectivext = "reject";
        $postupload_reject_extension = filter_input(INPUT_POST, "upload_reject_extension", FILTER_UNSAFE_RAW);
        $postupload_allow_type = false;
    }

    $postthumbw = filter_input(INPUT_POST, "thumbnails_width", FILTER_VALIDATE_INT);
    $postthumbh = filter_input(INPUT_POST, "thumbnails_height", FILTER_VALIDATE_INT);
    $listview = filter_input(INPUT_POST, "list_view", FILTER_UNSAFE_RAW);
    $postuploademail = filter_input(INPUT_POST, "upload_email", FILTER_UNSAFE_RAW);

    if ($postuploademail) {

        $notifylogsarray = array_map('trim', explode(',', $postuploademail));

        $logemailarray = array();

        foreach ($notifylogsarray as $logemail) {
            if (filter_var($logemail, FILTER_VALIDATE_EMAIL)) {
                $logemailarray[] = $logemail;
            }
        }
        $postuploademail = implode(',', $logemailarray);
    }
    
    $txtdir = filter_input(INPUT_POST, "txt_direction", FILTER_UNSAFE_RAW);
    $poststartingdir = filter_input(INPUT_POST, "starting_dir", FILTER_UNSAFE_RAW);

    $poststartingdir = $poststartingdir === 'download' ? 'downloads' : $poststartingdir;

    if ($_CONFIG['starting_dir'] != "./".$poststartingdir."/") {
        if (strlen($poststartingdir) == 0) {
            $_CONFIG['starting_dir'] = "./";
        } else {

            if (!file_exists("../".$poststartingdir."/")) {

                if ($_CONFIG['starting_dir'] == "./") {
                    mkdir("../".$poststartingdir."/");
                } else {
                    if (!rename(".".$_CONFIG['starting_dir'], "../".$poststartingdir."/")) {
                        Utils::setError('Error renaming uploads directory');
                        return;
                    }  
                }
            }
            $_CONFIG['starting_dir'] = "./".$poststartingdir."/";
        }
    }

    $_CONFIG['require_login'] = isset($_POST['require_login']) ? true : false;

    $timezone = filter_input(INPUT_POST, "default_timezone", FILTER_UNSAFE_RAW);
    $_CONFIG['default_timezone'] = $timezone ? $timezone : "UTC";

    $_CONFIG['appname'] = $postappname;

    $_CONFIG['selectivext'] = $selectivext;

    $_CONFIG['upload_reject_extension'] = $postupload_reject_extension ? array_map('trim', explode(',', strtolower($postupload_reject_extension))) : false;
    
    $_CONFIG['upload_allow_type'] = $postupload_allow_type ? array_map('trim', explode(',', strtolower($postupload_allow_type))) : false;

    $ip_list = filter_input(INPUT_POST, "ip_list", FILTER_UNSAFE_RAW);
    $ip_redirect = filter_input(INPUT_POST, "ip_redirect", FILTER_VALIDATE_URL);
    $ip_blacklist = filter_input(INPUT_POST, "ip_blacklist", FILTER_UNSAFE_RAW);
    $ip_whitelist = filter_input(INPUT_POST, "ip_whitelist", FILTER_UNSAFE_RAW);

    $_CONFIG['ip_list'] = $ip_list;
    $_CONFIG['ip_redirect'] = $ip_redirect;
    $_CONFIG['ip_blacklist'] = $ip_blacklist ? array_map(array( $admin, 'filterIP'), explode(',', $ip_blacklist)) : false;
    $_CONFIG['ip_whitelist'] = $ip_whitelist ? array_map(array( $admin, 'filterIP'), explode(',', $ip_whitelist)) : false;
    
    $_CONFIG['lang'] = $_POST['lang'];

    $_CONFIG['time_format'] = $_POST['time_format']." - H:i";
    
    $_CONFIG['show_path'] = (isset($_POST['show_path']) ? true : false);

    $_CONFIG['global_search'] = (isset($_POST['global_search']) ? true : false);

    $_CONFIG['show_foldertree'] = (isset($_POST['show_foldertree']) ? true : false);

    $_CONFIG['show_langmenu'] = (isset($_POST['show_langmenu']) ? true : false);

    $_CONFIG['show_langname'] = (isset($_POST['show_langname']) ? true : false);

    $_CONFIG['browser_lang'] = (isset($_POST['browser_lang']) ? true : false);

    $_CONFIG['show_captcha'] = (isset($_POST['show_captcha']) ? true : false);

    // $_CONFIG['show_captcha_admin'] = (isset($_POST['show_captcha_admin']) ? true : false);

    $_CONFIG['show_captcha_reset'] = (isset($_POST['show_captcha_reset']) ? true : false);
    
    $_CONFIG['show_captcha_register'] = (isset($_POST['show_captcha_register']) ? true : false);

    $_CONFIG['show_captcha_download'] = (isset($_POST['show_captcha_download']) ? true : false);

    $_CONFIG['recaptcha'] = (isset($_POST['recaptcha']) ? true : false);
    
    $_CONFIG['recaptcha_site'] = filter_input(INPUT_POST, "recaptcha_site", FILTER_UNSAFE_RAW);

    $_CONFIG['recaptcha_secret'] = filter_input(INPUT_POST, "recaptcha_secret", FILTER_UNSAFE_RAW);

    $_CONFIG['recaptcha_invisible'] = (isset($_POST['recaptcha_invisible']) ? true : false);

    $_CONFIG['show_usermenu'] = (isset($_POST['show_usermenu']) ? true : false);

    $_CONFIG['playmusic'] = (isset($_POST['playmusic']) ? true : false);

    $_CONFIG['playvideo'] = (isset($_POST['playvideo']) ? true : false);

    $_CONFIG['thumbnails'] = (isset($_POST['thumbnails']) ? true : false);

    $_CONFIG['inline_thumbs'] = (isset($_POST['inline_thumbs']) ? true : false);

    // delete all thumbnails if size changes
    if ($setUp->getConfig('thumbnails_width') !== (int) $postthumbw
        || $setUp->getConfig('thumbnails_height') !== (int) $postthumbh
    ) {
        $thumbs = glob('thumbs/*.jpg');
        foreach ($thumbs as $thumb) {
            if (is_file($thumb)) {
                unlink($thumb);
            }
        }
    }

    $_CONFIG['thumbnails_width'] = (int) $postthumbw;
    
    $_CONFIG['thumbnails_height'] = (int) $postthumbh;

    $_CONFIG['list_view'] = $listview;

    $_CONFIG['remote_uploader'] = (isset($_POST['remote_uploader']) ? true : false);

    $_CONFIG['max_upload_filesize'] = (int) filter_input(INPUT_POST, 'max_upload_filesize', FILTER_SANITIZE_NUMBER_INT);

    $_CONFIG['overwrite_files'] = isset($_POST['view_enable_guest']) ? filter_input(INPUT_POST, 'overwrite_files', FILTER_UNSAFE_RAW) : 'no';

    $remote_extensions = filter_input(INPUT_POST, 'remote_extensions', FILTER_UNSAFE_RAW);

    $_CONFIG['remote_extensions'] = $remote_extensions ? array_map('trim', explode(',', strtolower($remote_extensions))) : false;

    // Users permissions
    // Guest
    $_CONFIG['view_enable_guest'] = (isset($_POST['view_enable_guest']) ? true : false);
    $_CONFIG['download_enable_guest'] = (isset($_POST['download_enable_guest']) ? true : false);
    $_CONFIG['sendfiles_enable_guest'] = (isset($_POST['sendfiles_enable_guest']) ? true : false);
    $_CONFIG['viewdirs_enable_guest'] = (isset($_POST['viewdirs_enable_guest']) ? true : false);
    // User
    $_CONFIG['view_enable_user'] = (isset($_POST['view_enable_user']) ? true : false);
    $_CONFIG['download_enable_user'] = (isset($_POST['download_enable_user']) ? true : false);
    $_CONFIG['sendfiles_enable_user'] = (isset($_POST['sendfiles_enable_user']) ? true : false);
    $_CONFIG['upload_enable_user'] = (isset($_POST['upload_enable_user']) ? true : false);
    $_CONFIG['viewdirs_enable_user'] = (isset($_POST['viewdirs_enable_user']) ? true : false);
    $_CONFIG['newdir_enable_user'] = (isset($_POST['newdir_enable_user']) ? true : false);

    // Admin
    $_CONFIG['sendfiles_enable'] = (isset($_POST['sendfiles_enable']) ? true : false);
    $_CONFIG['upload_enable'] = (isset($_POST['upload_enable']) ? true : false);
    $_CONFIG['delete_enable'] = (isset($_POST['delete_enable']) ? true : false);
    $_CONFIG['rename_enable'] = (isset($_POST['rename_enable']) ? true : false);
    $_CONFIG['move_enable'] = (isset($_POST['move_enable']) ? true : false);
    $_CONFIG['copy_enable'] = (isset($_POST['copy_enable']) ? true : false);
    $_CONFIG['newdir_enable'] = (isset($_POST['newdir_enable']) ? true : false);
    $_CONFIG['delete_dir_enable'] = (isset($_POST['delete_dir_enable']) ? true : false);
    $_CONFIG['rename_dir_enable'] = (isset($_POST['rename_dir_enable']) ? true : false);

    // Generic roles
    include dirname(__FILE__).'/users/roles.php';

    if (is_array($getroles)) {
        $getroles = array_diff($getroles, array("user", "admin", "superadmin"));

        foreach ($getroles as $role) {
            $_CONFIG['sendfiles_enable_'.$role] = (isset($_POST['sendfiles_enable_'.$role]) ? true : false);
            $_CONFIG['upload_enable_'.$role] = (isset($_POST['upload_enable_'.$role]) ? true : false);
            $_CONFIG['delete_enable_'.$role] = (isset($_POST['delete_enable_'.$role]) ? true : false);
            $_CONFIG['rename_enable_'.$role] = (isset($_POST['rename_enable_'.$role]) ? true : false);
            $_CONFIG['move_enable_'.$role] = (isset($_POST['move_enable_'.$role]) ? true : false);
            $_CONFIG['copy_enable_'.$role] = (isset($_POST['copy_enable_'.$role]) ? true : false);
            $_CONFIG['newdir_enable_'.$role] = (isset($_POST['newdir_enable_'.$role]) ? true : false);
            $_CONFIG['delete_dir_enable_'.$role] = (isset($_POST['delete_dir_enable_'.$role]) ? true : false);
            $_CONFIG['rename_dir_enable_'.$role] = (isset($_POST['rename_dir_enable_'.$role]) ? true : false);
        }
    }

    $_CONFIG['download_dir_enable'] = (isset($_POST['download_dir_enable']) ? true : false);
    $_CONFIG['upload_notification_enable'] = (isset($_POST['upload_notification_enable']) ? true : false);

    if (GateKeeper::isMasterAdmin()) {
        $_CONFIG['superadmin_can_preferences'] = (isset($_POST['superadmin_can_preferences']) ? true : false);
        $_CONFIG['superadmin_can_appearance'] = (isset($_POST['superadmin_can_appearance']) ? true : false);
        $_CONFIG['superadmin_can_users'] = (isset($_POST['superadmin_can_users']) ? true : false);
        $_CONFIG['superadmin_can_translations'] = (isset($_POST['superadmin_can_translations']) ? true : false);
        $_CONFIG['superadmin_can_statistics'] = (isset($_POST['superadmin_can_statistics']) ? true : false);
    }
    $_CONFIG['registration_enable'] = (isset($_POST['registration_enable']) ? true : false);

    $registration_lifetime = filter_input(INPUT_POST, "registration_lifetime", FILTER_UNSAFE_RAW);
    $_CONFIG['registration_lifetime'] = $registration_lifetime ? $registration_lifetime : '-1 day';

    $regrole = filter_input(INPUT_POST, "registration_role", FILTER_UNSAFE_RAW);
    $_CONFIG['registration_role'] = $regrole;

    $reguserfolders = (isset($_POST['reguserfolders']) ? json_encode($_POST['reguserfolders']) : false);
    $_CONFIG['registration_user_folders'] = $reguserfolders;

    $regquota = filter_input(INPUT_POST, "regquota", FILTER_UNSAFE_RAW);
    $_CONFIG['registration_user_quota'] = $regquota;

    $_CONFIG['upload_email'] = $postuploademail;

    $_CONFIG['txt_direction'] = $txtdir;

    $_CONFIG['show_pagination'] = (isset($_POST['show_pagination']) ? true : false);

    $_CONFIG['show_hidden_files'] = (isset($_POST['show_hidden_files']) ? true : false);

    $filedefnum = filter_input(INPUT_POST, "filedefnum", FILTER_VALIDATE_INT);
    $_CONFIG['filedefnum'] = ($filedefnum ? $filedefnum : 10);

    $filedeforder = filter_input(INPUT_POST, "filedeforder", FILTER_UNSAFE_RAW);
    $_CONFIG['filedeforder'] = $filedeforder ? $filedeforder : "date";
    
    $folderdefnum = filter_input(INPUT_POST, "folderdefnum", FILTER_VALIDATE_INT);
    $_CONFIG['folderdefnum'] = ($folderdefnum ? $folderdefnum : 10);

    $folderdeforder = filter_input(INPUT_POST, "folderdeforder", FILTER_UNSAFE_RAW);
    $_CONFIG['folderdeforder'] = $folderdeforder ? $folderdeforder : "date";

    $_CONFIG['show_pagination_num'] = (isset($_POST['show_pagination_num']) ? true : false);

    $_CONFIG['show_pagination_num_folder'] = (isset($_POST['show_pagination_num_folder']) ? true : false);

    $_CONFIG['show_pagination_folders'] = (isset($_POST['show_pagination_folders']) ? true : false);

    $_CONFIG['show_search'] = (isset($_POST['show_search']) ? true : false);

    $_CONFIG['show_folder_counter'] = (isset($_POST['show_folder_counter']) ? true : false);

    $_CONFIG['lifetime'] = (isset($_POST['lifetime']) ?  (int) $_POST['lifetime'] : 1);

    $_CONFIG['one_time_download'] = (isset($_POST['one_time_download']) ? true : false);

    $_CONFIG['secure_sharing'] = (isset($_POST['secure_sharing']) ? true : false);

    $_CONFIG['clipboard'] = (isset($_POST['clipboard']) ? true : false);

    $_CONFIG['share_thumbnails'] = (isset($_POST['share_thumbnails']) ? true : false);
    $_CONFIG['share_playmusic'] = (isset($_POST['share_playmusic']) ? true : false);
    $_CONFIG['share_playvideo'] = (isset($_POST['share_playvideo']) ? true : false);

    // $_CONFIG['max_zip_files'] = (int) filter_input(INPUT_POST, 'max_zip_files', FILTER_SANITIZE_NUMBER_INT);
    // $_CONFIG['max_zip_filesize'] = (int) filter_input(INPUT_POST, 'max_zip_filesize', FILTER_SANITIZE_NUMBER_INT);

    $_CONFIG['notify_login'] = (isset($_POST['notify_login']) ? true : false);
    
    $_CONFIG['notify_upload'] = (isset($_POST['notify_upload']) ? true : false);

    $_CONFIG['notify_download'] = (isset($_POST['notify_download']) ? true : false);

    $_CONFIG['notify_newfolder'] = (isset($_POST['notify_newfolder']) ? true : false);

    $_CONFIG['notify_registration'] = (isset($_POST['notify_registration']) ? true : false);

    /**
    * Email logo
    */
    $email_logo_new = false;

    $remove_email_logo = filter_input(INPUT_POST, "remove_email_logo", FILTER_UNSAFE_RAW);

    $email_logo_new = $remove_email_logo ? false : $setUp->getConfig('email_logo', false);

    if (isset($_FILES['email_logo']['name']) && $_FILES['email_logo']['error'] !== 4) {
        $email_logo_new = $admin->uploadImage($_FILES['email_logo'], 'email-logo');
    }
    $_CONFIG['email_logo'] = $email_logo_new;

    /**
    * Mail setup
    */
    $email_from = filter_input(INPUT_POST, 'email_from', FILTER_VALIDATE_EMAIL);
    $_CONFIG['email_from'] = ($email_from ? $email_from : '');

    $_CONFIG['debug_smtp'] = (isset($_POST['debug_smtp']) ? true : false);

    $_CONFIG['smtp_enable'] = (isset($_POST['smtp_enable']) ? true : false);

    $_CONFIG['smtp_auth'] = (isset($_POST['smtp_auth']) ? true : false);

    $smtp_server = filter_input(INPUT_POST, 'smtp_server', FILTER_UNSAFE_RAW);
    $_CONFIG['smtp_server'] = ($smtp_server ? $smtp_server : '');

    $port = filter_input(INPUT_POST, 'port', FILTER_VALIDATE_INT);
    $_CONFIG['port'] = ($port ? $port : '');

    $_CONFIG['secure_conn'] = $_POST['secure_conn'];

    $email_login = filter_input(INPUT_POST, 'email_login', FILTER_UNSAFE_RAW);
    $_CONFIG['email_login'] = $email_login;

    $email_pass = filter_input(INPUT_POST, 'email_pass', FILTER_UNSAFE_RAW);

    if ($_CONFIG['smtp_enable'] == true && $_CONFIG['smtp_auth'] == true) {
        if (array_key_exists('email_pass', $_CONFIG)) {
            $_CONFIG['email_pass'] = ($email_pass ? $email_pass : $setUp->getConfig('email_pass'));
        } else {
            $_CONFIG['email_pass'] = ($email_pass ? $email_pass : '');
        }
    } else {
        $_CONFIG['email_pass'] = '';
    }

    $directlinks = isset($_POST['direct_links']) ? true : false;
    $_CONFIG['debug_mode'] = (isset($_POST['debug_mode']) ? true : false);

    if ($directlinks !== $_CONFIG['direct_links']) {
        if ($updater->updateHtaccess($_CONFIG['starting_dir'], $directlinks) === false) {
            Utils::setError('Error writing on: '.$_CONFIG['starting_dir'].'.htaccess, check CHMOD');
        } else {
            $_CONFIG['direct_links'] = $directlinks;
        }
    }

    // Save settings.
    $con = '$_CONFIG = ';
    if (false === (file_put_contents('config.php', "<?php\n\n $con".var_export($_CONFIG, true).";\n"))) {
        Utils::setError('Error saving config file');
    } else {
        Utils::setSuccess($setUp->getString('settings_updated'));
        $updater->clearCache('config.php');
    }
    header('Location:'.$script_url.'vfm-admin/');
    exit();
}