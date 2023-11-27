<?php
/**
 * VFM - veno file manager: admin-panel/view/admin-head-apperarance.php
 * main appearance setting process
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
    // Skins
    // $_CONFIG['skin'] = isset($_POST['skin']) ? $_POST['skin'] : $_CONFIG['skin'];
    if (isset($_CONFIG['skin'])) {
        unset($_CONFIG['skin']);
    }

    // Color scheme
    $color_primary = filter_input(INPUT_POST, '--color-primary', FILTER_UNSAFE_RAW);
    $color_dark = filter_input(INPUT_POST, '--color-dark', FILTER_UNSAFE_RAW);
    $color_light = filter_input(INPUT_POST, '--color-light', FILTER_UNSAFE_RAW);

    $_CONFIG['--color-primary'] = $color_primary ? $color_primary : 'hsl(216, 98%, 52%)';
    $_CONFIG['--color-dark'] = $color_dark ? $color_dark : 'hsl(210, 11%, 15%)';
    $_CONFIG['--color-light'] = $color_light ? $color_light : 'hsl(210, 16%, 98%)';
    $_CONFIG['dark_header'] = isset($_POST['dark_header']) ? true : false;

    // Progress bar
    $progressColor = filter_input(INPUT_POST, "progressColor", FILTER_UNSAFE_RAW);
    $_CONFIG['progress_color'] = $progressColor ? $progressColor : "";
    $_CONFIG['show_percentage'] = isset($_POST['show_percentage']) ? true : false;
    $_CONFIG['single_progress'] = isset($_POST['single_progress']) ? true : false;
    $_CONFIG['hide_logo'] = isset($_POST['hide_logo']) ? true : false;

    // Description
    // Sanitize string
    $postdescription = strip_tags($_POST['description'], '<p><div><a><span><strong><b><em><i><u><img><iframe><input><textarea><button><br><hr><table><thead><tbody><tfoot><tr><td><th><ul><ol><li></label><code><pre>');
    $_CONFIG['description'] = $postdescription;

    // Toasts alerts
    $stickyv = isset($_POST['sticky_alerts_pos_v']) ? filter_input(INPUT_POST, 'sticky_alerts_pos_v') : 'top';
    $stickyh = isset($_POST['sticky_alerts_pos_h']) ? filter_input(INPUT_POST, 'sticky_alerts_pos_h') : 'left';

    $_CONFIG['sticky_alerts_pos'] = $stickyv.'-'.$stickyh;

    // Audio notifications
    $_CONFIG['audio_notification'] = empty($_POST['audio_notification']) ? false : filter_input(INPUT_POST, 'audio_notification', FILTER_UNSAFE_RAW);

    // App icon
    $removeappico = filter_input(INPUT_POST, "remove_app_ico", FILTER_UNSAFE_RAW);

    $destination = "_content/uploads/favicon.ico";
    $destinationPNG = "_content/uploads/favicon-152.png";

    if (isset($_FILES['app_ico']['name']) && $_FILES['app_ico']['error'] !== 4) {
        $app_ico = $admin->uploadImage($_FILES['app_ico'], 'app-ico', false);
        $source = "_content/uploads/".$app_ico;

        if (file_exists($source)) {
            include_once 'class/class.php-ico.php';

            $ico_lib = new PHP_ICO($source, array(array(16, 16), array(32, 32), array(48, 48), array(64, 64)));
            $ico_lib->save_ico($destination);

            $ico_lib_png = new PHP_ICO($source, array(array(152, 152)));
            $ico_lib_png->save_ico($destinationPNG);
            unlink($source);
        }
    } else {
        if ($removeappico) {
            if (file_exists($destination)) {
                unlink($destination);
            }

            if (file_exists($destinationPNG)) {
                unlink($destinationPNG);
            }
        }
    }

    // Navbar logo
    $navbar_logo_new = false;

    $removenavlogo = filter_input(INPUT_POST, "remove_navbar_logo", FILTER_UNSAFE_RAW);

    $navbar_logo_new = $removenavlogo ? false : $setUp->getConfig('navbar_logo', false);

    if (isset($_FILES['navbar_logo']['name']) && $_FILES['navbar_logo']['error'] !== 4) {
        $navbar_logo_new = $admin->uploadImage($_FILES['navbar_logo'], 'navbar-logo');
    }

    $_CONFIG['navbar_logo'] = $navbar_logo_new;

    // Custom Header
    $removelogo = filter_input(INPUT_POST, "remove_logo", FILTER_UNSAFE_RAW);

    $logonew = $removelogo ? false : $setUp->getConfig('logo', false);

    if (isset($_FILES['header_image']['name']) && $_FILES['header_image']['error'] !== 4) {
        $logonew = $admin->uploadImage($_FILES['header_image'], 'header-image');
    }
    $_CONFIG['logo'] = $logonew;

    $logo_margin = filter_input(INPUT_POST, "logo_margin", FILTER_VALIDATE_INT);
    $_CONFIG['logo_margin'] = $logo_margin ? $logo_margin : 0;

    $header_padding = filter_input(INPUT_POST, "header_padding", FILTER_VALIDATE_INT);
    $_CONFIG['header_padding'] = $header_padding ? $header_padding : 0;

    $banner_width = filter_input(INPUT_POST, "banner_width", FILTER_UNSAFE_RAW);
    $_CONFIG['banner_width'] = $banner_width ? $banner_width : $setUp->getConfig('banner_width', 'wide');

    $_CONFIG['align_logo'] = isset($_POST['align_logo']) ? $_POST['align_logo'] : $setUp->getConfig('align_logo', 'center');

    $credits = filter_input(INPUT_POST, "credits", FILTER_UNSAFE_RAW);
    $credits_link = filter_input(INPUT_POST, "credits_link", FILTER_SANITIZE_URL);
    $header_position = filter_input(INPUT_POST, "header_position", FILTER_SANITIZE_URL);

    $_CONFIG['credits'] = $credits ? $credits : false;
    $_CONFIG['credits_link'] = $credits_link ? $credits_link : false;
    $_CONFIG['hide_credits'] = isset($_POST['hide_credits']) ? true : false;
    $_CONFIG['header_position'] = $header_position ? $header_position : 'below';

    // Update config
    $con = '$_CONFIG = ';
    if (false === (file_put_contents('config.php', "<?php\n\n $con".var_export($_CONFIG, true).";\n"))) {
        Utils::setError('Error saving config file');
    } else {
        Utils::setSuccess($setUp->getString('settings_updated'));
        $updater->clearCache('config.php');
    }
    $admin->updateCss();
    header('Location:'.$script_url.'vfm-admin/?section=appearance');
    exit();
}
