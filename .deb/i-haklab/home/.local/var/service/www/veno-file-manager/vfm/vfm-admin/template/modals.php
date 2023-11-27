<?php
/**
 * VFM - veno file manager: include/modals.php
 * popup windows
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

$VFMmodals = array();
/**
 * Group Actions
 */
if ($gateKeeper->isAccessAllowed()) {
    $insert4 = $setUp->getString('insert_4_chars');
    $time = time();
    $hash = md5($setUp->getConfig('salt').$time);
    $pulito = rtrim($setUp->getConfig("script_url"), "/");

    // if ($setUp->getConfig("show_pagination_num") == true
    //     || $setUp->getConfig("show_pagination") == true
    //     || $setUp->getConfig("show_search") == true
    // ) {
    //     $activepagination = true;
    // } else {
    //     $activepagination = 0;
    // }
    $selectfiles = $setUp->getString("select_files");
    $toomanyfiles = $setUp->getString('too_many_files');

    // $maxzipfiles = $setUp->getConfig('max_zip_files');
    // $prettylinks = $setUp->getConfig('enable_prettylinks') ? true : 0);

    $sharelinkatts = array(
        'insert4' => $insert4,
        'time' => $time,
        'hash' => $hash,
        'pulito' => $pulito,
        // 'activepagination' => $activepagination,
        // 'maxzipfiles' => $maxzipfiles,
        'selectfiles' => $selectfiles,
        // 'toomanyfiles' => $toomanyfiles,
        // 'prettylinks' => $prettylinks,
    );

    $VFMmodals['share'] = $sharelinkatts;

    ?>

    <div id="zipmodal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <input type="hidden" name="folder_zip_log" value="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title"><i class="bi bi-cloud-arrow-down"></i></p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    
                </div>
                <div class="modal-footer">
                    <div class="text-center"></div>
                </div>
            </div>
        </div>
    </div>

    <?php
    /**
     * Send files window
     */
    if ($gateKeeper->isAllowed('sendfiles_enable') && $gateKeeper->isAllowed('download_enable')) { ?>
            <div class="modal fade sendfiles" id="sendfilesmodal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title">
                                <?php echo " ".$setUp->getString("selected_files"); ?>: 
                                <span class="numfiles badge bg-light-darker"></span>
                            </p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="createlink-wrap mb-3">
                                <div class="d-grid gap-2">
                                    <button id="createlink" class="btn btn-primary">
                                        <i class="bi bi-check-lg"></i> <?php echo $setUp->getString("generate_link"); ?>
                                    </button>
                                </div>
                            </div>
        <?php
        if ($setUp->getConfig('secure_sharing')) { ?>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="use_pass" role="switch" id="use_pass">
                                <label class="form-check-label" for="use_pass"><i class="bi bi-key"></i> <?php echo $setUp->getString("password_protection"); ?></label>
                            </div>
            <?php
        } ?>
                        <div class="form-group shalink mb-3">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a class="btn btn-primary sharebutt" href="#" target="_blank"><i class="bi bi-link-45deg"></i></a>
                                </span>
                                <input id="copylink" class="sharelink form-control" type="text" onclick="this.select()" readonly>
        <?php
        if ($setUp->getConfig('clipboard')) { ?>
                                <span class="input-group-btn">
                                    <button id="clipme" class="clipme btn btn-primary" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="<?php echo $setUp->getString("copied"); ?>" data-clipboard-target="#copylink">
                                        <i class="bi bi-clipboard-check"></i>
                                    </button>
                                </span>
            <?php
        } ?>
                            </div>
                        </div>
        <?php
        if ($setUp->getConfig('secure_sharing')) { ?>
                        <div class="form-group seclink mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input class="form-control passlink setpass" type="text" onclick="this.select()" placeholder="<?php echo $setUp->getString("random_password"); ?>">
                            </div>
                        </div>
            <?php
        }
        $mailsystem = $setUp->getConfig('email_from');
        if (strlen($mailsystem) > 0) { ?>
            <div class="text-center">
                        <a class="openmail fs-1 btn btn-primary my-3" data-bs-toggle="collapse" href="#sendfiles">
                            <i class="bi bi-envelope-paper"></i>
                        </a>
                    </div>
                        <form role="form" id="sendfiles" class="collapse">
                            <div class="mailresponse"></div>
                            <input name="thislang" type="hidden" value="<?php echo $setUp->lang; ?>">
                            <label class="form-label" for="mitt"><?php echo $setUp->getString("from"); ?>:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input name="mitt" type="email" class="form-control" id="mitt" value="<?php echo $gateKeeper->getUserInfo('email'); ?>" placeholder="<?php echo $setUp->getString("your_email"); ?>" required>
                            </div>
                            <div class="wrap-dest">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="dest">
                                        <?php echo $setUp->getString("send_to"); ?>:
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input name="dest" type="email" data-role="multiemail" class="form-control addest" id="dest" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="btn btn-primary btn-xs shownext hidden">
                                    <i class="bi bi-person-plus"></i>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <textarea class="form-control" name="message" id="mess" rows="3" placeholder="<?php echo $setUp->getString("message"); ?>"></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-envelope"></i></button>
                                </div>
                            </div>

                            <input name="passlink" class="form-control passlink" type="hidden">
                            <input name="attach" class="attach" type="hidden">
                            <input name="sharelink" class="sharelink" type="hidden">
                        </form>
                        
                        <div class="mailpreload position-absolute w-100 h-100 start-0 top-0">
                            <div class="position-absolute w-100 h-100 start-0 top-0 d-flex align-items-center justify-content-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
            <?php
        } ?>
                    </div> <!-- modal-body -->
                </div>
            </div>
        </div>
        <?php
    } // end sendfiles enabled

    /**
     * Rename files and folders
     */
    if ($gateKeeper->isAllowed('rename_enable')) { ?>
        <div class="modal fade changename" id="modalchangename" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title"><i class="bi bi-pencil-square"></i> <?php echo $setUp->getString("rename"); ?></p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);?>">
                            <input readonly name="thisdir" type="hidden" class="form-control" id="dir">
                            <input readonly name="thisext" type="hidden" class="form-control" id="ext">
                            <input readonly name="oldname" type="hidden" class="form-control" id="oldname">
                            <div class="input-group">
                                <input name="newname" type="text" class="form-control" id="newname">
                                <button type="submit" class="btn btn-primary"><?php echo $setUp->getString("rename"); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } // end rename_enable

    /**
     * Manage Copy / Move files
     * and Folder tree navigation
     */
    ?>
        <div class="modal fade archive-map" id="archive-map" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title">
                            <i class="bi bi-list-task"></i> <?php echo $setUp->getString("select_destination_folder"); ?>
                        </p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="hiddenalert"></div>
                        <div class="modal-result"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade archive-map" id="archive-map-move" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title">
                            <i class="bi bi-list-task"></i> <?php echo $setUp->getString("select_destination_folder"); ?>
                        </p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="hiddenalert"></div>
                        <div class="modal-result"></div>
                        <form class="moveform"></form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade archive-map" id="archive-map-copy" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title">
                            <i class="bi bi-list-task"></i> <?php echo $setUp->getString("select_destination_folder"); ?>
                        </p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="hiddenalert"></div>
                        <div class="modal-result"></div>
                        <form class="moveform"></form>
                    </div>
                </div>
            </div>
        </div>

    <?php
    /**
     * Navigate with folder tree
     */
    if ($gateKeeper->isAllowed('move_enable')
        || $gateKeeper->isAllowed('copy_enable')
        || $setUp->getConfig("show_foldertree") == true
    ) {
        if (isset($_GET['dir']) && strlen($_GET['dir']) > 0) {
            $currentdir = "./".trim($_GET['dir'], "/")."/";
        } else {
            $currentdir = $setUp->getConfig('starting_dir');
        }

        $VFMmodals['foldertree'] = array(
            'currentdir' => $currentdir,
            'root' => $setUp->getString("root"),
        );
    }
    /**
     * Move or copy files
     */
    if ($gateKeeper->isAllowed('move_enable') || $gateKeeper->isAllowed('copy_enable')) {
        $VFMmodals['move'] = array(
            // 'activepagination' => $activepagination,
            'selectfiles' => $selectfiles,
            'time' => $time,
            'hash' => $hash,
        );
    } // end move_enable

    /**
     * Delete multiple files
     */
    if ($gateKeeper->isAllowed('delete_enable')) {
        $confirmthisdel = $setUp->getString('delete_this_confirm');
        $confirmdel = $setUp->getString('delete_confirm');

        $VFMmodals['delete'] = array(
            'confirmthisdel' => $confirmthisdel,
            'confirmdel' => $confirmdel,
            // 'activepagination' => $activepagination,
            'selectfiles' => $selectfiles,
            'time' => $time,
            'hash' => $hash,
        );
        ?>
        <div class="modal fade deletemulti" id="deletemulti" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title"> 
                            <?php echo $setUp->getString("selected_files"); ?>: <span class="numfiles badge bg-light-darker"></span>
                        </p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="text-center modal-body">
                        <form id="delform">
                            <a class="btn btn-primary btn-lg centertext bigd removelink" href="#">
                            <i class="bi bi-trash fs-1"></i></a>
                            <p class="delresp"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } // end delete enabled
} // end isAccessAllowed

/**
 * Show Thumbnails
 */
if (($setUp->getConfig("thumbnails") == true) || ($setUp->getConfig("playvideo") == true)) {
    $VFMmodals['zoomview'] = array(
        'baselink' => 'vfm-admin/vfm-downloader.php?q=',
        'script_url' => $setUp->getConfig('script_url'),
        'directlink' => $setUp->getConfig('direct_links'),
    );

    if ($setUp->getConfig('enable_prettylinks') == true) {
        $VFMmodals['zoomview']['baselink'] = 'download/';
    }
    ?>
    <div class="modal fade zoomview" id="zoomview" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title flex-fill">
                        <div class="input-group">
                            <a type="button" class="vfmlink btn btn-primary"><i class="bi bi-download"></i> </a> 
                            <input type="text" class="thumbtitle form-control" value="" onclick="this.select()" readonly >
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="vfm-zoom"></div>
                    <!--            
                     <div style="position:absolute; right:10px; bottom:10px;">Custom Watermark</div>
                    -->                
                </div>
            </div>
        </div>
    </div>

    <?php
} // end thumbnails || video
?>

<script type='text/javascript'>
/* <![CDATA[ */
var VFMmodals = '<?php echo json_encode($VFMmodals); ?>';
/* ]]> */
</script>
