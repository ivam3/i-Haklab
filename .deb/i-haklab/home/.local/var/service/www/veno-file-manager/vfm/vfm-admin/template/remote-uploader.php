<?php
/**
 * VFM - veno file manager: include/remote-uploader.php
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

/**
 * Upload from url
 */
if ($location->editAllowed()
    && $gateKeeper->isAllowed('upload_enable')
    && $setUp->getConfig('remote_uploader')
    && $setUp->getConfig('remote_extensions')
) {
    ?>
<div class="col-12">
    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#upload_from_url">
        <i class="bi bi-globe2"></i>  <?php echo $setUp->getString("remote_upload"); ?>
    </button>
</div>
<div class="modal fade" id="upload_from_url" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title"><i class="bi bi-globe2"></i> <?php echo $setUp->getString("enter_the_url_to_download"); ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="remote_uploader">
                    <div class="form-group mb-3">
                        <div class="input-group input-group-lg">
                            <input class="form-control" type="url" name="get_upload_url" placeholder="http://">
                            <input type="hidden" name="get_location" value="<?php echo $location->getDir(false, false, false, 0); ?>">
                            <button class="btn btn-primary send_remote_upload_url" type="submit"><i class="bi bi-download"></i></button>
                        </div>
                    </div>
                    <p class="text-start"><?php echo $setUp->getString("allowed_ext"); ?>: 
                        <span class="badge bg-primary">
                    <?php echo implode('</span> <span class="badge bg-primary">', $setUp->getConfig('remote_extensions')) ?>
                    </p>
                </form>
                <div class="modal_response text-center">
                    <div class="modal-body zipicon d-none">
                        <i class="bi bi-folder2-open display-2"></i>
                        <span class="ziparrow"><i class="bi bi-chevron-double-left fs-1 passing-animated-reverse d-inline-block"></i></span>
                        <i class="bi bi-file-earmark display-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php
}
