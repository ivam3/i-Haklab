    <footer class="main-footer bg-white p-3 d-flex">
        <div class="small">
            <a href="<?php echo $setUp->getConfig('script_url'); ?>">
                <strong><?php echo $setUp->getConfig('appname'); ?></strong>
            </a> &copy; <?php echo date('Y'); ?>
        </div>
        <div class="ms-auto">
            <a href="https://filemanager.veno.it/" target="_blank" title="Current version" style="line-height: 1;">
                <small><?php echo $vfm_version; ?></small>
            </a>
        </div>
    </footer>
    <script type="text/javascript" src="assets/bootstrap/js/bootstrap.bundle.min.js?v=5.0.1"></script>

    <?php
    $selectlang = str_replace('-', '_', $setUp->lang);
    $load_selectlang = file_exists('admin-panel/plugins/bootstrap-select/js/i18n/defaults-'.$selectlang.'.min.js') ? '<script type="text/javascript" src="admin-panel/plugins/bootstrap-select/js/i18n/defaults-'.$selectlang.'.min.js"></script>' : false;

    switch ($get_section) {
    case 'users':
        ?>
    <script type="text/javascript" src="assets/initial/initial.min.js?v=0.2.0"></script>
    <script type="text/javascript" src="assets/vfm/js/avatars.js?v=<?php echo $vfm_version; ?>"></script>
    <script type="text/javascript" src="assets/datatables/datatables.min.js?v=1.10.16"></script>
    <script type="text/javascript" src="admin-panel/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
        <?php echo $load_selectlang; ?>
        <?php
        break;
    case 'appearance': ?>
    <script type="text/javascript" src="admin-panel/plugins/spectrum/spectrum.min.js"></script>
    <script type="text/javascript" src="admin-panel/plugins/easyeditor/jquery.easyeditor.min.js"></script>
        <?php
        break;
    case 'logs': ?>
    <script type="text/javascript" src="assets/datatables/datatables.min.js?v=1.10.16"></script>
    <script type="text/javascript" src="admin-panel/plugins/chartjs/chart.min.js?v=3.7.0"></script>
    <script type="text/javascript" src="admin-panel/plugins/datepicker/jquery-ui.min.js"></script>
    <script type="text/javascript" src="admin-panel/js/statistics.js"></script>
        <?php
        break;
    default: ?>
    <script type="text/javascript" src="admin-panel/plugins/tagin/tagin.min.js"></script>
    <script type="text/javascript" src="admin-panel/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
        <?php echo $load_selectlang; ?>
        <?php
        break;
    } ?>

    <script type="text/javascript" src="admin-panel/js/admin.js?v=<?php echo $vfm_version; ?>"></script>
