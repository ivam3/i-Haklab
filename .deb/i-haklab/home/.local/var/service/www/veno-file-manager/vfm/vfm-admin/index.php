<?php
/**
 * VFM - veno file manager administration
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
define('VFM_APP', true);
require_once 'admin-panel/view/admin-head.php';

// update usernames prior to v 2.6.3 to unsensitive
if (file_exists('_unsensitive-users.php')) {
    if (count($_USERS) > 1 && version_compare($vfm_version, '2.6.3', '>')) {
        include '_unsensitive-users.php';
    } else {
        unlink('_unsensitive-users.php');
    }
}

// user available quota (in MB)
$_QUOTA = array(
    "10",
    "20",
    "50",
    "100",
    "200",
    "500",
    "1024", // 1GB
    "2048", // 2GB
    "5120", // 5GB
    );
// exipration for downloadable links
$share_lifetime = array(
    // "days" => "menu value"
    "1" => "24 h",
    "2" => "48 h",
    "3" => "72 h",
    "5" => "5 days",
    "7" => "7 days",
    "10" => "10 days",
    "30" => "30 days",
    "365" => "1 year",
    "36500" => "Unlimited",
    );

// exipration for registration links
// unit (('sec' | 'second' | 'min' | 'minute' | 'hour' | 'day' | 'month' | 'year') / ('s'))
$registration_lifetime = array(
    // "days" => "menu value"
    // "-1 minute" => "1 min",
    // "-2 minutes" => "2 min",
    "-1 hour" => "1 h",
    "-3 hours" => "3 h",
    "-6 hours" => "6 h",
    "-12 hours" => "12 h",
    "-1 day" => "1 day",
    "-2 days" => "2 days",
    "-7 days" => "7 days",
    "-1 month" => "30 days",
    );

$allroles = array();
require dirname(__FILE__).'/admin-panel/view/users/roles.php';
if (is_array($getroles)) {
    foreach ($getroles as $role) {
        $allroles[$role] = $setUp->getString("role_".$role);
    }
}
$allroles_nosuperadmin = $allroles;
unset($allroles_nosuperadmin['superadmin']);

$rtl_ext = '';
$rtl_att = '';
$rtl_class = '';
if ($setUp->getConfig("txt_direction") == "RTL") {
    $rtl_att = ' dir="rtl"';
    $rtl_ext = '.rtl';
    $rtl_class = ' rtl';
}
?>
<!doctype html>
<html lang="<?php echo $setUp->lang; ?>"<?php echo $rtl_att; ?>>
<head>
    <title><?php print $setUp->getString('administration')." | ".$setUp->getConfig('appname'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php echo $setUp->printIcon("_content/uploads/"); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap<?php echo $rtl_ext; ?>.min.css">
    <link rel="stylesheet" href="icons/bootstrap-icons.min.css">

    <?php
    switch ($get_section) {

    case 'appearance':
        ?>
    <link rel="stylesheet" href="admin-panel/plugins/spectrum/spectrum.min.css">
    <link rel="stylesheet" href="admin-panel/plugins/easyeditor/easyeditor.css">
        <?php
        break;

    case 'users':
        ?>
    <link rel="stylesheet" href="assets/datatables/datatables.min.css">
    <link rel="stylesheet" href="admin-panel/plugins/bootstrap-select/css/bootstrap-select.min.css">
        <?php
        break;
    case 'logs':
        ?>
        <link rel="stylesheet" href="assets/datatables/datatables.min.css">
        <?php
        break;

    default:
        ?>
    <link rel="stylesheet" href="admin-panel/plugins/tagin/tagin.min.css">
    <link rel="stylesheet" href="admin-panel/plugins/bootstrap-select/css/bootstrap-select.min.css">
        <?php
        break;
    }
    ?>
    <link rel="stylesheet" href="admin-panel/css/admin.css?v=2s">
    <link rel="stylesheet" href="css/colors.css?t=<?php echo time(); ?>">

    <script type="text/javascript" src="assets/jquery/jquery-3.3.1.min.js"></script>
</head>

<?php
$skin = $setUp->getConfig('admin_color_scheme') ? $setUp->getConfig('admin_color_scheme') : 'blue';
$scrollspy_data = $activesec == "home" ? ' data-bs-spy="scroll" data-bs-target="#sidebar-nav" data-bs-offset="0" tabindex="0" data-bs-offset="0"' : '';
?>
<body class="fixed sidebar-mini admin-body<?php echo $rtl_class; ?>"<?php echo $scrollspy_data; ?>>

<header class="navbar fixed-top bg-dark flex-md-nowrap shadow navbar-expand">
    <div class="container-fluid">
        <a class="navbar-brand me-0 px-3 flex-grow-1" href="./"><?php print $setUp->getConfig('appname'); ?></a>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav ms-auto">
                <li class="nav-item d-inline-block d-md-none">
                <button class="toggle-sidebar btn btn-link ms-auto" type="button" data-bs-target=".supercontainer">
                    <span class="navbar-toggler-icon"></span>
                </button>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $setUp->getConfig('script_url'); ?>"><i class="bi bi-house-door"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../?logout" title="<?php echo $setUp->getString("log_out"); ?>"><i class="bi bi-box-arrow-right"></i> </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-flag"></i>
                        <?php // echo $setUp->getString("LANGUAGE_NAME"); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark lang-menu">
                        <?php print ($setUp->printLangMenu()); ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>

<div class="supercontainer row g-0">

        <?php require dirname(__FILE__).'/admin-panel/view/sidebar.php'; ?>
    
        <main class="main bg-light d-flex flex-column justify-content-between min-vh-100">
        <div id="view-preferences"></div>
        <div class="content-wrapper px-3 px-md-4 pt-5 mb-auto">
            <?php
            switch ($get_section) {

            case 'appearance':
                if (GateKeeper::canSuperAdmin('superadmin_can_appearance')) { ?>
                <div class="content-header pt-5">
                    <h2 class="mb-4"><i class="bi bi-brush"></i> <?php print $setUp->getString("appearance"); ?></h2>
                </div>
                    <?php echo $admin->printAlert(); ?>
                <div class="content">
                    <form role="form" method="post" id="settings-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=appearance" enctype="multipart/form-data">
                    <?php
                    include dirname(__FILE__).'/admin-panel/view/appearance/appearance.php';
                    include dirname(__FILE__).'/admin-panel/view/save-settings.php'; ?>
                    </form>
                </div>
                    <?php
                }
                break;

            case 'users':
                if (GateKeeper::canSuperAdmin('superadmin_can_users')) { ?>
                <div class="content-header pt-5">
                    <h2 class="mb-4"><i class="bi bi-people"></i> <?php print $setUp->getString("users"); ?></h2>
                </div>
                    <?php echo $admin->printAlert(); ?>
                <div class="content body">
                    <div class="row">
                        <?php
                        include "admin-panel/view/users/new-user.php";
                        if (GateKeeper::isMasterAdmin()) {
                            include dirname(__FILE__).'/admin-panel/view/users/master-admin.php';
                        }
                        ?>
                    </div>
                    <?php
                    include dirname(__FILE__).'/admin-panel/view/users/list-users.php';
                    include dirname(__FILE__).'/admin-panel/view/users/modal-user.php';
                    ?>
                </div>
                    <?php
                }
                break;

            case 'translations':
                if (GateKeeper::canSuperAdmin('superadmin_can_translations')) { ?>
                <div class="content-header pt-5">
                    <h2 class="mb-4"><i class="bi bi-translate"></i> <?php print $setUp->getString("language_manager"); ?></h2>
                </div>
                    <?php echo $admin->printAlert(); ?>
                <div class="content">
                    <?php
                    if ($get_action == 'edit') {
                        if ($editlang || ($postnewlang && strlen($postnewlang) == 2 && !array_key_exists($postnewlang, $translations))) {
                            include dirname(__FILE__).'/admin-panel/view/language/edit.php';
                        }
                    } else {
                        include dirname(__FILE__).'/admin-panel/view/language/panel.php';
                    }
                    ?>
                </div>
                    <?php
                }
                break;

            case 'logs':
                if (GateKeeper::canSuperAdmin('superadmin_can_statistics')) { ?>
                <div class="content-header pt-5">
                    <h2 class="mb-4"><i class="bi bi-graph-up-arrow"></i> <?php print $setUp->getString("statistics"); ?></h2>
                </div>
                    <?php echo $admin->printAlert(); ?>
                <div class="content">
                    <?php
                    include dirname(__FILE__).'/admin-panel/view/analytics/selector.php';
                    include dirname(__FILE__).'/admin-panel/view/analytics/charts.php';
                    include dirname(__FILE__).'/admin-panel/view/analytics/table.php';
                    include dirname(__FILE__).'/admin-panel/view/analytics/range.php';
                    ?>
                </div>
                    <?php
                }
                break;

            default:
                if (GateKeeper::canSuperAdmin('superadmin_can_preferences')) { ?>
                <div class="content-header pt-5">
                    <h2 class="mb-4"><i class="bi bi-sliders"></i> <?php print $setUp->getString("preferences"); ?></h2>
                </div>
                <?php echo $admin->printAlert(); ?>
                <div class="content">
                    <form class="position-relative" role="form" method="post" id="settings-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
                        <?php
                        include dirname(__FILE__).'/admin-panel/view/dashboard/general.php';
                        include dirname(__FILE__).'/admin-panel/view/dashboard/uploads.php';
                        include dirname(__FILE__).'/admin-panel/view/dashboard/lists.php';
                        include dirname(__FILE__).'/admin-panel/view/dashboard/permissions.php';
                        include dirname(__FILE__).'/admin-panel/view/dashboard/registration.php';
                        include dirname(__FILE__).'/admin-panel/view/dashboard/share.php';
                        include dirname(__FILE__).'/admin-panel/view/dashboard/email.php';
                        include dirname(__FILE__).'/admin-panel/view/dashboard/security.php';
                        include dirname(__FILE__).'/admin-panel/view/dashboard/activities.php';
                        include dirname(__FILE__).'/admin-panel/view/dashboard/admin-color-scheme.php';
                        include dirname(__FILE__).'/admin-panel/view/save-settings.php';
                        ?>
                        <div class="form-group">       
                            <?php $debugchecked = $setUp->getConfig('debug_mode') ? ' checked' : ''; ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="debug_mode" value="" id="check-debug"<?php echo $debugchecked; ?>>
                                <label class="form-check-label" for="check-debug">
                                    <i class="bi bi-wrench-adjustable"></i> DEBUG MODE <a title="Display all PHP notices" class="tooltipper" data-bs-placement="right" data-bs-toggle="tooltip" href="javascript:void(0)"><i class="bi bi-question-circle"></i></a>
                                </label>
                            </div>
                        </div>
                    </form>
                </div> <!-- content -->
                        <?php
                } else {
                        $username = GateKeeper::getUserInfo('name');
                    ?>
                <div class="content">
                    <h2 class="mb-4"><?php echo GateKeeper::getAvatar($username, '').' <a href="'.$setUp->getConfig('script_url').'">'.$username.'</a>'; ?></h2>
                </div>
                        <?php
                }
                break;
            } ?>
            <br>
            <br>
            <br>
        </div> <!-- content-wrapper -->
        <?php
        require dirname(__FILE__).'/admin-panel/view/footer.php';
        if ($get_section == 'logs') {
            include dirname(__FILE__).'/admin-panel/view/analytics/loader.php';
        }
        ?>
    </main>
</div> <!-- supercontainer -->

</body>
</html>