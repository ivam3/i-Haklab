<?php
/**
 * VFM - veno file manager: include/load-js.php
 * Load javascript files
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
$debug_mode = $setUp->getConfig('debug_mode');

$VFMvars = array(
    'settings' => array(
        'prettylinks' => $setUp->getConfig('enable_prettylinks'),
    ),
);
?>

<?php
if ($gateKeeper->isAccessAllowed()) :
    /**
     * Setup Generic filetable config
     */
    $tablesettings = array(
        'dir' => $location->getDir(false, false, false, 0),
        'direction' => strtolower($setUp->getConfig("txt_direction")),
    );

    $VFMvars['tables']['settings'] = $tablesettings;

    /**
     * Setup Files Table
     */
    $filetableconfig = array();

    $filecolumns = array(
        'alpha' => 2,
        'size' => 3,
        'date' => 4,
    );
    $filetableconfig['ilenght'] = isset($_SESSION['ilenght']) ? $_SESSION['ilenght'] : $setUp->getConfig('filedefnum', 10);
    $filetableconfig['sort_col'] = isset($_SESSION['sort_col']) ? $_SESSION['sort_col'] : $filecolumns[$setUp->getConfig('filedeforder', 'date')];
    $default_order = ($filetableconfig['sort_col'] === 4) ? 'desc' : 'asc';
    $filetableconfig['sort_order'] = isset($_SESSION['sort_order']) ? $_SESSION['sort_order'] : $default_order;

    $filetableconfig['paginate'] = $setUp->getConfig("show_pagination") ? 'on' : 'off';
    $filetableconfig['pagination_type'] = ($setUp->getConfig("show_pagination_num") === true) ? 'full_numbers' : 'simple';
    $filetableconfig['show_search'] = $setUp->getConfig("show_search");
    $filetableconfig['search'] = filter_input(INPUT_GET, 's', FILTER_UNSAFE_RAW);

    $filecoulmns = array();

    $filecoulmns[] = array(
        'orderable' => false,
        'class' => 'checkb text-center',
        'data' => 'check',
    );
    $filecoulmns[] = array(
        'orderable' => false,
        'class' => 'icon itemicon text-center',
        'data' => 'icon',
    );
    $filecoulmns[] = array(
        'class' => 'small name',
        'data' => 'file_name',
    );
    $filecoulmns[] = array(
        'class' => 'mini reduce nowrap d-none d-md-table-cell',
        'data' => 'size',
        // 'visible' => false,
    );
    $filecoulmns[] = array(
        'class' => 'mini reduce d-none d-md-table-cell nowrap',
        'data' => 'last_change',
        // 'visible' => false,
    );
    if ($gateKeeper->isAllowed('rename_enable')) {
        $filecoulmns[] = array(
            'orderable' => false,
            'class' => 'icon text-center d-none d-md-table-cell',
            'data' => 'edit',
        );
    }
    $filecoulmns[] = array(
        'orderable' => false,
        'class' => 'text-center',
        'data' => 'delete',
    );
    $filetableconfig['columns'] = $filecoulmns;

    $VFMvars['tables']['files'] = $filetableconfig;

    /**
     * Setup Folders table
     */
    $foldertableconfig = array();

    $foldercolumns = array(
        'alpha' => 1,
        'date' => 2,
    );
    $foldertableconfig['dirlenght'] = isset($_SESSION['dirlenght']) ? $_SESSION['dirlenght'] : $setUp->getConfig('folderdefnum', 5);
    $foldertableconfig['sort_dir_col'] = isset($_SESSION['sort_dir_col']) ? $_SESSION['sort_dir_col'] : $foldercolumns[$setUp->getConfig('folderdeforder', 'alpha')];
    $default_dir_order = ($foldertableconfig['sort_dir_col'] === 1) ? 'asc' : 'desc';
    $foldertableconfig['sort_dir_order'] = isset($_SESSION['sort_dir_order']) ? $_SESSION['sort_dir_order'] : $default_dir_order;

    $foldertableconfig['paginate'] = $setUp->getConfig('show_pagination_folders') ? 'on' : 'off';
    $foldertableconfig['pagination_type'] = ($setUp->getConfig('show_pagination_num_folder') === true) ? 'full_numbers' : 'simple';
    $foldertableconfig['search'] = filter_input(INPUT_GET, 'sd', FILTER_UNSAFE_RAW);

    $foldercoulmns = array();

    $foldercoulmns[] = array(
        'orderable' => false,
        'class' => 'icon nowrap folder-badges',
        'data' => 'counter',
    );
    $foldercoulmns[] = array(
        'class' => 'small name',
        'data' => 'folder_name',
    );
    $foldercoulmns[] = array(
        'class' => 'd-none d-md-table-cell mini reduce nowrap',
        'data' => 'last_change',
    );

    if ($location->editAllowed()) {
        // Mobile menu.
        if (($setUp->getConfig("download_dir_enable") === true && $gateKeeper->isAllowed('download_enable'))
            || $gateKeeper->isAllowed('rename_dir_enable')
            || $gateKeeper->isAllowed('delete_dir_enable')
        ) {
            $foldercoulmns[] = array(
                'orderable' => false,
                'class' => 'text-end d-md-none',
                'data' => 'mini_menu',
            );
        }
        if ($setUp->getConfig("download_dir_enable") === true && $gateKeeper->isAllowed('download_enable')) {
            $foldercoulmns[] = array(
                'orderable' => false,
                'class' => 'text-center d-none d-md-table-cell',
                'data' => 'download_dir',
            );
        }
        if ($gateKeeper->isAllowed('rename_dir_enable')) {
            $foldercoulmns[] = array(
                'orderable' => false,
                'class' => 'text-center d-none d-md-table-cell',
                'data' => 'rename_dir',
            );
        }
        if ($gateKeeper->isAllowed('delete_dir_enable')) {
            $foldercoulmns[] = array(
                'orderable' => false,
                'class' => 'text-center d-none d-md-table-cell',
                'data' => 'delete_dir',
            );
        }
    }
    $foldertableconfig['columns'] = $foldercoulmns;
    $VFMvars['tables']['folders'] = $foldertableconfig;
