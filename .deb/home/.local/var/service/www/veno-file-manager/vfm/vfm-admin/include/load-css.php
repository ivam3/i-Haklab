<?php
if (!defined('VFM_APP')) {
    return;
}
?>
<link rel="stylesheet" href="vfm-admin/assets/bootstrap/css/bootstrap<?php echo $rtl_ext; ?>.min.css?v=5.1">
<link rel="stylesheet" href="vfm-admin/icons/bootstrap-icons.min.css?v=5.1">
<?php
if ($setUp->getConfig('debug_mode')) {
    ?>
    <link rel="stylesheet" href="vfm-admin/assets/datatables/datatables.min.css?v=1.10.16">
    <link rel="stylesheet" href="vfm-admin/assets/videojs/video-js.min.css?v=7.17.0">
    <link rel="stylesheet" href="vfm-admin/assets/vfm/css/vfm-style.css?v=<?php echo $vfm_version; ?>">
    <?php
} else {
    ?>
    <link rel="stylesheet" href="vfm-admin/css/vfm-bundle.min.css?v=<?php echo $vfm_version; ?>">
    <?php
}
$colors_css = 'vfm-admin/css/colors.css';
$custom_css = 'vfm-admin/_content/template/style.css';
if (file_exists($colors_css)) {
    ?>
    <link rel="stylesheet" href="<?php echo $colors_css; ?>?t=<?php echo time(); ?>">
    <?php
}

if (file_exists($custom_css)) {
    ?>
    <link rel="stylesheet" href="<?php echo $custom_css; ?>?t=<?php echo time(); ?>">
    <?php
}