endif;

$VFMvars['strings'] = array(
    'ok' => $setUp->getString("OK"),
    'cancel' => $setUp->getString("CANCEL"),
    'confirm' => $setUp->getString("CONFIRM"),
    'confirm_folder_download' => $setUp->getString("confirm_folder_download"),
    'files' => $setUp->getString("files"),
    'folders' => $setUp->getString("folders"),
    'browse' => $setUp->getString('browse'),
);

if ($gateKeeper->isUserLoggedIn()) {
    $VFMvars['avatar'] = array(
        'username' => $gateKeeper->getUserInfo('name'),
        // 'image' => $gateKeeper->getAvatar($username, 'vfm-admin/'),
    );
}

if ($location->editAllowed() && $gateKeeper->isAllowed('upload_enable')) {
    $android = (stripos($_SERVER['HTTP_USER_AGENT'], 'android') !== false ? 'yes' : 'no');
    $singleprogress = ($setUp->getConfig('single_progress') ? true : 0);

    $VFMvars['uploaders'] = array(
        'android' => $android,
        'singleprogress' => $singleprogress,
        'path' => urlencode($location->getCleanPath()),
        'chunksize' => $setUp->getChunkSize(),
    );
}
?>

<script type="text/javascript" src="vfm-admin/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<?php
/**
 * Load video preview
 */
if ($setUp->getConfig('playvideo') === true) { ?>
<script src="vfm-admin/assets/videojs/alt/video.core.novtt.min.js?v=7.17.0"></script>
    <?php
} ?>
<script type='text/javascript'>
/* <![CDATA[ */
var VFMvars = '<?php echo json_encode($VFMvars); ?>';
/* ]]> */
</script>


<?php
if ($debug_mode === true) {
    // build soundmanager2-nodebug-jsmin.js
    ?>
    <script type="text/javascript" src="vfm-admin/assets/soundmanager/soundmanager2.js?v=2.97"></script>
    <script type="text/javascript" src="vfm-admin/assets/vfm/js/vfm-inlineplayer.js?v=2.97"></script>

    <script type="text/javascript" src="vfm-admin/assets/initial/initial.min.js?v=0.2.0"></script>
    <script type="text/javascript" src="vfm-admin/assets/cropit/jquery.cropit.min.js?v=0.5.1"></script>
    <script type="text/javascript" src="vfm-admin/assets/vfm/js/avatars.js?v=<?php echo $vfm_version; ?>"></script>

    <script type="text/javascript" src="vfm-admin/assets/bootbox/bootbox.min.js?v=5.5.2"></script>
    <script type="text/javascript" src="vfm-admin/assets/datatables/datatables.min.js?v=1.10.16"></script>
    <script type="text/javascript" src="vfm-admin/assets/clipboard/clipboard.min.js"></script>

    <script type="text/javascript" src="vfm-admin/assets/uploaders/resumable.js?v=1.1.2"></script>
    <script type="text/javascript" src="vfm-admin/assets/uploaders/jquery.form.min.js?v=4.3.0"></script>
    <script type="text/javascript" src="vfm-admin/assets/vfm/js/uploaders.js?v=<?php echo $vfm_version; ?>"></script>

    <script type="text/javascript" src="vfm-admin/assets/vfm/js/app.js?v=<?php echo $vfm_version; ?>"></script>
    <?php
} else { ?>
    <script type="text/javascript" src="vfm-admin/js/vfm-bundle.min.js?v=<?php echo $vfm_version; ?>"></script>
    <?php
}

// Audio notification after upload
if ($setUp->getConfig('audio_notification') && isset($_GET['response'])) { ?>
    <script type="text/javascript">
        audio_ping.play();
    </script>
    <?php
}
